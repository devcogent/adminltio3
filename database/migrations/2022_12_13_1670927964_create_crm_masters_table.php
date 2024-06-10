<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmMastersTable extends Migration
{

        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_masters', function (Blueprint $table) {

		$table->increments('id');
		$table->string('crm_name',45)->nullable()->default('NULL');
		$table->string('crm_type',200)->nullable()->default('NULL');
		$table->string('created_by',45)->nullable()->default('NULL');
		$table->string('updated_by',45)->nullable()->default('NULL');
		$table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_masters');
    }
}
