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
            $table->string('runday', 6);
            $table->string('next_working_day', 6);
            $table->timestamp('start', 0)->nullable();
            $table->timestamp('end', 0)->nullable();
            $table->string('status', 1);
            $table->integer('runtime');
            $table->string('conclusion', 1);
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
