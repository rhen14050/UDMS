<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RapidXUser;

class RapidXDepartment extends Model
{
    protected $table = 'departments';
    protected $connection = 'rapidx';

    // public function users(){
    //     return $this->belongsTo(RapidXUser::class);
    // }
}
