$(function () {

    var base_url = $('#url').val();
    var uRL = base_url+'/admin/';

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $('.modal').on('hidden.bs.modal', function () {
        $('.modal form')[0].reset();
    });

    $('.change-logo').click(function () {
        $('.change-com-img').click();
    });

    // delete data common function
    function destroy_data(name,url){
        var el = name;
        var id= el.attr('data-id');
        var dltUrl = url+id;
        if(confirm('Are you Sure Want to Delete This')){
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                    }else{
                        Toast.fire({
                            icon: 'danger',
                            title: dataResult
                        })
                    }
                }
            });
        }
    }

    function show_formAjax_error(data){
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

        $('.admin-logout').click(function(){
            $.ajax({
                url: uRL+'logout',
                type: "GET",
                cache: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        setTimeout(function(){
                            window.location.href = base_url;
                            
                        }, 500);
                        Toast.fire({
                            icon: 'success',
                            title: 'Logged Out Succesfully.'
                        })
                    }
                }
            });
        })

    // ========================================
    // script for Employees module
    // ========================================

    $('.emp-department').change(function () {
        var id = $(this).val();
        $.ajax({
            url: uRL + 'department-designations',
            type: "POST",
            data: {id:id},
            cache: false,
            success: function (dataResult) {
                console.log(dataResult);
                if(dataResult != ''){
                    var option = '';
                    $(dataResult).each(function(k,v){
                        option += '<option value="'+v['id']+'">'+v['name']+'</option>'
                    })
                    $('.emp-designation').html(option);
                    $('.emp-department').next('small.text-danger').hide();
                }else{
                    $('<small class="text-danger">Select Another Designations not found</small>').insertAfter('.emp-department');
                }
            }
        });
    })


    $('#addEmployee').validate({
        rules: {
            emp_name: { required: true },
            phone: { required: true },
            email: { required: true },
            password: { required: true },
            employeeId: { required: true},
            department: { required: true },
            designation: { required: true },
            join_date: { required: true },
            join_salary: { required: true },
        },
        
        submitHandler: function(form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'employees',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = uRL+'employees'; },1000)
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $('.error').hide();
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });


    $('#updateEmployee').validate({
        rules: {
            emp_name: { required: true },
            phone: { required: true },
            email: { required: true },
            department: { required: true },
            designation: { required: true },
            join_date: { required: true },
            join_salary: { required: true },
        },

        messages: {
            emp_name: { required: "Please Enter Name" },
            phone: { required: "Please Enter Phone Number" },
            email: { required: "Please Enter Email address" },
            department: { required: "Please Enter a Department Name" },
            designation: { required: "Please Enter a Designation Name" },
            join_date: { required: "Please Enter a Join Date" },
            join_salary: { required: "Please Enter Join Salary" },
        },
        
        submitHandler: function(form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    console.log(dataResult);
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = uRL+'employees'; },1000)
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete-employee", function() {
         destroy_data($(this),'employees/')
    });


    // ========================================
    // script for Department module
    // ========================================

    $('#add_department').validate({
        rules: { department: { required: true }},
        messages: { department: { required: "Please Enter Department Name" } },
        submitHandler: function(form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'departments',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                     if(dataResult == '1'){
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                     }
                },
                error : function(error){
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click','.edit_department',function(){
        var id= $(this).attr('data-id');
        var dltUrl = 'departments/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function(dataResult){
                $('#modal-info input[name=id]').val(dataResult[0].department_id);
                $('#modal-info input[name=department]').val(dataResult[0].name);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].department_id);
               $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_department").validate({
        rules: { department: { required: true } },
        messages: { department: { required: "Please Enter Department Name" } },

        submitHandler: function(form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL+'departments/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                },
                error : function(error){
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-department", function() {
        destroy_data($(this),'departments/')
    });

    // ========================================
    // script for Designation module
    // ========================================

    $('#add_designation').validate({
        rules: {
            designation: { required: true },
            department: { required: true }
        },
        messages: {
            designation: { required: "Please Enter Designation Name" },
            department: { required: "Please Enter Department Name" }
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                },
                error : function(error){
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click','.edit_designation',function () {
        var id= $(this).attr('data-id');
        var dltUrl = 'designations/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function(dataResult){
                console.log(dataResult);
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=designation]').val(dataResult[0].name);
                $('#modal-info input[name=department]').val(dataResult[0].department_id);
                $("#modal-info select[name=department] option").each(function(){
                    if($(this).val() == dataResult[0].department_id){
                        $(this).attr('selected',true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_designation").validate({
        rules: { 
            designation: { required: true },
            department: { required: true }
        },
        messages: { 
            designation: { required: "Please Enter Designation Name" },
            department: { required: "Please Enter Department Name" }
        },
        submitHandler: function(form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'designations'+'/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                }
            });
        },
        error : function(error){
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-designation", function() {
        destroy_data($(this),' designations/')
    });

    // ========================================
    // script for Notice Board module
    // ========================================

    $('#addNotice').validate({
        rules: {
            notice: { required: true },
            description: { required: true }
        },
        messages: {
            notice: { required: "Please Enter Notice" },
            description: { required: "Please Enter Description" }
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = url; },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $('#updateNotice').validate({
        rules: {
            notice: { required: true },
            description: { required: true },
            status:{ required: true }
        },
        messages: {
            notice: { required: "Please Enter Name" },
            description: { required: "Please Enter Description" },
            status: { required: "Please Enter Status" }
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    console.log(dataResult);
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = $('.rdt-url').val(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete-notice", function() {
        destroy_data($(this),' notice_board/')
    });

    // ========================================
    // script for Expenses module
    // ========================================

    $('#addExpense').validate({
        rules: {
            item_name: { required: true },
            pur_date: { required: true },
            amount: { required: true },
        },
        messages: {
            item_name: { required: "Please Enter Item Name" },
            pur_date: { required: "Please Enter Purchase Date" },
            amount: { required: "Please Enter Amount" },
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = url; },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $('#updateExpense').validate({
        rules: {
            item_name: { required: true },
            pur_date: { required: true },
            amount: { required: true },
        },
        messages: {
            item_name: { required: "Please Enter Item Name" },
            pur_date: { required: "Please Enter Purchase Date" },
            amount: { required: "Please Enter Amount" },
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    console.log(dataResult);
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = $('.rdt-url').val(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete-expense", function() {
        destroy_data($(this),' expenses/')
    });

    // ========================================
    // script for Awards module
    // ========================================

    $('#addAward').validate({
        rules: {
            award_name: { required: true },
            emp: { required: true },
        },
        messages: {
            award_name: { required: "Please Enter Award Name" },
            emp: { required: "Please Select Employee Name" },
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = url; },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $('#updateAward').validate({
        rules: {
            award_name: { required: true },
            emp: { required: true },
        },
        messages: {
            award_name: { required: "Please Enter Award Name" },
            emp: { required: "Please Enter Employee Name" },
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.href = $('.rdt-url').val(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete-award", function() {
        destroy_data($(this),' awards/')
    });


    // ========================================
    // script for Holidays module
    // ========================================

     $('#add_holiday').validate({
        rules: { 
            holiday_date: { required: true },
            occasion: { required: true }
        },
        messages: { 
            holiday_date: { required: "Please Enter Holiday Date" }, 
            occasion: { required: "Please Enter occasion" } 
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                     if(dataResult == '1'){
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                     }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });


    $(document).on("click", ".delete-holiday", function(){
        destroy_data($(this),' holidays/')
    });

     // ========================================
    // script for Leave Type module
    // ========================================

    $('#add_leave').validate({
        rules: {
            leave_type: { required: true },
            number_leave: { required: true }
        },
        messages: {
            leave_type: { required: "Please Enter Leave Type" },
            number_leave: { required: "Please Enter Number Leave" }

        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on('click', '.edit_leave', function () {
        var id= $(this).attr('data-id');
        var dltUrl = 'leave_type/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function(dataResult){
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=leave_type]').val(dataResult[0].leave_type);
                $('#modal-info input[name=number_leave]').val(dataResult[0].number_of_type);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_leave").validate({
        rules: { leave_type: { required: true },
                number_leave: { required: true } 
            },
        messages: { leave_type: { required: "Please Enter Leave Type" },
        number_leave: { required: "Please Enter Number Leave" } },

        submitHandler: function(form) {
            var url = $('.u-url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete_leave_type", function() {
        destroy_data($(this),' leave_type/')
    });

    // ========================================
    // script for LeaveApplication module
    // ========================================

    $('#add_EmpLeave').validate({
        rules: { 
            date: { required: true},
            leave: { required: true },
            reason: { required: true }
        },
        messages: { 
            date: { required: "Please Enter Date" }, 
            leave: { required: "Please Enter Leave Type" },
            reason: { required: "Please Enter Reason Name" } 
        },
        submitHandler: function (form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function(){ window.location.reload(); },1000);
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", ".view_leave", function () {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url+'/'+id,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                console.log(dataResult);
                $('#view-application #id').html(dataResult[0].id);
                $('#view-application #date').html(dataResult[0].date);
                $('#view-application #leave_type').html(dataResult[0].leave_type);
                $('#view-application #reason').html(dataResult[0].reason);
                var status = dataResult[0].status;
                if(status == '0') {
                    $('#view-application #status').html('<span class="badge badge-warning">Pending</span>');
                }else if (status == '1') {
                    $('#view-application #status').html('<span class="badge  badge-success">Approve</span>');
                }else {
                    $('#view-application #status').html('<span class="badge badge-danger">Reject</span>');
                }
                $('#view-application').modal('show');
            },
            error: function (data) {
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="error">' + error[0] + '</span>'));
                    });
                }
            }
        });
    });

    $(document).on("click", ".change_status", function () {
        var id = $(this).attr('data-id');
        var  val = $(this).attr('data-value');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url + '/change-leave-status',
            type: "POST",
            data: {leave_id:id,status:val},
            cache: false,
            success: function (dataResult) {
              window.location.reload();  
            },
            error: function (data) {
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="error">' + error[0] + '</span>'));
                    });
                }
            }
        });
    });
    
    // ========================================
    // script for General Setting module
    // ========================================

    $('#updateGeneralSetting').validate({
        rules: {
            name: { required: true },
            email: { required: true },
            currency: { required: true },
            clock_in: { required: true },
            clock_out: { required: true },
        },
        messages: {
            name: { required: "Company Name is Required" },
            email: { required: "Company Email is Required" },
            currency: { required: "Currency Format is Required" },
        },  
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    console.log(dataResult);
                    setTimeout(function(){
                        window.location.href = url;
                    }, 1000);
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Succesfully.'
                    })
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    // ========================================
    // script for Admin  module
    // ========================================

    $('#updateProfileSetting').validate({
        rules: {
            username: { required: true },
            email: { required: true },
            username: { required: true },
        },
        messages: {
            admin_name: { required: "Please Enter Your Username" },
            admin_email: { required: "Please Enter Email Address" },
            username: { required: "Please Enter Email Address" }
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult){
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        })
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $('#updateAdminPassword').validate({
        rules: {
            password: { required: true },
            new_pass: { required: true },
            con_pass: { required: true, equalTo: "#new-pass" },
        },
        messages: {
            password: { required: "Old Password is Required" },
            new_pass: { required: "New Password is Required" },
            con_pass: { required: "Please Re-enter Correct New Password" }
        },
        submitHandler: function (form) {
            var url = $('.p-url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        })
                    }else{
                        $.each(dataResult, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error + '</span>'));
                        });
                    }
                },
                error: function (data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error[0] + '</span>'));
                        });
                    }
                }
            });
        }
    });

    $(document).on('click','.attendance-mark',function () {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var date = $(this).attr('data-date');
        if($('#attendance-status'+id).is(":checked")){
            var status = '1';
        }else{
            var status = '0';
        }
        var leaveType = '';
        var halfDay = '';
        var reason = '';
        if(status == '0'){
            var leaveType = $('#leaveform'+id+' .leave-type option:selected').val();
            if ($('#leaveform' + id + ' .half-day').is(":checked")) {
                var halfDay = '1';
            } else {
                var halfDay = '0';
            }
            var reason = $('#leaveform' + id + ' .reason').val();
        }
        var clockIn = $('#clock-in' + id).val();
        var clockOut = $('#clock-out' + id).val();
        if ($('#late' + id).is(":checked")) {
            var is_late = '1';
        } else {
            var is_late = '0';
        }
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                id: id,date:date,status:status,leaveType:leaveType,halfDay:halfDay,reason:reason,clockIn:clockIn,clockOut:clockOut,is_late:is_late
            },
            success: function (dataResult) {
                if (dataResult == '1') {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Marked Succesfully.'
                    })
                }
            }
        });
    })

    $('.save-all-attendance').click(function(){
        var data = [];
        var url = $(this).attr('data-url');
        $("input[name='employeeId[]']").each(function () {
            var id = $(this).val();
            
            if ($('#attendance-status' + id).is(":checked")) {
                var status = '1';
            } else {
                var status = '0';
            }
            var leaveType = '';
            var halfDay = '';
            var reason = '';
            if (status == '0') {
                var leaveType = $('#leaveform' + id + ' .leave-type option:selected').val();
                if ($('#leaveform' + id + ' .half-day').is(":checked")) {
                    var halfDay = '1';
                } else {
                    var halfDay = '0';
                }
                var reason = $('#leaveform' + id + ' .reason').val();
            }
            var clockIn = $('#clock-in' + id).val();
            var clockOut = $('#clock-out' + id).val();
            if ($('#late' + id).is(":checked")) {
                var is_late = '1';
            } else {
                var is_late = '0';
            }
            var obj = {
                employeeId: id,
                status: status,
                leaveType: leaveType,
                halfDay: halfDay,
                reason: reason,
                clock_in: clockIn,
                clock_out: clockOut,
                late: is_late
            };
            data[id] = obj;
        });
        //var data = JSON.stringify(data);
        console.log(data);
        
        $.ajax({
            url: url,
            type: 'PATCH',
            data: { data: JSON.stringify(data)},
            success: function (dataResult) {
                console.log(dataResult);
                if (dataResult == '1') {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Added Succesfully.'
                    })
                }
            }
        });
        
    });


    $(".date-attendance").change(function () {
        var val = $(this).val(); 
       var url = $('#editAttendance').attr('action');
    //    $('#editAttendance').attr('action',url+'/'+val+'/edit').submit();
        window.location.replace(url + '/' + val + '/edit');
    });

    function filterAttendance(url){
        var employee = $('#attendance-employee option:selected').val();
        var month = $('#attendance-month option:selected').val();
        var year = $('#attendance-year option:selected').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {employee:employee,month:month,year:year},
            success: function (dataResult) {
                var thead = '<tr><th>Employee</th>';
                for ($i = 1; $i <= dataResult.days_in_month;$i++){
                    thead += '<th class="pl-2 pr-2">' + $i + '</th>';
                }
                thead += '</tr>';
                $('#attendance-view thead').html(thead);
                var tbody = '';
                $.each(dataResult.employees, function (index, value) {
                    tbody += '<tr>';
                    tbody += '<td>'+index+'</td>';
                    $.each(value, function (j) {
                        tbody += '<td>' + value[j] + '</td>';
                    })
                    tbody += '</tr>';
                });
                $('#attendance-view tbody').html(tbody);
            }
        });
    }

    $('.filter-attendance').click(function(){
        filterAttendance(uRL + 'attendance-filter');
    })

    $('#attendance-view').ready(function(){
        filterAttendance(uRL + 'attendance-filter');
    })
    

});

