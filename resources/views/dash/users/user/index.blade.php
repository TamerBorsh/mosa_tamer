@extends('dash.layouts.app')
@section('title', 'الرئيسية | وزارة التنمية الاجتماعية')
@section('stylesheet')
<link rel="stylesheet" href="/datatables-bs5/dataTables.min.css">
@endsection
@section('content')
<div class="content-body">
    <!-- users edit start -->
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                                <i class="ft-user mr-25"></i><span class="d-none d-sm-block">بياناتي</span>
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
                            <form id="UpdateData">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>الاسم : </label>
                                                <input type="text" class="form-control" value="{{Auth::user()->name}}" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>الهوية : </label>
                                                <input type="text" class="form-control" value="{{ Auth::user()['id-number'] }}" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>عدد الأفراد : </label>
                                                <input type="text" class="form-control" value="{{Auth::user()->count_childern}}" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="region_id">المنطقة المحلية</label>
                                            <select id="region_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                @foreach ($regions as $region)
                                                <option value="{{$region->id}}" @selected($region->id == Auth::user()->region_id) disabled="disabled">{{$region->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label> الجوال : </label>
                                                <input type="text" class="form-control" value="{{Auth::user()->phone}}" name="phone">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">تحديث</button>
                                    </div>
                                </div>
                            </form>
                            <!-- users edit account form ends -->
                        </div>
                        <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped dataTable no-footer text-center" id="table_user">
                                    <thead>
                                        <tr>
                                            <th class="sorting">{{ __('#') }}</th>
                                            <th class="sorting">رقم الكابون</th>
                                            <th class="sorting">تاريخ الاستلام</th>
                                            <th class="sorting">المخزن</th>
                                            <th class="sorting">نوع الطرد</th>
                                            <th class="sorting">حالة التسليم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users edit ends -->
</div>
@endsection()
@push('script')
<script src="/datatables-bs5/dataTables.min.js"></script>
<script src="/datatables-bs5/dataTables.bootstrap5.min.js"></script>
<script>
    // Save Data
    // $("#UpdateData").on('submit', function(e) {
    //     e.preventDefault();
    //     var method = "post";
    //     var storeUrl = "{{ route('users.updatePhone') }}";
    //     var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
    //     var formId = "#addDataForm";
    //     var reload = "#";

    //     addData(method, storeUrl, formData, formId, reload);
    // });
    // =============================
    $('#table_user').DataTable({
        processing: true,
        bDestroy: true,
        serverSide: true,
        ajax: "{{route('users.my_detalies')}}",
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
            }, {
                data: 'type'
            },
            {
                data: 'is_recive'
            }
        ]
    });
    // =============================
    function validateSaudiPhoneNumber(phone) {
        // const regex = /^(05)[0-9]{8}$/;
        const regex = /^(059|056)[0-9]{7}$/;
        return regex.test(phone);
    }

    $(document).ready(function() {
        const phoneInput = $('input[name="phone"]');
        const helpBlock = phoneInput.siblings('.help-block');
        let originalPhoneNumber = phoneInput.val();
        let isPhoneValid = validateSaudiPhoneNumber(originalPhoneNumber);

        phoneInput.on('input', function() {
            const phoneNumber = $(this).val();

            if (phoneNumber !== originalPhoneNumber) {
                if (validateSaudiPhoneNumber(phoneNumber)) {
                    helpBlock.text('رقم الجوال صحيح');
                    helpBlock.css('color', 'green');
                    isPhoneValid = true;
                } else {
                    helpBlock.text('رقم الجوال غير صحيح');
                    helpBlock.css('color', 'red');
                    isPhoneValid = false;
                }
                helpBlock.show();
            } else {
                helpBlock.hide();
                isPhoneValid = validateSaudiPhoneNumber(phoneNumber);
            }
        });

        $("#UpdateData").on('submit', function(e) {
            e.preventDefault();

            const currentPhoneNumber = phoneInput.val();

            if (currentPhoneNumber !== originalPhoneNumber && !isPhoneValid) {
                alert('الرجاء إدخال رقم جوال صحيح قبل التحديث');
                return;
            }

            var method = "post";
            var storeUrl = "{{ route('users.updatePhone') }}";
            var formData = new FormData(this);
            var formId = "#UpdateData";
            var reload = "#";

            addData(method, storeUrl, formData, formId, reload);
        });

        // Hide help block initially
        helpBlock.hide();
    });
</script>
@endpush