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
			return $entryValu['value'] * $entryValu['amount'];
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
		$amount,
		$typeMovement
	)
	{
		$money = BillsCoinsController::findBillsCoin($billOrCoin, $valueMoney);

		$movementDetail = TblMovementBoxDetail::create([
			'movement_box_id' => $movementBoxId,
			'bills_money_id' => $money->id,
			'amount' => $amount,
			'type_movement' => $typeMovement,
		]);

		BillsCoinsController::updateMoney(
			$billOrCoin,
			$valueMoney,
			$amount,
			$typeMovement
		);

		return $movementDetail;
	}

	public static function findWithDetail($movementBoxId)
	{
		return TblMovementBox::
					with('detail.money')->
					find($movementBoxId);
	}
}
