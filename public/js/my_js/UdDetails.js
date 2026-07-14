function executeSearch(poNumber) {
            $.ajax({
                type: "GET",
                url: "get_prod_name_by_po",
                data: { po_number: poNumber },
                dataType: "json",
                success: function (response) {
                    if (response['wbs_sakidashi_issuance'] && response['wbs_sakidashi_issuance'].length > 0) {
                        $('#txtPartsProductName').val(response.wbs_sakidashi_issuance[0].device_name);
                        $('#txtQty').val(response.wbs_sakidashi_issuance[0].po_qty);
                    } else {
                        alert("PO not found. Please check the PO number and try again.");
                        $('#txtPartsProductName').val('');
                        $('#txtQty').val('');
                    }
                },
                error: function() {
                    console.error("Search failed");
                }
            });
        }

        function saveUdDetails() {
    let form = $("#frmSaveUdDetails")[0]; // native DOM element

    let formData = new FormData(form); // includes files

    $.ajax({
        url: "save_ud_details",
        method: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,  // Important for FormData
        contentType: false,  // Important for FormData
        beforeSend: function() {
            $(".input-error", form).text('');
            $(".form-control", form).removeClass('is-invalid');
        },
        success: function(response) {
            if (response['result'] == 1) {
                toastr.success('Record saved successfully!');
                $('#modalSaveUdDetails').modal('hide');
                form.reset();
                $('.select2').val(null).trigger('change');
                $('#tblUdDetails').DataTable().ajax.reload();
            } else {
                toastr.error('Save failed: ' + response['msg']);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    toastr.error(messages[0]);
                    let input = $(form).find(`[name="${key}"]`);
                    input.addClass('is-invalid');
                    input.next('.input-error').text(messages[0]);
                });
            }
        }
    });
}

// function saveUdDetails() {
//     // Wrap the ID in jQuery $()
//     let form = $("#frmSaveUdDetails");

//     $.ajax({
//         url: "save_ud_details",
//         method: 'post',
//         // Use the jQuery 'form' variable here
//         data: form.serialize(),
//         dataType: 'json',
//         beforeSend: function() {
//             // Re-enable disabled fields temporarily so they ARE serialized/sent
//             // only if you used .prop('disabled', true) earlier
//             form.find(':disabled').prop('disabled', false);

//             $(".input-error", form).text('');
//             $(".form-control", form).removeClass('is-invalid');
//         },
//         success: function(response) {
//             if (response['result'] == 1) {
//                 toastr.success('Record saved successfully!');
//                 $('#modalSaveUdDetails').modal('hide');

//                 // Use [0] to get the native DOM element to call reset()
//                 form[0].reset();
//                 $('.select2').val(null).trigger('change');
//                 $('#tblUdDetails').DataTable().ajax.reload();
//             } else {
//                 toastr.error('Save failed: ' + response['msg']);
//             }
//         },
//         error: function(xhr) {

//             if (xhr.status === 422) {
//                 let errors = xhr.responseJSON.errors;
//                 $.each(errors, function(key, messages) {
//                     toastr.error(messages[0]);
//                     let input = form.find(`[name="${key}"]`);
//                     input.addClass('is-invalid');
//                     input.next('.input-error').text(messages[0]);
//                 });
//             }
//         }
//     });
// }

 function getUdControlNumber(cboElement){
    let $cbo = $(cboElement);
    $.ajax({
        url: "get_ud_control_number",
        method: 'GET',
        success: function(JsonObject) {
            let result = '';
            if (JsonObject['ud_from_rapid'] && JsonObject['ud_from_rapid'].length > 0) {
                result = '<option selected disabled>-- Select One -- </option>';
                for (let index = 0; index < JsonObject['ud_from_rapid'].length; index++) {
                    let rapidDocs = JsonObject['ud_from_rapid'][index];
                    // console.log(rapidDocs);
                    result += `<option value="${rapidDocs.pkid}"  data-docno="${rapidDocs.doc_no}" data-revision="${rapidDocs.rev_no}" data-dposted="${rapidDocs.date_time_created}">
                            ${rapidDocs.doc_no}
                    </option>`;
                }
            } else {
                result = '<option value=""> -- No record found -- </option>';
            }
            $cbo.html(result);
        },
        error: function(xhr, status, error) {
            $cbo.html('<option value=""> -- Reload Again -- </option>');
            console.error("AJAX Error:", status, error);
        }
    });
}

function getAttendeesByRapidX(cboElement, callback) {
    let $cbo = $(cboElement);
    $.ajax({
        url: "get_attendees_by_rapidx",
        method: 'GET',
        success: function(JsonObject) {
            let result = '';
            if (JsonObject['data'] && JsonObject['data'].length > 0) {
                for (let index = 0; index < JsonObject['data'].length; index++) {
                    let rapidXUsers = JsonObject['data'][index];
                    result += `<option value="${rapidXUsers.id}">${rapidXUsers.name}</option>`;
                }
            } else {
                result = '<option value=""> -- No record found -- </option>';
            }
            $cbo.html(result);

            // Now this will work because 'callback' is defined
            if (typeof callback === "function") {
                callback();
            }
        },
        error: function(xhr, status, error) {
            $cbo.html('<option value=""> -- Reload Again -- </option>');
            console.error("AJAX Error:", status, error);
        }
    });
}
