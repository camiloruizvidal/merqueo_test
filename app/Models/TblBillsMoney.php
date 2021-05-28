<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblBillsMoney extends Model
{
	protected $table = 'tbl_bills_money';

	protected $primaryKey = 'id';

	protected $fillable = [
		'type',
		'value',
		'status',
		'amount',
		'total',
	];

}
