<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BillsCoinsController;

class CashRegisterController extends Controller
{
	private $billsCoins;

	public function __construct()
	{
		$this->billsCoins = new BillsCoinsController();
	}

	public function loadBase(Request $request)
	{
		$validations = $this->preValidationLoadBase($request->all());

		if(count($validations) === 0) {
			return $this->response('The validation is success');
		} else {
			return $this->response(['errors'=>$validations], 422);
		}


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
