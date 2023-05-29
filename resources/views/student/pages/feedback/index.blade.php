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
                                    <td>Actions</td>
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