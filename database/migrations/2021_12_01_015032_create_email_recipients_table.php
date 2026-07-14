<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment = 'RapidX ID on users table';
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('section')->nullable();
            $table->tinyInteger('email_recipient_status')->nullable();

            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_updated_by')->unsigned();
            $table->bigInteger('logdel')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_recipients');
    }
}
