<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BillsCoinsController;
use App\Http\Controllers\MovementController;
use App\Models\TblBillsMoney;

class CashRegisterController extends Controller
{
	private $billsCoins;

	public function __construct()
	{
		$this->billsCoins = new BillsCoinsController();
	}

	public function loadBase(Request $request)
	{
		$noValidations = $this->preValidationLoadBase($request->all());

		if(count($noValidations) === 0) {

			$entryValues = $request->all();
			$movement = MovementController::registerMovement('loadBase', $entryValues);

			foreach($entryValues as $money) {
				MovementController::registerMovementDetail(
					$movement->id,
					$money['type'],
					$money['value'],
					$money['count'],
					'input'
				);
			}

		} else {
			return $this->response(['errors'=>$noValidations], 422);
		}

		$response = MovementController::findWithDetail($movement->id);

		return $this->response($response);
	}

	/*
	TODO
	*/
	public function getStatusCash (Request $request)
	{

	}

	public function getMovements(Request $request)
	{
		$movements = MovementController::getMovements(
			$request->input('dateStart'),
			$request->input('dateFinish')
		);

		return $this->response($movements);
	}

	public function emptyCash()
	{
		$response = MovementController::emptyCash();
		return $this->response($response);
	}

	private function preValidationLoadBase($moneysAndBills)
	{
		$validations = [];
		foreach($moneysAndBills as $moneyAndBill) {

			$this->billsCoins->validationTypes($moneyAndBill);
			$validationsTemp = $this->billsCoins->getValidationFailed();

			if(!$validationsTemp->isValid) {
				$validations[] = $validationsTemp->errors;
			}

		}

		return $validations;
	}

	public function makePayment(Request $request)
	{
		$response = null;

		foreach($request->input('biilsAndCoin') as $billOrCoin) {
			$this->billsCoins->validationTypes($billOrCoin);
		}

		$dataValidation = $this->billsCoins->getValidationFailed();
		if($dataValidation->isValid) {

			$totalMoney = $this->sumMoney($request->input('biilsAndCoin'));
			$change = $totalMoney - $request->input('totalPay');

			$moneyChange = [];
			$moneyInBox = BillsCoinsController::getAllBillMoney();
			$changeReduce = $change;
			foreach($moneyInBox as $money) {
				if($changeReduce>=$money['value']) {


					$countNecesary = floor($changeReduce/$money['value']);
					if($countNecesary>$money['count']) {
						$countNecesary = $money['count'];
					}

					$moneyChange[] = [
						'money' => number_format($money['value']),
						'count' => $countNecesary,
					];

					$changeReduce = $changeReduce - $money['value'] * $countNecesary;
				}
			}

			$response = $this->response([
				'change'=>$change,
				'moneyChange'=>$moneyChange
			]);

		} else {

			$response = $this->response($this->billsCoins->getValidationFailed(), 422);
		}

		return $response;
	}

	private function sumMoney($moneys)
	{
		$totalSum = array_reduce($moneys, function($total, $money)
		{
			$total += $money['value'] * $money['count'];
			return $total;
		});
		return $totalSum;
	}

}
