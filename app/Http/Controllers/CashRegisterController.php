<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MovementController;
use App\Models\TblMovementBox;
use App\Models\TblBillsMoney;

class CashRegisterController extends Controller
{
	public function loadBase(Request $request)
	{
		$noValidations = $this->preValidationLoadBase($request->all());

		if($noValidations) {
			$entryValues = $request->all();
			$movement = TblMovementBox::newMovement('loadBase', $entryValues);
		} else {
			return $this->responseError(['errors'=>$noValidations]);
		}

		$response = TblMovementBox::findWithDetail($movement->id);

		return $this->response($response);
	}

	public function getStatusCash (Request $request)
	{
		$money = TblBillsMoney::getAllBillMoney();
		return $this->response($money);
	}

	public function getMovements(Request $request)
	{
		$movements = TblMovementBox::getMovements(
			$request->input('dateStart'),
			$request->input('dateFinish')
		);

		return $this->response($movements);
	}

	public function emptyCash()
	{
		$response = TblMovementBox::emptyCash();
		return $this->response($response);
	}

	private function preValidationLoadBase($moneysAndBills)
	{
		$billsCoins = new TblBillsMoney();
		$validations = [];
		foreach($moneysAndBills as $moneyAndBill) {
			$billsCoins->validationTypes($moneyAndBill);
		}

		return $billsCoins->getValidationFailed();
	}

	public function makePayment(Request $request)
	{
		$change = TblMovementBox::makePayment(
					$request->input('biilsAndCoin'),
					$request->input('totalPay')
				  );
		$validate = $change['validate'];
		if($validate) {
			return $this->response($change);
		} else {
			return $this->responseError($change);
		}
	}



}
