//============================== Add Email Recipient ==============================
function AddCustomerClaim(){
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
        url: "add_customer_claim",
        method: "post",
        // processData: false,
        // contentType: false,
        data: $('#formAddCustomerClaim').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddCustomerClaimIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomerClaim").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving claim records failed!');
                if(response['error']['pmi_control_number'] === undefined){
                    $("#txtAddControlNumber").removeClass('is-invalid');
                    $("#txtAddControlNumber").attr('title', '');
                }
                else{
                    $("#txtAddControlNumber").addClass('is-invalid');
                    $("#txtAddControlNumber").attr('title', response['error']['pmi_control_number']);
                }

                if(response['error']['reference_number'] === undefined){
                    $("#txtAddReferenceNumber").removeClass('is-invalid');
                    $("#txtAddReferenceNumber").attr('title', '');
                }
                else{
                    $("#txtAddReferenceNumber").addClass('is-invalid');
                    $("#txtAddReferenceNumber").attr('title', response['error']['reference_number']);
                }

                if(response['error']['quarter'] === undefined){
                    $("#selectQuarter").removeClass('is-invalid');
                    $("#selectQuarter").attr('title', '');
                }
                else{
                    $("#selectQuarter").addClass('is-invalid');
                    $("#selectQuarter").attr('title', response['error']['quarter']);
                }
                if(response['error']['customer'] === undefined){
                    $("#selectCustomer").removeClass('is-invalid');
                    $("#selectCustomer").attr('title', '');
                }
                else{
                    $("#selectCustomer").addClass('is-invalid');
                    $("#selectCustomer").attr('title', response['error']['customer']);
                }
                if(response['error']['sender_name'] === undefined){
                    $("#selectSenderName").removeClass('is-invalid');
                    $("#selectSenderName").attr('title', '');
                }
                else{
                    $("#selectSenderName").addClass('is-invalid');
                    $("#selectSenderName").attr('title', response['error']['sender_name']);
                }
                if(response['error']['contributor'] === undefined){
                    $("#selectContributor").removeClass('is-invalid');
                    $("#selectContributor").attr('title', '');
                }
                else{
                    $("#selectContributor").addClass('is-invalid');
                    $("#selectContributor").attr('title', response['error']['contributor']);
                }
                if(response['error']['validity'] === undefined){
                    $("#selectValidity").removeClass('is-invalid');
                    $("#selectValidity").attr('title', '');
                }
                else{
                    $("#selectValidity").addClass('is-invalid');
                    $("#selectValidity").attr('title', response['error']['validity']);
                }
                if(response['error']['product_classification'] === undefined){
                    $("#selectProductClassification").removeClass('is-invalid');
                    $("#selectProductClassification").attr('title', '');
                }
                else{
                    $("#selectProductClassification").addClass('is-invalid');
                    $("#selectProductClassification").attr('title', response['error']['product_classification']);
                }
                if(response['error']['model_name'] === undefined){
                    $("#txtAddModelName").removeClass('is-invalid');
                    $("#txtAddModelName").attr('title', '');
                }
                else{
                    $("#txtAddModelName").addClass('is-invalid');
                    $("#txtAddModelName").attr('title', response['error']['model_name']);
                }
                if(response['error']['mode_of_defect'] === undefined){
                    $("#txtAddModeOfDefect").removeClass('is-invalid');
                    $("#txtAddModeOfDefect").attr('title', '');
                }
                else{
                    $("#txtAddModeOfDefect").addClass('is-invalid');
                    $("#txtAddModeOfDefect").attr('title', response['error']['mode_of_defect']);
                }
                if(response['error']['lot_number'] === undefined){
                    $("#txtAddPONumber").removeClass('is-invalid');
                    $("#txtAddPONumber").attr('title', '');
                }
                else{
                    $("#txtAddPONumber").addClass('is-invalid');
                    $("#txtAddPONumber").attr('title', response['error']['lot_number']);
                }
                if(response['error']['automotive'] === undefined){
                    $("#selectAutomotive").removeClass('is-invalid');
                    $("#selectAutomotive").attr('title', '');
                }
                else{
                    $("#selectAutomotive").addClass('is-invalid');
                    $("#selectAutomotive").attr('title', response['error']['automotive']);
                }
                if(response['error']['quantity'] === undefined){
                    $("#txtAddQuantity").removeClass('is-invalid');
                    $("#txtAddQuantity").attr('title', '');
                }
                else{
                    $("#txtAddWorkloadDescription").addClass('is-invalid');
                    $("#txtAddWorkloadDescription").attr('title', response['error']['quantity']);
                }
                if(response['error']['number_of_ng'] === undefined){
                    $("#txtAddNumberOfNG").removeClass('is-invalid');
                    $("#txtAddNumberOfNG").attr('title', '');
                }
                else{
                    $("#txtAddNumberOfNG").addClass('is-invalid');
                    $("#txtAddNumberOfNG").attr('title', response['error']['number_of_ng']);
                }
                if(response['error']['return_to_vendor'] === undefined){
                    $("#txtAddReturnToVendor").removeClass('is-invalid');
                    $("#txtAddReturnToVendor").attr('title', '');
                }
                else{
                    $("#txtAddReturnToVendor").addClass('is-invalid');
                    $("#txtAddReturnToVendor").attr('title', response['error']['return_to_vendor']);
                }
                if(response['error']['defect_category_class'] === undefined){
                    $("#selectDefectCategoryClass").removeClass('is-invalid');
                    $("#selectDefectCategoryClass").attr('title', '');
                }
                else{
                    $("#selectDefectCategoryClass").addClass('is-invalid');
                    $("#selectDefectCategoryClass").attr('title', response['error']['defect_category_class']);
                }
                if(response['error']['date_received'] === undefined){
                    $("#txtDateReceived").removeClass('is-invalid');
                    $("#txtDateReceived").attr('title', '');
                }
                else{
                    $("#txtDateReceived").addClass('is-invalid');
                    $("#txtDateReceived").attr('title', response['error']['date_received']);
                }
                if(response['error']['actual_date_received_claim'] === undefined){
                    $("#txtAddActualDateReceivedOfClaim").removeClass('is-invalid');
                    $("#txtAddActualDateReceivedOfClaim").attr('title', '');
                }
                else{
                    $("#txtAddActualDateReceivedOfClaim").addClass('is-invalid');
                    $("#txtAddActualDateReceivedOfClaim").attr('title', response['error']['actual_date_received_claim']);
                }
                if(response['error']['date_return_of_claim'] === undefined){
                    $("#txtAddDateReturnOfClaimSample").removeClass('is-invalid');
                    $("#txtAddDateReturnOfClaimSample").attr('title', '');
                }
                else{
                    $("#txtAddDateReturnOfClaimSample").addClass('is-invalid');
                    $("#txtAddDateReturnOfClaimSample").attr('title', response['error']['date_return_of_claim']);
                }
                if(response['error']['required_reply'] === undefined){
                    $("#txtAddRequiredReply").removeClass('is-invalid');
                    $("#txtAddRequiredReply").attr('title', '');
                }
                else{
                    $("#txtAddRequiredReply").addClass('is-invalid');
                    $("#txtAddRequiredReply").attr('title', response['error']['required_reply']);
                }
            }else{
                // $("#modalAddCustomerClaim").modal('hide');
                $('#smartwizard').smartWizard("next");
                toastr.success('Claim records was succesfully saved!');
                dataTablesCustomerClaimCN.draw();
                dataTablesCustomerClaimTS.draw();
                dataTablesCustomerClaimYF.draw();
                dataTablesCustomerClaimPPS.draw();
                // resetFormValues();
            }

            $("#iBtnAddCustomerClaimIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomerClaim").removeAttr('disabled');
            $("#iBtnAddCustomerClaimIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").removeAttr('disabled');
            $("#iBtnAddWorkloadIcon").addClass('fa fa-check');
        }
    });
}


//============================== Edit/Get Customer Claim by id to edit ==============================
function GetCustomerClaimById(customerClaimId){
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
        url: "get_customer_claim_by_id",
        method: "get",
        data: {
            customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddCustomerClaim = $('#formAddCustomerClaim');
            let customerClaim = response['customerClaim'];
            if(customerClaim.length > 0){
                $("#txtAddSection").val(customerClaim[0].section);
                $("#txtAddItemNumber").val(customerClaim[0].item_number);
                $("#txtAddControlNumber").val(customerClaim[0].pmi_control_number);
                $("#txtAddReferenceNumber").val(customerClaim[0].reference_number);
                $('select[name="quarter"]', formAddCustomerClaim).val(customerClaim[0].quarter).trigger('change');
                $('select[name="customer"]', formAddCustomerClaim).val(customerClaim[0].customer).trigger('change');
                $("#selectSenderName").val(customerClaim[0].sender_name);
                $('select[name="contributor"]', formAddCustomerClaim).val(customerClaim[0].contributor).trigger('change');
                $('select[name="validity"]', formAddCustomerClaim).val(customerClaim[0].validity).trigger('change');
                $('select[name="product_classification"]', formAddCustomerClaim).val(customerClaim[0].product_classification).trigger('change');
                $("#txtAddModelName").val(customerClaim[0].model_name);
                $("#txtAddModeOfDefect").val(customerClaim[0].mode_of_defect);
                $("#txtAddPONumber").val(customerClaim[0].po_number);
                $('select[name="automotive"]', formAddCustomerClaim).val(customerClaim[0].automotive).trigger('change');
                $("#txtAddQuantity").val(customerClaim[0].quantity);
                $("#txtAddNumberOfNG").val(customerClaim[0].number_of_ng);
                $("#txtAddReturnToVendor").val(customerClaim[0].return_to_vendor);
                $('select[name="defect_category_class"]', formAddCustomerClaim).val(customerClaim[0].defect_category_class).trigger('change');
                $("#txtDateReceived").val(customerClaim[0].date_received);

                
                // Dates checkboxes
                if(customerClaim[0].actual_date_received_claim != null){
                    $('#chkActualDateReceivedClaim').attr('checked', true);
                    console.log('not null');

                    if($('#chkActualDateReceivedClaim').is(':checked')){
                        $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                        $('#txtAddActualDateReceivedOfClaim').attr('disabled', false);
                    }else{
                        console.log('null');
                        $('#chkActualDateReceivedClaim').attr('checked', false);
                        $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                        $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
                    }
                }else{
                    console.log('null');
                    $('#chkActualDateReceivedClaim').attr('checked', false);
                    $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                    $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
                }
                
                // Dates inputs
                $("#txtAddDateReturnOfClaimSample").val(customerClaim[0].date_return_of_claim);
                $("#txtAddRequiredReply").val(customerClaim[0].required_reply);
                $("#txtAddInitialResponse").val(customerClaim[0].initial_response);
                $("#txtAddActualResponse").val(customerClaim[0].actual_response);
                $("#txtAddTurnAroundTime").val(customerClaim[0].turn_around_time);

                // Claim Status
                if(customerClaim[0].status == 0){
                    $("#spanStatus").html('<strong>OPEN</strong>');
                    $("#initialReportBgColor").removeClass('bg-success');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                    $("#statusBgColor").addClass('bg-info');
                }else if(customerClaim[0].status == 1){
                    $("#spanStatus").html('<strong>CLOSED</strong>');
                    $("#initialReportBgColor").removeClass('bg-info');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                    $("#statusBgColor").addClass('bg-success');
                }else{
                    $("#spanStatus").html('<strong>N/A</strong>');
                    $("#initialReportBgColor").removeClass('bg-info');
                    $("#initialReportBgColor").removeClass('bg-success');
                    $("#statusBgColor").addClass('bg-secondary');
                }
                
                // Initial Report
                if(customerClaim[0].initial_response <= customerClaim[0].required_reply){
                    $("#spanInitialReport").html('<strong>RELEASED</strong>');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                    $("#initialReportBgColor").addClass('bg-success');
                    
                }else{
                    $("#spanInitialReport").html('<strong>N/A</strong>');
                    $("#initialReportBgColor").removeClass('bg-success');
                    $("#initialReportBgColor").addClass('bg-secondary');
                }
                
                // Final Report
                if(customerClaim[0].final_report == 1){
                    $("#spanFinalReport").html('<strong>ON TIME</strong>');
                    $("#finalReportBgColor").removeClass('bg-danger');
                    $("#finalReportBgColor").addClass('bg-success');
                    
                }else{
                    $("#spanFinalReport").html('<strong>Late</strong>');
                    $("#finalReportBgColor").removeClass('bg-success');
                    $("#finalReportBgColor").addClass('bg-danger');
                }
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


//============================== Get Customer Claim for viewing only ==============================
function GetCustomerClaimByIdForViewing(customerClaimId){
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
        url: "get_customer_claim_view_by_id",
        method: "get",
        data: {
            view_customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formViewCustomerClaim = $('#formViewCustomerClaim');
            let customerClaim = response['customerClaim'];
            if(customerClaim.length > 0){
                $("#txtViewSection").val(customerClaim[0].section);
                $("#txtViewItemNumber").val(customerClaim[0].item_number);
                $("#txtViewControlNumber").val(customerClaim[0].pmi_control_number);
                $("#txtViewReferenceNumber").val(customerClaim[0].reference_number);
                $('select[name="quarter"]', formViewCustomerClaim).val(customerClaim[0].quarter).trigger('change');
                $('select[name="customer"]', formViewCustomerClaim).val(customerClaim[0].customer).trigger('change');
                $("#selectSenderName").val(customerClaim[0].sender_name);
                $('select[name="contributor"]', formViewCustomerClaim).val(customerClaim[0].contributor).trigger('change');
                $('select[name="validity"]', formViewCustomerClaim).val(customerClaim[0].validity).trigger('change');
                $('select[name="product_classification"]', formViewCustomerClaim).val(customerClaim[0].product_classification).trigger('change');
                $("#txtViewModelName").val(customerClaim[0].model_name);
                $("#txtViewModeOfDefect").val(customerClaim[0].mode_of_defect);
                $("#txtViewPONumber").val(customerClaim[0].po_number);
                $('select[name="automotive"]', formViewCustomerClaim).val(customerClaim[0].automotive).trigger('change');
                $("#txtViewQuantity").val(customerClaim[0].quantity);
                $("#txtViewNumberOfNG").val(customerClaim[0].number_of_ng);
                $("#txtViewReturnToVendor").val(customerClaim[0].return_to_vendor);
                $('select[name="defect_category_class"]', formViewCustomerClaim).val(customerClaim[0].defect_category_class).trigger('change');
                $("#txtViewDateReceived").val(customerClaim[0].date_received);
                $('input[name="actual_date_received_claim"]', formViewCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');

                $("#txtViewDateReturnOfClaimSample").val(customerClaim[0].date_return_of_claim);
                $("#txtViewRequiredReply").val(customerClaim[0].required_reply);
                $("#txtViewInitialResponse").val(customerClaim[0].initial_response);
                $("#txtViewActualResponse").val(customerClaim[0].actual_response);
                $("#txtViewTurnAroundTime").val(customerClaim[0].turn_around_time);
            }
            else{
                toastr.warning('No claim records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


//============================== EDIT WORKLOAD ==============================
function EditWorkload(){
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

    let formData = new FormData($('#formEditWorkload')[0]);

    $.ajax({
        url: "edit_workload",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditWorkloadIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating workload failed!');

                if(response['error']['name'] === undefined){
                    $("#txtEditWorkloadName").removeClass('is-invalid');
                    $("#txtEditWorkloadName").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadName").addClass('is-invalid');
                    $("#txtEditWorkloadName").attr('title', response['error']['name']);
                }

                if(response['error']['work_instruction_title'] === undefined){
                    $("#txtEditWorkloadWorkInstructionTitle").removeClass('is-invalid');
                    $("#txtEditWorkloadWorkInstructionTitle").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadWorkInstructionTitle").addClass('is-invalid');
                    $("#txtEditWorkloadWorkInstructionTitle").attr('title', response['error']['work_instruction_title']);
                }

                if(response['error']['description'] === undefined){
                    $("#txtEditWorkloadDescription").removeClass('is-invalid');
                    $("#txtEditWorkloadDescription").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadDescription").addClass('is-invalid');
                    $("#txtEditWorkloadDescription").attr('title', response['error']['description']);
                }
            }else if(response['result'] == 1){
                toastr.success('Workload was succesfully updated!');
                $("#modalEditWorkload").modal('hide'); // hide modal
                dataTableWorkloads.draw(); // reload the datatables after the update operation
                dataTablePendingWorkloads.draw(); // reload the datatables after the update operation

                // reset the formEditWorkload values including checkbox, showing/hiding input file/text, disabled fields and remove error border
                resetFormValues();
                $("#formEditWorkload")[0].reset();
                $('#chkEditFile').removeAttr('checked'); // uncheck the Edit Attachment
                
                // check if the #chkEditFile(checkbox) has no attribute checked then hide then fileEditWorkloadFile(input type file) and show txtEditWorkloadFile(input type text)
                var chkEditFile = $('#chkEditFile').attr('checked');
                if (typeof chkEditFile === 'undefined' || chkEditFile === false) {
                    $('#fileEditWorkloadFile').addClass('d-none')
                    $('#txtEditWorkloadFile').removeClass('d-none');
                }
            }else if(response['result'] == 0){
                toastr.success("Workload was succesfully updated!" + ' ' + "<span class='text-danger'>Note that there is no file was uploaded</span>");
                $("#modalEditWorkload").modal('hide'); // hide modal
                dataTableWorkloads.draw(); // reload the datatables after the update operation
                dataTablePendingWorkloads.draw(); // reload the datatables after the update operation
                
                // reset the formEditWorkload values including checkbox, showing/hiding input file/text, disabled fields and remove error border
                resetModalValue(); 
                $("#formEditWorkload")[0].reset();
                $('#chkEditFile').removeAttr('checked'); // uncheck the Edit Attachment
                
                // check if the #chkEditFile(checkbox) has no attribute checked then hide then fileEditWorkloadFile(input type file) and show txtEditWorkloadFile(input type text)
                var chkEditFile = $('#chkEditFile').attr('checked');
                if (typeof chkEditFile === 'undefined' || chkEditFile === false) {
                    $('#fileEditWorkloadFile').addClass('d-none');
                    $('#txtEditWorkloadFile').removeClass('d-none');
                }
            }
            $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").removeAttr('disabled');
            $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").removeAttr('disabled');
            $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
        }
    });
}