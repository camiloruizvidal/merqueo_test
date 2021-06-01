<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Rules\moneyAndBillsRules;
use Illuminate\Validation\Rule;
use App\Models\TblBillsMoney;

class TblBillsMoney extends Model
{
	protected $table = 'tbl_bills_money';

	protected $primaryKey = 'id';

	protected $hidden = ['created_at', 'updated_at'];

	private $validationFailed = null;

	protected $fillable = [
		'type',
		'value',
		'count',
	];

	public function getValidationFailed()
	{
		return $this->validationFailed;
	}

	public static function findBillsCoin($type, $value)
	{
		return TblBillsMoney::firstOrCreate([
			'type' => $type,
			'value' => $value,
		]);
	}

	public static function updateMoney($type, $value, $count, $entry)
	{
		$searchMoney = self::findBillsCoin($type, $value);
		$updatedCount = $entry == 'input'
				  ? $searchMoney->count + $count
				  : $searchMoney->count - $count;

		$money = TblBillsMoney::find($searchMoney->id);
		$money->type = $type;
		$money->value = $value;
		$money->count = $updatedCount;
		$money->save();

		return $money;
	}

	public static function getAllBillMoney()
	{
		return TblBillsMoney::where('count', '>', 0)->orderBy('value','DESC')->get();
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
