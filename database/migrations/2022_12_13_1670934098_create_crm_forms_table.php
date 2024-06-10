<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmFormsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_forms', function (Blueprint $table) {

		$table->increments('id');
		$table->string('crm_id',45)->nullable()->default('NULL');
		$table->string('form_type',200)->default('1');
		$table->string('cti_type',200)->nullable()->default('NULL');
		$table->string('cti_depend_form',200)->nullable()->default('NULL');
		$table->string('form_name',45)->nullable()->default('NULL');
		$table->string('is_depend',250)->nullable()->default('NULL');
		$table->string('save_path',300)->nullable()->default('NULL');
		$table->string('created_by',45)->nullable()->default('NULL');
		$table->string('updated_by',45)->nullable()->default('NULL');
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();


        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_forms');
    }
}
