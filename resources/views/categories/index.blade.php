@extends('layouts.app')


@section('content')

    <div class="d-flex justify-content-end m-2">
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-header">Categories
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>NAME</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info">Edit</a>
                                <button class="btn btn-danger "
                                    onclick="handleDelete( {{ $category->id }})">Delete</button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal -->
            <form action="" id="deleteCategoryForm" method="POST">
                @csrf

                @method('DELETE')

                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center text-bold">
                                    <h4>Are you sure you want to delete ?</h4>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Go back</button>
                                <button type="submit" class="btn btn-danger">Yes, delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function handleDelete(id) {
            var form = document.getElementById('deleteCategoryForm')
            form.action = '/categories/' + id
            $('#deleteModal').modal('show')
        }

    </script>
@endsection
