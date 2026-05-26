<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceRequestController;
use App\Http\Controllers\SlideController;

// ── Language
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'kh', 'km'])) session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

// ── Public Pages
Route::get('/', function () {
    return view('home', [
        'totalStudents' => DB::table('students')->count(),
        'totalTeachers' => DB::table('teachers')->count(),
        'totalClasses'  => DB::table('courses')->count(),
        'totalCourses'  => DB::table('courses')->distinct('category')->count('category'),
        'slides'        => \App\Models\Slide::where('is_active', true)->orderBy('order')->get(),
    ]);
})->name('home');

Route::get('/services',   fn () => view('services'))->name('services');
Route::get('/contact-us', fn () => view('contactus'))->name('contact');
Route::get('/about-us',   fn () => view('aboutus', ['name'=>'lyhuo','email'=>'lyhuo@example.com','id'=>19374]))->name('about');

// ── Guest Only
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',    [AuthenticatedSessionController::class, 'store']);
    Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// ── Auth Protected
Route::middleware('auth')->group(function () {

    // Shop
    Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students
    Route::resource('students', StudentController::class);

    // Teachers
    Route::controller(TeacherController::class)->prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/',             'index')->name('index');
        Route::get('/add',          'add')->name('add');
        Route::post('/store',       'store')->name('store');
        Route::get('/edit/{id}',    'edit')->name('edit');
        Route::put('/update/{id}',  'update')->name('update');
        Route::post('/delete/{id}', 'delete')->name('delete');
        Route::get('/{id}',         'show')->name('show');
    });

    // Courses
    Route::resource('courses', CourseController::class);

    // Classes
    Route::resource('classes', ClassController::class);

    // Schedules
    Route::resource('schedules', ScheduleController::class);

    // Attendances
    Route::get('/attendances/report', [AttendanceController::class, 'report'])->name('attendances.report');
    Route::resource('attendances', AttendanceController::class)->except(['show']);

    // Attendance Requests
    Route::get('/requests',                                [AttendanceRequestController::class, 'index'])->name('attendance-requests.index');
    Route::get('/requests/create',                         [AttendanceRequestController::class, 'create'])->name('attendance-requests.create');
    Route::post('/requests',                               [AttendanceRequestController::class, 'store'])->name('attendance-requests.store');
    Route::get('/requests/my',                             [AttendanceRequestController::class, 'myRequests'])->name('attendance-requests.my');
    Route::post('/requests/{attendanceRequest}/review',    [AttendanceRequestController::class, 'review'])->name('attendance-requests.review');

    // Profile
    Route::get('/profile', fn () => view('pages.profile', ['user' => Auth::user()]))->name('profile');
    Route::put('/profile/update',   [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo',   [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Users
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });

    // News
    Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
        Route::get('/',            'index')->name('index');
        Route::get('/create',      'create')->name('create');
        Route::post('/store',      'store')->name('store');
        Route::get('/edit/{id}',   'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/{id}',     'destroy')->name('destroy');
    });

    // Books
    Route::controller(BookController::class)->prefix('books')->name('books.')->group(function () {
        Route::get('/',             'index')->name('index');
        Route::get('/add',          'add')->name('add');
        Route::post('/store',       'store')->name('store');
        Route::get('/edit/{id}',    'edit')->name('edit');
        Route::put('/update/{id}',  'update')->name('update');
        Route::post('/delete/{id}', 'delete')->name('delete');
        Route::get('/{id}',         'show')->name('show');
    });

    // Orders
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/',                 'index')->name('index');
        Route::get('/create/{book_id}', 'create')->name('create');
        Route::post('/store',           'store')->name('store');
        Route::get('/invoice/{id}',     'invoice')->name('invoice');
        Route::get('/delete/{id}',      'delete')->name('delete');
        Route::post('/{id}/status',     'updateStatus')->name('status');
        Route::get('/{id}/pdf',         'exportPdf')->name('pdf');
    });

    // Slides
    Route::resource('slides', SlideController::class);
});
