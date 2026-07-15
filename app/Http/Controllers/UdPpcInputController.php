<?php

namespace App\Http\Controllers;

use App\Model\UdPpcInput;
use App\Model\SecondDiscussionDetails;
use App\Model\ClosingDetails;
use App\Model\Rapid;
use App\Model\WBSMaterialKitting;
use App\RapidXUser;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\UdMonitoringExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UdUpdateNotification;


class UdPpcInputController extends Controller
{
    //

    public function getUdPpcInputsDetails(Request $request){
    	$ud_ppc_inputs = UdPpcInput::with(['second_discussion_details', 'closing_details'])
        ->where('logdel', 0)
        ->get();

        return DataTables::of($ud_ppc_inputs)
          ->addColumn('action', function($row){
                $result = '';
                $result .= '<center>';
                $result .= '<button type="button" class="btn btn-xs btn-primary table-btns btnEditData" style="margin-right: 3px;" data-id="' . $row->id . '">
                                <i class="fa fa-edit" title="Edit"></i>
                            </button>';

                $result .= '<button type="button" class="btn btn-xs btn-danger table-btns btnDeleteData" data-id="' . $row->id . '">
                                <i class="fa fa-trash" title="Delete"></i>
                            </button>';
                $result .= '</center>';

                return $result;
            })
            ->addColumn('status', function($row){
                    $cp_sei = $row->second_discussion_details ? $row->second_discussion_details->cp_sei : null;
                    $cp_sei_atachment = $row->second_discussion_details ? $row->second_discussion_details->cp_sei_attachment : null;
                    $special_runcard = $row->second_discussion_details ? $row->second_discussion_details->cp_special_runcard : null;
                    $inspection_data = $row->second_discussion_details ? $row->second_discussion_details->cp_inspection_data : null;
                    $cp_orientation = $row->second_discussion_details ? $row->second_discussion_details->cp_orientation : null;

					$result = '';
                    if($row->status == 0){
                        $result .= '<span class="badge badge-info">For Production Update(2nd Discussion)</span><br>';
                        $result .= '<span class="badge badge-warning">In-Charge: Production</span>';

                    }else if($row->status == 1){
                        $result .= '<span class="badge badge-info">For Production Update(SEI)</span>';
                        $result .= '<span class="badge badge-warning">In-Charge: Engineering</span>';
                    }else if($row->status == 2){
                        $result .= '<span class="badge badge-info">For Production Update(Special Runcard)</span>';
                        $result .= '<span class="badge badge-warning">In-Charge: Production</span>';
                    }else if($row->status == 3){
                        $result .= '<span class="badge badge-info">For Production Update(Inspection Data Sheet)</span>';
                        $result .= '<span class="badge badge-warning">In-Charge: QC / Engineering</span>';
                    }else if($row->status == 4){
                        $result .= '<span class="badge badge-info">For Production Update(Orientation)</span>';
                        $result .= '<span class="badge badge-warning">In-Charge: Production</span>';
                    }else if($row->status == 5){
                        // $result .= '<span class="badge badge-success">Closed</span>';
                        $result .= '<span class="badge badge-info">For Closing</span>';
                        $result .= '<span class="badge badge-warning">In-Charge: PPC</span>';
                    }else if($row->status == 6){
                        $result .= '<span class="badge badge-success">Closed</span>';
                    }

	                return $result;
			})
            ->addColumn('sent_by_from_yec', function($row) {
                $nameMap = [
                    '1' => 'YEC - Goto-san',
                    '2' => 'YEC - Chie-san',
                    '3' => 'YEC - Yanagawa-san',
                    '4' => 'YEC - Kondo-san',
                    '5' => 'YEC - Kenta-san'
                ];

                // Check if the value exists to avoid errors on null
                if (empty($row->sent_by_from_yec)) {
                    return '';
                }

                $ids = explode(',', $row->sent_by_from_yec);

                $names = array_map(function($id) use ($nameMap) {
                    $name = $nameMap[trim($id)] ?? $id;
                    // Wrap in a span to prevent line breaks within the name itself
                    return '<span style="white-space: nowrap;">' . $name . '</span>';
                }, $ids);

                // Use <br> to separate different people, but each person stays on one line
                return implode('<br>', $names);
            })
            ->addColumn('attention_to_pmi_ppc', function($row) {
                // 1. Define your mapping
                $nameMap = [
                    '1' => 'Ms. Jeng',
                    '2' => 'Ms. Jessa',
                    '3' => 'Mr. Oyama',
                    '4' => 'Mr. Tomura',
                    '5' => 'Ms. Shibuki',
                    '6' => 'Mr. Yanagawa',
                    '7' => 'Mr. Goto',
                    '8' => 'Mr. Darwin',
                    '9' => 'Mr. TJ',

                ];

                // 2. Convert "1,2" back into an array ['1', '2']
                $ids = explode(',', $row->attention_to_pmi_ppc);

                // 3. Map the IDs to Names
                $names = array_map(function($id) use ($nameMap) {
                    // Return the name if found, otherwise return the ID itself
                    return $nameMap[trim($id)] ?? $id;
                }, $ids);

                // 4. Join them with <br> tags
                return implode('<br>', $names);
            })

            ->rawColumns(['action','status','sent_by_from_yec','attention_to_pmi_ppc'])
            ->make(true);
    }

    public function getUdControlNumber(Request $request){
        $ud_from_rapid = Rapid::where('doc_type', 'Urgent Direction')
                            // ->where('status', '!=', 'Closed')
                            ->where('logdel', 0)
                            ->get();

        return response()->json(['ud_from_rapid' => $ud_from_rapid]);
    }

    public function getProdNameByPo(Request $request){
        $wbs_sakidashi_issuance = WBSMaterialKitting::
        where('po_no', $request->po_number)
        ->get();

        return response()->json(['wbs_sakidashi_issuance' => $wbs_sakidashi_issuance]);
    }

    public function saveUdDetails(Request $request) {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        // return $data;


        $validator = Validator::make($data, [
            'date_information_from_yec' => 'nullable|date', // Usually YYYY-MM-DD from a date picker

            // Multi-selects
            'sent_by_from_yec' => 'nullable|array',
            'sent_by_from_yec.*' => 'string',
            'attention_to_pmi_ppc' => 'required|array',
            'attention_to_pmi_ppc.*' => 'string',

            // 'select_ud_control_number' => 'required',
            'revision' => 'nullable|string|max:255',
            'parts_product_name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1', // Numeric is safer for large quantities
            'po_number' => 'required|string|max:255',

            // Date Coverage: if it's "until PO ended", use 'string'.
            // If it's always a date, use 'date'.
            'date_coverage' => 'required|string|max:255',
            'ud_review_date' => 'required|string|max:255',
            'ud_review_result' => 'required|string|max:255',
            'first_discussion_date' => 'required|string|max:255',
            'assessment_ctrl_no' => 'required|string|max:255',

            'content_ud_special_instruction' => 'required|string',

            // Date from JS (en-GB format: DD/MM/YYYY)
            'date_posted_in_rapid' => 'nullable|date_format:d/m/Y',


        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 0, 'errors' => $validator->errors()], 422);
        }

        try {
            // --- STEP 1: SAVE TO PPC TABLE ---
            if (!empty($request->ud_ppc_input_id)) {
                $ppcInput = UdPpcInput::find($request->ud_ppc_input_id);
                if (!$ppcInput) return response()->json(['result' => 0, 'message' => 'Record not found'], 404);
            } else {
                $ppcInput = new UdPpcInput();
                $ppcInput->created_by = $_SESSION["rapidx_user_id"] ?? 0;
            }

            $ppcInput->date_from_yec            = $request->date_information_from_yec;
            $ppcInput->sent_by_from_yec         = $request->sent_by_from_yec ? implode(',', $request->sent_by_from_yec) : null;
            $ppcInput->attention_to_pmi_ppc     = $request->attention_to_pmi_ppc ? implode(',', $request->attention_to_pmi_ppc) : null;
            $ppcInput->ud_ctrlno                = $request->ud_control_number;
            $ppcInput->ud_ctrlno_id             = $request->selected_ud_control_number_id;
            $ppcInput->revision                 = $request->revision;
            $ppcInput->p_name                   = $request->parts_product_name;
            $ppcInput->qty                      = $request->qty;
            $ppcInput->po_num                   = $request->po_number;
            $ppcInput->date_coverage            = $request->date_coverage;
            $ppcInput->content_of_ud            = $request->content_ud_special_instruction;
            $ppcInput->date_posted_rapid        = $request->date_posted_in_rapid;
            $ppcInput->date_ud_review           = $request->ud_review_date;
            $ppcInput->result_ud_review         = $request->ud_review_result;
            $ppcInput->fd_ppc_date              = $request->first_discussion_date;
            $ppcInput->fd_ppc_risk_ctrl_no      = $request->assessment_ctrl_no;
            $ppcInput->ppc_remarks              = $request->ppc_remarks;
            $ppcInput->status                   = 0; // default status when saving/updating details (can be updated later based on discussions and updates)
            $ppcInput->save();

            $ppcInputId = $ppcInput->id; // Get the ID after saving (for both create and update)

            $status = $ppcInput->status; // keep current status

            // return $data;

            if ($request->filled('meeting_date')) {

                $secondDiscussionDetails = SecondDiscussionDetails::where('ppc_input_id', $ppcInput->id)->first();

                if (!$secondDiscussionDetails) {
                    $secondDiscussionDetails = new SecondDiscussionDetails();
                    $secondDiscussionDetails->ppc_input_id = $ppcInput->id;
                    $secondDiscussionDetails->date = $request->meeting_date;
                    $secondDiscussionDetails->attendees = $request->select_attendees ? implode(',', $request->select_attendees) : null;
                    $secondDiscussionDetails->attendees_role = $request->select_attendee_role ? implode(',', $request->select_attendee_role) : null;
                    $secondDiscussionDetails->created_by = $_SESSION["rapidx_user_id"] ?? 0;
                    if ($request->hasFile('orcto_attachment')) {
                        $file = $request->file('orcto_attachment');
                        $original = $file->getClientOriginalName();
                        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $original);

                        Storage::putFileAs('public/orcto_attachment', $file, $filename);

                        $secondDiscussionDetails->orcto_attachment = $original;
                        $secondDiscussionDetails->orcto_attachment_path = 'public/orcto_attachment/' . $filename;
                    }
                    $secondDiscussionDetails->save();

                    $status = 1;
                } else {

                    $secondDiscussionDetails->date = $request->meeting_date;
                    $secondDiscussionDetails->attendees = $request->select_attendees ? implode(',', $request->select_attendees) : null;

                    // ✅ Engineering (SEI)
                    if ($request->filled('sei')) {
                        $secondDiscussionDetails->cp_sei = $request->sei;

                        if ($request->hasFile('sei_attachment')) {
                            $file = $request->file('sei_attachment');
                            $original = $file->getClientOriginalName();
                            $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $original);

                            Storage::putFileAs('public/sei_attachments', $file, $filename);

                            $secondDiscussionDetails->cp_sei_attachment = $original;
                            $secondDiscussionDetails->cp_sei_attachment_path = 'public/sei_attachments/' . $filename;
                        }

                        $status = max($status, 2);
                    }

                    // ✅ Production (Special Runcard)
                    if ($request->filled('special_runcard')) {
                        $secondDiscussionDetails->cp_special_runcard = $request->special_runcard;
                        $status = max($status, 3);
                    }

                    // ✅ QC / Engineering (Inspection Data)
                    if ($request->filled('inspection_data_sheet')) { // FIXED
                        $secondDiscussionDetails->cp_inspection_data = $request->inspection_data_sheet;

                        if ($request->hasFile('inspection_data_sheet_attachment')) {
                            $file = $request->file('inspection_data_sheet_attachment');
                            $original = $file->getClientOriginalName();
                            $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $original);

                            Storage::putFileAs('public/ids_attachments', $file, $filename);

                            $secondDiscussionDetails->cp_inspection_data_attachment = $original;
                            $secondDiscussionDetails->cp_inspection_data_attachment_path = 'public/ids_attachments/' . $filename;
                        }

                        $status = max($status, 4);
                    }

                    // ✅ Production (Orientation)
                    if ($request->filled('orientation')) {
                        $secondDiscussionDetails->cp_orientation = $request->orientation;

                        if ($request->hasFile('orientation_attachment')) {
                            $file = $request->file('orientation_attachment');
                            $original = $file->getClientOriginalName();
                            $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $original);

                            Storage::putFileAs('public/orientation_attachments', $file, $filename);

                            $secondDiscussionDetails->cp_orientation_attachment = $original;
                            $secondDiscussionDetails->cp_orientation_attachment_path = 'public/orientation_attachments/' . $filename;
                        }

                        $status = max($status, 5);
                    }

                    $secondDiscussionDetails->save();
                }

                // ✅ Update ONCE
                // $ppcInput->update(['status' => $status]);
            }


            if($request->filled('c_production_date') && $request->filled('shipment_date') && $request->filled('c_qty') && $request->filled('c_ppc_incharge')){
                //incharge PPC Closing
                $closingDetails = ClosingDetails::where('ppc_input_id', $ppcInput->id)->first();
                if(!$closingDetails){
                    // Create new record
                    $closingDetails = new ClosingDetails();
                    $closingDetails->ppc_input_id = $ppcInput->id;
                    $closingDetails->production_date = $request->c_production_date;
                    $closingDetails->shipment_date = $request->shipment_date;
                    $closingDetails->qty = $request->c_qty;
                    $closingDetails->ppc_incharge = implode(',', $request->c_ppc_incharge);
                    $closingDetails->status = $request->status;
                    $closingDetails->created_by = $_SESSION["rapidx_user_id"] ?? 0;
                    $closingDetails->save();
                }
                else {
                    $closingDetails->status = $request->status; // Assuming 1 means Closed
                    $closingDetails->save();
                }
                // Update PPC Input status to Closed (or whatever status indicates it's closed)
                // $ppcInput->update(['status' => 6]); // Assuming 6 means Closed
                $status = max($status, 6);

            }

            $ppcInput->update(['status' => $status]);

            // ================= EMAIL SECTION =================

            // Refresh latest status
            $ppcInput->refresh();

            $status = $ppcInput->status;

            // Header + In-Charge
            $emailHeader = '';
            $inChargeList = [];

            // 🧠 STATUS-BASED EMAIL
            switch ($status) {

                case 0:
                    $emailHeader = 'For Production Update (2nd Discussion)';
                    $inChargeList[] = 'Production';
                    break;

                case 1:
                    $emailHeader = 'For Production Update (SEI)';
                    $inChargeList[] = 'Engineering';
                    break;

                case 2:
                    $emailHeader = 'For Production Update (Special Runcard)';
                    $inChargeList[] = 'Production';
                    break;

                case 3:
                    $emailHeader = 'For Production Update (Inspection Data Sheet)';
                    $inChargeList[] = 'QC / Engineering';
                    break;

                case 4:
                    $emailHeader = 'For Production Update (Orientation)';
                    $inChargeList[] = 'Production';
                    break;

                case 5:
                    $emailHeader = 'For PPC Update (Closing)';
                    $inChargeList[] = 'PPC';
                    break;
                case 6:
                    $emailHeader = 'UD Request Closed';
                    $inChargeList[] = 'N/A';
                    break;
            }

            $ppcEmailData = [
                'date_from_yec' => $ppcInput->date_from_yec,
                'sent_by_from_yec' => $ppcInput->sent_by_from_yec,
                'attention_to_pmi_ppc' => $ppcInput->attention_to_pmi_ppc,
                'ud_ctrlno' => $ppcInput->ud_ctrlno,
                'revision' => $ppcInput->revision,
                'p_name' => $ppcInput->p_name,
                'qty' => $ppcInput->qty,
                'po_num' => $ppcInput->po_num,
                'date_coverage' => $ppcInput->date_coverage,
                'content_of_ud' => $ppcInput->content_of_ud,
                'date_posted_rapid' => $ppcInput->date_posted_rapid,
                'date_ud_review' => $ppcInput->date_ud_review,
                'result_ud_review' => $ppcInput->result_ud_review,
                'fd_ppc_date' => $ppcInput->fd_ppc_date,
                'fd_ppc_risk_ctrl_no' => $ppcInput->fd_ppc_risk_ctrl_no,
                'ppc_remarks' => $ppcInput->ppc_remarks,
                'status' => $status
            ];

            $attentionToList = $ppcInput->attention_to_pmi_ppc
                ? explode(',', $ppcInput->attention_to_pmi_ppc)
                : [];

            $attentionMap = [
                1 => 'Ms. Jeng',
                2 => 'Ms. Jessa',
                3 => 'Mr. Oyama',
                4 => 'Mr. Tomura',
                5 => 'Ms. Shibuki',
                6 => 'Mr. Yanagawa',
                7 => 'Mr. Goto',
            ];

            $attentionNames = [];

            foreach ($attentionToList as $id) {
                if (isset($attentionMap[$id])) {
                    $attentionNames[] = $attentionMap[$id];
                }
            }

            $attentionNamesString = implode(', ', $attentionNames);

            // $recipientEmails = 'group-iss-software@pricon.ph';
            $recipientEmails = 'group-tsf3@pricon.ph';
            $bcc = ['mrronquez@pricon.ph', 'jgsulit@pricon.ph', 'cpagtalunan@pricon.ph'];
            $bcc = array_diff($bcc, [$recipientEmails]);

            Mail::to($recipientEmails)
                ->bcc($bcc)
                ->send(new UdUpdateNotification(
                    $ppcEmailData,
                    $attentionNamesString,
                    $emailHeader,
                    $inChargeList // ✅ NEW
                ));


            DB::commit(); // All good, save everything
            return response()->json(['result' => 1, 'status' => 'success', 'message' => 'All details saved successfully'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Something went wrong, undo everything
            return response()->json(['result' => 0, 'message' => 'Database Error: ' . $e->getMessage()], 500);
        }

    }

    public function getUdDetails(Request $request) {
        $ud_ppc_input = UdPpcInput::with(['second_discussion_details', 'closing_details'])
        ->find($request->ud_ppc_input_id);

        if (!$ud_ppc_input) {
            return response()->json([
                'result' => 0,
                'status' => 'error',
                'message' => 'UD PPC Input not found'
            ], 404);
        }

        return response()->json([
            'result' => 1,
            'status' => 'success',
            'data' => $ud_ppc_input
        ], 200);
    }

    public function getAttendeesByRapidX(Request $request) {
        $rapidXUsers = RapidXUser::where('user_stat', 1)->get();

        if (!$rapidXUsers) {
            return response()->json([
                'result' => 0,
                'status' => 'error',
                'message' => 'Users not found'
            ], 404);
        }

        return response()->json([
            'result' => 1,
            'status' => 'success',
            'data' => $rapidXUsers
        ], 200);
    }

    // public function export()
    // {
    //   $data = UdPpcInput::with(['second_discussion_details', 'closing_details'])
    //     ->where('logdel', 0)
    //     ->get();

    //     // return $data;

    //     return Excel::download(new UdMonitoringExport($data), 'UD_Monitoring.xlsx');
    // }

public function export()
{
    $data = UdPpcInput::with([
        'second_discussion_details',
        'closing_details'
    ])->get()->toArray();

    // return $data;

    return Excel::download(new UdMonitoringExport($data), 'UD_Monitoring.xlsx');
}

public function downloadOrctoAttachment($id)
{
    // return $id;
    $secondDiscussionDetails = SecondDiscussionDetails::where('orcto_attachment', $id)->first();

    if (!$secondDiscussionDetails || !$secondDiscussionDetails->orcto_attachment_path) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    $filePath = $secondDiscussionDetails->orcto_attachment_path;

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'File not found on server.'], 404);
    }

    return Storage::download($filePath, $secondDiscussionDetails->orcto_attachment);
}


public function downloadSeiAttachment($id)
{
    // return $id;
    $secondDiscussionDetails = SecondDiscussionDetails::where('cp_sei_attachment', $id)->first();

    if (!$secondDiscussionDetails || !$secondDiscussionDetails->cp_sei_attachment_path) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    $filePath = $secondDiscussionDetails->cp_sei_attachment_path;

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'File not found on server.'], 404);
    }

    return Storage::download($filePath, $secondDiscussionDetails->cp_sei_attachment);
}

public function downloadIdsAttachment($id)
{
    // return $id;
    $secondDiscussionDetails = SecondDiscussionDetails::where('cp_inspection_data_attachment', $id)->first();

    if (!$secondDiscussionDetails || !$secondDiscussionDetails->cp_inspection_data_attachment_path) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    $filePath = $secondDiscussionDetails->cp_inspection_data_attachment_path;

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'File not found on server.'], 404);
    }

    return Storage::download($filePath, $secondDiscussionDetails->cp_inspection_data_attachment);
}

public function downloadOrientationAttachment($id)
{
    // return $id;
    $secondDiscussionDetails = SecondDiscussionDetails::where('cp_orientation_attachment', $id)->first();

    if (!$secondDiscussionDetails || !$secondDiscussionDetails->cp_orientation_attachment_path) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    $filePath = $secondDiscussionDetails->cp_orientation_attachment_path;

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'File not found on server.'], 404);
    }

    return Storage::download($filePath, $secondDiscussionDetails->cp_orientation_attachment);
}

public function deleteUdPpcInput($id)
{
    $ppcInput = UdPpcInput::find($id);

    if (!$ppcInput) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $ppcInput->logdel = 1;
    $ppcInput->save();

    return response()->json([
        'success' => true,
        'message' => 'Record deleted successfully'
    ]);
}





}
