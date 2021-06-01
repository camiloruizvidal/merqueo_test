<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblMovementBox;
use App\Http\Controllers\BillsCoinsController;
use App\Models\TblMovementBoxDetail;


class MovementController extends Controller
{
	public static function newMovement($typeMovement, $entryValues, $rowsMovement)
	{
		$movement = self::registerMovement($typeMovement, $entryValues);

		foreach($rowsMovement as $billMoney) {

			self::registerMovementDetail(
				$movement->id,
				$billMoney->type,
				$billMoney->value,
				$billMoney->count,
				$typeMovement
			);

		}

	}

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

	public static function makePayment($biilsAndCoin, $totalPay)
	{
		$validations = new BillsCoinsController();

		foreach($biilsAndCoin as $billOrCoin) {
			$validations->validationTypes($billOrCoin);
		}

		$dataValidation = $validations->getValidationFailed();
		if(!$dataValidation->isValid) {

			return [
				'validate' =>false,
				'message' => $validations->getValidationFailed(),
			];

		}

		$totalMoney = array_reduce($biilsAndCoin, function($total, $money) {
			$total += $money['value'] * $money['count'];
			return $total;
		});

		$change = $totalMoney - $totalPay;

		$moneyChange = [];
		$moneyInBox = BillsCoinsController::getAllBillMoney();
		$changeReduce = $change;

		foreach($moneyInBox as $money) {
			if($changeReduce >= $money['value']) {

				$countNecesary = floor($changeReduce/$money['value']);
				if($countNecesary > $money['count']) {
					$countNecesary = $money['count'];
				}

				$resultChange = new stdClass();
				$resultChange->value = $money['value'];
				$resultChange->type = $money['type'];
				$resultChange->count = $countNecesary;

				$moneyChange[] = $resultChange;
				$changeReduce = $changeReduce - $money['value'] * $countNecesary;
			}
		}

		self::newMovement('payment', $entryValues, $moneyChange);

		return [
			'validate' => true,
			'change' => $change,
			'moneyChange' => $moneyChange,
		];

		return $response;
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

	public static function emptyCash()
	{
		$billsMoneys = BillsCoinsController::getAllBillMoney();
		$idMovement = self::registerMovement('emptyBox', $billsMoneys->toArray());

		foreach($billsMoneys as $billMoney) {

			self::registerMovementDetail(
				$idMovement->id,
				$billMoney->type,
				$billMoney->value,
				$billMoney->count,
				'output'
			);

		}

		$movementEmpty = self::findWithDetail($idMovement->id);
		return $movementEmpty;
	}

	/*
		$dateTimeStart and $dateTimeFinish type date
		format YYYY-mm-dd
	*/
	public static function getMovements($dateStart, $dateFinish = NULL)
	{
		$movement = TblMovementBox::
		with(['detail' => function($query)
		{
			$query->
			join(
				'tbl_bills_money',
				'tbl_movement_box_detail.bills_money_id',
				'=',
				'tbl_bills_money.id'
			);
		}])->
		whereDate('created_at', '>=', $dateStart)->
		orderBy('type')->orderBy('created_at');

		if(!is_null($dateFinish)) {
			$movement = $movement->whereDate('created_at', '<=', $dateFinish);
		}

		return $movement->get();
	}

}
