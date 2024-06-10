<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmFieldDependenciesTable extends Migration
{
    public function up()
    {
        Schema::create('crm_field_dependencies', function (Blueprint $table) {

		$table->increments('id');
		$table->string('crm_id',100);
		$table->string('dropdown_id_from',100);
		$table->string('dropdown_id',100);
		$table->string('option_id',100);
		$table->string('childs_id')->default('NULL');
		$table->string('created_by',100);
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_field_dependencies');
    }
}
