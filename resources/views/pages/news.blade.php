@extends('layouts.master') @section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">គ្រប់គ្រងព័ត៌មាន (News Management)</h3>
        <a href="{{ url('pages/add-news') }}" class="btn btn-primary">+ បន្ថែមព័ត៌មាន</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>រូបភាព</th>
                        <th>ចំណងជើង (KH)</th>
                        <th>កាលបរិច្ឆេទ</th>
                        <th>ស្ថានភាព</th>
                        <th>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="news-sample.jpg" width="60" class="rounded"></td>
                        <td>ពិធីបុណ្យចូលឆ្នាំខ្មែរខាងមុខនេះ</td>
                        <td>02-Apr-2026</td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info text-white">កែប្រែ</a>
                            <button class="btn btn-sm btn-danger">លុប</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection