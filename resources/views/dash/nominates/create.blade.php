@extends('dash.layouts.app')
@section('title', 'المرشحين | وزارة التنمية الاجتماعية')
@section('stylesheet')
<link href="/css/select2.min.css" rel="stylesheet" />
<style>
    #loadingIndicator {
        position: fixed;
        /* اجعل العنصر ثابتاً بالنسبة للشاشة */
        top: 50%;
        /* ضعه في منتصف الشاشة عموديًا */
        left: 50%;
        /* ضعه في منتصف الشاشة أفقيًا */
        transform: translate(-50%, -50%);
        /* لتوسيط العنصر تمامًا */
        z-index: 9999;
        /* ضعه في الطبقة الأعلى */
        display: none;
        /* اجعله مخفيًا افتراضيًا */
    }

    .spinner-border {
        width: 3rem;
        /* حجم مؤشر التحميل */
        height: 3rem;
        /* حجم مؤشر التحميل */
        color: #007bff;
        /* لون مؤشر التحميل (يمكنك تغييره) */
    }
</style>
@endsection
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form id="filter" method="post">
                            @method('post')
                            @csrf
                            <div class="row ">
                                <!-- إدخال البيانات هنا -->
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
                                    <label for="is_active">حالة المستفيد</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="is_active" name="is_active">
                                            <option value=""></option>
                                            <option value="1" @selected(request('is_active')=='1' )>نشط</option>
                                            <option value="2" @selected(request('is_active')=='2' )>مجمد</option>
                                        </select>
                                    </fieldset>
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
                                    <label for="gender">الجنس</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="gender" name="gender">
                                            <option value=""></option>
                                            <option value="male" @selected(request('gender')=="male" )>ذكر</option>
                                            <option value="fmale" @selected(request('gender')=="fmale" )>أنثى</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="gender">الحالة الاجتماعية</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="socialst" name="socialst">
                                            <option value=""></option>
                                            <option value="1" @selected(request('socialst')=="1" )>أعزب</option>
                                            <option value="2" @selected(request('socialst')=="2" )>متزوج</option>
                                            <option value="3" @selected(request('socialst')=="3" )>متعدد الزوجات</option>
                                            <option value="4" @selected(request('socialst')=="4" )>أرمل</option>
                                            <option value="5" @selected(request('socialst')=="5" )>مطلق</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="form-group validate">
                                        <div class="controls">
                                            <label>عدد الأفراد من وإلى</label>
                                            <div class="d-flex">
                                                <input type="number" class="form-control mr-2" name="childern_min" placeholder="من">
                                                <input type="number" class="form-control" name="childern_max" placeholder="إلى">
                                            </div>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="form-group validate">
                                        <div class="controls">
                                            <label>شهر تسليم الكابون وعدد مرات الاستلام</label>
                                            <div class="d-flex">
                                                <input type="number" class="form-control mr-2" name="month" placeholder="شهر">
                                                <input type="number" class="form-control mr-2" name="min_count" placeholder="أقل عدد">
                                                <input type="number" class="form-control" name="max_count" placeholder="أقصى عدد">
                                            </div>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="couponid">ألا يكون استفاد من :</label>
                                    <fieldset class="form-group">
                                        <select class="form-control js-example-basic-single" id="couponid" name="couponid[]" multiple>
                                            @foreach($coupons as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
                                    <button class="btn btn-block btn-info glow" id="exportWithSearch"> <i class="la la-search"></i> بحث</button>
                                </div>
                            </div>
                        </form>

                        <!-- قسم الجدول -->
                        <div class="row justify-content-center mt-4" id="hidetam" style="display:none;">
                            <div class="col-12">
                                <button type="button" class="btn btn-success  btn-min-width mr-1 mb-1" id="storeNominate" style="color: #fff;display: block !important;margin-right: auto !important;"> <i class="la la-share-alt"></i>ترشيح المستفيدين</button>

                                <table id="resultsTable" class="table table-bordered table-striped dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="check-all" class="custom-control-input">
                                                    <label class="custom-control-label" for="check-all"></label>
                                                </div>
                                            </th>
                                            <th>الهوية</th>
                                            <th>اسم المستفيد</th>
                                            <th>المنطقة</th>
                                            <th>تاريخ الميلاد</th>
                                            <th>عدد الأفراد</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- سيتم تعبئة النتائج هنا بواسطة JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- نهاية قسم الجدول -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============== -->
    <!-- Modal -->
    <div class="modal fade" id="selectionModal" tabindex="-1" role="dialog" aria-labelledby="selectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectionModalLabel">تأكيد الاختيار</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form id="selectionForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> <label for="coupon_id">اختر الكابون</label> <select id="coupon_id" name="coupon_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title=""> @foreach ($coupons as $coupon) <option value="{{$coupon->id}}">{{$coupon->name}}</option> @endforeach </select> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> <label for="recive_date">تاريخ استلام الكابون</label> <input type="date" id="recive_date" class="form-control" name="recive_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الاستلام" data-original-title="" title=""> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> <label for="redirect_date">تاريخ ترشيح المستفيد</label> <input type="date" id="redirect_date" class="form-control" name="redirect_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الترشيح" data-original-title="" title=""> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> <label for="block_date">تاريخ انتهاء صرف الكابون</label> <input type="date" id="block_date" class="form-control" name="block_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الترشيح" data-original-title="" title="" require> </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button> <button type="button" class="btn btn-primary" id="confirmSelection">تأكيد</button> </div>
            </div>
        </div>
    </div>
    <!-- ============ -->
</section>
<div id="loadingIndicator" style="display: none;">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
   
</div>
@endsection
@push('script')
<script src="/js/select2.min.js"></script>
<script src="/datatables-bs5/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // تهيئة Select2
        $('.js-example-basic-single').select2({
            width: 'resolve', // يساعد في حل مشكلة عرض Select2
            placeholder: 'اختر الكوبونات',
            allowClear: true
        });

        // إخفاء الجدول في البداية
        $('#hidetam').hide();

        // تهيئة DataTables
        var table = $('#resultsTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            lengthMenu: [25, 50, 100, 200, 300, 500, 1000, 2000],
            language: {
                url: '/datatables_ar.json'
            },
            ajax: {
                url: "{{ route('nominates.filter') }}",
                type: 'POST',
                data: function(d) {
                    d.name = $('input[name="name"]').val();
                    d.is_active = $('select[name="is_active"]').val();
                    d.state_id = $('select[name="state_id"]').val();
                    d.region_id = $('select[name="region_id"]').val();
                    d.gender = $('select[name="gender"]').val();
                    d.socialst = $('select[name="socialst"]').val();
                    d.count_childern_min = $('input[name="childern_min"]').val();
                    d.count_childern_max = $('input[name="childern_max"]').val();
                    d.month = $('input[name="month"]').val();
                    d.min_count = $('input[name="min_count"]').val();
                    d.max_count = $('input[name="max_count"]').val();
                    d.couponid = $('select[name="couponid[]"]').val();
                    d._token = "{{ csrf_token() }}";
                },
                beforeSend: function() {
                    // منع الطلب إذا كانت جميع الحقول فارغة
                    if (!$('input[name="name"]').val() && !$('select[name="is_active"]').val() &&
                        !$('select[name="state_id"]').val() && !$('select[name="region_id"]').val() &&
                        !$('select[name="gender"]').val() && !$('select[name="socialst"]').val() &&
                        !$('input[name="count_childern"]').val() && !$('input[name="month"]').val() &&
                        !$('input[name="min_count"]').val() && !$('input[name="max_count"]').val() &&
                        !$('select[name="couponid[]"]').val()) {
                        return false; // منع الطلب إذا كانت الحقول فارغة
                    }
                }
            },
            columns: [{
                    data: 'check',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id-number',
                    name: 'id-number'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'region_id',
                    name: 'region_id'
                },
                {
                    data: 'barh-of-date',
                    name: 'barh-of-date'
                },
                {
                    data: 'count_childern',
                    name: 'count_childern'
                }
            ]
        });

        // التعامل مع تقديم النموذج
        $('#filter').on('submit', function(e) {
            e.preventDefault();
            table.ajax.reload(); // إعادة تحميل البيانات بناءً على البحث
            $('#hidetam').show(); // إظهار الجدول بعد تقديم النموذج
        });
        // ==================================
        // Click on "Check All" 
        $('#check-all').click(function() {
            if ($(this).prop('checked')) {
                $('.custom-control-input').prop('checked', true);
            } else {
                $('.custom-control-input').prop('checked', false);
            }
        });
        // =====
        // store Nominate
        $('body').on('click', '#storeNominate', function(e) {
            e.preventDefault();
            var selectedIds = [];
            var table = $('#resultsTable');

            table.find('input[type="checkbox"]:checked').each(function() {
                var id = $(this).attr('id').replace('user-', '');
                if (id !== 'check-all') { // تأكد من عدم إضافة 'check-all'
                    selectedIds.push(id);
                }
            });

            if (selectedIds.length > 0) {
                // فتح المودال هنا
                $('#selectionModal').modal('show');

                // عند النقر على زر تأكيد داخل المودال
                $('#confirmSelection').off('click').on('click', function() {
                    // إظهار مؤشر التحميل
                    $('#loadingIndicator').show();

                    // التحقق من الكمية المتاحة للكوبونات
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('coupons.checkQuantity') }}", // مسار إلى وظيفة للتحقق من الكمية
                        data: {
                            selectedIds: selectedIds,
                            coupon_id: $('#coupon_id').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // إذا كانت الكمية كافية، قم بإرسال الطلب لحفظ البيانات
                                var formData = {
                                    selectedIds: selectedIds,
                                    coupon_id: $('#coupon_id').val(),
                                    recive_date: $('#recive_date').val(),
                                    redirect_date: $('#redirect_date').val(),
                                    _token: '{{ csrf_token() }}'
                                };
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ route('nominates.store') }}",
                                    data: formData,
                                    success: function(response) {
                                        showMessage({
                                            icon: 'success',
                                            title: 'تم ترشيح الأسماء بنجاح'
                                        });
                                        // إعادة تعيين النموذج
                                        $('#selectionModal').find('form')[0].reset();
                                        $('#selectionModal').modal('hide');
                                        // إخفاء مؤشر التحميل
                                        $('#loadingIndicator').hide();
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
                                        // إخفاء مؤشر التحميل
                                        $('#loadingIndicator').hide();
                                    }
                                });
                            } else {
                                showMessage({
                                    icon: 'error',
                                    title: 'لا توجد كمية كافية من الكوبونات.'
                                });
                                // إخفاء مؤشر التحميل
                                $('#loadingIndicator').hide();
                            }
                        },
                        error: function(xhr) {
                            // ...
                            // إخفاء مؤشر التحميل
                            $('#loadingIndicator').hide();
                        }
                    });
                });
            } else {
                showMessage({
                    icon: 'error',
                    title: 'يرجى اختيار مرشحين أولا.'
                });
            }
        });



    });
</script>

@endpush