function ajaxsetup() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function notification(type, message) {
    Swal.fire({
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 1500,
        toast: true
    });
}

function delete_handler(model, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxsetup();
            $.ajax({
                type: 'DELETE',
                url: `${model}/${id}`,
                dataType: 'json',
                success: function (res) {
                    if (res.status === 404) {
                        notification("error", res.message)
                    } else {
                        $('#data').DataTable().draw();

                    }
                },
                error: (error)=>{
                    notification("error",error.responseText ?? "something went wrong")
                }

            })
        }
    })
}

function edit_btn_handler(model, id) {
    $('#edit').modal('show');
    ajaxsetup();
    return $.ajax({
        type: 'get',
        url: `${model}/${id}/edit`,
        dataType: 'json',
        success: function (res) {
            return res;
        },
        error: (error)=>{
            notification("error",error.responseText ?? "something went wrong")
        }
    });
}

function edit_form_handle(model, id, formData) {
    formData.append('_method', 'PUT');
    ajaxsetup();
    $.ajax({
        type: 'post',
        enctype: 'multipart/form-data',
        url: `${model}/${id}`,
        data: formData,
        contentType: false,
        accepts: "application/json",
        processData: false,
        success: function (res) {
            console.log(res)
            const list = $('#edit_errorList');
            if (res.status === 400) {
                list.html("");
                list.removeClass("d-none");
                $.each(res.errors, function (key, err_value) {
                    $('#edit_errorList').append('<li>' + err_value + '</li>');
                });
            } else if (res.status === 200) {
                list.html("");
                list.addClass("d-none");

                $('#editForm').trigger("reset");
                $('#edit').modal('hide');
                $('#data').DataTable().draw();
                notification("success", res.message)
            }
        },
        error: (error)=>{
            notification("error",error.responseText ?? "something went wrong")
        }
    })
}

function store_handler(url, formData) {
    ajaxsetup();
    $.ajax({
        type: 'post',
        enctype: 'multipart/form-data',
        url: url,
        data: formData,
        accepts: "application/json",
        processData: false,
        contentType: false,
        success:  (response) =>{
            const list = $('#save_errorList');
            if (response.status === 400) {
                list.html("");
                list.removeClass("d-none");
                $.each(response.errors, function (key, err_value) {
                    $('#save_errorList').append('<li>' + err_value + '</li>');
                });
            } else if (response.status === 200) {
                list.html("");
                list.addClass("d-none");

                //clear form and hide modal
                $('#addForm').trigger("reset");
                $('#add').modal('hide');

                //call resource api for update data
                $('#data').DataTable().draw();
                notification("success", response.message)
            }
        },
        error: (error)=>{
        notification("error",error.responseText ?? "something went wrong")
    }
    })
}

$(document).on("click", "#delete", function (e) {
    e.preventDefault();
    const link = $(this).attr("href");
    Swal.fire({
        title: 'Confirm Your password',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm!',
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        preConfirm: (password) => {
            const formData = new FormData();
            formData.append('password', password);
            //formData.append('_csrf',password);
            return fetch(`/admin/confirm-password`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                        if (data.message) {
                            return data;
                        }
                        if (data.error) {
                            Swal.showValidationMessage(
                                `${data.errors}`
                            )
                        }
                    }

                )
                .catch(error => {
                    console.log(error)
                })
        },
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = link;
        }
    })
});

$(document).on("click", ".destroy", function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {form.submit();}
    });
});
