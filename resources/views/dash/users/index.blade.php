@extends('dash.layouts.app')
@section('title', 'المستفيدين | وزارة التنمية الاجتماعية')
@section('stylesheet')
<style>
    /* Custom styles for the toggle switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
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
                                                <label>أقرب مسجد</label>
                                                <input type="text" class="form-control" name="mosque" value="{{ request('mosque') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label> عدد الأفراد</label>
                                                <input type="text" class="form-control" name="count_childern" value="{{ request('count_childern') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>الشهر</label>
                                                <input type="text" class="form-control" name="month" value="{{ request('month') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>أقل عدد استلام</label>
                                                <input type="text" class="form-control" name="min_count" value="{{ request('min_count') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="form-group validate">
                                            <div class="controls">
                                                <label>أكثر عدد استلام</label>
                                                <input type="text" class="form-control" name="max_count" value="{{ request('max_count') }}">
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
                        <form id="exportForm" action="{{ route('users.ExportEcel') }}" method="get" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-min-width mr-1 mb-1">
                                <i class="la la-file-excel-o"></i> تصدير Excel
                            </button>
                        </form>

                        <button type="button" class="btn btn-success  btn-min-width mr-1 mb-1" id="storeNominate"> <i class="la la-share-alt"></i> ترشيح</button>
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
        <div class="modal fade text-left" id="backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel4">عرض التفاصيل</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- ====== -->
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                                                <i class="ft-user mr-25"></i><span class="d-none d-sm-block">معلومات</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab" href="#information" aria-controls="information" role="tab" aria-selected="false">
                                                <i class="ft-info mr-25"></i><span class="d-none d-sm-block">المساعدات</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                            <!-- ===================== -->
                                            <div class="card">
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <form class="form">
                                                            <div class="form-body">

                                                                <div class="form-group">
                                                                    <label for="show_name">اسم المستفيد : </label>
                                                                    <input type="text" id="show_name" class="form-control" name="issuetitle" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="اسم المستفيد" data-original-title="" title="" disabled>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_state">الولاية</label>
                                                                            <select id="show_state" disabled class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                                                @foreach ($states as $state)
                                                                                <option value="{{$state->id}}" disabled>{{$state->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_region">المنطقة</label>
                                                                            <select id="show_region" disabled class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                                                @foreach ($regions as $region)
                                                                                <option value="{{$region->id}}" disabled>{{$region->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_mosque">المسجد</label>
                                                                            <select id="show_mosque" disabled class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                                                @foreach ($mosques as $mosque)
                                                                                <option value="{{$mosque->id}}" disabled>{{$mosque->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_is_death">حالة الوفاة</label>
                                                                            <select id="show_is_death" disabled class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                                                <option value="0" disabled>حي</option>
                                                                                <option value="1" disabled>متوفي</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_id_number">الهوية</label>
                                                                            <input type="text" id="show_id_number" class="form-control" name="dateopened" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="هوية المستفيد" data-original-title="" title="" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_phone">الجوال</label>
                                                                            <input type="number" id="show_phone" class="form-control" name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="رقم جوال المستفيد" data-original-title="" title="" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_phone">الجوال 2</label>
                                                                            <input type="number" id="show_phone" class="form-control" name="datefixed" disabled data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="رقم جوال المستفيد" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_barh_of_date">تاريخ الميلاد</label>
                                                                            <input type="date" id="show_barh_of_date" class="form-control" disabled name="dateopened" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الميلاد" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_name_wife">اسم الزوجة</label>
                                                                            <input type="text" id="show_name_wife" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_id_number_wife">هوية الزوجة</label>
                                                                            <input type="text" id="show_id_number_wife" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_name_wife2">اسم الزوجة 2</label>
                                                                            <input type="text" id="show_name_wife2" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_id_number_wife2">هوية الزوجة 2</label>
                                                                            <input type="text" id="show_id_number_wife2" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_death_date">تاريخ الوفاة</label>
                                                                            <input type="date" id="show_death_date" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_socialst">الحالة الاجتماعية</label>
                                                                            <select id="show_socialst" disabled class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                                                <option value="1" disabled>أعزب</option>
                                                                                <option value="2" disabled>متزوج</option>
                                                                                <option value="3" disabled>متعدد الزوجات</option>
                                                                                <option value="4" disabled>مطلق</option>
                                                                                <option value="5" disabled>أرمل</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="show_count_children">عدد الأفراد</label>
                                                                            <input type="text" id="show_count_children" class="form-control" disabled name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="show_note">ملاحظات</label>
                                                                    <textarea id="show_note" rows="3" disabled class="form-control" name="comments" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="ملاحظات" data-original-title="" title=""></textarea>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ===================== -->
                                        </div>
                                        <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                                            <!-- ===================== -->
                                            <div class="table-responsive">
                                                <table class="table dataTable" id="table_reciver">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting">{{ __('#') }}</th>
                                                            <th class="sorting">رقم الكابون</th>
                                                            <th class="sorting">تاريخ الاستلام</th>
                                                            <th class="sorting">المخزن</th>
                                                            <th class="sorting">حالة النسليم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- ===================== -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ====== -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <!-- Modal -->
    <div class="modal fade" id="selectionModal" tabindex="-1" role="dialog" aria-labelledby="selectionModalLabel" aria-hidden="true"> <div class="modal-dialog modal-md" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="selectionModalLabel">تأكيد الاختيار</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div><div class="modal-body"> <form id="selectionForm"> <div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="coupon_id">اختر الكابون</label> <select id="coupon_id" name="coupon_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title=""> @foreach ($coupons as $coupon) <option value="{{$coupon->id}}">{{$coupon->name}}</option> @endforeach </select> </div></div><div class="col-md-6"> <div class="form-group"> <label for="recive_date">تاريخ استلام الكابون</label> <input type="date" id="recive_date" class="form-control" name="recive_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الاستلام" data-original-title="" title=""> </div></div><div class="col-md-6"> <div class="form-group"> <label for="redirect_date">تاريخ ترشيح المستفيد</label> <input type="date" id="redirect_date" class="form-control" name="redirect_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الترشيح" data-original-title="" title=""> </div></div></div></form> </div><div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button> <button type="button" class="btn btn-primary" id="confirmSelection">تأكيد</button> </div></div></div></div>
    <!-- ========================================== -->
</section>

@endsection()
@push('script')
<script src="/datatables-bs5/datatables-bootstrap5.js" defer></script>
{!! $dataTable->scripts() !!}
<script>
    $('body').on('click', '#showRow', async function() {
        const id = $(this).data('id');
        const url = "{{ url('/') }}";
        try {
            // إعداد DataTable
            $('#table_reciver').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: `${url}/dash/users/get-detalies/${id}`,
                language: {
                    url: "/datatables_ar.json",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'number_copon'
                    },
                    {
                        data: 'recive_date'
                    },
                    {
                        data: 'location_id'
                    },
                    {
                        data: 'is_recive'
                    }
                ]
            });
            // الحصول على بيانات المستخدم
            const response = await axios.get(`${url}/dash/users/${id}`);
            const data = response.data;
            // تحديث النموذج بالبيانات
            $('#show_name').val(data.name);
            $('#show_state').val(data.state_id);
            $('#show_region').val(data.region_id);
            $('#show_mosque').val(data.mosque_id);
            $('#show_is_death').val(data.is_death);
            $('#show_id_number').val(data['id-number']);
            $('#show_phone').val(data.phone);
            $('#show_phone2').val(data.phone2);
            $('#show_barh_of_date').val(data['barh-of-date']);
            $('#show_name_wife').val(data['name-wife']);
            $('#show_id_number_wife').val(data['id-number-wife']);
            $('#show_name_wife2').val(data['name-wife2']);
            $('#show_id_number_wife2').val(data['id-number-wife2']);
            $('#show_death_date').val(data.death_date);
            $('#show_socialst').val(data.socialst);
            $('#show_count_children').val(data.count_childern);
            $('#show_note').val(data.notes);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    });
    // ================
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
        var table = $('#user-table');

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
                        } else {
                            showMessage({
                                icon: 'error',
                                title: 'لا توجد كمية كافية من الكوبونات.'
                            });
                        }
                    },
                    error: function(xhr) {
                        // ...
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
    // =============================
    $('body').on('click', '#deleteUser', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/users/' + id;
        var reload = "#user-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
    // =============================
</script>
@endpush