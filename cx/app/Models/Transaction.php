<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'tranzakcio';
	protected $primaryKey = 'Tranzakcio_ID';

	protected $fillable = [
		'Ugyfel_ID',
		'UgyfelDolgozo_ID',
		'NettoOsszeg',
		'BruttoOsszeg',
		'Deviza_ID',
		'Tipus',
		'Adat',
		'ResponseCode',
		'TransactionID',
		'Event',
		'Merchant',
	];

	public function currency()
	{
		return $this->belongsTo(Currency::class, 'Deviza_ID');
	}
}
