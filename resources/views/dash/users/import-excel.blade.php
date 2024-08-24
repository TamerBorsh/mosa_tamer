@extends('dash.layouts.app')
@section('content')
<style>
    h3.text-center {
        font-family: 'JazeeraFont' !important;
    }
</style>
<div class="col-md-6 offset-md-3">
    <h3 class="text-center">استيراد بيانات مستفيدين</h3>
    <div class="d-flex justify-content-center align-items-center">
        <span class="py-2 text-center">
            يجب تنزيل الملف التالي وتعبئة البيانات حسب ترتيب إكسل.
            <br><a href="/users.xlsx">اضغط هنا للتنزيل</a>
        </span>
    </div>
    <form action="{{ route('users.ImportEcel') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="form-group">
            <label for="excel_file">اختر ملف Excel:</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
    @endif
</div>

@endsection