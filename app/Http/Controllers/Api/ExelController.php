<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exels;
use App\Trading;

/**
* Получить данные файла эксель, получить данные trading (п.4)
*
*
* @author 'Fair Value'
*/

class ExelController extends Controller
{
    /**
	* ПОЛУЧИТЬ ДАННЫЕ ФАЙЛА EXEL
	* 
	* GET запрос на этот адрес<br>
	*  baseURL/api/getexel<br>
	* @return array
	*/	
	public function index()
    {	
		$exels = Exels::all();
		return response()->json($exels, 200);
    }
	
	/**
	* ПОЛУЧИТЬ ДАННЫЕ TRADING (ПУНКТ.4)
	* 
	* GET запрос на этот адрес<br>
	*  baseURL/api/gettradings/{status}<br>
	* где {status}  это 0 (открытые) или 1 (закрытые) сделки
	* @return array
	*/	
	public function gettradings($status)
    {	
		$tradings = Trading::where('closed', '=', $status)->get();
		return response()->json($tradings, 200);
    }
}
