@extends('admin.layout.master')
@section('title')
    Student
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">{{ucfirst($type)}}
                @if(auth()->user()->can('index User'))
                    <a href="{{route('User.index')}}" class="float-end rounded btn btn-sm btn-info">All Student</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{route('User.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card ">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror " placeholder="First Name" id="firstname" name="first_name" value="{{ old('first_name') }}">
                                                    <label for="firstname">First Name <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror " placeholder="Last Name" id="lastname" name="last_name" value="{{ old('last_name') }}">
                                                    <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form row">
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="dob" id="dob" name="dob" value="{{ old('dob') }}" max="{{date('Y-m-d')}}" >
                                                    <label for="dob">DOB<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" aria-label="Gender" name="gender" >
                                                        <option selected value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <select class="form-select @error('blood_group') is-invalid @enderror" id="blood_group" aria-label="blood_group" name="blood_group" >
                                                        <option value="">Select Blood group</option>
                                                        <option value="A+">A positive (A+)</option>
                                                        <option value="A-">A negative (A-)</option>
                                                        <option value="B+">B positive (B+)</option>
                                                        <option value="B-">B negative (B-)</option>
                                                        <option value="O+">O positive (O+)</option>
                                                        <option value="O-">O negative (O-)</option>
                                                        <option value="AB+">AB positive (AB+)</option>
                                                        <option value="AB-">AB negative (AB-)</option>
                                                    </select>
                                                    <label for="blood_group">Blood Group</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating g-2 mb-3">
                                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" placeholder="father name" id="father-name" name="father_name" value="{{ old('father_name') }}">
                                            <label for="father-name">Father Name<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-floating g-2 mb-3">
                                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" placeholder="mother name" id="mother-name" name="mother_name" value="{{ old('mother_name') }}">
                                            <label for="mother-name">Mother Name<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-floating g-2 mb-3">
                                            <input type="text" class="form-control @error('father_occupation') is-invalid @enderror" placeholder="Occupation" id="father-occupation" name="father_occupation" value="{{ old('father_occupation') }}">
                                            <label for="father-occupation">Father's Occupation<span class="text-danger">*</span></label>
                                        </div>

                                        <div class="form row">
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <input type="text" class="form-control @error('parent_contact_number') is-invalid @enderror" placeholder="Contact number" id="parent-contact-number" name="parent_contact_number" value="{{ old('parent_contact_number') }}">
                                                    <label for="parent-contact-number">Parent Contact number(+88)<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Contact number" id="contact-number" name="contact_number" value="{{ old('contact_number') }}">
                                                    <label for="contact-number">Contact number(+88)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating g-2 mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}">
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form row">
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <textarea class="form-control @error('present_address') is-invalid @enderror" placeholder="present-address" id="present-address" name="present_address" style="height: 100px">{{ old('present_address')}}</textarea>
                                                    <label for="present-address">Present Address<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <textarea class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Permanent Address" id="permanent-address" name="permanent_address" style="height: 100px">{{ old('permanent_address')}}</textarea>
                                                    <label for="permanent-address">Permanent Address<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating g-2 mb-3">
                                            <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" accept="image/*" name="avatar">
                                            <label for="formFile">Image</label>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating g-2 mb-3">
                                                    <select class="form-select @error('group_id') is-invalid @enderror" id="group" aria-label="Group" name="group_id" >
                                                        <option selected value="">Choose one</option>
                                                        @foreach($groups as $row)
                                                            <option  value="{{$row->id}}">{{$row->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="group">Group<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        @if($type == "create")
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating g-2 mb-3">
                                                        <select class="form-select @error('year') is-invalid @enderror" id="year" aria-label="Year" name="year" >
                                                            <option selected value="">Choose one</option>
                                                            @foreach($years as $row)
                                                                <option  value="{{$row}}">{{$row}}</option>
                                                            @endforeach
                                                        </select>
                                                        <label for="year">Admission Year<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg g-2 ">Save</button>
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
        $(document).ready(function(){});
    </script>
@endsection
