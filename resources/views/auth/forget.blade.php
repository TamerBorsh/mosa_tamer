@extends('auth.app')
@section('title', 'نسيت كلمة المرور | وزارة التنمية الاجتماعية')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                            <div class="card-header border-0 pb-0">
                                <div class="card-title text-center">
                                    <img src="/logo.png" alt="branding logo" height="80px">
                                    <h4 class="text-center pt-2" style=" font-family: 'JazeeraFont' !important; ">وزارة التنمية الاجتماعية</h4>
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span style=" font-family: 'JazeeraFont' !important; ">تحديث كلمة المرور من خلال رقم الهوية</span></h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if (session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    @if (session('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                    @endif
                                    <form class="form-horizontal" id="reset" action="{{ route('auth.isFound') }}" method="POST">
                                        @csrf
                                        @method('post')
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control @error('id-number') is-invalid @enderror" id="id-number" name="id-number" placeholder="رقم هويتك .." required>
                                            @error('id-number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </fieldset>
                                        <div class="row">
                                    
                                            <div class="col-12">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور الجديدة" required="">
                                                </fieldset>
                                            </div>
                                            <div class="col-6">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="number" class="form-control" id="barh-of-date" name="barh-of-date" placeholder="سنة ميلادك" required="" minlength="4" maxlength="4" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);">
                                                </fieldset>
                                            </div>
                                            <div class="col-6">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="number" class="form-control" id="id-number-wife" name="id-number-wife" placeholder="رقم هوية الزوجة ..">
                                                </fieldset>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-outline-info btn-lg btn-block my-2">
                                            <i class="ft-unlock"></i> تحديث كلمة المرور
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection