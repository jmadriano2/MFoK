<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsContainErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_contains_errors', function (Blueprint $table) {
            $table->bigInteger('log_id')->unsigned();
            $table->bigInteger('error_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('log_id')->references('id')->on('cob_logs');
            $table->foreign('error_id')->references('id')->on('errors');
            
            $table->primary(['log_id','error_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_contains_errors');
    }
}
