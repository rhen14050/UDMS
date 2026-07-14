<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_classifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name');
            $table->string('product_details')->nullable();
            $table->string('product_classification_status')->nullable();

            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('product_classifications');
    }
}
