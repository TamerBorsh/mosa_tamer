@extends('dash.layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="/datatables-bs5/main.css" />
@endsection
@section('content')
<section id="configuration">
    <div class="row">



        <div class="col-12">

            <div class="card">

                <div class="card-content collapse show">
                    <div class="card-header">

                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <h4 class="form-section"><i class="la la-plus-square"></i> أضف مستفيد جديد</h4>
                        </div>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form" id="addDataForm" style=" margin-top: -40px; ">
                                        @method('post')
                                        @csrf
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="show_name">اسم المستفيد </label>
                                                <input type="text" class="form-control" name="name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="اسم المستفيد" data-original-title="" title="">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="id_number">الهوية</label>
                                                        <input type="text" class="form-control" name="id-number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="هوية المستفيد" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="show_phone">الجوال</label>
                                                        <input type="number" class="form-control" name="phone" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="رقم جوال المستفيد" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="show_phone">الجوال 2</label>
                                                        <input type="number" class="form-control" name="phone2" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="رقم جوال المستفيد" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="state_id">المنطقة الرئيسية</label>
                                                        <select id="state_id" name="state_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            @foreach ($states as $state)
                                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="region_id">المنطقة المحلية</label>
                                                        <select id="region_id" name="region_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            @foreach ($regions as $region)
                                                            <option value="{{$region->id}}">{{$region->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="mosque_id">المسجد</label>
                                                        <select id="mosque_id" name="mosque_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            @foreach ($mosques as $mosque)
                                                            <option value="{{$mosque->id}}">{{$mosque->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="count_childern">عدد أفراد الأسرة</label>
                                                        <input type="number" id="count_childern" class="form-control" name="count_childern" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>تاريخ الميلاد</label>
                                                        <input type="date" class="form-control" name="barh-of-date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="تاريخ الميلاد" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gender">الجنس</label>
                                                        <select id="gender" name="gender" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            <option value="male">ذكر</option>
                                                            <option value="fmale">أنثى</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="socialst">الحالة الاجتماعية</label>
                                                        <select id="socialst" name="socialst" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            <option value="1">أعزب</option>
                                                            <option value="2">متزوج</option>
                                                            <option value="3">متعدد الزوجات</option>
                                                            <option value="4">أرمل</option>
                                                            <option value="5">مطلق</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="is_active">حالة المستفيد</label>
                                                        <select id="is_active" name="is_active" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            <option value="1">نشط</option>
                                                            <option value="0">مجمد</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="is_death">المستفيد متوفي؟</label>
                                                        <select id="is_death" name="is_death" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" data-original-title="" title="">
                                                            <option value="0">لا</option>
                                                            <option value="1">نعم</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name_wife">اسم الزوج</label>
                                                        <input type="text" id="name_wife" class="form-control" name="name-wife" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="اسم الزوج" data-original-title="" title="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="id_number_wife">هوية الزوج</label>
                                                        <input type="number" id="id_number_wife" class="form-control" name="id-number-wife" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="هوية الزوج" data-original-title="" title="">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="notes">ملاحظات</label>
                                                <textarea id="notes" rows="3" class="form-control" name="notes" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="ملاحظات" data-original-title="" title=""></textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
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

            </div>
        </div>
    </div>
    <!-- ========================================== -->

</section>
@endsection()
@push('script')
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('users.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#";

        addData(method, storeUrl, formData, formId, reload);
    });
    // =============================
</script>
@endpush