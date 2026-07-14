<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rapid extends Model
{
    //
    protected $table = 'tbl_active_docs';
    protected $connection = 'mysql_rapid';
}
