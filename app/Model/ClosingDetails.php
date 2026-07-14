<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ClosingDetails extends Model
{
    //
    protected $table = 'closing_details';
    protected $connection = 'mysql';

    protected $fillable = [
        'ppc_input_id',    // <--- Add this line here
        'production_date',
        'shipment_date',
        'qty',
        'ppc_incharge',
        'status',
        'created_by',
        'created_at',
        'updated_at',
            // Add any other fields from Process 2 here
    ];
}
