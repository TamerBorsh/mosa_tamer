@extends('dash.layouts.app')
@section('title', 'إنشاء رول جديد')
@section('stylesheet')
<style>
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        /* يسمح للقوائم الرئيسية بالتفاف */
    }

    .box_permission {
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 4px;
    }

    .box_permission ul {
        list-style-type: none;
        padding-left: 0;
    }

    .box_permission ul>li {
        margin-bottom: 1rem;
    }

    .child_permissions {
        list-style-type: none;
        padding-left: 1rem;
    }

    .child_permissions li {
        margin-bottom: 0.5rem;
    }

    .custom-control-label {
        margin-left: 5px;
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
                                    {{ $permission->name }} - {{ $permission->name_ar }}
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
                                    {{ $item->name }} - {{ $item->name_ar }}
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
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }).catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: error.response.data.message || 'An error occurred',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    }

    document.querySelectorAll(".selectAll").forEach(function(element) {
        element.addEventListener('change', function() {
            let isChecked = this.checked;
            document.querySelectorAll('.selectItems_' + this.dataset.id).forEach(function(childCheckbox) {
                childCheckbox.checked = isChecked;
                // Update for each child checkbox
                update('{{ $role->id }}', childCheckbox.id);
            });
        });
    });

    document.querySelectorAll(".custom-control-input:not(.selectAll)").forEach(function(element) {
        element.addEventListener('change', function() {
            update('{{ $role->id }}', this.id);
        });
    });
</script>
@endpush