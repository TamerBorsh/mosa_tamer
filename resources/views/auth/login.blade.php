@extends('auth.app')
@section('content')
<section class="row flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <img src="/logo.png" alt="branding logo"  height="200px"><br>
                        <h2 class="pt-1" style=" font-family: 'JazeeraFont' !important; font-weight: 700; ">وزارة التنمية الاجتماعية</h2>
                    </div>
                </div>
                <div class="card-content">
                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>سجل دخولك للمتابعة</span></p>
                    <div class="card-body">
                        <form class="form-horizontal" id="login" novalidate>
                            
                            <input type="hidden" name="guard" value="{{ $guard }}">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" id="user-name" name="login_type" placeholder="اليوزرنيم أو رقم الموبايل" required>
                                <div class="form-control-position">
                                    <i class="la la-user"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control" id="user-password" name="password" placeholder="كلمة المرور" required>
                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                    <fieldset>
                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                        <label for="remember-me"> تذكرني</label>
                                    </fieldset>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> دخول</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection()
@push('script')
<script>
    function seeting_toastr() {
        toastr.options = {
            "closeButton": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "rtl": true
        };
    }

    $("#login").submit(function(e) {
        e.preventDefault();
        axios.post("{{ route('auth.authenticate') }}", new FormData(this))
            .then(function(response) {
                window.location.href = "{{ route('dash.index') }}";
            })
            .catch(function(error) {
                seeting_toastr();
                var message = (error.response.status === 422) ?
                    Object.values(error.response.data.errors)[0][0] : error.response.data.message;
                toastr.error(message);
            });

    });
</script>
@endpush