@extends('dash.layouts.app')
@section('title', 'ربط الصلاحيات بالدور | وزارة التنمية الاجتماعية')
@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                    @foreach ($permissions as $permission)
                            <div class="form-group box_permission col-md-3">
                                <ul class="nav my-2">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input selectAll" data-id="{{ $permission->id }}"
                                                type="checkbox" id="{{ $permission->id }} "
                                                onchange="update('{{ $role->id }}', '{{ $permission->id }}')"
                                                @foreach ($role->permissions as $item)
                                                    @checked($role->id == $item->pivot->role_id && $permission->id == $item->pivot->permission_id) @endforeach>
                                            <label for="{{ $permission->id }}"
                                                class="custom-control-label fw-bolder">{{ $permission->name }} - {{ $permission->name_ar }}</label>
                                        </div>

                                        @foreach ($permission->childrens as $item)
                                            <ul class="nav ps-1">
                                                <li>
                                                    <input class="custom-control-input selectItems_{{ $permission->id }}"
                                                        type="checkbox" id="{{ $item->id }}"
                                                        onchange="update('{{ $role->id }}', '{{ $item->id }}')"
                                                        @foreach ($role->permissions as $item_2)
                                                            @checked($role->id == $item_2->pivot->role_id && $item->id == $item_2->pivot->permission_id) @endforeach>
                                                    <label for="{{ $permission->id }}"
                                                        class="custom-control-label">{{ $item->name }} - {{ $item->name_ar }}</label>
                                                </li>
                                            </ul>
                                        @endforeach

                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ========================================== -->
 
</section>
@endsection()
@push('script')

<script>
    // Click on "Check All" 
    $('#check-all').click(function() {
        if ($(this).prop('checked')) {
            $('.custom-control-input').prop('checked', true);
        } else {
            $('.custom-control-input').prop('checked', false);
        }
    });
    // =====
    // Save Check
    $('body').on('click', '#refreshFilter', function(e) {
        e.preventDefault();
        var selectedIds = [];
        var table = $('#copon-table');

        table.find('input[type="checkbox"]:checked').each(function() {
            selectedIds.push($(this).attr('id').replace('copon-', ''));
        });

        if (selectedIds.length > 0) {
            // فتح المودال هنا
            $('#selectionModal').modal('show');

            // عند النقر على زر تأكيد داخل المودال
            $('#confirmSelection').off('click').on('click', function() {
                var formData = {
                    selectedIds: selectedIds,
                    is_recive: $('#is_recive').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: "{{ route('copons.refreshStatus') }}",
                    data: formData,
                    success: function(response) {
                        $('#copon-table').DataTable().ajax.reload();
                        showMessage({
                            icon: 'success',
                            title: 'تم تحديث الحالة بنجاح '
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
                        alert(errorMessage);
                        $('#selectionModal').modal('hide');
                    }
                });
            });
        } else {
            showMessage({
                icon: 'error',
                title: 'لتحديث حالة الترشيح يرجى اختيار المرشحين اولا'
            });
        }
    });
    // =============================
    $('body').on('click', '#deleteCopon', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        var deleteUrl = "{{ url('/') }}" + '/dash/copons/' + id;
        var reload = "#copon-table";
        var to_route = "#";
        deleteRow(deleteUrl, to_route, reload);
    });
    // =============================
    // Export excel
    $(document).ready(function() {
        // Export excel
        $('body').on('click', '#exportButton', function(e) {
            e.preventDefault();
            var selectedIds = [];
            var table = $('#copon-table');

            table.find('input[type="checkbox"]:checked').each(function() {
                selectedIds.push($(this).attr('id').replace('copon-', ''));
            });

            if (selectedIds.length > 0) {
                var formData = {
                    selectedIds: selectedIds,
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'GET',
                    url: "{{ route('copons.ExportEcel') }}",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response, status, xhr) {
                        var blob = new Blob([response], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var fileName = disposition ? disposition.split('filename=')[1].split(';')[0] : 'copons.xlsx';
                        link.download = fileName.replace(/['"]/g, '');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage({
                            icon: 'success',
                            title: 'تم التصدير بنجاح'
                        });
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء العملية. حاول مرة أخرى.';
                        showMessage({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            } else {
                showMessage({
                    icon: 'error',
                    title: 'يرجى الاختيار أولا لتتم عملية تصدير ملف Excel'
                });
            }
        });
    });
</script>
@endpush