@extends('dash.layouts.app')
@section('title', 'إنشاء رول جديد')
@section('stylesheet')
<style>
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        /* يسمح للقوائم الرئيسية بالتفاف */
        gap: 1rem; /* استخدام gap لتحديد المسافة بين العناصر */
    }

    .box_permission {
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* ظل بسيط لإبراز الكارد */
        flex: 1 1 auto; /* يسمح للكارد بالنمو حسب المساحة المتاحة */
        min-width: 200px; /* تحديد الحد الأدنى للعرض لضمان تناسق التصميم */
    }

    .box_permission ul {
        list-style-type: none;
        padding-left: 0;
        margin: 0; /* إزالة الهوامش الافتراضية للقائمة */
    }

    .box_permission ul>li {
        margin-bottom: 1rem;
    }

    .child_permissions {
        list-style-type: none;
        padding-left: 1rem;
        margin: 0; /* إزالة الهوامش الافتراضية للقائمة الفرعية */
    }

    .child_permissions li {
        margin-bottom: 0.5rem;
    }

    .custom-control-label {
        margin-left: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <div class="permissions-container">
                @foreach ($permissions as $permission)
                <div class="form-group box_permission">
                    <ul>
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input selectAll" data-id="{{ $permission->id }}" type="checkbox" id="{{ $permission->id }}" onchange="update('{{ $role->id }}', '{{ $permission->id }}')" @checked($role->permissions->contains('pivot.permission_id', $permission->id))>
                                <label for="{{ $permission->id }}" class="custom-control-label fw-bolder">
                                    {{ $permission->name_ar }}
                                </label>
                            </div>
                        </li>
                    </ul>

                    <!-- Display child permissions if any -->
                    @if ($permission->childrens->isNotEmpty())
                    <ul class="child_permissions">
                        @foreach ($permission->childrens as $item)
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input selectItems_{{ $permission->id }}"
                                    type="checkbox" id="{{ $item->id }}"
                                    onchange="update('{{ $role->id }}', '{{ $item->id }}')"
                                    @checked($role->permissions->contains('pivot.permission_id', $item->id))>
                                <label for="{{ $item->id }}"
                                    class="custom-control-label">
                                     {{ $item->name_ar }}
                                </label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    function update(roleId, permissionId) {
        axios.put("{{ url('/') }}" + '/dash/roles/' + roleId + '/permissions', {
            permission_id: permissionId,
        }).then(function(response) {
            //   console.log(response);
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
        }).catch(function(error) {
            // console.log(error);
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: error.response.data.message
            })
        })
    }

    $(".selectAll").click(function() {
            $('.selectItems_' + $(this).data('id')).prop("checked", $(this).prop("checked"));
        });

    // Handle change for selectAll checkbox
    // document.querySelectorAll(".selectAll").forEach(function(element) {
    //     element.addEventListener('change', function() {
    //         let isChecked = this.checked;
    //         let childIds = [];

    //         // Collect all child permissions' IDs
    //         document.querySelectorAll('.selectItems_' + this.dataset.id).forEach(function(childCheckbox) {
    //             childCheckbox.checked = isChecked;
    //             childIds.push(childCheckbox.id);
    //         });

    //         // Include the parent permission ID as well
    //         childIds.push(this.dataset.id);

    //         // Send one update request for all selected permissions
    //         update('{{ $role->id }}', childIds);
    //     });
    // });

    // Handle change for individual child checkboxes
    // document.querySelectorAll(".custom-control-input:not(.selectAll)").forEach(function(element) {
    //     element.addEventListener('change', function() {
    //         // Send update request only for this single permission
    //         update('{{ $role->id }}', [this.id]);
    //     });
    // });
</script>


@endpush