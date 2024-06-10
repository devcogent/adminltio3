<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCampaignsLogTable extends Migration
{
    public function up()
    {
        Schema::create('crm_campaigns_log', function (Blueprint $table) {

		$table->increments('id');
		$table->string('campaign_id',200);
		$table->string('crm_id',100)->nullable()->default('NULL');
        $table->text('camp_response');
		$table->text('dailer_url');
		$table->string('api_type',100)->nullable()->default('NULL');
		$table->string('created_by',200);
		$table->timestamp('create_date')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_campaigns_log');
    }
}
