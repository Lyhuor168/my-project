
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
use App\Http\Controllers\SlideController;

    /*
    |--------------------------------------------------------------------------
    | 1. Language Switcher (Public)
    |--------------------------------------------------------------------------
        */
            Route::get('/lang/{locale}', function ($locale) {
                if (in_array($locale, ['en', 'kh', 'km'])) {
                    session(['locale' => $locale]);
                }
                return redirect()->back();
            })->name('lang.switch');

    /*
    |--------------------------------------------------------------------------
    | 2. Public Pages
    |--------------------------------------------------------------------------
    */
            Route::get('/', function () {
            return view('home', [
                'totalStudents' => DB::table('students')->count(), // ← លុប // ចេញ
                'totalTeachers' => DB::table('teachers')->count(),
                'totalClasses'  => DB::table('courses')->count(),
                'totalCourses'  => DB::table('courses')->distinct('category')->count('category'),
                'slides'        => \App\Models\Slide::where('is_active', true)->orderBy('order')->get(),
            ]);
        })->name('home');

            Route::get('/services',   fn () => view('services'))->name('services');
            Route::get('/school',     fn () => view('school'))->name('school');
            Route::get('/class',      fn () => view('schedules.index'))->name('class');
            Route::get('/contact-us', fn () => view('contactus'))->name('contact');
            Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop')->middleware('auth');
            Route::get('/about-us',   fn () => view('aboutus', [
                'name'  => 'lyhuo',
                'email' => 'lyhuo@example.com',
                'id'    => 19374,
            ]))->name('about');

    /*
    |--------------------------------------------------------------------------
    | 3. Guest Only (មិនទាន់ Login)
    |--------------------------------------------------------------------------
        */
            Route::middleware('guest')->group(function () {
                Route::get('/login',     [AuthenticatedSessionController::class, 'create'])->name('login');
                Route::post('/login',    [AuthenticatedSessionController::class, 'store']);
                Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
                Route::post('/register', [RegisteredUserController::class, 'store']);
            });

            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

        /*
        |--------------------------------------------------------------------------
        | 4. Auth Protected Routes (ត្រូវ Login មុន)
        |--------------------------------------------------------------------------
        */
            Route::middleware('auth')->group(function () {

        // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Students
            Route::resource('students', StudentController::class);

        // Teachers
            Route::controller(TeacherController::class)->prefix('teachers')->name('teachers.')->group(function () {
                Route::get('/',            'index')->name('index');
                Route::get('/add',         'add')->name('add');
                Route::post('/store',      'store')->name('store');
                Route::get('/edit/{id}',   'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::post('/delete/{id}', 'delete')->name('delete');
                Route::get('/{id}',        'show')->name('show');
            });

            // Courses
                Route::resource('courses', CourseController::class);

            // Classes
                Route::resource('classes', ClassController::class);

            // Schedules
                Route::resource('schedules', ScheduleController::class);

            // Attendances
                Route::resource('attendances', AttendanceController::class);

            // Profile
                Route::get('/profile', function () {
                    return view('pages.profile', ['user' => Auth::user()]);
                })->name('profile');
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
                    Route::get('/',            'index')->name('index');
                    Route::get('/add',         'add')->name('add');
                    Route::post('/store',      'store')->name('store');
                    Route::get('/edit/{id}',   'edit')->name('edit');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::post('/delete/{id}', 'delete')->name('delete');
                    Route::get('/{id}',        'show')->name('show');
                });

            // Orders
                Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
                    Route::get('/',                 'index')->name('index');
                    Route::get('/create/{book_id}', 'create')->name('create');
                    Route::post('/store',           'store')->name('store');
                    Route::get('/invoice/{id}',    'invoice')->name('invoice');
                    Route::get('/delete/{id}',     'delete')->name('delete');
                });

            // Slides
                Route::resource('slides', SlideController::class);

            
                    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->middleware('auth')
                    ->name('logout');

            // បន្ថែម line នេះ
                Route::get('/logout', fn () => redirect('/'));
            // បន្ថែម order routes នៅទីនេះ
                Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
                Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
                Route::get('/orders/{id}/pdf', [OrderController::class, 'exportPdf'])->name('orders.pdf');
                Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        });        

 