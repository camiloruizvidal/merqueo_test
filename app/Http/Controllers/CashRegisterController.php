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
					$money['amount'],
					'input'
				);
			}

		} else {
			return $this->response(['errors'=>$validations], 422);
		}

		$response = MovementController::findWithDetail($movement->id);

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
		try {
			$validation = $this->billsCoins->validationTypes($request->all());

			return $this->response($validation);
		} catch (\Exception $th) {

			return $this->response($this->billsCoins->getValidationFailed(), 422);
		}
	}

}
