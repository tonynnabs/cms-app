@extends('layouts.app')


@section('content')

    <div class="d-flex justify-content-end m-2">
        <a href="{{ route('tags.create') }}" class="btn btn-success">
            Add tag
        </a>
    </div>

    <div class="card">
        <div class="card-header">Tags
        </div>
        <div class="card-body">
            @if ($tags->count() > 0)
                <table class="table">
                    <thead>
                        <th>NAME</th>
                        <th>POST COUNT</th>
                        <th></th>
                    </thead>

                    <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>
                                    {{ $tag->name }}
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info">Edit</a>
                                    <button class="btn btn-danger "
                                        onclick="handleDelete( {{ $tag->id }})">Delete</button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No tags Yet</h3>
            @endif

            <!-- Modal -->
            <form action="" id="deletetagForm" method="POST">
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
            var form = document.getElementById('deletetagForm')
            form.action = '/tags/' + id
            $('#deleteModal').modal('show')
        }

    </script>
@endsection
