<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_fields', function (Blueprint $table) {

		$table->increments('id');
		$table->integer('crm_form_id',)->nullable();
		$table->string('field_type',100)->nullable()->default('NULL');
		$table->string('field_name',100)->nullable()->default('NULL');
		$table->integer('sortBy',)->nullable();
		$table->string('minlength',45)->nullable()->default('NULL');
		$table->string('length',45)->nullable()->default('NULL');
		$table->string('label_name',100)->nullable()->default('NULL');
		$table->string('is_numaric',100)->nullable()->default('NULL');
		$table->string('is_required',100)->nullable()->default('NULL');
		$table->string('field_depend',200)->nullable()->default('NULL');
		$table->string('is_unique',200)->nullable()->default('NULL');
		$table->string('is_audit',100)->default('no');
		$table->integer('created_by',)->nullable();
		$table->integer('updated_by',)->nullable();
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_fields');
    }
}
