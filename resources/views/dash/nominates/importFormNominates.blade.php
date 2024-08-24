@extends('dash.layouts.app')
@section('content')
<style>
    h3.text-center {
        font-family: 'JazeeraFont' !important;
    }
</style>
<div class="col-md-6 offset-md-3">
    <h3 class="text-center py-1">استيراد ملف اكسل لترشيح أسماء مستفيدين بشكل مباشر
    </h3>
    <div class="d-flex justify-content-center align-items-center">
        <span class="py-2 text-center">
            يجب تنزيل الملف التالي وتعبئة البيانات حسب ترتيب إكسل.
            <br><a href="/nominates.xlsx">اضغط هنا للتنزيل</a>
        </span>
    </div>


    <form action="{{ route('nominates.importFormNominates') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="form-group mt-2">
            <label for="file">اختر ملف الاكسل :</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">رفع الملف</button>
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