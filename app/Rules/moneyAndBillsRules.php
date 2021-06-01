<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class moneyAndBillsRules implements Rule
{
	private $type;

	public function __construct($moneyAndBills)
	{
		$this->type = isset($moneyAndBills['type'])
					  ? $moneyAndBills['type']
					  : null;
	}

	public function passes($attribute, $value)
	{
		$key = false;
		$rules = [
			'billetes'=> [ 100000, 50000, 20000, 10000, 5000, 2000, 1000 ],
			'monedas' => [ 1000, 500, 200, 100, 50 ]
		];

		if(isset($rules[$this->type])) {
			$key = array_search($value, $rules[$this->type]);
		}

		return is_numeric($key);
	}

	public function message()
	{
		return $this->type . ' :input not found';
	}
}
