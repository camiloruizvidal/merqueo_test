<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\moneyAndBillsRules;
use App\Models\TblBillsMoney;

class BillsCoinsController extends Controller
{
	private $validationFailed = null;

	public function getValidationFailed()
	{
		return $this->validationFailed;
	}

	public function store($request)
	{
		$saveValue = new TblBillsMoney();
		if($this->validationTypes($request)) {
			$saveValue->type = $request['type'];
			$saveValue->value = $request['value'];
			$saveValue->amount = $request['amount'];
			$saveValue->total = $request['value'] * $request['amount'];
			$saveValue->status = 'in';
			$saveValue->save();
		} else {
			dd($this->getValidationFailed());
		}
		dd($saveValue);
		return $saveValue;
	}

	public function validationTypes($moneyAndBills)
	{
		$validation = Validator::make(
			$moneyAndBills,
			[
				'type' => ['required', Rule::in(['billetes', 'monedas'])],
				'value' => ['required', new moneyAndBillsRules($moneyAndBills)]
			],
			[
				'required' => 'El atributo :attribute es obligatorio.',
				'in'=>'El atributo ":attribute" = ":input" es invalido'
			]
		);


		$this->validationFailed = new \stdClass;
		$this->validationFailed->isValid = !$validation->fails();
		$this->validationFailed->errors = $validation->errors();

		return !$validation->fails();

	}
}
