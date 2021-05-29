<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TblMovementBoxDetail;

class TblMovementBox extends Model
{
	protected $table = 'tbl_movement_box';

	protected $primaryKey = 'id';

	protected $fillable = [
		'type',
		'total',
	];

	public function detail()
	{
		return $this->hasMany(TblMovementBoxDetail::class, 'movement_box_id');
	}

}
