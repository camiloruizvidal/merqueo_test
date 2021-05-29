<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMovementBox extends Migration
{
	public function up()
	{
		Schema::create('tbl_movement_box', function (Blueprint $table) {
			$table->id();
			$table->enum('type', ['payment', 'loadBase', 'emptyBox']);
			$table->integer('total')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('tbl_movement_box');
	}
}
