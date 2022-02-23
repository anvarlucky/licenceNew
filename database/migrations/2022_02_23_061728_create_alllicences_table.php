<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllLicencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alllicences', function (Blueprint $table) {
            $table->id();
            $table->string('licence_number');
            $table->string('licence_number_new')->nullable();
            $table->date('licence_given_date');
            $table->date('end_date')->nullable();
            $table->string('organization_inn');
            $table->string('organization_name');
            $table->string('organization_phone')->nullable();
            $table->string('organization_email')->nullable();
            $table->string('difficulty_category')->nullable();
            $table->text('license_direction')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_licences');
    }
}
