@extends('admin.layouts.admin_master')
@section('title')
Roles
@endsection
@section('admin')
<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Name</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Home</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('update-roles') }}" method="post">
    @csrf
    <input type="hidden" name="uuid" value="{{ $role->uuid }}">
    <div class="row">
        <div class="col-md-12">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Permissions</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkPermissionAll">All</label>
                                </div>
                                <hr>
                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @php
                                        $permissions = App\Models\User::getpermissionsByGroupName(
                                        $group->name,
                                        );
                                        $j = 1;
                                        @endphp
                                        @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                            <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                        @php $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-info mt-4 pr-4 pl-4">Save User</button>
                    </div>
                </div>
            </section>
        </div>
    </div>

</form>

<script>
    document.getElementById('checkPermissionAll').onclick = function() {
        var checkboxes = document.querySelectorAll('.form-check-input[name="permissions[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }

        var groupCheckboxes = document.querySelectorAll('[id$="Management"]');
        for (var groupCheckbox of groupCheckboxes) {
            groupCheckbox.checked = this.checked;
            if (this.checked) {
                checkPermissionByGroup(groupCheckbox.id.replace('Management', 'management-checkbox'),
                    groupCheckbox);
            } else {
                checkPermissionByGroup(groupCheckbox.id.replace('Management', 'management-checkbox'),
                    groupCheckbox);
            }
        }
    }

    function checkPermissionByGroup(className, checkThis) {
        const classCheckBox = $('.' + className + ' input');
        if ($(checkThis).is(':checked')) {
            classCheckBox.prop('checked', true);
        } else {
            classCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }

    function implementAllChecked() {
        const countPermissions = {
            {
                count($permissions)
            }
        };
        const countPermissionGroups = {
            {
                count($permission_groups)
            }
        };
        if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
            $("#checkPermissionAll").prop('checked', true);
        } else {
            $("#checkPermissionAll").prop('checked', false);
        }
    }
</script>
@endsection