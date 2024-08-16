@extends('dash.layouts.app')
@section('content')
<div class="col-md-6 offset-md-3">
    <h3 class="text-center py-4">Import Excel File</h3>
    <form action="{{ route('users.ImportEcel') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="form-group">
            <label for="excel_file">Choose Excel File:</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control">
        </div>
        <!-- <fieldset class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="excel_file_id">
                <label class="custom-file-label" for="excel_file_id" name="excel_file">Choose Excel File</label>
            </div>
        </fieldset> -->
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