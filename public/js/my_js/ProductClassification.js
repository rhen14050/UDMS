//============================== Add Email Recipient ==============================
function AddProductClassification(){
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
        url: "add_product_classification",
        method: "post",
        // processData: false,
        // contentType: false,
        data: $('#formAddProductClassification').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving product classification failed!');
                if(response['error']['product_name'] === undefined){
                    $("#txtAddProductName").removeClass('is-invalid');
                    $("#txtAddProductName").attr('title', '');
                }
                else{
                    $("#txtAddProductName").addClass('is-invalid');
                    $("#txtAddProductName").attr('title', response['error']['product_name']);
                }
                if(response['error']['product_details'] === undefined){
                    $("#txtAddProductDetails").removeClass('is-invalid');
                    $("#txtAddProductDetails").attr('title', '');
                }
                else{
                    $("#txtAddProductDetails").addClass('is-invalid');
                    $("#txtAddProductDetails").attr('title', response['error']['product_details']);
                }
            }else{
                toastr.success('Product classification was succesfully saved!');
                $('#modalAddProductClassification').modal('hide');
                resetFormValuesProductClassification();
            }

            $("#iBtnAddProductClassificationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").removeAttr('disabled');
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-check');
            dataTablesProductClassification.draw();
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddProductClassificationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").removeAttr('disabled');
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-check');
        }
    });
}


//============================== Edit/Get Customer Claim by id to edit ==============================
function GetProductClassificationById(productClassificationId){
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
        url: "get_product_classification_by_id",
        method: "get",
        data: {
            product_classification_id: productClassificationId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddProductClassification = $('#formAddProductClassification');
            let productClassification = response['productClassification'];
            if(productClassification.length > 0){
                // The user_id is the id stored in the table and that id will be used to reference the user id in the RapidX's user(table) id
                // Since we used val() function to fetch/get the data when edit button is clicked, the user_id will be used to match in the value(attribute) 
                // that we get via ajax to fetch all the users's details including recipient_name, email & user_id
                // $('select[name="product_classification_id"]', formAddProductClassification).val(productClassification[0].id).trigger('change');
                $("#txtAddProductName").val(productClassification[0].product_name);
                $("#txtAddProductDetails").val(productClassification[0].product_details);
            }
            else{
                toastr.warning('No Product Classification records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


//============================== Delete Email Recipient ==============================
function DeleteProductClassification(){
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
        url: "delete_product_classification",
        method: "post",
        data: $('#formDeleteProductClassification').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Product Classification Deletion Failed');
            }else{
                // console.log(response['status']);
                if(response['result'] == 1){
                    if(response['status'] == 0){
                        toastr.success('Product Classification Deleted!');
                        dataTablesProductClassification.draw();
                    }
                    else{
                        toastr.success('Product Classification Restored!');
                        dataTablesProductClassification.draw();
                    }
                }
                $("#modalDeleteProductClassification").modal('hide');
                $("#formDeleteProductClassification")[0].reset();
            }

            $("#iBtnAddProductClassificationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").removeAttr('disabled');
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddProductClassificationIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddProductClassification").removeAttr('disabled');
            $("#iBtnAddProductClassificationIcon").addClass('fa fa-check');
        }
    });
}


function GetProductClassification(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_product_classification',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['productClassifications'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['productClassifications'].length; index++){
                    result += '<option value="' + response['productClassifications'][index].id + '">' + response['productClassifications'][index].product_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No Product Classification found</option>';
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