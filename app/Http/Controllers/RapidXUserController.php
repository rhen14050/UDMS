<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RapidXUser;
use App\RapidXDepartment;
use App\EmailRecipient;

class RapidXUserController extends Controller
{
    public function get_cbo_rapidx_users(Request $request){
        date_default_timezone_set('Asia/Manila');

        $search = $request->search;

        if($search == ''){
            $datas = [];
        }
        else{
            $datas = EmailRecipient::orderby('name','asc')->select('id','name')
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->where('email_recipient_status', 1)
                        ->get();
        }

        $response = array();
        $response[] = array(
            "id" => '',
            "text" => '',
        );

        foreach($datas as $data){
            $response[] = array(
                "id" => $data->id,
                "text" => $data->name,
            );
        }

        echo json_encode($response);
        exit;
    }


    public function get_rapidx_users(Request $request){
        $users = RapidXUser::with('department')->get();
        // return $users;
        return response()->json(['users' => $users]);
    }


    public function get_section(Request $request){
        $sections = RapidXDepartment::all();
        // return $users;
        return response()->json(['sections' => $sections]);
    }
}
