<!-- @abdullah zahid joy-->
@extends('admin.layout.master')
@section('title')
    Donor
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 fw-bold">Donor
                <a href="#" class="float-end btn btn-sm btn-primary rounded" data-bs-toggle="modal" data-bs-target="#add"> <i class="fa-solid fa-plus"></i> </a>
            </h1>

            <!-- Modal for add  -->
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add_Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_Label">Add Donor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="addForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="save_errorList"></ul>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label ">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"  required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label ">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"  >
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label ">Address</label>
                                    <textarea class="form-control" id="address" name="address"  ></textarea>
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
            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit_Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_Label">Edit Donor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="editForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="edit_errorList"></ul>
                                <input type="hidden" id="edit_id" name="id" >

                                <div class="form-group mb-3 edit_name">
                                    <label for="edit_name" class="form-label ">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name"  required>
                                </div>
                                <div class="form-group mb-3 edit_phone">
                                    <label for="edit_phone" class="form-label ">Phone</label>
                                    <input type="text" class="form-control" id="edit_phone" name="phone"  >
                                </div>
                                <div class="form-group mb-3 edit_address">
                                    <label for="edit_address" class="form-label ">Address</label>
                                    <textarea class="form-control" id="edit_address" name="address"  ></textarea>
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
                                    <th>Name</th>
                                    <th>Phone</th>

                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

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
        //url for edit ,fetch ,delete
        const model = "/admin/donor";
        const textAreas = ["address","edit_address"];
        $(document).ready(function(){

            for (let textArea of textAreas){
                $(`#${textArea}`).ckeditor();
            }
            fetch();

            //fetch data
            function fetch(){
                ajaxsetup();
                $('#data').DataTable({
                    "order": [[ 0, "desc" ]],
                    responsive: true,
                    language: {
                        searchPlaceholder: 'Search...',
                        sSearch: '',
                        lengthMenu: '_MENU_ items/page',
                    },
                    processing: true,
                    serverSide:true,
                    ajax: model,
                    columns:[
                        {data:"id",name:'#'},
                        {data:'name',name:'Name'},
                        {data:'phone',name:'Phone'},

                        {data:"actions",name:'Actions'},
                    ]
                });
            }
        });

        //create form handle
        $(document).on('submit','#addForm',function(e){
            e.preventDefault();
            let formData = new FormData($('#addForm')[0]);

            store_handler( "{{route('Donor.store')}}" ,formData );
        });

        //edit form handle
        $(document).on('submit','#editForm',function(e){
            e.preventDefault();
            let formData = new FormData($('#editForm')[0]);

            edit_form_handle(model, $('#edit_id').val(), formData);
        });

        //prepare edit form for specific recode
        $(document).on('click','.edit_button',function(e){
            e.preventDefault();
            edit_btn_handler(model,$(this).val()).then(function(res){
                if(res.status === 200){
                    $('#edit_id').val(res.data.id);
                    $('#edit_name').val(res.data.name);
                    $('#edit_phone').val(res.data.phone);
                    $('#edit_address').val(res.data.address);

                    $(`.edit_status > input[type="radio"]`).each((index , input) =>{
                        if(res.data.status === input.value){
                            input.checked= true;
                        }
                    });
                }
            });
        });

        //delete recode
        $(document).on('click','.delete_button', function(e){
            e.preventDefault();
            delete_handler(model,$(this).val());
        });

    </script>
@endsection
