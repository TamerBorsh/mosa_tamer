@extends('dash.layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="/datatables-bs5/dataTables.min.css">
@endsection
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> <button type="button" class="btn btn-success btn-min-width mr-1 mb-1" data-toggle="modal" data-target="#addNew"><i class="la la-check"></i>
                            أضف جديد</button></h4>

                    <!-- Modal -->
                    <div class="modal fade text-left" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <label class="modal-title text-text-bold-600" id="myModalLabel33">أضف جديد</label>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="create">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">
                                        <label>الاسم</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="إغلاق">
                                        <input type="submit" class="btn btn-outline-primary btn-lg" value="حفظ">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
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
</section>
@endsection()
@push('script')
<script src="/datatables-bs5/dataTables.min.js"></script>
<script src="/datatables-bs5/dataTables.bootstrap5.min.js"></script>{!! $dataTable->scripts() !!}
@endpush