@extends('layouts.app')
@section('title', 'មុខវិជ្ជា')
@section('content')
    <h1>មុខវិជ្ជាទាំងអស់</h1>
    <a href="{{ route('courses.create') }}">បន្ថែមមុខវិជ្ជា</a>
    <table>
        <tr><th>ឈ្មោះ</th><th>Action</th></tr>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->name }}</td>
            <td>
                <a href="{{ route('courses.edit', $course->id) }}">កែ</a>
                <form method="POST" action="{{ route('courses.destroy', $course->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit">លុប</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
