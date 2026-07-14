//============================== Add Email Recipient ==============================
function AddEmailRecipient(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    // let formData = new FormData($('#formAddCustomerClaim')[0]);

	$.ajax({
        url: "add_email_recipient",
        method: "post",
        // processData: false,
        // contentType: false,
        data: $('#formAddEmailRecipient').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddEmailRecipientIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddEmailRecipient").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving email recipient failed!');
                if(response['error']['email'] === undefined){
                    $("#txtAddEmail").removeClass('is-invalid');
                    $("#txtAddEmail").attr('title', '');
                }
                else{
                    $("#txtAddEmail").addClass('is-invalid');
                    $("#txtAddEmail").attr('title', response['error']['email']);
                }
                if(response['error']['section'] === undefined){
                    $("#txtAddSection").removeClass('is-invalid');
                    $("#txtAddSection").attr('title', '');
                }
                else{
                    $("#txtAddSection").addClass('is-invalid');
                    $("#txtAddSection").attr('title', response['error']['section']);
                }
            }else{
                toastr.success('Email recipient was succesfully saved!');
                $('#modalAddEmailRecipient').modal('hide');
                resetFormValuesEmailRecipient();
            }

            $("#iBtnAddEmailRecipientIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddEmailRecipient").removeAttr('disabled');
            $("#iBtnAddEmailRecipientIcon").addClass('fa fa-check');
            dataTablesEmailRecipient.draw();
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddEmailRecipientIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddEmailRecipient").removeAttr('disabled');
            $("#iBtnAddEmailRecipientIcon").addClass('fa fa-check');
        }
    });
}


//============================== Edit/Get Customer Claim by id to edit ==============================
function GetEmailRecipientById(emailRecipientId){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_email_recipient_by_id",
        method: "get",
        data: {
            email_recipient_id: emailRecipientId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddEmailRecipient = $('#formAddEmailRecipient');
            let emailRecipient = response['emailRecipient'];
            if(emailRecipient.length > 0){
                // The user_id is the id stored in the table and that id will be used to reference the user id in the RapidX's user(table) id
                // Since we used val() function to fetch/get the data when edit button is clicked, the user_id will be used to match in the value(attribute) 
                // that we get via ajax to fetch all the users's details including recipient_name, email & user_id
                $('select[name="recipient_name_display"]', formAddEmailRecipient).val(emailRecipient[0].user_id).trigger('change');
                $("#txtAddEmailDisplay").val(emailRecipient[0].email);
                $('select[name="section"]', formAddEmailRecipient).val(emailRecipient[0].section).trigger('change');
            }
            else{
                toastr.warning('No Claim records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


//============================== Delete Email Recipient ==============================
function DeleteEmailRecipient(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "delete_email_recipient",
        method: "post",
        data: $('#formDeleteEmailRecipient').serialize(),
        dataType: "json",
        beforeSend: function(){
            // $("#iBtnChangeUserStatIcon").addClass('fa fa-spinner fa-pulse');
            // $("#btnChangeUserStat").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Email Recipient Deletion Failed');
            }else{
                if(response['result'] == 1){
                    if($("#txtEmailRecipientStatus").val() == 1){
                        toastr.success('Email Recipient Deleted!');
                        dataTablesEmailRecipient.draw();
                    }
                    else{
                        toastr.success('Email Recipient Restored!');
                        dataTablesEmailRecipient.draw();
                    }
                }
                $("#modalDeleteEmailRecipient").modal('hide');
                $("#formDeleteEmailRecipient")[0].reset();
            }

            // $("#iBtnChangeUserStatIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnChangeUserStat").removeAttr('disabled');
            // $("#iBtnChangeUserStatIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            // $("#iBtnChangeUserStatIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnChangeUserStat").removeAttr('disabled');
            // $("#iBtnChangeUserStatIcon").addClass('fa fa-check');
        }
    });
}


function GetEmailRecipient(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_email_recipient',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['emailRecipients'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['emailRecipients'].length; index++){
                    result += '<option value="' + response['emailRecipients'][index].name + '">' + response['emailRecipients'][index].name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No Email Recipient found</option>';
			}
			cboElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
	});
}