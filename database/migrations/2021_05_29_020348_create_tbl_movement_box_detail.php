<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMovementBoxDetail extends Migration
{

	public function up()
	{
		Schema::create('tbl_movement_box_detail', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('movement_box_id');
			$table->unsignedBigInteger('bills_money_id');
			$table->integer('amount');
			$table->enum('type_movement', ['input', 'output']);
			$table->timestamps();

			$table->foreign('movement_box_id')
					->references('id')
					->on('tbl_movement_box');

			$table->foreign('bills_money_id')
					->references('id')
					->on('tbl_bills_money');
		});
	}

	public function down()
	{
		Schema::dropIfExists('tbl_movement_box_detail');
	}
}
