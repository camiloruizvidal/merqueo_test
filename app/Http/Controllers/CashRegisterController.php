<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BillsCoinsController;

class CashRegisterController extends Controller
{
	private $billetes;

	public function __construct()
	{
		$this->billsCoins = new BillsCoinsController();
	}

	public function loadBase(Request $request)
	{
		$validation = false;
		$validation = $this->billsCoins->validateBillsCoin($request);
		return [$validation];
	}

	public function makePayment(Request $request)
	{
		$validation = false;
		$validation = $this->billetes->validateBillsCoin($request);
		return [$validation];
	}

}
