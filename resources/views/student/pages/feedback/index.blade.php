@extends('student.layout.master')
@section('title')
    Feedback
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 fw-bold">Feedback
                <a href="#" class="float-end btn btn-sm btn-primary rounded" data-bs-toggle="modal" data-bs-target="#add"> <i class="fa-solid fa-plus"></i> </a>
            </h1>

            <!-- Modal for add  -->
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add_Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_Label">Add Feedback</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('feedback.store') }}" enctype="multipart/form-data" id="addForm">
                            @csrf
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="save_errorList"></ul>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label ">Reason</label>
                                    <input type="text" class="form-control" id="reason" name="reason"  required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bn_name" class="form-label ">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description" ></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Modal for add-->

            <!-- Modal for update  -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="edit_Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_Label">Edit Feedback</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" id="editForm" action="" enctype="multipart/form-data" id="editForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="edit_errorList"></ul>
                                @csrf
                                <div class="form-group mb-3 edit_name">
                                    <label for="edit_name" class="form-label ">Reason</label>
                                    <input type="text" class="form-control" id="edit_reason" name="reason"  required>
                                </div>
                                <div class="form-group mb-3 edit_bn_name">
                                    <label for="edit_bn_name" class="form-label ">Description</label>
                                    <input type="text" class="form-control" id="edit_description" name="description">
                                </div>
                                <div class="form-group mb-3 edit_status">
                                    <label  >Status: </label>
                                    <br>
                                    <input class="form-check-input" type="radio" name="status" id="edit_status_active" value="active" >
                                    <label class="form-check-label" for="edit_status_active">
                                        Active
                                    </label>
                                    <input class="form-check-input" type="radio" name="status" id="edit_status_inactive" value="inactive">
                                    <label class="form-check-label" for="edit_status_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end Modal for update  -->

            <!-- data table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-border" id="data">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->id }}</td>
                                    <td>{{ $feedback->reason }}</td>
                                    <td>
                                        <div class="dropright">
                                            <span class="btn btn-success rounded btn-sm px-3" type="button" id="action" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg class="svg-inline--fa fa-ellipsis-vertical" aria-hidden="true" focusable="false"
                                                     data-prefix="fas" data-icon="ellipsis-vertical" role="img" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 128 512" data-fa-i2svg="">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </svg>
                                            </span>
                                            <ul class="dropdown-menu text-center" aria-labelledby="action" style="">
                                                <li><button class="m-2 btn btn-sm btn-success edit_button rounded" class="show-feedback" onclick="showModal({{ $feedback }})">
                                                        Edit
                                                    </button>
                                                </li>
                                                <li><a href="{{ route('feedback.show', $feedback->id) }}" class="m-2 btn btn-sm btn-success rounded">View</a>
                                                </li>
                                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <li><button class="m-2 btn btn-sm btn-danger rounded" type="submit" value="2"> Delete </button></li>
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>

        function showModal(feedback) {
            $("#editModal").modal('show');

            $('#editForm').attr('action', `/feedback/${feedback.id}`);
            $('#edit_id').val(feedback.id);
            $('#edit_reason').val(feedback.reason);
            $('#edit_description').val(feedback.description);
        }

    </script>
@endsection