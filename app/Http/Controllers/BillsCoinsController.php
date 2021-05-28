<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BillsCoinsController extends Controller
{
	private $validationFailed = null;

	public function getValidationFailed()
	{
		return $this->validationFailed;
	}

	public function validationTypes(Request $request)
	{
		$validation = Validator::make(
			$request->all(),
			[
				'tipo' => ['required', Rule::in(['billetes', 'monedas'])],
				'valor' =>
				[
					'required',
					Rule::in([
						100000,
						50000,
						20000,
						10000,
						5000,
						1000,
						500,
						200,
						100,
						50
					]),
				],
			],
			[
				'required' => 'El atributo ":attribute" es obligatorio.',
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
