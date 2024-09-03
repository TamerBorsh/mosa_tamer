@extends('dash.layouts.app')
@section('title', 'الموظفين | وزارة التنمية الاجتماعية')
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


</section>
@endsection()
@push('script')
<script src="/datatables-bs5/dataTables.min.js"></script>

{!! $dataTable->scripts() !!}
<script>
    $('body').on('click', '#deleteLog', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/logs/' + id;
        var reload = "#log-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
</script>
@endpush