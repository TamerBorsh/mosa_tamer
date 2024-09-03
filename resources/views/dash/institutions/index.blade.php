@extends('dash.layouts.app')
@section('title', 'المؤسسات | وزارة التنمية الاجتماعية')
@section('stylesheet')
<script src="/datatables-bs5/dataTables.min.css"></script>
@endsection
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-min-width mr-1 mb-1" data-toggle="modal" data-backdrop="false" data-target="#add"> <i class="la la-plus-square"></i> أضف جديد</button>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        {!! $dataTable->table([
                                        'class' => 'table table-bordered table-striped dataTable no-footer',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <div class="form-group">
        <!-- Modal -->
        <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="card-body">
                        <form class="form" id="addDataForm" method="post">
                            @csrf
                            @method('post')
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-edit"></i>إضافة جديد</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">اسم المؤسسة</label>
                                            <input type="text" id="name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">
                                    <i class="ft-x"></i> الغاء
                                </button>
                                <button type="submit" class="btn btn-info">
                                    <i class="la la-check-square-o"></i> حفظ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="card-body">

                        <form class="form" id="updateDataForm" method="post">
                            @csrf
                            @method('post')
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-edit"></i>تعديل بيانات</h4>
                                <div class="row">
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="e_name">اسم الموظف</label>
                                            <input type="text" id="e_name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">
                                    <i class="ft-x"></i> الغاء
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> حفظ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
</section>
@endsection()
@push('script')
<script src="/datatables-bs5/dataTables.min.js"></script>
{!! $dataTable->scripts() !!}
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('institutions.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#institution-table";
        addData(method, storeUrl, formData, formId, reload);
    });
    // =============================
    $('body').on('click', '#editRow', function() {
        let id = $(this).data('id');
        // ====
        //Show Data In Form Where Click ShowRow
        axios.get("{{ url('/') }}" + '/dash/institutions/' + id + '/edit')
            .then(function(response) {
                console.log(response)
                $('#id').val(response.data.id);
                $('#e_name').val(response.data.name);
            });

        // ====
        // Update Data
        $("#updateDataForm").on('submit', function(e) {
            e.preventDefault();
            var method = "post";
            var storeUrl = "{{ route('institutions.updateData') }}";
            var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
            var formId = "";
            var reload = "#institution-table";

            addData(method, storeUrl, formData, formId, reload);
        });
    })
    // =============================
    $('body').on('click', '#deleteInstitution', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/institutions/' + id;
        var reload = "#institution-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
</script>
@endpush