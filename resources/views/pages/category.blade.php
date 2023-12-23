@extends('layouts.app')
@section('title', 'Category')
@include('components.navbar')
@include('components.sidebar')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Category Table</h1>
        <div class="table-buttons">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#basicModal">
                Add Category
            </button>
        </div>
    </div>
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expenses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Create Category</h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="categoryForm" action="{{ route('category.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="" selected>Top-level category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <h5 class="card-title">Total Category Table</h5>

                <<table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td></td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">Delete</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the category "{{ $category->name }}"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                    @endforeach
                    </tbody>
                </table>
                {{$categories->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </section>
</main>
