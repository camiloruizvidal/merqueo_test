<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BillsCoinsController;
use App\Models\TblBillsMoney;

class CashRegisterController extends Controller
{
	private $billsCoins;

	public function __construct()
	{
		$this->billsCoins = new BillsCoinsController();
	}

	public function totalDay($date = '')
	{
		if($date == '') {
			$date = date('Y-m-d');
		}

		$totalDay = $this->totalIn($date) - $this->totalOut($date);
		dd($totalDay);
	}

	public function totalIn($date)
	{
		$total = TblBillsMoney::
					whereDate('created_at', $date)->
					where('status', '=', 'in')->
					sum('total');
		return $total;
	}

	public function totalOut($date)
	{
		$total = TblBillsMoney::
					whereDate('created_at', $date)->
					where('status', '=', 'out')->
					sum('total');
		return $total;

	}

	public function loadBase(Request $request)
	{
		$this->totalDay();
		$noValidations = $this->preValidationLoadBase($request->all());

		if(count($noValidations) === 0) {
			foreach($request->all() as $values) {
				$this->billsCoins->store($values);
			}
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
