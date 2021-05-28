<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBillsMoney extends Migration
{

	public function up()
	{
		Schema::create('tbl_bills_money', function (Blueprint $table) {
			$table->id();
			$table->integer('value');
			$table->enum('type', ['billetes', 'monedas']);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('tbl_bills_money');
	}
}
