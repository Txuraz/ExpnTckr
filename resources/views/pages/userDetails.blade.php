<!-- usersList.blade.php -->

@extends('layouts.app')

@section('title', 'Users List')

@include('components.navbar')
@include('components.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Users List</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-container">
                    <h4>Total Users</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->first()->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal{{$user->id}}">Delete</button>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateUserModal{{$user->id}}">Update</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$users->links('pagination::bootstrap-5')}}
                </div>
            </div>



            <!-- Delete User Modal -->
            @foreach($users as $user)
                <div class="modal fade" id="deleteUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel{{$user->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalLabel{{$user->id}}">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this user?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{route('user.delete', $user->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update User Modal -->
                <div class="modal fade" id="updateUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel{{$user->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateUserModalLabel{{$user->id}}">Update User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.update', $user->id) }}" method="post">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group">
                                        <label for="updateUserName">Name</label>
                                        <input type="text" name="name" class="form-control" id="updateUserName" placeholder="Enter name" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="updateUserEmail">Email</label>
                                        <input type="email" name="email" class="form-control" id="updateUserEmail" placeholder="Enter email" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="updateUserRole">Role</label>
                                        <select name="role_id" class="form-control" id="updateUserRole">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
</main>


