<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;
use App\Http\Controllers\ExelController;

use Illuminate\Http\Request;
use App\Exels;
use App\Trading;
use App\Divisiontradings;

class CustomController extends Controller
{
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}