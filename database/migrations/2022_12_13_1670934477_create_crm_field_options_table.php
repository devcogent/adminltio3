<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmFieldOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_field_options', function (Blueprint $table) {

		$table->increments('id');
		$table->string('crm_filed_id',200)->nullable()->default('NULL');
		$table->string('options',200)->nullable()->default('NULL');
		$table->string('parent_name',100)->nullable()->default('NULL');
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();
		$table->string('created_by',45)->nullable()->default('NULL');
		$table->string('updated_by',45)->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_field_options');
    }
}
