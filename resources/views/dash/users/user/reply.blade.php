@extends('dash.layouts.app')
@section('title', 'الشكاوي | وزارة التنمية الاجتماعية')
@section('stylesheet')
<link rel="stylesheet" href="/datatables-bs5/dataTables.min.css">
@endsection
@section('content')
<section class="row all-contacts">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">All Contacts</h4>
                                        <div class="heading-elements mt-0">
                                            <button class="btn btn-primary btn-sm " data-toggle="modal" data-target="#AddContactModal"><i class="d-md-none d-block ft-plus white"></i>
                                                <span class="d-md-block d-none">Add Contacts</span></button>
                                            <div class="modal fade" id="AddContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <section class="contact-form">
                                                            <form id="form-add-contact" class="contact-input">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel1">Add New Contact</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="contact-name" class="contact-name form-control" placeholder="Name">
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="contact-email" class="contact-email form-control" placeholder="Email">
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="contact-phone" class="contact-phone form-control" placeholder="Phone Number">
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="checkboxsmallallq">
                                                                            <label class="custom-control-label" for="checkboxsmallallq">favorite</label>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="file" class="form-control-file" id="user-image">
                                                                    </fieldset>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                        <button type="button" id="add-contact-item" class="btn btn-info add-contact-item" data-dismiss="modal"><i class="la la-paper-plane-o d-block d-lg-none"></i> <span class="d-none d-lg-block">Add New</span></button>
                                                                    </fieldset>
                                                                </div>
                                                            </form>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="EditContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <section class="contact-form">
                                                            <form id="form-edit-contact" class="contact-input">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Contact</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="name" class="name form-control" placeholder="Name">
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="email" class="email form-control" placeholder="Email">
                                                                    </fieldset>
                                                                    <fieldset class="form-group col-12">
                                                                        <input type="text" id="phone" class="phone form-control" placeholder="Phone Number">
                                                                    </fieldset>
                                                                    <span id="fav" class="d-none"></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                        <button type="button" id="edit-contact-item" class="btn btn-info edit-contact-item" data-dismiss="modal"><i class="la la-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">Edit</span></button>
                                                                    </fieldset>
                                                                </div>
                                                            </form>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="dropdown">
                                                <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-warning dropdown-toggle dropdown-menu-right btn-sm"><i class="ft-download-cloud white"></i></button>
                                                <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="ft-upload"></i> Import</a>
                                                    <a href="#" class="dropdown-item"><i class="ft-download"></i> Export</a>
                                                    <a href="#" class="dropdown-item"><i class="ft-shuffle"></i> Find Duplicate</a>
                                                </span>
                                            </span>
                                            <button class="btn btn-default btn-sm"><i class="ft-settings white"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Task List table -->
                                        <button type="button" class="btn btn-sm btn-danger delete-all mb-1">Delete All</button>
                                        <div class="table-responsive">
                                            <div id="users-contacts_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="users-contacts_length"><label>Show <select name="users-contacts_length" aria-controls="users-contacts" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="users-contacts_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="users-contacts"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="users-contacts" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle text-center dataTable" role="grid" aria-describedby="users-contacts_info">
                                                <thead>
                                                    <tr role="row"><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-label="
                                                            
                                                                
                                                                
                                                            
                                                        : activate to sort column ascending" style="width: 21px;">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmallall">
                                                                <label class="custom-control-label" for="checkboxsmallall"></label>
                                                            </div>
                                                        </th><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-sort="descending" aria-label="Name: activate to sort column ascending" style="width: 144.266px;">Name</th><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 150.094px;">Email</th><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 86.7031px;">Phone</th><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-label="Favorite: activate to sort column ascending" style="width: 52.9844px;">Favorite</th><th class="sorting" tabindex="0" aria-controls="users-contacts" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 114.344px;">Actions</th></tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    

                                                    
                                                    
                                                    
                                                    
                                                    

                                                    
                                                    
                                                    
                                                    
                                                    



                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                <tr role="row" class="odd">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall14">
                                                                <label class="custom-control-label" for="checkboxsmall14"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-9.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Will Trumpt</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">will@example.com</a>
                                                        </td>
                                                        <td class="phone">+289-614-504</td>
                                                        <td class="text-center">
                                                            <div class="favorite active" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-on.png" title="Favorite"><input name="score" type="hidden" value="1"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop15" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop15" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall15">
                                                                <label class="custom-control-label" for="checkboxsmall15"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-10.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Verty Barny</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">verty@example.com</a>
                                                        </td>
                                                        <td class="phone">+132-954-114</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop16" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop16" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="odd">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall16">
                                                                <label class="custom-control-label" for="checkboxsmall16"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Steffy Agile</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">steffy@example.com</a>
                                                        </td>
                                                        <td class="phone">+699-654-238</td>
                                                        <td class="text-center">
                                                            <div class="favorite active" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-on.png" title="Favorite"><input name="score" type="hidden" value="1"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop17" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop17" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall20">
                                                                <label class="custom-control-label" for="checkboxsmall20"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Sinthia Tecker</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">Sinthia@example.com</a>
                                                        </td>
                                                        <td class="phone">+987-654-564</td>
                                                        <td class="text-center">
                                                            <div class="favorite active" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-on.png" title="Favorite"><input name="score" type="hidden" value="1"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop21" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop21" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="odd">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall6">
                                                                <label class="custom-control-label" for="checkboxsmall6"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-5.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Scott Marshall</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">scott@example.com</a>
                                                        </td>
                                                        <td class="phone">+954-654-564</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop7" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop7" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall4">
                                                                <label class="custom-control-label" for="checkboxsmall4"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Russell Bryant</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">russell@example.com</a>
                                                        </td>
                                                        <td class="phone">+235-654-564</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop5" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop5" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="odd">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall19">
                                                                <label class="custom-control-label" for="checkboxsmall19"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-13.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Rushee Brent</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">rushee@example.com</a>
                                                        </td>
                                                        <td class="phone">+135-614-594</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop20" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop20" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall21">
                                                                <label class="custom-control-label" for="checkboxsmall21"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-4.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Rose Wends</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">rose@example.com</a>
                                                        </td>
                                                        <td class="phone">+387-694-567</td>
                                                        <td class="text-center">
                                                            <div class="favorite active" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-on.png" title="Favorite"><input name="score" type="hidden" value="1"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop22" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop22" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="odd">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall26">
                                                                <label class="custom-control-label" for="checkboxsmall26"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-5.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Prezi Henz</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">prezi@example.com</a>
                                                        </td>
                                                        <td class="phone">+194-854-857</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop27" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop27" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall25">
                                                                <label class="custom-control-label" for="checkboxsmall25"></label>
                                                            </div>
                                                        </td>
                                                        <td class="sorting_1">
                                                            <div class="media">
                                                                <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span></div>
                                                                <div class="media-body media-middle">
                                                                    <a class="media-heading name">Missy Loen</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="email" href="mailto:email@example.com">missi@example.com</a>
                                                        </td>
                                                        <td class="phone">+987-654-564</td>
                                                        <td class="text-center">
                                                            <div class="favorite" style="cursor: pointer;"><img alt="1" src="../../../app-assets/images/raty/star-off.png" title="Favorite"><input name="score" type="hidden"></div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" data-target="#EditContactModal" class="primary edit mr-1"><i class="la la-pencil"></i></a>
                                                            <a class="danger delete mr-1"><i class="la la-trash-o"></i></a>
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop26" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right"><i class="la la-ellipsis-v"></i></a>
                                                                <span aria-labelledby="btnSearchDrop26" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a data-toggle="modal" data-target="#EditContactModal" class="dropdown-item edit"><i class="ft-edit-2"></i>
                                                                        Edit</a>
                                                                    <a href="#" class="dropdown-item delete"><i class="ft-trash-2"></i> Delete</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle primary"></i> Projects</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Team</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Clients</a>
                                                                    <a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Friends</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr></tbody>
                                                <tfoot>
                                                    <tr><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Email</th><th rowspan="1" colspan="1">Phone</th><th rowspan="1" colspan="1">Favorite</th><th rowspan="1" colspan="1">Actions</th></tr>
                                                </tfoot>
                                            </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="users-contacts_info" role="status" aria-live="polite">Showing 1 to 10 of 30 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="users-contacts_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="users-contacts_previous"><a href="#" aria-controls="users-contacts" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="users-contacts" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="users-contacts" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="users-contacts" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item next" id="users-contacts_next"><a href="#" aria-controls="users-contacts" data-dt-idx="4" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
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
<script>
    // Save Data
    $("#addDataForm").on('submit', function(e) {
        e.preventDefault();
        var method = "post";
        var storeUrl = "{{ route('users.problem.store') }}";
        var formData = new FormData(this) // OR new FormData($('#addDataForm')[0]);
        var formId = "#addDataForm";
        var reload = "#problem-table";
        addData(method, storeUrl, formData, formId, reload);
    });
</script>
@endpush