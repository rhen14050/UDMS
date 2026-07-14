<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_number')->default(1);
            $table->string('quarter');
            $table->string('validity');
            $table->date('date_received')->nullable();
            $table->date('actual_date_received_claim')->nullable();
            $table->date('date_return_of_claim')->nullable();
            $table->date('required_reply')->nullable();
            $table->string('original_filename')->nullable()->comment = 'Issued Report for Operations';
            $table->string('section')->comment = 'CN/TS/YF/PPS';
            $table->string('pmi_control_number')->nullable();
            $table->string('reference_number')->nullable()->comment = 'From Customer';
            $table->string('product_classification');
            $table->string('customer');
            $table->string('model_name');
            $table->string('mode_of_defect')->nullable();
            $table->string('po_number')->nullable()->comment = 'Lot/PO/Trace Code/Serial';
            $table->string('automotive');
            $table->integer('quantity')->nullable();
            $table->integer('number_of_ng')->nullable();
            $table->string('return_to_vendor')->nullable();
            $table->string('sender_name')->nullable();
            $table->date('send_date')->nullable();
            $table->string('contributor');
            $table->string('defect_category_class')->comment = 'Class A, Class B, Class C';
            $table->string('yec_yed_report_name')->nullable();
            $table->date('yec_yed_report_date')->nullable();
            $table->string('yec_yed_report_file')->nullable()->comment = 'From YEC Report, Ref. Only';
            $table->date('initial_response')->nullable();
            $table->date('actual_response')->nullable();
            $table->date('turn_around_time')->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comment = '0-Open, 1-Closed';
            $table->string('initial_report')->nullable()->comment = 'N/A or Released';
            $table->tinyInteger('final_report')->nullable()->comment = '1-On time, 2-Late Submission';
            $table->string('remarks')->nullable();

            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_updated_by')->unsigned();
            $table->bigInteger('logdel')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();

            // Foreign Key
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('last_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_claims');
    }
}
