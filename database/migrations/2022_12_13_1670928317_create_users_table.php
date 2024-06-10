<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

		$table->bigIncrements('id')->unsigned();
		$table->string('name',191);
		$table->string('email',191);
		$table->timestamp('email_verified_at')->useCurrent();
		$table->string('emp_id',45)->nullable()->default('NULL');
		$table->string('emp_type',45)->nullable()->default('NULL');
		$table->string('password',191);
		$table->string('process_name',60)->nullable()->default('NULL');
		$table->integer('user_access',)->default('0');
		$table->string('remember_token',100)->nullable()->default('NULL');
		$table->string('created_by',45)->nullable()->default('NULL');
		$table->string('updated_by',45)->nullable()->default('NULL');
        $table->timestamp('created_at')->useCurrent();
		$table->timestamp('updated_at')->useCurrent();

        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
