<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_campaigns', function (Blueprint $table) {

		$table->increments('id');
		$table->string('camp_name',200);
		$table->text('token_name');
		$table->string('skill_name',200);
		$table->string('date_format',200);
		$table->string('list_name',200);
		$table->string('api_url',200);
		$table->string('crm_id',200);
		$table->string('depend_status',200);
		$table->string('dropdown_id',200)->nullable()->default('NULL');
		$table->string('option_id',200)->nullable()->default('NULL');
		$table->string('created_by',200);
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();
		$table->tinyInteger('encrypted',)->default('0');

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_campaigns');
    }
}
