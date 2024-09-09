@extends('dash.layouts.app')
@section('title', 'عرض الشكوى | وزارة التنمية الاجتماعية')
@section('stylesheet')
@endsection
@section('content')
<div class="content-body">
    <!-- users edit start -->
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">


                    <form id="UpdateData">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>عنوان الشكوى</label>
                                        <input type="text" class="form-control" value="{{$problem->title}}" readonly>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">تفاصيل الشكوى</label>
                                    <textarea type="text" id="content" class="form-control" readonly rows="3" require>{{$problem->content}}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- users edit ends -->
</div>
@endsection()
@push('script')
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('users.problem.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#problem-table";
        addData(method, storeUrl, formData, formId, reload);
    });
</script>
@endpush