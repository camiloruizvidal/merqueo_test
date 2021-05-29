<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblBillsMoneyEntry extends Model
{
	protected $table = 'tbl_bills_money_entry';

	protected $primaryKey = 'id';

	protected $hidden = ['created_at', 'updated_at'];
}
