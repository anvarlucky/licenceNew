<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertices11Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertices', function (Blueprint $table) {
            $table->date('decision_start_date')->nullable();
            $table->date('decision_end_date')->nullable();
            $table->integer('decision_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expertices', function (Blueprint $table) {
            //
        });
    }
}
