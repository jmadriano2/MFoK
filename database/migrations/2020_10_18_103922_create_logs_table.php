<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cob_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('system_id')->unsigned();
            $table->string('runday', 8);//YYYYMMDD
            $table->string('next_working_day', 8);//YYYYMMDD
            $table->timestamp('start', 0)->nullable();
            $table->timestamp('end', 0)->nullable();
            $table->string('status', 10);
            $table->integer('runtime');
            $table->string('conclusion', 10)->nullable();
            $table->string('creator', 20);
            $table->timestamps();

            $table->foreign('system_id')->references('id')->on('systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cob_logs');
    }
}
