@extends('dash.layouts.app')
@section('content')
<style>
    h3.text-center {
        font-family: 'JazeeraFont' !important;
    }
</style>
<div class="col-md-6 offset-md-3">
    <h3 class="text-center py-1">استيراد ملف اكسل لتحديث حالة المستفيد
    </h3><span class="pb-3">
        قبل رفع الملف تأكد العمود A يحتوي على رقم الكابون والعمود B يحتوي على حالة المستفيد

        <br>1 : تعني مرشح<span class="px-1"></span> 2 : تعني مطبوع<span class="px-1"></span> 3 : تعني مستلم<span class="px-1"></span> 4 : تعني غير مستلم
    </span>

    <form action="{{ route('nominates.ImportEcel') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="form-group mt-2">
            <label for="excel_file">اختر ملف الاكسل :</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control">
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