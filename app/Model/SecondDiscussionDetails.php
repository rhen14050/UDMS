<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class SecondDiscussionDetails extends Model
{
    //
    protected $table = 'second_discussion_details';
    protected $connection = 'mysql';

    protected $fillable = [
        'ppc_input_id',    // <--- Add this line here
        'date',
        'attendees',
        'cp_sei',
        'cp_special_runcard',
        'cp_inspection_data',
        'cp_orientation',
        'created_by',
        'created_at',
        'updated_at',
        // Add any other fields from Process 2 here
    ];
}
