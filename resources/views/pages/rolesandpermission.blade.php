@extends('layouts.app')
@section('title', 'Manage Permissions')
@include('components.navbar')
@include('components.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Manage Permissions</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-6">

                <form method="post" action="">
                    @csrf
                    <div class="mb-3">
                        <h5>Admin Role</h5>
                    </div>

                    <div class="mb-3">
                        <h5>Permissions</h5>
                        @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rolePermissions[admin][]" value="{{ $permission->id }}">
                                <label class="form-check-label" for="{{ $permission->name }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Update Permissions for Admin</button>
                </form>

            </div>
            <div class="col-lg-6">

                <form method="post" action="">
                    @csrf
                    <div class="mb-3">
                        <h5>User Role</h5>
                    </div>

                    <div class="mb-3">
                        <h5>Permissions</h5>
                        @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rolePermissions[user][]" value="{{ $permission->id }}">
                                <label class="form-check-label" for="{{ $permission->name }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Update Permissions for User</button>
                </form>

            </div>
        </div>
    </section>

</main>
