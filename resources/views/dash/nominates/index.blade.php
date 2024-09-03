@extends('dash.layouts.app')
@section('title', 'المرشحين | وزارة التنمية الاجتماعية')
@section('stylesheet')
<script src="/datatables-bs5/dataTables.min.css"></script>
@endsection
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card default-collapse collapse-icon accordion-icon-rotate">
                <a id="headingCollapse12" class="card-header info" data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
                    <div class="card-title lead collapsed"> <i class="la la-search"></i> بحث متقدم</div>
                </a>
                <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <form id="searchForm">
                                @method('get')
                                <div class="row border border-light rounded py-2 mb-2">
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>اسم المستفيد أو الهوية لأحد الزوجين</label>
                                                <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <label for="state_id">المحافظة</label>
                                        <fieldset class="form-group">
                                            <select class="form-control" id="state_id" name="state_id">
                                                <option value=""></option>
                                                @foreach ($states as $item)
                                                <option value="{{$item->id}}" @selected(request('state_id')==$item->id)>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <label for="region_id">المنطقة</label>
                                        <fieldset class="form-group">
                                            <select class="form-control" id="region_id" name="region_id">
                                                <option value=""></option>
                                                @foreach ($regions as $item)
                                                <option value="{{$item->id}}" @selected(request('region_id')==$item->id)>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <label for="is_recive">حالة الكابون</label>
                                        <fieldset class="form-group">
                                            <select class="form-control" id="is_recive" name="is_recive">
                                                <option value=""></option>
                                                <option value="1" @selected(request('is_recive')=='1' )>مرشح</option>
                                                <option value="2" @selected(request('is_recive')=='2' )>مطبوع</option>
                                                <option value="3" @selected(request('is_recive')=='3' )>مستلم</option>
                                                <option value="4" @selected(request('is_recive')=='4' )>غير مستلم</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>الشهر</label>
                                                <input type="month" class="form-control" name="month" value="{{ request('month') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>تاريخ الترشيح</label>
                                                <input type="date" class="form-control" name="redirect_date" value="{{ request('redirect_date') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>تاريخ الاستلام</label>
                                                <input type="date" class="form-control" name="nominate_date" value="{{ request('nominate_date') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                        <button class="btn btn-block btn-info glow" id="exportWithSearch"> <i class="la la-search"></i> بحث</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                        <form id="exportForm" action="{{ route('nominates.ExportEcel') }}" method="get" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-min-width mr-1 mb-1" id="exportButton">
                                <i class="la la-file-excel-o"></i> تصدير Excel
                            </button>
                        </form>


                        <button type="button" class="btn btn-success btn-min-width mr-1 mb-1" id="refreshFilter">
                            <i class="la la-share-alt"></i> تحديث الحالة
                        </button>
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
    <!-- Modal -->
    <div class="modal fade" id="selectionModal" tabindex="-1" role="dialog" aria-labelledby="selectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectionModalLabel">تحديث الحالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="selectionForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="model_is_recive">حالة الترشيح</label>
                                    <select id="model_is_recive" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                        <option value=""></option>
                                        <option value="1">مرشح</option>
                                        <option value="2">مطبوع</option>
                                        <option value="3">مستلم</option>
                                        <option value="4">غير مستلم</option>
                                    </select>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="confirmSelection">تأكيد</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection()
@push('script')
<script src="/datatables-bs5/dataTables.min.js"></script>
{!! $dataTable->scripts() !!}
<script>
    // Click on "Check All" 
    $('#check-all').click(function() {
        if ($(this).prop('checked')) {
            $('.custom-control-input').prop('checked', true);
        } else {
            $('.custom-control-input').prop('checked', false);
        }
    });
    // =====
    $('body').on('click', '#refreshFilter', function(e) {
        e.preventDefault();

        var selectedIds = [];
        var table = $('#nominate-table');

        // الحصول على جميع العناصر المختارة
        table.find('input[type="checkbox"]:checked').each(function() {
            var id = $(this).attr('id').replace('nominate-', '');
            if (id !== 'check-all') { // تأكد من عدم إضافة 'check-all'
                selectedIds.push(id);
            }
        });

        if (selectedIds.length > 0) {
            // فتح المودال هنا
            $('#selectionModal').modal('show');

            // عند النقر على زر تأكيد داخل المودال
            $('#confirmSelection').off('click').on('click', function() {
                var formData = {
                    selectedIds: selectedIds,
                    is_recive: $('#model_is_recive').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: "{{ route('nominates.refreshStatus') }}",
                    data: formData,
                    success: function(response) {
                        $('#nominate-table').DataTable().ajax.reload();
                        showMessage({
                            icon: 'success',
                            title: 'تم تحديث الحالة بنجاح '
                        });
                        // إعادة تعيين النموذج
                        $('#selectionModal').find('form')[0].reset();
                        $('#selectionModal').modal('hide');
                    },
                    error: function(xhr) {
                        // تحسين إدارة الأخطاء
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء العملية. حاول مرة أخرى.';
                        showMessage({
                            icon: 'error',
                            title: errorMessage
                        });
                        $('#selectionModal').modal('hide');
                    }
                });
            });
        } else {
            showMessage({
                icon: 'error',
                title: 'لتحديث حالة الترشيح يرجى اختيار المرشحين وتحديد حالة الاستلام'
            });
        }
    });


    // =============================
    $('body').on('click', '#deleteNominate', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/nominates/' + id;
        var reload = "#nominate-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
    // =============================
    // Export excel
    $(document).ready(function() {
        // Export excel
        $('body').on('click', '#exportButton', function(e) {
            e.preventDefault();
            var selectedIds = [];
            var table = $('#nominate-table');

            table.find('input[type="checkbox"]:checked').each(function() {
                selectedIds.push($(this).attr('id').replace('nominate-', ''));
            });

            if (selectedIds.length > 0) {
                var formData = {
                    selectedIds: selectedIds,
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'GET',
                    url: "{{ route('nominates.ExportEcel') }}",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response, status, xhr) {
                        var blob = new Blob([response], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var fileName = disposition ? disposition.split('filename=')[1].split(';')[0] : 'nominates.xlsx';
                        link.download = fileName.replace(/['"]/g, '');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage({
                            icon: 'success',
                            title: 'تم التصدير بنجاح'
                        });
                        $('#nominate-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء العملية. حاول مرة أخرى.';
                        showMessage({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            } else {
                showMessage({
                    icon: 'error',
                    title: 'يرجى الاختيار أولا لتتم عملية تصدير ملف Excel'
                });
            }
        });
    });
</script>
@endpush