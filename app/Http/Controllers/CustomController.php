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
	
     public function Index(){
		if ( $xlsx = ExelController::parse('exel/info.xlsx') ) {	

			$xlsx =$xlsx->rows();
			
			array_shift($xlsx);

			Exels::truncate();
	
			$exel_base = [];
			
			$tickers = [];
			
			foreach ($xlsx as $result) {
				
				$tickers[] = $result[0];
				
				$tickers_fair_value[$result[0]] = $result[1];				
			}
			
			$tickers_str = implode(',', $tickers);
									
			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => "https://seeking-alpha.p.rapidapi.com/market/get-realtime-prices?symbols=$tickers_str",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => [
					"x-rapidapi-host: seeking-alpha.p.rapidapi.com",
					"x-rapidapi-key: 792795ec29msh7b131e29f852470p1b8535jsnaa3118cedf90"
				],
			]);
  
			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
								
				$res= json_decode($response, true);
		  
				foreach ($res['data'] as $result) {

					$safety_margin = ceil((($tickers_fair_value[$result['attributes']['identifier']] - $result['attributes']['last'])/$tickers_fair_value[$result['attributes']['identifier']]) * 100);

					$exel_base = [
						'ticker' =>$result['attributes']['identifier'],
						'fair_value' => $tickers_fair_value[$result['attributes']['identifier']],
						'market_price' =>round($result['attributes']['last'], 2),
						'name' =>$result['attributes']['name'],
						'safety_margin' =>$safety_margin
					];
					
					$ex = Exels::create($exel_base);
				}
			}
			
			$color = [
				'first' => '',
				'second' => '',
				'three' => 'green',
			];

			$exels = Exels::all();	
			
			return view('exel.index', ['exels' => $exels, 'color' => $color]);
		} else {
			echo ExelController::parseError();
		}	
    }
	 
	public function Getfileshow(){
		
		$tickers = [];
		$exels = Exels::all();	
		foreach ($exels as $result) {
			$tickers[] = $result->ticker;
		}
		
		$tickers_str = implode(',', $tickers);
		
		// [identifier] => TSLA
		// [name] => Tesla Inc
		// [last] => 810.15
		// [change] => 5.33
		// [percentChange] => 0.662
		// [previousClose] => 804.82
		// [open] => 812.34
		// [high] => 829.88
		// [low] => 801.725
		// [volume] => 17862989
		// [dateTime] => 2021-02-11 15:07:52
		// [quoteInfo] => IEX real time price
		// [close] => 804.82
		// [changeFromPreviousClose] => 
		// [percentChangeFromPreviousClose] => 
		// [low52Week] => 72.24
		// [high52Week] => 883.09
		// [extendedHoursPrice] => 
		// [extendedHoursChange] => 
		// [extendedHoursPercentChange] => 
		// [extendedHoursDateTime] => 
		// [extendedHoursType] => 
		// [sourceAPI] => IEX Stream
		
		$color = [
			'first' => 'green',
			'second' => '',
			'three' => '',
		];
		
		$exels = Exels::all();	
		return view('exel.index', ['exels' => $exels, 'color' => $color]);
    }
	
	public function Getfile(Request $request){
			
			if($request->isMethod('post')){

				if($request->hasFile('image')) {
					$file = $request->file('image');
					$file->move(public_path() . '/exel','info.xlsx');
				}
			 }
			 
		$color = [
			'first' => '',
			'second' => 'green',
			'three' => '',
		];	 
			 
		$exels = Exels::all();
		return view('exel.index', ['exels' => $exels,'color' => $color]);
    }
	
	
	
	public function Trading(Request $request){
			
		if($request->isMethod('post')){
			Trading::create($request->all());
			
			$ticker = $request->ticker;
					 
			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => "https://seeking-alpha.p.rapidapi.com/market/get-realtime-prices?symbols=$ticker",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => [
					"x-rapidapi-host: seeking-alpha.p.rapidapi.com",
					"x-rapidapi-key: 792795ec29msh7b131e29f852470p1b8535jsnaa3118cedf90"
				],
			]);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
										
				$res= json_decode($response, true);
		  
				foreach ($res['data'] as $result) {
					Trading::where('ticker', $ticker)->update(['market_price'=>$result['attributes']['last']]);	
				}
			}
		
			return redirect()->back();
		}
						
		$closed = false;
		
		if ($request->close == 'close') {
			$closed = true;
			$trading = Trading::where('closed', '=', 1)->get();
		} else {
			$trading = Trading::where('closed', '=', 0)->get();
		}
				
		$divisions = [];
		$divisions_ = [];
		$divisiontradings = Divisiontradings::all();
		foreach ( $divisiontradings as $result) {
			$divisions[$result->parent_trading_id][] = $result->children_trading_id;
			$divisions_[$result->children_trading_id][] = $result->parent_trading_id;
		}	
							
		return view('exel.trading', ['trading' => $trading, 'closed' => $closed, 'divisions' => $divisions, 'divisions_' => $divisions_]);
    }
	
	public function tradingupdate(Request $request){
			
		$trading = Trading::find($request->id);	
		$success = false;

		if($request->isMethod('post')){
			
			$close_price = $request->close_price;
			$percent_for_close = $request->percent_for_close;
			$percent = $request->percent;
			
			
			$closed = $request->closed;
			if (!$trading->closed && $request->closed) {
				
				if ($trading->percent > $request->percent_for_close) {
					$trading_base = [
						'ticker' =>$request->ticker,
						'order_type' => $request->order_type,
						'buy_price' =>$request->buy_price,
						'market_price' =>$request->market_price,
						'take_profit' =>$request->take_profit,
						'stop_loss' =>$request->stop_loss,
						'percent' => ($request->percent - $request->percent_for_close),
						'closed' => $request->closed,
						'close_price' => $request->close_price,
						'percent_for_close' => $request->percent_for_close
					];
				
				$ex = Trading::create($trading_base);
				
				$closed = false;
		
				$division_base = [
					'parent_trading_id' =>$request->id,
					'children_trading_id' => $ex->id,
					'percent_for_close' => $request->percent_for_close
				];
				
				Divisiontradings::create($division_base);
					
				$percent = $percent - $request->percent_for_close;
				$close_price = null;
				$percent_for_close = null;

					
				}
			}
			
			$trading->order_type = $request->order_type;
			$trading->buy_price = $request->buy_price;
			$trading->take_profit = $request->take_profit;
			$trading->stop_loss = $request->stop_loss;
			$trading->percent = $percent;
			
			$trading->closed = $closed;
			
			$trading->close_price = $close_price;
			$trading->percent_for_close = $percent_for_close;
					   	
			$trading->save();
			$success = true;
		 }
			 	 
		return view('exel.tradingupdate', ['trading' => $trading, 'success' => $success]);
    }
	 
	public function tradingdelete(Request $request){ 	 
		$trading = Trading::find($request->id)->delete();	 
		return response()->json(array('msg'=> $trading), 200);
	}
}