@extends('admin.layout.master')
@section('title')
    Routine
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Routine
                @if(auth()->user()->can('index Routine'))
                    <a href="{{route('Routine.index')}}" class="float-end rounded btn btn-sm btn-success">Routine</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('Routine.store')}}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="academic_year" class="form-label ">Academic year</label>
                                    <select class="form-select" id="academic_year" name="academic_year" required>
                                        <option selected>Choose...</option>
                                        @foreach($years as $year)
                                            <option value="{{$year}}">{{$year}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <fieldset class="border border-secondary p-2 mt-2">
                                    <legend class="float-none w-auto ">Class Routine</legend>
                                    <div id="routine">
                                        <div class="row" id="field_1">
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label for="class_time_id_1" class="form-label ">Class Time</label>
                                                    <select class="form-select" id="class_time_id_1"
                                                            name="class_time_id[]" required>
                                                        <option selected>Choose...</option>
                                                        @foreach($times as $time)
                                                            <option value="{{$time->id}}">{{$time->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="teacher_id_1" class="form-label ">Teacher</label>
                                                    <select class="form-select" id="teacher_id_1" name="teacher_id[]">
                                                        <option selected value="0">Choose...</option>
                                                        @foreach($teachers as $teacher)
                                                            <option
                                                                value="{{$teacher->id}}">{{$teacher->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label for="group_id_1" class="form-label ">Group</label>
                                                    <select class="form-select" id="group_id_1" name="group_id[]"
                                                             onchange="changeGroup('group_id_1' , 1)">
                                                        <option selected value="0">Choose...</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->id}}">{{$group->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="subject_id_1" class="form-label ">Subject</label>
                                                    <select class="form-select"  id="subject_id_1" name="subject_id[]"
                                                            >
                                                        <option selected value="0">Choose...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label for="is_break_1" class="form-label ">Break</label>
                                                    <select class="form-select"  id="is_break_1" name="is_break[]"
                                                    >
                                                        <option selected value="0">No</option>
                                                        <option  value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="note_1" class="form-label ">Note</label>
                                                    <input type="text" class="form-control " id="note_1" name="note[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary g-2 mt-3 " onclick="handle_add()">
                                            <i class="align-middle" data-feather="plus"></i>
                                        </button>
                                    </div>
                                </fieldset>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary float-end">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        let field_count = 2;
        const field = $("#routine");
        let lastRemovedId = [];

        const changeGroup = (group, count) => {
            const id = $(`#${group}`).find(":selected").val();
            if (id !== 0) {
                ajaxsetup();
                $.ajax({
                    type: 'get',
                    url: "/admin/get-subject/" + id,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 404) {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            )
                        } else {
                            let subject = $(`#subject_id_${count}`).empty();
                            $.each(response.subject, function (key, val) {
                                subject.append('<option value ="' + val.subject.id + '">' + val.subject.name + '</option>');
                            });
                        }
                    }
                })
            }

        }

        const handle_add = () => {
            let formField = `<div class="row mt-3" id="field_${field_count}">
             <div class="col-md-2">
             <div class="form-group mb-3">
             <label for="class_time_id_${field_count}" class="form-label ">Class Time</label>
             <select class="form-select" id="class_time_id_${field_count}" name="class_time_id[]" required>
            <option selected value="0">Choose...</option>
            @foreach($times as $time)
            <option value="{{$time->id}}">{{$time->name}} </option>
             @endforeach
            </select>
        </div>
    </div>
<div class="col-md-3">
<div class="form-group mb-3">
<label for="teacher_id_${field_count}" class="form-label ">Teacher</label>
                                        <select class="form-select" id="teacher_id_${field_count}" name="teacher_id[]" >
                                            <option selected value="0">Choose...</option>
                                                @foreach($teachers as $teacher)
            <option value="{{$teacher->id}}">{{$teacher->name}} </option>
                                                 @endforeach
            </select>
        </div>
    </div>
     <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label for="group_id_${field_count}" class="form-label ">Group</label>
                                                    <select class="form-select" id="group_id_${field_count}" name="group_id[]"
                                                             onchange="changeGroup('group_id_${field_count}' , ${field_count})">
                                                        <option selected value="0">Choose...</option>
                                                        @foreach($groups as $group)
            <option value="{{$group->id}}">{{$group->name}} </option>
                                                        @endforeach
            </select>
        </div>
    </div>
     <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="subject_id_${field_count}" class="form-label ">Subject</label>
                                                    <select class="form-select" id="subject_id_${field_count}" name="subject_id[]">
                                                        <option selected value="0">Choose...</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label for="is_break_${field_count}" class="form-label ">Break</label>
                                                    <select class="form-select"  id="is_break_${field_count}" name="is_break[]"
                                                    >
                                                        <option selected value="0">No</option>
                                                        <option  value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                               <div class="col-md-10 mb-3">
                                                <div class="form-group mb-3">
                                                    <label for="note_${field_count}" class="form-label ">Note</label>
                                                    <input type="text" class="form-control " id="note_${field_count}" name="note[]">
                                                </div>
                                            </div>

                                             <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <button type="button" class="btn btn-danger " onclick="handle_remove(${field_count})">
                                                        -
                                                    </button>
                                                </div>
                                            </div>

</div>`;
            field.append(formField);
            field_count++;
        }

        const handle_remove = (id)=>{
            document.getElementById(`field_${id}`).remove();
        }

    </script>
@endsection
