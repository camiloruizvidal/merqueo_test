<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class moneyAndBillsRules implements Rule
{
	private $_moneyAndBills;

	public function __construct($moneyAndBills)
	{
		$this->_moneyAndBills = $moneyAndBills;
	}

	public function passes($attribute, $value)
	{
		$valor = $value;
		$tipo = $this->_moneyAndBills['tipo'];
		$rules = [
			'billetes'=> [ 100000, 50000, 20000, 10000, 5000, 1000 ],
			'monedas' => [ 1000, 500, 200, 100, 50 ]
		];

		$key = false;
		if(isset($rules[$tipo])) {
			$key = array_search($valor, $rules[$tipo]);
		}

		return is_numeric($key);
	}

	public function message()
	{
		return $this->_moneyAndBills['tipo'] . ' :input not found';
	}
}
