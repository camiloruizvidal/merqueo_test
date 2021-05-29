<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblMovementBox;
use App\Models\TblMovementBoxDetail;


class MovementController extends Controller
{
	public static function registerMovement($typeMovement, $entryValues)
	{
		$valuesTotal = array_map(function($entryValu) {
			return $entryValu['value'] * $entryValu['count'];
		}, $entryValues);
		$total = array_sum($valuesTotal);

		$movement = TblMovementBox::create([
			'total' => $total,
			'type' => $typeMovement,
		]);

		return $movement;
	}

	public static function registerMovementDetail(
		$movementBoxId,
		$billOrCoin,
		$valueMoney,
		$count,
		$typeMovement
	)
	{
		$money = BillsCoinsController::findBillsCoin($billOrCoin, $valueMoney);

		$movementDetail = TblMovementBoxDetail::create([
			'movement_box_id' => $movementBoxId,
			'bills_money_id' => $money->id,
			'amount' => $count,
			'type_movement' => $typeMovement,
		]);

		BillsCoinsController::updateMoney(
			$billOrCoin,
			$valueMoney,
			$count,
			$typeMovement
		);

		return $movementDetail;
	}

	public static function findWithDetail($movementBoxId)
	{
		return TblMovementBox::
				with(['detail' => function($query)
				{
					$query
					->join(
						'tbl_bills_money',
						'tbl_movement_box_detail.bills_money_id',
						'=',
						'tbl_bills_money.id'
					);
				}])->
				find($movementBoxId);
	}
}
