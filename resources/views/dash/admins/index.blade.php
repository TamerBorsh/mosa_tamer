@extends('dash.layouts.app')
@section('title', 'الموظفين | وزارة التنمية الاجتماعية')
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
                        <!-- basic buttons -->
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
                                        'class' => 'table dataTable',
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="card-body">
                        <form class="form" id="addDataForm" method="post">
                            @csrf
                            @method('post')
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-edit"></i>إضافة موظف جديد</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">اسم الموظف</label>
                                            <input type="text" id="name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="role_id">المسمى الوظيفي</label>
                                                <select class="form-control" id="role_id" name="role_id" require>
                                                    @foreach ($roles as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">اليوزرنيم</label>
                                            <input type="text" id="username" class="form-control" name="username" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">رقم الجوال</label>
                                            <input type="text" id="phone" class="form-control" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">كلمة المرور</label>
                                            <input type="text" id="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">صورة الموظف</label>
                                        <input type="file" name="image" id="image" class="form-control">
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="card-body">

                        <form class="form" id="updateDataForm" method="post">
                            @csrf
                            @method('post')
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-edit"></i>إضافة موظف جديد</h4>
                                <div class="row">
                                    <input type="hidden" name="id" id="id">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="e_name">اسم الموظف</label>
                                            <input type="text" id="e_name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="e_role_id">المسمى الوظيفي</label>
                                                <select class="form-control" id="e_role_id" name="role_id" require>
                                                    @foreach ($roles as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="e_username">اليوزرنيم</label>
                                            <input type="text" id="e_username" class="form-control" name="username" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="e_phone">رقم الجوال</label>
                                            <input type="text" id="e_phone" class="form-control" name="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">صورة الموظف</label>
                                        <input type="file" name="image" id="image" class="form-control">
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
{!! $dataTable->scripts() !!}
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('admins.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#admin-table";

        addData(method, storeUrl, formData, formId, reload);
    });
    // =============================
    $('body').on('click', '#editRow', function() {
        let id = $(this).data('id');
        // ====
        //Show Data In Form Where Click ShowRow
        axios.get("{{ url('/') }}" + '/dash/admins/' + id + '/edit')
            .then(function(response) {
                console.log(response)
                $('#id').val(response.data.id);
                $('#e_name').val(response.data.name);
                $('#e_role_id').val(response.data.roles.map(role => role.id).join(','));
                $('#e_username').val(response.data.username);
                $('#e_phone').val(response.data.phone);
            });

        // ====
        // Update Data
        $("#updateDataForm").on('submit', function(e) {
            e.preventDefault();
            var method = "post";
            var storeUrl = "{{ route('admins.updateData') }}";
            var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
            var formId = "";
            var reload = "#admin-table";

            addData(method, storeUrl, formData, formId, reload);
        });
    })
    // =============================
    $('body').on('click', '#deleteAdmin', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/admins/' + id;
        var reload = "#admin-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
</script>
@endpush