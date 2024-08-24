@extends('dash.layouts.app')


@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="info">{{$users}}</h3>
                            <h6> جميع المستفيدين</h6>
                        </div>
                        <div>
                            <i class="la la-users info font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 100%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">{{$usersInCurrentMonthCount}}</h3>
                            <h6>المستفيدين خلال الشهر الحالي</h6>
                        </div>
                        <div>
                            <i class="la la-user-plus success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="warning">{{$usersNotInCurrentMonth}}</h3>
                            <h6>غير المستفيدين الشهر الحالي</h6>
                        </div>
                        <div>
                            <i class="la la-user warning font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="danger">{{$userInActive}}</h3>
                            <h6>المستفيدين المجمدين</h6>
                        </div>
                        <div>
                            <i class="la la-user-times danger font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="card-title">البركسات والمخازن</div>
                    <canvas id="ChartLocation" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="card-title">المستفيدين</div>
                    <canvas id="ChartRecive" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

<script src="/js/chart.js"></script>

<script>
    fetchAndRenderChart("{{ route('dash.ChartRecive') }}", "ChartRecive", "pie");
    // fetchAndRenderChart("{{ route('dash.ChartLocation') }}", "ChartLocation", "polarArea");
    // fetchAndRenderChart("{{ route('dash.ChartLocation') }}", "ChartLocation", "line");
    fetchAndRenderChart("{{ route('dash.ChartLocation') }}", "ChartLocation", "bar");

    // fetchAndRenderChart("{{ route('dash.ChartLocation') }}", "ChartLocation", "radar");
</script>

@endpush