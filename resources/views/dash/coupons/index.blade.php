@extends('dash.layouts.app')
@section('title', 'الكابون | وزارة التنمية الاجتماعية')
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
                                <h4 class="form-section"><i class="la la-edit"></i>إضافة جديد</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">الاسم</label>
                                            <input type="text" id="name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="institution_id">المؤسسة</label>
                                                <select class="form-control" id="institution_id" name="institution_id" require>
                                                    @foreach ($institutions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="location_id">البركس أو المخزن</label>
                                                <select class="form-control" id="location_id" name="location_id" require>
                                                    @foreach ($locations as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="type">نوع الطرد</label>
                                                <select class="form-control" id="type" name="type" require>
                                                    <option value="1">غذائي</option>
                                                    <option value="2">صحي</option>
                                                    <option value="3">pdding</option>
                                                    <option value="4">أُخرى</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">الكمية</label>
                                            <input type="text" id="quantity" class="form-control" name="quantity" require>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="notes">ملاحظات</label>
                                            <textarea id="notes" rows="3" class="form-control" name="notes" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="ملاحظات" data-original-title="" title=""></textarea>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="card-body">
                        <form class="form" id="updateDataForm" method="post">
                            @csrf
                            @method('post')
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-edit"></i>إضافة جديد</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="e_name">الاسم</label>
                                            <input type="text" id="e_name" class="form-control" name="name" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="e_institution_id">المؤسسة</label>
                                                <select class="form-control" id="e_institution_id" name="institution_id" require>
                                                    @foreach ($institutions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="e_location_id">البركس أو المخزن</label>
                                                <select class="form-control" id="e_location_id" name="location_id" require>
                                                    @foreach ($locations as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset class="form-group position-relative">
                                                <label for="e_type">نوع الطرد</label>
                                                <select class="form-control" id="e_type" name="type" require>
                                                    <option value="1">غذائي</option>
                                                    <option value="2">صحي</option>
                                                    <option value="3">pdding</option>
                                                    <option value="4">أُخرى</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="e_quantity">الكمية</label>
                                            <input type="text" id="e_quantity" class="form-control" name="quantity" require>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="e_notes">ملاحظات</label>
                                            <textarea id="e_notes" rows="3" class="form-control" name="notes" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="ملاحظات" data-original-title="" title=""></textarea>
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
    </div>
    <!-- ========================================== -->
</section>
@endsection()
@push('script')
<script src="/datatables-bs5/datatables-bootstrap5.js" defer></script>
{!! $dataTable->scripts() !!}
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('coupons.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#coupon-table";
        addData(method, storeUrl, formData, formId, reload);
    });
    // =============================
    $('body').on('click', '#editRow', function() {
        let id = $(this).data('id');
        // ====
        //Show Data In Form Where Click ShowRow
        axios.get("{{ url('/') }}" + '/dash/coupons/' + id + '/edit')
            .then(function(response) {
                console.log(response)
                $('#id').val(response.data.id);
                $('#e_name').val(response.data.name);
                $('#e_institution_id').val(response.data.institution_id);
                $('#e_location_id').val(response.data.location_id);
                $('#e_type').val(response.data.type);
                $('#e_quantity').val(response.data.quantity);
                $('#e_notes').val(response.data.notes);
            });
        // ====
        // Update Data
        $("#updateDataForm").on('submit', function(e) {
            e.preventDefault();
            var method = "post";
            var storeUrl = "{{ route('coupons.updateData') }}";
            var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
            var formId = "";
            var reload = "#coupon-table";
            addData(method, storeUrl, formData, formId, reload);
        });
    })
    // =============================
    $('body').on('click', '#deleteCoupon', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/coupons/' + id;
        var reload = "#coupon-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
    // =============================
</script>
@endpush