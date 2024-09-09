@extends('dash.layouts.app')
@section('title', 'صرف الكابون | وزارة التنمية الاجتماعية')
@section('content')
<section id="configuration">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body card-dashboard">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h3 class="text-center" style="font-family: 'JazeeraFont' !important; margin: 10px 0;">صرف الكابون للمستفيد</h3>
                        </div>
                        <div class="col-12 col-lg-8">
                            <form id="addDataForm" class="d-flex justify-content-center" method="post">
                                @csrf
                                @method('post')
                                <div class="row w-100">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group validate">
                                            <label>رقم الهوية أو رقم الكابون:</label>
                                            <input type="text" class="form-control" name="number" value="{{ request('number') }}" placeholder="ابحث برقم الهوية أو رقم الكابون ..">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div style="margin-top: 2rem !important;">
                                            <button type="submit" class="btn btn-info w-100">بحث</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div style="margin-top: 2rem !important;">
                                            <button type="submit" class="btn btn-danger w-100">طباعة التقرير اليومي</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- قسم الجدول -->
                    <div class="row justify-content-center mt-4">
                        <div class="col-12">
                            <table id="resultsTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>رقم الكابون</th>
                                        <th>رقم الهوية</th>
                                        <th>اسم المستفيد</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>الهاتف</th>
                                        <th>تاريخ التسليم</th>
                                        <th>نوع الطرد</th>
                                        <th>صرف</th>
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
</section>

@endsection

@push('script')
<script>
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('nominates.search') }}";
        var formData = new FormData(this);

        $.ajax({
            type: method,
            url: storeUrl,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); // عرض البيانات للتحقق من هيكلها
                var tbody = $('#resultsTable tbody');
                tbody.empty(); // افرغ محتوى الجدول الحالي

                // قم بإضافة البيانات الجديدة إلى الجدول
                response.forEach(function(item) {
                    tbody.append(`
                    <tr>
                        <td>${item.number_copon}</td>
                        <td>${item.user['id-number']}</td>
                        <td>${item.user['name']}</td>
                         <td>${item.user['barh-of-date']}</td>
                        <td>${item.user['phone']}</td>
                        <td>${item.recive_date}</td>
                        <td>${item.coupon.CouponType}</td>
                        <td><button class="btn" id="updateRecive" style=" padding: 0; " data-id="${item.id}"><div class="fonticon-wrap"><i class="la la-check-square"></i></div></button></td>
                    </tr>
                `);
                });
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                    xhr.responseJSON.message :
                    'حدث خطأ أثناء العملية. حاول مرة أخرى.';
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ',
                    text: errorMessage
                });
            }
        });
    });
    // =======================
    $('body').on('click', '#updateRecive', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "تأكيد عملية التسليم",
            text: "أنت على وشك تأكيد عملية التسليم للمستفيد. هل أنت متأكد من رغبتك في إتمام هذه العملية؟",
            confirmButtonText: "تأكيد",
            cancelButtonText: "إلغاء",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data('id');
                axios.post("{{ route('nominates.refreshStatus') }}", {
                        selectedIds: [id],
                        is_recive: 3
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تسجيل حالة التسليم بنجاح'
                        });
                        // تأكد من تحديد tbody بشكل صحيح قبل استخدامه
                        $('tbody').empty(); // افترض أن tbody هو العنصر الذي تريد مسحه
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ',
                            text: 'لم يتم تسجيل حالة التسليم. يرجى المحاولة مرة أخرى.'
                        });
                    });
            } else if (result.isDismissed) {
                Swal.fire({
                    icon: 'info',
                    title: 'تم إلغاء العملية',
                    text: 'لم يتم تنفيذ عملية التسليم.'
                });
            }
        });
    });
</script>
@endpush