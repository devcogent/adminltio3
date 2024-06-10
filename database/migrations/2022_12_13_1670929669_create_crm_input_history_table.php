<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmInputHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('crm_input_history', function (Blueprint $table) {

		$table->increments('id');
		$table->integer('form_id',);
		$table->string('form_name',100);
		$table->integer('field_id',);
		$table->text('data');
		$table->integer('created_by',);
		$table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_input_history');
    }
}
