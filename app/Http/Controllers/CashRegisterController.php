<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MovementController;
use App\Models\TblMovementBox;
use App\Models\TblBillsMoney;

class CashRegisterController extends Controller
{
	private $billsCoins;
	private $movement;

	public function __construct()
	{
		$this->billsCoins = new TblBillsMoney();
	}

	public function loadBase(Request $request)
	{
		$noValidations = $this->preValidationLoadBase($request->all());

		if(count($noValidations) === 0) {

			$entryValues = $request->all();
			$movement = TblMovementBox::registerMovement('loadBase', $entryValues);

			foreach($entryValues as $money) {
				TblMovementBox::registerMovementDetail(
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

		$response = TblMovementBox::findWithDetail($movement->id);

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
		$change = TblMovementBox::makePayment(
					$request->input('biilsAndCoin'),
					$request->input('totalPay')
				  );

		return $this->response($change);
	}



}
