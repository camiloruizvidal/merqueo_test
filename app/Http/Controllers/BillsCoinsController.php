<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\moneyAndBillsRules;

class BillsCoinsController extends Controller
{
	private $validationFailed = null;

	public function getValidationFailed()
	{
		return $this->validationFailed;
	}

	public function validationTypes($moneyAndBills)
	{
		$validation = Validator::make(
			$moneyAndBills,
			[
				'tipo' => ['required', Rule::in(['billetes', 'monedas'])],
				'valor' => ['required', new moneyAndBillsRules($moneyAndBills)]
			],
			[
				'required' => 'El atributo :attribute es obligatorio.',
				'in'=>'El atributo ":attribute" = ":input" es invalido'
			]
		);


		$this->validationFailed = new \stdClass;
		$this->validationFailed->isValid = !$validation->fails();
		$this->validationFailed->errors = $validation->errors();

		if($validation->fails()) {
			throw new \Exception('The validation is failed');
		}

	}
}
