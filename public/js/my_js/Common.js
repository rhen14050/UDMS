// Reset Form values function
function resetFormValues(){
    // Reset values
    $("#formAddCustomerClaim")[0].reset();
    $('select[name="quarter"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="customer"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="sender_name"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="contributor"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="validity"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="product_classification"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="automotive"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="defect_category_class"]', $("#formAddCustomerClaim")).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');
    $("div").find('input[type="date"]').attr('title', '');

    $('#chkActualDateReceivedClaim').attr('checked', false);
    $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
    $('#chkdateReturnClaim').attr('checked', false);
    $('#txtAddDateReturnOfClaimSample').attr('disabled', true);
}


// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalAddCustomerClaim").on('hidden.bs.modal', function(){
    resetFormValues();
});


// Reset Form values function
function resetFormValuesEmailRecipient(){
    // Reset values
    $("#formAddEmailRecipient")[0].reset();

    // Reset hidden input fields
    $("input[name='user_id']", $('#formAddEmailRecipient')).val('');
    $("input[name='email_recipient_id']", $('#formAddEmailRecipient')).val('');
    $("input[name='recipient_name']", $('#formAddEmailRecipient')).val('');

    // Reset values
    $("select[name='recipient_name_display']", $('#formAddEmailRecipient')).val(0).trigger('change');
    $("select[name='section']", $('#formAddEmailRecipient')).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');
}


$("#modalAddEmailRecipient").on('hidden.bs.modal', function(){
    resetFormValuesEmailRecipient();
});


// Reset Form(Product Classification) values function
function resetFormValuesProductClassification(){
    // Reset values
    $("#formAddProductClassification")[0].reset();

    // Reset hidden input fields
    $("input[name='product_name']", $('#formAddProductClassification')).val('');
    $("input[name='product_details']", $('#formAddProductClassification')).val('');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
}


$("#modalAddProductClassification").on('hidden.bs.modal', function(){
    resetFormValuesProductClassification();
});