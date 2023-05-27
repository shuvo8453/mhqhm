@extends('admin.layout.master')
@section('title')
    Activity Log
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Activity Log</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-border " id="data">
                                <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Subject Id</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $row)
                                    <tr>
                                        <td> {{$row['subject']}}</td>
                                        <td> {{$row['subject_id']}}</td>
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
        $(document).ready(function() {
            $('#data').DataTable({
                "order": false
            });
        });
    </script>
@endsection