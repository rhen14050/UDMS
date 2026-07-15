@php $layout = 'layouts.super_user_layout';

    if(Auth::check()){
        if(Auth::user()->user_level_id == 1){
            $layout = 'layouts.super_user_layout';
        } else if(Auth::user()->user_level_id == 2){
            $layout = 'layouts.admin_layout';
        }
    }

@endphp

@auth
    @php
        if(Auth::user()->user_level_id == 1){
            $layout = 'layouts.super_user_layout';
        }
        else if(Auth::user()->user_level_id == 2){
            $layout = 'layouts.admin_layout';
        }
        else if(Auth::user()->user_level_id == 3){
            $layout = 'layouts.user_layout';
        }
    @endphp
@endauth

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'UD Monitoring')

@section('content_page')

@section('style')
<style>
            /* 1. Target only the "Sent By" tags background/text */
        #txtSentByFromYec + .select2 .select2-selection__choice {
            background-color: transparent !important;
            color: darkgreen !important;
            border: 1px solid #28a745 !important;
        }

        /* 2. Target only the "Sent By" 'x' button */
        #txtSentByFromYec + .select2 .select2-selection__choice__remove {
            color: #dc3545 !important;
        }

        /* 3. Target only the "Sent By" dropdown hover color */
        #txtSentByFromYec + .select2-container .select2-results__option--highlighted {
            background-color: darkgreen !important;
        }

        html, body {
            height: auto !important;
            overflow: auto !important;
        }

        .content-wrapper {
            height: auto !important;
            overflow: visible !important;
        }
</style>
@endsection

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>UD Monitoring</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('blank') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">UD Monitoring</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">UD Monitoring</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-sm-right">
                                        <a href="{{ route('export.ud.monitoring') }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-file-excel"></i> Export Excel
                                        </a>
                                        <button class="btn btn-primary btn-sm btnAddUD"><i class="fa fa-plus"></i> Add UD Details</button>

                                        <br><br>
                                    </div> <!-- .float-sm-right -->



                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" id="tblUdDetails" style="width: 100%;">
                                        <thead>
                                            <tr style="text-align: center;">
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Date of Information from YEC</th>
                                            <th>Sent By (From YEC)</th>
                                            <th>Attention to (PMI-PPC)</th>
                                            <th>UD Control #</th>
                                            <th>Revision</th>
                                            <th>PO#</th>
                                            <th>Parts / Product Name</th>
                                            <th>Qty</th>
                                            <th>Date Coverage</th>
                                            <th>Content UD / Special Instruction</th>
                                            </tr>
                                        </thead>
                                        </table>
                                    </div>

                                </div> <!-- .col-sm-12 -->
                            </div> <!-- .row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- MODALS Add Ud Details -->
<div class="modal fade" id="modalSaveUdDetails" tabindex="-1" role="dialog" aria-labelledby="modalSaveUdDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h4 class="modal-title"><b>UD Details Monitoring</b></h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="frmSaveUdDetails" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ud_ppc_input_id" id="txtUdPpcInputId">

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            {{-- <h3 class="card-title">PPC UPDATE</h3> --}}
                            <h3 class="card-title">In-Charge: <b>PPC</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i> </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Date Information from YEC</label>
                                        <input class="form-control" type="date" name="date_information_from_yec" id="txtDateInformationFromYec">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sent By (From YEC)</label>
                                        <select name="sent_by_from_yec[]" id="txtSentByFromYec" class="form-control select2bs4" multiple="multiple" data-placeholder="Select Sent By">
                                            <option value="1">YEC - Goto-san</option>
                                            <option value="2">YEC - Chie-san</option>
                                            <option value="3">YEC - Yanagawa-san</option>
                                            <option value="4">YEC - Kondo-san</option>
                                            <option value="5">YEC - Kenta-san</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Attention to: </label>
                                        <select name="attention_to_pmi_ppc[]" id="txtAttentionToPmiPpc" class="form-control select2bs4" multiple="multiple" data-placeholder="Select Attention To">
                                            <option value="1">Ms. Jeng</option>
                                            <option value="2">Ms. Jessa</option>
                                            <option value="3">Mr. Oyama</option>
                                            <option value="4">Mr. Tomura</option>
                                            <option value="5">Ms. Shibuki</option>
                                            <option value="6">Mr. Yanagawa</option>
                                            <option value="7">Mr. Goto</option>
                                            <option value="8">Mr. Darwin</option>
                                            <option value="9">Mr. TJ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>UD Control #</label>
                                        <select class="form-control select2bs4 selectUdControlNumber" id="txtSelectUdControlNumber" name="selected_ud_control_number_id" style="width: 100%;">
                                            <option value="">Select Order Number</option>
                                        </select>
                                        <input type="text" class="form-control bg-light" name="ud_control_number" id="txtUdControlNumber" readonly hidden>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Revision</label>
                                        <input class="form-control bg-light" type="text" name="revision" id="txtRevision" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Date Posted in Rapid</label>
                                        <input class="form-control bg-light" type="text" name="date_posted_in_rapid" id="txtDatePostedInRapid" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PO Number</label>
                                        <input class="form-control" type="text" name="po_number" id="txtPoNumber" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Parts / Product Name</label>
                                        <input class="form-control bg-light" type="text" name="parts_product_name" id="txtPartsProductName" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Qty</label>
                                        <input class="form-control bg-light" type="text" name="qty" id="txtQty" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Date Coverage</label>
                                        <input class="form-control" type="text" name="date_coverage" id="txtDateCoverage" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Content UD / Special Instruction</label>
                                        <textarea class="form-control" name="content_ud_special_instruction" id="txtContentUdSpecialInstruction" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>UD Review Date</label>
                                        <input type="date" class="form-control" name="ud_review_date" id="txtUdReviewDate" >
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>UD Review Result</label>
                                        <textarea class="form-control" name="ud_review_result" id="txtUdReviewResult" rows="2" autocomplete="off" ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PPC 1st Discussion Date</label>
                                        <input type="date" class="form-control" name="first_discussion_date" id="txtFirstDiscussionDate" >
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Risk Assessment Ctrl. No</label>
                                        <input class="form-control" type="text" name="assessment_ctrl_no" id="txtAssessmentCtrlNo" autocomplete="off" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="ppc_remarks" id="txtPpcRemarks" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-4 mb-2" id="divSecondDiscussionHeader" hidden>
                        <h5 class="text-primary"><i class="fas fa-comments mr-2"></i><b>2nd Discussion (Production)</b></h5>
                        <hr>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardProductionProcess" hidden>
                        <div class="card-header">
                            {{-- <h3 class="card-title text-muted"><i class="fas fa-users mr-2"></i><b>PROCESS 2:</b> Production Input</h3> --}}
                            <h3 class="card-title text-muted"><i></i>In-Charge: <b>Production</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i> </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyProductionProcess" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Meeting Date</label>
                                        <input class="form-control prod-field" type="date" name="meeting_date" id="txtMeetingDate" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Attendee/s</label>
                                        <select class="form-control select2bs4 selectAttendees prod-field" id="txtSelectAttendees" name="select_attendees[]" multiple="multiple" style="width: 100%;" disabled>
                                            <option value="">Select Attendee/s</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">

                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Attendee Role</label>
                                        <select class="form-control select2bs4 selectAttendeeRole prod-field" id="txtselectAttendeeRole" name="select_attendee_role[]" multiple="multiple" style="width: 100%;" disabled>
                                            <option value="1">Operators</option>
                                            <option value="2">QC Inspectors</option>
                                            <option value="3">MH</option>
                                            <option value="4">Technician</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>ORCTO Attachment</label>
                                        <input type="file" class="form-control prod-field" name="orcto_attachment" id="txtOrctoAttachmentId" accept=".xls,.xlsx, .pdf" disabled></input>
                                        <input type="text" class="form-control prod-field" name="orcto_uploaded_attachment" id="txtOrctoUploadedAttachmentId" readonly hidden></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardEngineeringProcess" hidden>
                        <div class="card-header">
                            <h3 class="card-title text-muted">In-Charge: <b>Engineering</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyEngineeringProcess" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>SEI</label>
                                        <input type="text" class="form-control eng-field" name="sei" id="txtSeiId" disabled></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>SEI Attachment</label>
                                        <input type="file" class="form-control eng-field" name="sei_attachment" id="txtSeiAttachmentId" accept=".xls,.xlsx" disabled></input>
                                        <input type="text" class="form-control eng-field" name="sei_uploaded_attachment" id="txtSeiUploadedAttachment" readonly hidden></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardProductionSpecialRuncard" hidden>
                        <div class="card-header">
                            <h3 class="card-title text-muted">In-Charge: <b>Production</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyProductionSpecialRuncard" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Special Runcard</label>
                                        <input type="text" class="form-control sr-field" name="special_runcard" id="txtSpecialRuncard" disabled></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardInspectionDataSheet" hidden>
                        <div class="card-header">
                            <h3 class="card-title text-muted">In-Charge: <b>QC / Engineering</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyInspectionDataSheet" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Inspection Data Sheet</label>
                                        <input type="text" class="form-control ids-field" name="inspection_data_sheet" id="txtInspectionDataSheet" disabled></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Inspection Data Sheet Attachment</label>
                                        <input type="file" class="form-control ids-field" name="inspection_data_sheet_attachment" id="txtInspectionAttachmentId" accept=".xls,.xlsx" disabled></input>
                                        <input type="text" class="form-control ids-field" name="inspection_data_sheet_uploaded_attachment" id="txtInspectionDataSheetUploadedAttachmentId" readonly hidden></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardOrientation" hidden>
                        <div class="card-header">
                            <h3 class="card-title text-muted">In-Charge: <b>Production</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyOrientation" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Orientation</label>
                                        <select name="orientation" id="txtOrientation" class="form-control o-field select2bs4" disabled>
                                            <option selected value="0">Select</option>
                                            <option value="1">YES</option>
                                            <option value="2">NO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Orientation Attachment</label>
                                        <input type="file" class="form-control o-field" name="orientation_attachment" id="txtOrientationAttachmentId" accept=".pdf" disabled></input>
                                        <input type="text" class="form-control o-field" name="orientation_uploaded_attachment" id="txtOrientationUploadedAttachmentId" readonly hidden></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary mt-3" id="cardClosing" hidden>
                        <div class="card-header">
                            <h3 class="card-title text-muted">In-Charge: <b>PPC</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bodyClosing" style="background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Production Date</label>
                                        <input type="date" class="form-control closing-field" name="c_production_date" id="txtCProductionDate" disabled></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Shipment Date</label>
                                        <input type="date" class="form-control closing-field" name="shipment_date" id="txtShipmentDate" disabled></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Qty</label>
                                        <input type="number" class="form-control closing-field" name="c_qty" id="txtCQty" disabled></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>PPC - In-Charge/s</label>
                                        <select name="c_ppc_incharge[]" id="txtCPpcIncharge" class="form-control select2bs4 closing-field" multiple="multiple" data-placeholder="Select PPC In-Charge/s" disabled>
                                            {{-- <option value="0" selected>Select PPC In-Charge/s</option> --}}
                                            <option value="1">Ms. Jeng</option>
                                            <option value="2">Ms. Jessa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" id="txtStatus" class="form-control o-field select2bs4" disabled>
                                            <option selected value="0">Select Status</option>
                                            <option value="1">Closed</option>
                                            <option value="2">Continuous</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSaveUdDetails">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection




@section('js_content')
    <script type="text/javascript">

        $(document).ready(function () {
            let dtUdDetails, btnSaveUdDetails, frmSaveUdDetails;
            frmSaveUdDetails = $('#frmSaveUdDetails');

            btnSaveUdDetails = $('.btnSaveUdDetails');

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
                // dropdownParent: $('#modalSaveUdDetails') // Ensure dropdowns are within the modal
            });


            dtUdDetails = $('#tblUdDetails').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_ud_ppc_inputs_details') }}",
                columns: [
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'date_from_yec', name: 'date_of_information_from_yec' },
                    { data: 'sent_by_from_yec', name: 'sent_by_from_yec' },
                    { data: 'attention_to_pmi_ppc', name: 'attention_to_pmi_ppc' },
                    { data: 'ud_ctrlno', name: 'ud_control_number' },
                    { data: 'revision', name: 'revision' },
                    { data: 'po_num', name: 'po_num' },
                    { data: 'p_name', name: 'p_name' },
                    { data: 'qty', name: 'qty' },
                    { data: 'date_coverage', name: 'date_coverage' },
                    { data: 'content_of_ud', name: 'content_of_ud' }
                ]
            });

            $(document).on('click', '.btnAddUD', function () {
                // 1. Reset/Hide the Production/Engineering sections and header
                $('#divSecondDiscussionHeader').prop('hidden', true);
                $('#cardProductionProcess').prop('hidden', true);
                $('#cardEngineeringProcess').prop('hidden', true);
                $('#cardProductionSpecialRuncard').prop('hidden', true);
                $('#cardInspectionDataSheet').prop('hidden', true);
                $('#cardOrientation').prop('hidden', true);
                $('#cardClosing').prop('hidden', true);

                // 2. Reset the card styling to 'secondary' (gray)
                $('#cardProductionProcess').removeClass('card-success').addClass('card-secondary');
                $('#cardProductionProcess .card-title').addClass('text-muted');
                $('#bodyProductionProcess').css('background-color', '#f8f9fa');

                $('#cardEngineeringProcess').removeClass('card-success').addClass('card-secondary');
                $('#cardEngineeringProcess .card-title').addClass('text-muted');
                $('#bodyEngineeringProcess').css('background-color', '#f8f9fa');

                $('#cardProductionSpecialRuncard').removeClass('card-success').addClass('card-secondary');
                $('#cardProductionSpecialRuncard .card-title').addClass('text-muted');
                $('#bodyProductionSpecialRuncard').css('background-color', '#f8f9fa');

                $('#cardInspectionDataSheet').removeClass('card-success').addClass('card-secondary');
                $('#cardInspectionDataSheet .card-title').addClass('text-muted');
                $('#bodyInspectionDataSheet').css('background-color', '#f8f9fa');

                $('#cardOrientation').removeClass('card-success').addClass('card-secondary');
                $('#cardOrientation .card-title').addClass('text-muted');
                $('#bodyOrientation').css('background-color', '#f8f9fa');

                $('#cardClosing').removeClass('card-success').addClass('card-secondary');
                $('#cardClosing .card-title').addClass('text-muted');
                $('#bodyClosing').css('background-color', '#f8f9fa');


                // 3. Reset form fields (especially hidden IDs and readonly/disabled states)
                $('#frmSaveUdDetails')[0].reset();
                $('#txtUdPpcInputId').val(""); // Clear the ID so it doesn't try to update

                // Enable fields that might have been locked during Edit
                $('#txtDateInformationFromYec').prop('readonly', false);
                $('#txtPoNumber').prop('readonly', false);
                $('#txtDateCoverage').prop('readonly', false);
                $('#txtContentUdSpecialInstruction').prop('readonly', false);

                // 4. Reset Select2 pointers/opacity (undoing the 'Edit' locking)
                $('.select2bs4').val(null).trigger('change');
                $('.select2-container').css({
                    'pointer-events': 'auto',
                    'opacity': '1'
                });
                $('.select2-selection').css('background-color', '');
                $('.select2-search--inline').show();

                // 5. Show the modal and load Control Numbers
                $('#modalSaveUdDetails').modal('show');
                $('#txtUdReviewDate').prop('readonly', false);
                $('#txtUdReviewResult').prop('readonly', false);
                $('#txtFirstDiscussionDate').prop('readonly', false);
                $('#txtAssessmentCtrlNo').prop('readonly', false);
                $('#txtPpcRemarks').prop('readonly', false);
                getUdControlNumber($('.selectUdControlNumber'));
            });

            $('.selectUdControlNumber').on('change', function() {
                let selectedOption = $(this).find('option:selected');
                let selectedRevision = selectedOption.data('revision');
                let rawDate = selectedOption.data('dposted');
                let selectedDocNo = selectedOption.data('docno');
                // console.log(selectedOption.data());

                $('#txtUdControlNumber').val(selectedDocNo);

                // 1. Handle Date Formatting
                let displayDate = "";
                if (rawDate) {
                    let dateObj = new Date(rawDate);
                    // Check if date is valid before formatting
                    if (!isNaN(dateObj.getTime())) {
                        displayDate = dateObj.toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    } else {
                        // If it's already a string like "08/10/2015", just use it
                        displayDate = rawDate;
                    }
                }

                // 2. Handle Revision "NONE"
                if (selectedRevision === 'NONE' || !selectedRevision) {
                    selectedRevision = '-';
                }

                // 3. Update Inputs
                $('#txtRevision').val(selectedRevision);
                $('#txtDatePostedInRapid').val(displayDate);
            });

            $('#txtPoNumber').on('keydown', function(e) {
                if (e.keyCode === 13 && e.target.nodeName !== 'TEXTAREA') {
                    e.preventDefault();
                    return false;
                }
            });


            $('#txtPoNumber').on('keydown', function(e) {
                // Check if the key pressed is "Enter"
                if (e.keyCode === 13) {
                    e.preventDefault(); // Stop form from doing anything else

                    let poNumber = $(this).val();

                    if (poNumber !== '' ) {
                        if(poNumber != 'N/A'){
                            executeSearch(poNumber);
                             $('#txtPartsProductName').prop('readonly', true)
                            $('#txtQty').prop('readonly', true)

                        }else{
                            $('#txtPartsProductName').val('');
                            $('#txtQty').val('');
                            $('#txtPartsProductName').prop('readonly', false)
                            $('#txtQty').prop('readonly', false)
                        }
                    }
                    else {
                        alert('Please enter a PO Number first');
                    }
                }
            });

            $("#frmSaveUdDetails").submit(function(e){
                e.preventDefault();
                saveUdDetails();
            });

            $(document).on('click', '.btnEditData', function() {
                let udPpcInputId = $(this).data('id');
                $('#txtUdPpcInputId').val(udPpcInputId);
                $('#modalSaveUdDetails').modal('show');
                $.ajax({
                    url: "{{ route('get_ud_details') }}",
                    method: 'GET',
                    data: { ud_ppc_input_id: udPpcInputId },
                    dataType: 'json',
                    success: function(response) {
                        if (response['data']) {
                            let details = response.data;

                            let sentByString = details.sent_by_from_yec;
                            let attentionToString = details.attention_to_pmi_ppc;

                            $('#txtDateInformationFromYec').val(details.date_from_yec).prop('readonly', true);

                            if (sentByString) {
                                let sentByArray = sentByString.split(',');
                                $('#txtSentByFromYec').val(sentByArray).trigger('change');

                                $('#txtSentByFromYec').next('.select2-container').css({
                                    'pointer-events': 'none',
                                    'opacity': '1', // Optional: slight fade to show it's locked
                                });

                                $('#txtSentByFromYec').next('.select2-container').find('.select2-selection').css({
                                    'background-color': '#e9ecef'
                                });
                                $('#txtSentByFromYec').next('.select2-container').find('.select2-search--inline').hide();

                            } else {
                                // Clear it if no data exists
                                $('#txtSentByFromYec').val(null).trigger('change');
                            }

                            if(attentionToString) {
                                let attentionToArray = attentionToString.split(',');
                                $('#txtAttentionToPmiPpc').val(attentionToArray).trigger('change');

                                $('#txtAttentionToPmiPpc').next('.select2-container').css({
                                    'pointer-events': 'none',
                                    'opacity': '1', // Optional: slight fade to show it's locked
                                });

                                $('#txtAttentionToPmiPpc').next('.select2-container').find('.select2-selection').css({
                                    'background-color': '#e9ecef'
                                });
                                $('#txtAttentionToPmiPpc').next('.select2-container').find('.select2-search--inline').hide();

                            } else {
                                $('#txtAttentionToPmiPpc').val(null).trigger('change').prop('readonly', true);
                            }


                            // $('#txtAttentionToPmiPpc').val(details.attention_to_pmi_ppc).trigger('change');
                            // $('#txtSelectUdControlNumber').val(details.ud_ctrlno).trigger('change');
                            ctrlNumber = details.ud_ctrlno;
                            ctrlNumberId = details.ud_ctrlno_id;
                            // ctrlNumberId = details;

                            // console.log('ctrlNumberId',ctrlNumberId)
                            // console.log('details',details)

                            let $ctrlNumber = $('#txtSelectUdControlNumber');
                            $('#txtSelectUdControlNumber').next('.select2-container').css({
                                    'pointer-events': 'none',
                                    'opacity': '1', // Optional: slight fade to show it's locked
                                    'background-color': '#e9ecef' // Standard Bootstrap "disabled" grey
                            });
                            $('#txtSelectUdControlNumber').next('.select2-container').find('.select2-selection').css({
                                    'background-color': '#e9ecef'
                            });

                            $('#txtSelectUdControlNumber').next('.select2-container').find('.select2-search--inline').hide();
                            if ($ctrlNumber.find("option[value='" + ctrlNumberId + "']").length === 0) {
                                $ctrlNumber.append($('<option>', { value: ctrlNumberId, text: ctrlNumber }));
                            }
                            $ctrlNumber.val(ctrlNumberId).trigger('change');
                            $('#txtUdControlNumber').val(details.ud_ctrlno).prop('readonly', true);

                            $('#txtRevision').val(details.revision);
                            $('#txtDatePostedInRapid').val(details.date_posted_rapid);
                            $('#txtPoNumber').val(details.po_num).prop('readonly', true);
                            $('#txtPartsProductName').val(details.p_name);
                            $('#txtQty').val(details.qty);
                            $('#txtDateCoverage').val(details.date_coverage).prop('readonly', true);
                            $('#txtContentUdSpecialInstruction').val(details.content_of_ud).prop('readonly', true);
                            $('#txtUdReviewResult').val(details.ud_review_result);
                            $('#txtFirstDiscussionDate').val(details.first_discussion_date);
                            $('#txtAssessmentCtrlNo').val(details.assessment_ctrl_no);
                            $('#txtPpcRemarks').val(details.ppc_remarks).prop('readonly', true);
                            if(details.date_ud_review){
                                $('#txtUdReviewDate').val(details.date_ud_review).prop('readonly', true);
                                $('#txtUdReviewResult').val(details.result_ud_review).prop('readonly', true);
                                $('#txtFirstDiscussionDate').val(details.fd_ppc_date).prop('readonly', true);
                                $('#txtAssessmentCtrlNo').val(details.fd_ppc_risk_ctrl_no).prop('readonly', true);
                            }


                            if(details.status == 0){
                                $('#cardProductionProcess').prop('hidden', false)
                                $('#divSecondDiscussionHeader').prop('hidden', false);
                                $('#cardProductionProcess').removeClass('card-secondary').addClass('card-success');
                                $('#cardProductionProcess .card-title').removeClass('text-muted');
                                $('#bodyProductionProcess').css('background-color', 'transparent');
                                $('.prod-field').prop('disabled', false);
                                getAttendeesByRapidX($('.selectAttendees'));
                                $('#txtOrctoAttachmentId').prop('disabled', false);

                                $('#cardEngineeringProcess').prop('hidden', true);
                                $('#cardEngineeringProcess').removeClass('card-success').addClass('card-secondary');
                                $('#cardEngineeringProcess .card-title').addClass('text-muted');
                                $('#bodyEngineeringProcess').css('background-color', '#f8f9fa');

                                $('#cardProductionSpecialRuncard').prop('hidden', true);
                                $('#cardProductionSpecialRuncard').removeClass('card-success').addClass('card-secondary');
                                $('#cardProductionSpecialRuncard .card-title').addClass('text-muted');
                                $('#bodyProductionSpecialRuncard').css('background-color', '#f8f9fa');

                                $('#cardInspectionDataSheet').prop('hidden', true);
                                $('#cardInspectionDataSheet').removeClass('card-success').addClass('card-secondary');
                                $('#cardInspectionDataSheet .card-title').addClass('text-muted');
                                $('#bodyInspectionDataSheet').css('background-color', '#f8f9fa');

                                $('#cardOrientation').prop('hidden', true);
                                $('#cardOrientation').removeClass('card-success').addClass('card-secondary');
                                $('#cardOrientation .card-title').addClass('text-muted');
                                $('#bodyOrientation').css('background-color', '#f8f9fa');

                                $('#cardInspectionDataSheet').prop('hidden', true);
                                $('#cardInspectionDataSheet').removeClass('card-success').addClass('card-secondary');
                                $('#cardInspectionDataSheet .card-title').addClass('text-muted');
                                $('#bodyInspectionDataSheet').css('background-color', '#f8f9fa');

                                $('#cardOrientation').prop('hidden', true);
                                $('#cardOrientation').removeClass('card-success').addClass('card-secondary');
                                $('#cardOrientation .card-title').addClass('text-muted');
                                $('#bodyOrientation').css('background-color', '#f8f9fa');

                                $('#cardClosing').prop('hidden', true);
                                $('#cardClosing').removeClass('card-success').addClass('card-secondary');
                                $('#cardClosing .card-title').addClass('text-muted');
                                $('#bodyClosing').css('background-color', '#f8f9fa');



                            }else if(details.status == 1 || details.status == 2 || details.status == 3 || details.status == 4 || details.status == 5 || details.status == 6){
                                $('#cardProductionProcess').prop('hidden', false);
                                $('#divSecondDiscussionHeader').prop('hidden', false);
                                $('#cardProductionProcess .card-title').removeClass('text-muted');
                                $('#cardProductionProcess').removeClass('card-secondary').addClass('card-success');

                                $('#cardEngineeringProcess').prop('hidden', false);
                                $('#cardEngineeringProcess').removeClass('card-secondary').addClass('card-success');
                                $('#cardEngineeringProcess .card-title').removeClass('text-muted');
                                $('#bodyEngineeringProcess').css('background-color', 'transparent');
                                $('.eng-field').prop('disabled', false);
                                $('#txtSeiAttachmentId').prop('disabled', false);

                                // 1. Temporarily ENABLE fields so Select2 can accept values
                                $('.prod-field').prop('disabled', false);

                                let prodData = response.data.second_discussion_details;

                                if (prodData) {
                                    $('#txtMeetingDate').val(prodData.date);
                                    let attendeesString = prodData.attendees;
                                    let attendeeRoleString = prodData.attendees_role;

                                    if(attendeeRoleString){
                                        let attendeesRoleToArray = attendeeRoleString.split(',').map(item => item.trim());
                                        $('#txtselectAttendeeRole').val(attendeesRoleToArray).trigger('change');


                                            $('#txtMeetingDate').prop('readonly',true);
                                            $('#txtselectAttendeeRole').next('.select2-container').css({
                                                'pointer-events': 'none',
                                                'opacity': '1', // Optional: slight fade to show it's locked
                                            });

                                            $('#txtselectAttendeeRole').next('.select2-container').find('.select2-selection').css({
                                                'background-color': '#e9ecef'
                                            });
                                            $('#txtselectAttendeeRole').next('.select2-container').find('.select2-search--inline').hide();
                                    }

                                    getAttendeesByRapidX('#txtSelectAttendees', function() {
                                        if (attendeesString) {
                                            let attendeesToArray = attendeesString.split(',').map(item => item.trim());

                                            // Use .val().trigger('change')
                                            // If it still doesn't show, we might need to re-initialize Select2 here
                                            $('#txtSelectAttendees').val(attendeesToArray).trigger('change');


                                            $('#txtMeetingDate').prop('readonly',true);
                                            $('#txtSelectAttendees').next('.select2-container').css({
                                                'pointer-events': 'none',
                                                'opacity': '1', // Optional: slight fade to show it's locked
                                            });

                                            $('#txtSelectAttendees').next('.select2-container').find('.select2-selection').css({
                                                'background-color': '#e9ecef'
                                            });
                                            $('#txtSelectAttendees').next('.select2-container').find('.select2-search--inline').hide();
                                        } else {

                                        }
                                    });


                                $('#txtOrctoUploadedAttachmentId').val(prodData.orcto_attachment).prop('hidden', false); // show the filename in a readonly input
                                $('#txtOrctoAttachmentId').prop('hidden', true); // hide the file input since we already have an attachment
                                $('#txtOrctoAttachmentId').prop('disabled', true); // disable the file input to prevent changes
                                $('txtOrctoUploadedAttachmentId').val(prodData.orcto_attachment); // set the filename in the readonly input

                                let downloadLink = 'orcto_attachment/download/' + prodData.orcto_attachment; // dynamic URL
                                // Remove any existing button first to avoid duplicates
                                $('#btnDownloadOrctoAttachment').remove();

                                $('#txtOrctoUploadedAttachmentId').after(
                                    '<a href="' + downloadLink + '" target="_blank" id="btnDownloadOrctoAttachment" class="btn btn-sm btn-info mt-2">Download Attachment</a>'
                                );

                                $('#chkReuploadOrctoAttachment').closest('.form-check').remove();

                                $('#txtOrctoUploadedAttachmentId').after(
                                    '<div class="form-check mt-2">' +
                                        '<input class="form-check-input" type="checkbox" id="chkReuploadOrctoAttachment">' +
                                        '<label class="form-check-label" for="chkReuploadOrctoAttachment">Re-upload document</label>' +
                                    '</div>'
                                );

                                    if(prodData.cp_sei){
                                        if(prodData.cp_sei_attachment){ // check if attachment exists
                                            $('#txtSeiId').val(prodData.cp_sei);
                                            $('#txtSeiId').prop('readonly', true);
                                            $('#txtSeiUploadedAttachment').val(prodData.cp_sei_attachment).prop('hidden', false); // show the filename in a readonly input
                                            $('#txtSeiAttachmentId').prop('hidden', true); // hide the file input since we already have an attachment
                                            $('#txtSeiAttachmentId').prop('disabled', true); // disable the file input to prevent changes
                                            $('txtSeiUploadedAttachment').val(prodData.cp_sei_attachment); // set the filename in the readonly input

                                            let downloadLink = 'sei_attachment/download/' + prodData.cp_sei_attachment; // dynamic URL
                                            // Remove any existing button first to avoid duplicates
                                            $('#btnDownloadSeiAttachment').remove();

                                            $('#txtSeiUploadedAttachment').after(
                                                '<a href="' + downloadLink + '" target="_blank" id="btnDownloadSeiAttachment" class="btn btn-sm btn-info mt-2">Download Attachment</a>'
                                            );

                                            $('#chkReuploadSei').closest('.form-check').remove();

                                            $('#txtSeiUploadedAttachment').after(
                                                '<div class="form-check mt-2">' +
                                                    '<input class="form-check-input" type="checkbox" id="chkReuploadSei">' +
                                                    '<label class="form-check-label" for="chkReuploadSei">Re-upload document</label>' +
                                                '</div>'
                                            );


                                            $('#cardProductionSpecialRuncard').prop('hidden', false);
                                            $('#cardProductionSpecialRuncard').removeClass('card-secondary').addClass('card success');
                                            $('#cardProductionSpecialRuncard .card-title').removeClass('text-muted');
                                            $('#bodyProductionSpecialRuncard').css('background-color', 'transparent');
                                            $('.sr-field').prop('disabled', false);

                                            if(prodData.cp_special_runcard){
                                                $('#txtSpecialRuncard').val(prodData.cp_special_runcard);
                                                $('#txtSpecialRuncard').prop('readonly', true);

                                                $('#cardInspectionDataSheet').prop('hidden', false);
                                                $('#cardInspectionDataSheet').removeClass('card-secondary').addClass('card success');
                                                $('#cardInspectionDataSheet .card-title').removeClass('text-muted');
                                                $('#bodyInspectionDataSheet').css('background-color', 'transparent');
                                                $('.ids-field').prop('disabled', false);

                                                if(prodData.cp_inspection_data){
                                                    $('#txtInspectionDataSheet').val(prodData.cp_inspection_data);
                                                    $('#txtInspectionDataSheet').prop('readonly', true);
                                                    $('#cardOrientation').prop('hidden', false);
                                                    $('#cardOrientation').removeClass('card-secondary').addClass('card success');
                                                    $('#cardOrientation .card-title').removeClass('text-muted');
                                                    $('#bodyOrientation').css('background-color', 'transparent');
                                                    $('.o-field').prop('disabled', false);

                                                    if(prodData.cp_inspection_data_attachment){ // check if attachment exists
                                                        $('#txtInspectionDataSheetUploadedAttachmentId').val(prodData.cp_inspection_data_attachment).prop('hidden', false); // show the filename in a readonly input
                                                        $('#txtInspectionDataSheetUploadedAttachmentId').prop('disabled', true); // disable the file input to prevent changes
                                                        $('#txtInspectionAttachmentId').prop('hidden', true); // hide the file input since we already have an attachment
                                                        let idsDownloadLink = 'ids_attachment/download/' + prodData.cp_inspection_data_attachment; // dynamic URL
                                                        // Remove any existing button first to avoid duplicates
                                                        $('#btnDownloadIdsAttachment').remove();

                                                        $('#txtInspectionDataSheetUploadedAttachmentId').after(
                                                            '<a href="' + idsDownloadLink + '" target="_blank" id="btnDownloadIdsAttachment" class="btn btn-sm btn-info mt-2">Download Attachment</a>'
                                                        );

                                                        $('#chkReuploadIds').closest('.form-check').remove();

                                                        $('#txtInspectionDataSheetUploadedAttachmentId').after(
                                                            '<div class="form-check mt-2">' +
                                                                '<input class="form-check-input" type="checkbox" id="chkReuploadIds">' +
                                                                '<label class="form-check-label" for="chkReuploadIds">Re-upload document</label>' +
                                                            '</div>'
                                                        );

                                                    } else {
                                                        $('#txtInspectionDataSheetUploadedAttachmentId').prop('hidden', false); // show the file input for uploading
                                                        $('#txtInspectionDataSheetUploadedAttachmentId').prop('disabled', false); // enable the file input
                                                        $('#txtInspectionAttachmentId').prop('hidden', true); // hide the readonly input since there's no attachment
                                                        $('#txtInspectionDataSheetUploadedAttachmentId').val(''); // clear any existing value in the readonly input
                                                        $('#btnDownloadInspectionDataSheetAttachment').remove(); // remove any existing download button
                                                    }

                                                    if(prodData.cp_orientation){
                                                        $('#txtOrientation').val(prodData.cp_orientation).trigger('change');
                                                        $('#txtOrientation').next('.select2-container').css({
                                                            'pointer-events': 'none',
                                                            'opacity': '1', // Optional: slight fade to show it's locked
                                                        });

                                                        $('#txtOrientation').next('.select2-container').find('.select2-selection').css({
                                                            'background-color': '#e9ecef'
                                                        });
                                                        $('#txtOrientation').next('.select2-container').find('.select2-search--inline').hide();

                                                        $('#cardClosing').prop('hidden', false);
                                                        $('#cardClosing').removeClass('card-secondary').addClass('card success');
                                                        $('#cardClosing .card-title').removeClass('text-muted');
                                                        $('#bodyClosing').css('background-color', 'transparent');
                                                        $('.closing-field').prop('disabled', false);

                                                        if(prodData.cp_orientation_attachment){

                                                            $('#txtOrientationAttachmentId').prop('hidden', true); // hide the file input since we already have an attachment
                                                            $('#txtOrientationAttachmentId').prop('disabled', true); // disable the file input to prevent changes
                                                            $('#txtOrientationUploadedAttachmentId').val(prodData.cp_orientation_attachment).prop('hidden', false); // show the filename in a readonly input
                                                            let orientationDownloadLink = 'orientation_attachment/download/' + prodData.cp_orientation_attachment; // dynamic URL
                                                            // Remove any existing button first to avoid duplicates
                                                            $('#btnDownloadOrientationAttachment').remove();


                                                            $('#txtOrientationUploadedAttachmentId').after(
                                                                '<a href="' + orientationDownloadLink + '" target="_blank" id="btnDownloadOrientationAttachment" class="btn btn-sm btn-info mt-2">Download Attachment</a>'
                                                            );

                                                            $('#chkReuploadOrientation').closest('.form-check').remove();

                                                            $('#txtOrientationUploadedAttachmentId').after(
                                                                '<div class="form-check mt-2">' +
                                                                    '<input class="form-check-input" type="checkbox" id="chkReuploadOrientation">' +
                                                                    '<label class="form-check-label" for="chkReuploadOrientation">Re-upload document</label>' +
                                                                '</div>'
                                                            );
                                                        }else{
                                                            $('#txtOrientationAttachmentId').prop('hidden', false); // show the file input for uploading
                                                            $('#txtOrientationAttachmentId').prop('disabled', false); // enable the file input
                                                            $('#txtOrientationUploadedAttachmentId').prop('hidden', true); // hide the readonly input since there's no attachment
                                                            $('#txtOrientationUploadedAttachmentId').val(''); // clear any existing value in the readonly input
                                                            $('#btnDownloadOrientationAttachment').remove(); // remove any existing download button
                                                        }
                                                    }

                                                }
                                            }

                                            if(details.status === 6){
                                                $('.closing-field').prop('disabled', false);
                                                $('#chkReuploadSei').prop('disabled', true);
                                                $('#chkReuploadIds').prop('disabled', true);
                                                $('.btnSaveUdDetails').prop('hidden', true);
                                                $('#chkReuploadOrientation').prop('disabled', true);

                                                    let closingData = response.data.closing_details;
                                                    if(closingData){
                                                        $('#txtCProductionDate').val(closingData.production_date);
                                                        $('#txtShipmentDate').val(closingData.shipment_date);
                                                        $('#txtCQty').val(closingData.qty);

                                                        let ppcInchargeString = closingData.ppc_incharge;
                                                        if(ppcInchargeString){
                                                            let ppcInchargeArray = ppcInchargeString.split(',').map(item => item.trim());

                                                            $('#txtCPpcIncharge').val(ppcInchargeArray).trigger('change');

                                                            $('#txtCProductionDate').prop('readonly', true);
                                                            $('#txtShipmentDate').prop('readonly', true);
                                                            $('#txtCQty').prop('readonly', true);
                                                            $('#txtCPpcIncharge').next('.select2-container').css({
                                                                'pointer-events': 'none',
                                                                'opacity': '1', // Optional: slight fade to show it's locked
                                                            });

                                                            $('#txtCPpcIncharge').next('.select2-container').find('.select2-selection').css({
                                                                'background-color': '#e9ecef'
                                                            });
                                                            $('#txtCPpcIncharge').next('.select2-container').find('.select2-search--inline').hide();
                                                        }

                                                        $('#txtStatus').val(closingData.status).trigger('change');

                                                        if(closingData.status == 1){
                                                            $('#txtStatus').next('.select2-container').css({
                                                                'pointer-events': 'none',
                                                                'opacity': '1', // Optional: slight fade to show it's locked
                                                            });

                                                            $('#txtStatus').next('.select2-container').find('.select2-selection').css({
                                                                'background-color': '#e9ecef'
                                                            });
                                                            $('#txtStatus').next('.select2-container').find('.select2-search--inline').hide();
                                                        }


                                                    }
                                            }

                                        }else{
                                            $('#txtSeiAttachmentId').prop('hidden', false); // show the file input for uploading
                                            $('#txtOrctoAttachmentId').prop('hidden', false); // show the file input for uploading
                                            $('#txtOrctoAttachmentId').prop('disabled', false); // enable the file input
                                            $('#txtOrctoUploadedAttachment').prop('hidden', true); // hide the readonly input since there's no attachment
                                            $('#txtOrctoUploadedAttachment').val(''); // clear any existing value in the readonly input
                                            $('#btnDownloadOrctoAttachment').remove(); // remove any existing download button
                                        }

                                    }

                                } else {
                                    $('.prod-field').prop('disabled', true);
                                }

                            }
                            else{
                                $('#cardProductionProcess').prop('hidden', true);
                                $('#cardProductionProcess').removeClass('card-success').addClass('card-secondary');
                                $('#cardProductionProcess .card-title').addClass('text-muted');
                                $('#bodyProductionProcess').css('background-color', '#f8f9fa');
                                $('.prod-field').prop('disabled', true);
                            }
                        } else {
                            alert('Failed to fetch details. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching details. Please try again.');
                    }

                });
            });

            $(document).on('click', '.btnDeleteData', function(){
                let ppcInputId = $(this).data('id');

                console.log('ppcInputId to delete:', ppcInputId);
                if(confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                    $.ajax({
                        url: 'delete_ud_ppc_input/' + ppcInputId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.success) {
                                alert('Record deleted successfully.');
                                // $('#udMonitoringTable').DataTable().ajax.reload();
                                dtUdDetails.ajax.reload();
                            } else {
                                alert('Failed to delete record. Please try again.');
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the record. Please try again.');
                        }
                    });
                }
            })

            $(document).on('change', '#chkReuploadSei', function () {
                if ($(this).is(':checked')) {
                    // Enable file input
                    $('#txtSeiAttachmentId').prop('hidden', false).prop('disabled', false);

                    // Hide filename + download button
                    $('#txtSeiUploadedAttachment').prop('hidden', true);
                    $('#btnDownloadSeiAttachment').hide();
                } else {
                    // Disable file input again
                    $('#txtSeiAttachmentId').prop('hidden', true).prop('disabled', true);

                    // Show filename + download button
                    $('#txtSeiUploadedAttachment').prop('hidden', false);
                    $('#btnDownloadSeiAttachment').show();
                }
            });

            $(document).on('change', '#chkReuploadIds', function () {
                if ($(this).is(':checked')) {
                    // Enable file input
                    $('#txtInspectionAttachmentId').prop('hidden', false).prop('disabled', false);

                    // Hide filename + download button
                    $('#txtInspectionDataSheetUploadedAttachmentId').prop('hidden', true);
                    $('#btnDownloadIdsAttachment').hide();
                } else {
                    // Disable file input again
                    $('#txtInspectionAttachmentId').prop('hidden', true).prop('disabled', true);

                    // Show filename + download button
                    $('#txtInspectionDataSheetUploadedAttachmentId').prop('hidden', false);
                    $('#btnDownloadIdsAttachment').show();
                }
            });


            $(document).on('change', '#chkReuploadOrctoAttachment', function () {
                if ($(this).is(':checked')) {
                    // Enable file input
                    $('#txtOrctoAttachmentId').prop('hidden', false).prop('disabled', false);

                    // Hide filename + download button
                    $('#txtOrctoUploadedAttachmentId').prop('hidden', true);
                    $('#btnDownloadOrctoAttachment').hide();
                } else {
                    // Disable file input again
                    $('#txtOrctoAttachmentId').prop('hidden', true).prop('disabled', true);

                    // Show filename + download button
                    $('#txtOrctoUploadedAttachmentId').prop('hidden', false);
                    $('#btnDownloadOrctoAttachment').show();
                }
            });

            $(document).on('change', '#chkReuploadOrientation', function () {
                if ($(this).is(':checked')) {
                    // Enable file input
                    $('#txtOrientationAttachmentId').prop('hidden', false).prop('disabled', false);

                    // Hide filename + download button
                    $('#txtOrientationUploadedAttachmentId').prop('hidden', true);
                    $('#btnDownloadOrientationAttachment').hide();
                } else {
                    // Disable file input again
                    $('#txtOrientationAttachmentId').prop('hidden', true).prop('disabled', true);

                    // Show filename + download button
                    $('#txtOrientationUploadedAttachmentId').prop('hidden', false);
                    $('#btnDownloadOrientationAttachment').show();
                }
            });



            $('#modalSaveUdDetails').on('hidden.bs.modal', function () {
                $('#frmSaveUdDetails')[0].reset();
                $('#txtselectTest').val(null)
                $('#txtSentByFromYec').val(null).trigger('change').prop('readonly', false);
                $('#txtAttentionToPmiPpc').val(null).trigger('change').prop('readonly', false);
                $('#txtSelectUdControlNumber').val(null).trigger('change').prop('readonly', false);
                $('#txtPoNumber').prop('readonly', false);
                $('#txtDateCoverage').prop('readonly', false);
                $('#txtContentUdSpecialInstruction').prop('readonly', false);

                // Reset Select2 styles
                $('#txtSentByFromYec').next('.select2-container').css({
                    'pointer-events': '',
                    'opacity': '',
                    'background-color': ''
                }).find('.select2-selection').css({
                    'background-color': ''
                });
                $('#txtSentByFromYec').next('.select2-container').find('.select2-search--inline').show();

                $('#txtAttentionToPmiPpc').next('.select2-container').css({
                    'pointer-events': '',
                    'opacity': '',
                    'background-color': ''
                }).find('.select2-selection').css({
                    'background-color': ''
                });
                $('#txtAttentionToPmiPpc').next('.select2-container').find('.select2-search--inline').show();

                $('#txtSelectUdControlNumber').next('.select2-container').css({
                    'pointer-events': '',
                    'opacity': '',
                    'background-color': ''
                }).find('.select2-selection').css({
                    'background-color': ''
                });
                $('#txtSelectUdControlNumber').next('.select2-container').find('.select2-search--inline').show();
            });


        });





    </script>



@endsection
