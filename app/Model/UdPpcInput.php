<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\SecondDiscussionDetails;
use App\Model\ClosingDetails;

class UdPpcInput extends Model
{
    //
    protected $table = 'ppc_input';
    protected $connection = 'mysql';

    public function second_discussion_details(){
        return $this->hasOne(SecondDiscussionDetails::class, 'ppc_input_id', 'id');
    }

    public function closing_details(){
        return $this->hasOne(ClosingDetails::class, 'ppc_input_id', 'id');
    }


    protected $fillable = [
        'date_from_yec',
        'sent_by_from_yec',
        'attention_to_pmi_ppc',
        'ud_ctrlno',
        'revision',
        'p_name',
        'qty',
        'po_num',
        'date_coverage',
        'content_of_ud',
        'date_posted_rapid',
        'date_ud_review',
        'result_ud_review',
        'fd_ppc_date',
        'fd_ppc_risk_ctrl_no',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'logdel'

    ];

}
