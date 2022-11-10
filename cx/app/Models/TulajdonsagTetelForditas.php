<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class TulajdonsagTetelForditas extends Model
{
	use HasCompositePrimaryKey;

	protected $table = 'tulajdonsag_tetel_forditas';
	protected $primaryKey = [
		'Tulajdonsag_ID',
		'TulajdonsagTetel_ID',
		'Nyelv_ID',
	];
}
