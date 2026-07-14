<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerClaimEmailRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_claim_email_recipients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('email_recipient_id')->unsigned();
            $table->tinyInteger('type')->comment = '1-Attention, 2-CC';
                        
            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_updated_by')->unsigned();
            $table->bigInteger('logdel')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();

            // Foreign key
            $table->foreign('email_recipient_id')->references('id')->on('email_recipients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_claim_email_recipients');
    }
}
