@extends('admin.layout.master')
@section('title')
    Module
@endsection
@section('content')
    <main class="content p-0">
        <div class="row d-flex justify-content-center">
                <div class="col-12  ">
                    <div class="w-100">
                        <div class="row">
                            <form action="{{ route('Module.store') }}" method="POST" id="module">
                                @csrf
                                <div class="card ">
                                    <div class="card-header ">
                                        <h3>Add New Module</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Module Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           placeholder="Enter module name" value="{{ old('name') }}">
                                                    <ul class="text-danger d-none" id="errorList"></ul>
                                                    <p class="text-danger d-none" id="errors"></p>
                                                    <p class="text-success d-none" id="message"></p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Module Type</label>
                                                    <br>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" type="radio" name="type" id="spa"
                                                           checked value="spa">
                                                    <label class="form-check-label" for="spa">SPA</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type" id="regular"
                                                           value="regular">
                                                    <label class="form-check-label" for="regular">Regular</label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <h4 class="mt-4">Schema Builder</h4>
                                        <div id="field" class="mt-3">
                                            <div id="field_1">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row" >
                                                            <div class="col-md-1 ">
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="field_name_1">Name</label>
                                                                        <input type="text" class="form-control "
                                                                               id="field_name_1" name="field[name][]" required>
                                                                        <ul class="text-danger d-none" id="errorList"></ul>
                                                                        <p class="text-danger d-none" id="errors"></p>
                                                                        <p class="text-success d-none" id="message"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="datatype_1">Data</label>
                                                                    <select class="form-control" id="datatype_1"
                                                                            name="field[type][]" required
                                                                            onchange="dataTypeSelect('1')">
                                                                        <option value="">.....</option>
                                                                        @foreach ($dataType as $type)
                                                                            <option value="{{ $type }}">{{ ucFirst($type) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="inputType_1">Input</label>
                                                                    <select class="form-control" id="inputType_1"
                                                                            name="field[inputType][]" required>
                                                                        <option value="">.....</option>
                                                                        @foreach ($inputType as $type)
                                                                            <option value="{{ $type }}">{{ ucFirst($type) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="nullable_1">Nullable</label>
                                                                    <select class="form-control" id="nullable_1" name="field[is_nullable][]">
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no" selected>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="unique_1">Unique</label>
                                                                    <select class="form-control" id="unique_1" name="field[is_unique][]">
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no" selected>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" >
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="default_1">Default</label>
                                                                        <input type="text" class="form-control " id="default_1" name="field[default][]" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="field_char_1" id="label_char_1">Length</label>
                                                                        <input type="text" class="form-control " readonly id="field_char_1" name="field[char][]" max="255">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" >
                                                                <div class="form-group">
                                                                    <label for="field_foreign_1" id="label_foreign_1">Model</label>
                                                                    <select class="form-control" id="field_foreign_1" readonly name="field[foreign][]" >
                                                                        <option value="" selected>......</option>
                                                                        @foreach ($availableModels as $row)
                                                                            <option value="{{ $row->name }}">
                                                                                {{ ucFirst($row->name) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="field_precision_1" id="label_precision_1">Precision</label>
                                                                        <input type="text" class="form-control " readonly id="field_precision_1" name="field[precision][]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="field_scale_1" id="label_scale_1">Scale</label>
                                                                        <input type="text" class="form-control " readonly id="field_scale_1" name="field[scale][]" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="enum1_value_1" id="label_enum1_1">Enum</label>
                                                                        <input type="text" class="form-control " readonly id="enum1_value_1" name="field[enum1][]" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" >
                                                                <div class="form-inline">
                                                                    <div class="form-group ">
                                                                        <label for="enum2_value_1" id="label_enum2_1">Enum</label>
                                                                        <input type="text" class="form-control " readonly id="enum2_value_1" name="field[enum2][]" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group my-auto">
                                                            <button type="button" class="btn btn-primary g-2 mt-3 " id="add_1" onclick="handle_add('1')">
                                                                <span >+</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer ">
                                        <div class="form-group float-end">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
@section('script')
    <script>
        let field_count = 2;
        let lastRemovedId = [];
        const field = $("#field");

        const dataTypeSelect =(id)=>{
            const val = $(`#datatype_${id}`).val();
            const enum1Field = $(`#enum1_value_${id}`);
            const enum2Field = $(`#enum2_value_${id}`);
            const enum1Label = $(`#label_enum1_${id}`);
            const enum2Label = $(`#label_enum2_${id}`);

            const foreignField = $(`#field_foreign_${id}`);
            const foreignLabel = $(`#label_foreign_${id}`);

            const scaleField = $(`#field_scale_${id}`);
            const precisionField = $(`#field_precision_${id}`);
            const scaleLabel = $(`#label_scale_${id}`);
            const precisionLabel = $(`#label_precision_${id}`);
            const charField = $(`#field_char_${id}`);
            const charLabel = $(`#label_char_${id}`);

            if (val === 'enum') {
                removeReadonlyAttr(enum1Field);
                removeReadonlyAttr(enum2Field);
                addColorAndBold(enum1Label);
                addColorAndBold(enum2Label);
            }
            else if (val !== 'enum') {
                removeCurrentValue(enum1Field);
                removeCurrentValue(enum2Field);
                addReadonlyAttr(enum1Field);
                addReadonlyAttr(enum2Field);
                removeLabelColorAndBold(enum1Label);
                removeLabelColorAndBold(enum2Label);
            }
            if ( val === 'unsignedBigInteger' || val === 'unsignedInteger' || val ===
                'unsignedMediumInteger' || val ===
                'unsignedSmallInteger' || val === 'unsignedTinyInteger') {
                removeReadonlyAttr(foreignField);
                addColorAndBold(foreignLabel);
            }
            else if ( val !== "unsignedBigInteger" || val !== "unsignedInteger" || val !==
                "unsignedMediumInteger" || val !==
                "unsignedSmallInteger" || val !== "unsignedTinyInteger") {
                removeCurrentValue(foreignField);
                addReadonlyAttr(foreignField);
                removeLabelColorAndBold(foreignLabel);
            }
            if (val === 'decimal' || val === 'double' || val === 'float' || val === "unsignedDecimal") {
                removeReadonlyAttr(scaleField);
                removeReadonlyAttr(precisionField);
                addColorAndBold(scaleLabel);
                addColorAndBold(precisionLabel);
            }
            else if (val !== 'decimal' || val !== 'double' || val !== 'float' || val !== 'unsignedDecimal') {
                removeCurrentValue(scaleField);
                removeCurrentValue(precisionField);
                addReadonlyAttr(scaleField);
                addReadonlyAttr(precisionField);
                removeLabelColorAndBold(scaleLabel);
                removeLabelColorAndBold(precisionLabel);
            }
            if (val === 'char' || val === 'string') {
                removeReadonlyAttr(charField);
                addColorAndBold(charLabel);
            }
            else if (val !== 'char' || val !== 'string') {
                removeCurrentValue(charField);
                addReadonlyAttr(charField);
                removeLabelColorAndBold(charLabel);
            }
        }

        const removeReadonlyAttr = (field)=>{
            if (field.attr('readonly') === "readonly") {
                field.removeAttr("readonly");
            }
        };

        const addColorAndBold = (labelField)=>{
            labelField.css("color", "#029d37");
            labelField.addClass("fw-bold");
        };

        const removeCurrentValue = (field)=>{
            field.val("");
        };

        const addReadonlyAttr = (field)=>{
            if (field.attr('readonly') !== "readonly") {
                field.attr("readonly",true);
            }
        };

        const removeLabelColorAndBold = (field)=>{
            field.css("color", "#495057");
            field.removeClass("fw-bold");
        };

        //custom validation that check is name start with capital letter or not
        $.validator.addMethod("ucFirst", function(value, element) {
            return this.optional(element) || /^[A-Z][a-zA-Z0-9_-]{1,198}$/.test(value);
        }, "Name must be start with capital letter");

        $("#module").validate({
            errorClass: "error text-danger fw-bold",
            rules: {
                name: {
                    required: true,
                    ucFirst: true
                },

            },
        });

        const findPreviousId = (id)=>{
            for(let i = id-1 ; i => 1 ; i--){
                const prevField = document.getElementById(`field_${i}`);
                if(  prevField ) {
                        return i;
                }
            }
        }

        const findNextId = (id)=>{
            for(let i = id+1 ; i <= field_count ; i++){
                const nextField = document.getElementById(`field_${i}`);
                if(  nextField ) {
                    return i;
                }
            }
            return 0;
        }

        const handle_remove = (id)=>{
            const next =  findNextId(id);
            const prevId = findPreviousId(id);
            const addBtn = $(`#add_${id-1}`);
            const preAddBtn = $(`#add_${ prevId }`);
            if( !lastRemovedId.includes(id-1) ){
                if(next === 0){
                    if (addBtn.hasClass('d-none')) {
                        addBtn.removeClass('d-none');
                    }
                }
            }else if( lastRemovedId.includes(id-1) ){
                if(next === 0){
                    if ( preAddBtn.hasClass('d-none')) {
                        preAddBtn.removeClass('d-none');
                    }
                }
            }else{
                if ( addBtn.hasClass('d-none') ) {
                    addBtn.removeClass('d-none');
                }

            }
            document.getElementById(`field_${id}`).remove();
            lastRemovedId[lastRemovedId.length] = id;
        }

        const handle_add = (id)=>{
            const addBtn = $(`#add_${id}`);
            if (!addBtn.hasClass('d-none')) {
                addBtn.addClass('d-none');
            }
            let formField = `<div id="field_${field_count}" class="mt-3">
                  <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-inline">
                                        <div class="form-group ">
                                            <label for="field_name_${field_count}">Name</label>
                                            <input type="text" class="form-control" id="field_name_${field_count}" name="field[name][]" required>
                                            <ul class="text-danger d-none" id="errorList"></ul>
                                            <p class="text-danger d-none" id="errors"></p>
                                            <p class="text-success d-none" id="message"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="datatype_${field_count}">Data</label>
                                        <select class="form-control" id="datatype_${field_count}" name="field[type][]" required onchange="dataTypeSelect('${field_count}')">
                                            <option value="">.....</option>
                                            @foreach ($dataType as $type)
                                            <option value="{{ $type }}">{{ ucFirst($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                         <label for="inputType_${field_count}">Input</label>
                                         <select class="form-control" id="inputType_${field_count}" name="field[inputType][]" required>
                                             <option value="">.....</option>
                                            @foreach ($inputType as $type)
                                            <option value="{{ $type }}">{{ ucFirst($type) }}</option>
                                            @endforeach
                                        </select>
                                   </div>
                               </div>
                               <div class="col-md-1">
                                   <div class="form-group">
                                        <label for="nullable_${field_count}">Nullable</label>
                                        <select class="form-control" id="nullable_${field_count}" name="field[is_nullable][]">
                                            <option value="yes">Yes</option>
                                            <option value="no" selected>No</option>
                                        </select>
                                        </div>
                                   </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                             <label for="unique_${field_count}">Unique</label>
                                             <select class="form-control" id="unique_${field_count}" name="field[is_unique][]">
                                                 <option value="yes">Yes</option>
                                                 <option value="no" selected>No</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1" >
                                        <div class="form-inline">
                                             <div class="form-group ">
                                                 <label for="default_${field_count}">Default</label>
                                                 <input type="text" class="form-control " id="default_${field_count}" name="field[default][]" >
                                             </div>
                                        </div>
                                    </div>
                                     <div class="col-md-1">
                                        <div class="form-inline">
                                             <div class="form-group ">
                                                 <label for="field_char_${field_count}" id="label_char_${field_count}">Length</label>
                                                 <input type="text" class="form-control " readonly id="field_char_${field_count}" name="field[char][]" max="255">
                                             </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                       <div class="form-group">
                                             <label for="field_foreign_${field_count}" id="label_foreign_${field_count}">Model</label>
                                             <select class="form-control" id="field_foreign_${field_count}" name="field[foreign][]" readonly>
                                                 <option value="" selected>.....</option>
                                                @foreach ($availableModels as $row)
                                                <option value="{{ $row->name }}">{{ ucFirst($row->name) }}</option>
                                                @endforeach
                                            </select>
                                       </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-inline">
                                             <div class="form-group ">
                                                 <label for="field_precision_${field_count}" id="label_precision_${field_count}">Precision</label>
                                                        <input type="text" class="form-control " readonly id="field_precision_${field_count}" name="field[precision][]">
                                             </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-inline">
                                             <div class="form-group ">
                                                 <label for="field_scale_${field_count}" id="label_scale_${field_count}">Scale</label>
                                                 <input type="text" class="form-control " id="field_scale_${field_count}" name="field[scale][]" readonly>
                                             </div>
                                        </div>
                                    </div>
                                     <div class="col-md-1">
                                <div class="form-inline">
                                     <div class="form-group ">
                                         <label for="enum1_value_${field_count}" id="label_enum1_${field_count}">Enum</label>
                                         <input type="text" class="form-control " id="enum1_value_${field_count}" name="field[enum1][]" readonly>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-inline">
                                     <div class="form-group ">
                                         <label for="enum2_value_${field_count}" id="label_enum2_${field_count}">Enum</label>
                                         <input type="text" class="form-control " id="enum2_value_${field_count}" name="field[enum2][]" readonly>
                                     </div>
                                </div>
                            </div>
                            </div>
                               </div>

                            <div class="col-md-2">
                                <div class="form-group my-auto">
                                    <button type="button" class="btn btn-primary g-2 mt-3 " id="add_${field_count}" onclick="handle_add(${field_count})">
                                        +
                                    </button>

                                    <button type="button" class="btn btn-danger g-2 mt-3 " id="id="remove_${field_count}" onclick="handle_remove(${field_count})">
                                        -
                                    </button>
                                </div>
                            </div>
                        </div>
                  </div>
              </div>
            </div>`;
            field.append(formField);
            field_count++;
        }

    </script>
@endsection
