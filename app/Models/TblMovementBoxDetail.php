<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TblBillsMoney;

class TblMovementBoxDetail extends Model
{
	protected $table = 'tbl_movement_box_detail';

	protected $primaryKey = 'id';

	protected $hidden = ['created_at', 'updated_at'];

	protected $fillable = [
		'movement_box_id',
		'bills_money_id',
		'amount',
		'type_movement',
	];

	public function money()
	{
		return $this->belongsTo(TblBillsMoney::class, 'bills_money_id');
	}

}
