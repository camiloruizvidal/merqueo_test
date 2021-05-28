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
		try {

			foreach($request->all() as $moneyAndBill) {
				$this->billsCoins->validationTypes($moneyAndBill);
			}
			return $this->response('The validation is success');

		} catch (\Exception $th) {
			return $this->response($this->billsCoins->getValidationFailed(), 422);
		}
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
