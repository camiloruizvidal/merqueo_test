<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TblMovementBoxDetail;
use App\Models\TblBillsMoney;

class TblMovementBox extends Model
{
	protected $table = 'tbl_movement_box';

	protected $primaryKey = 'id';

	protected $hidden = ['updated_at'];

	protected $fillable = [
		'type',
		'total',
	];

	public function getDetail()
	{
		return $this->hasMany(TblMovementBoxDetail::class, 'movement_box_id');
	}

	public static function newMovement($typeMovement, $entryValues)
	{
		$typesMovements = [
			'payment' => 'input',
			'loadBase' => 'input',
			'emptyBox' => 'output',
			'changeMoney' => 'output',
		];

		$movement = self::registerMovement($typeMovement, $entryValues);

		foreach($entryValues as $billMoney) {

			self::registerMovementDetail(
				$movement->id,
				$billMoney['type'],
				$billMoney['value'],
				$billMoney['count'],
				$typesMovements[$typeMovement]
			);

		}
		return $movement;

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
		$money = TblBillsMoney::findBillsCoin($billOrCoin, $valueMoney);

		$movementDetail = TblMovementBoxDetail::create([
			'movement_box_id' => $movementBoxId,
			'bills_money_id' => $money->id,
			'amount' => $count,
			'type_movement' => $typeMovement,
		]);

		TblBillsMoney::updateMoney(
			$billOrCoin,
			$valueMoney,
			$count,
			$typeMovement
		);

		return $movementDetail;
	}

	public static function makePayment($biilsAndCoin, $totalPay)
	{
		$validations = new TblBillsMoney();

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
		$moneyInBox = TblBillsMoney::getAllBillMoney();
		$changeReduce = $change;

		foreach($moneyInBox as $money) {
			if($changeReduce >= $money['value']) {

				$countNecesary = floor($changeReduce/$money['value']);
				if($countNecesary > $money['count']) {
					$countNecesary = $money['count'];
				}

				$register = new \stdClass();
				$register->value = $money['value'];
				$register->type = $money['type'];
				$register->count = $countNecesary;

				$moneyChange[]= $register;
				$changeReduce = $changeReduce - $money['value'] * $countNecesary;
			}
		}

		self::newMovement('payment', $moneyChange);

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
				with(['getDetail' => function($query)
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
		$billsMoneys = TblBillsMoney::getAllBillMoney();
		$idMovement = self::registerMovement('emptyBox', $billsMoneys);

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
		with(['getDetail' => function($query)
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
