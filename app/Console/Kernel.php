<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Message;


use App\Posts;
use App\Exels;

use App\Trading;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
		//	Message::truncate(); 

		$schedule->call(function () {

			$tickers = [];
			$exels = Exels::all();	
			
			foreach ($exels as $result) {
				$tickers[] = $result->ticker;
				$tickers_fair_value[$result->ticker] = $result->fair_value;
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
					
				Exels::truncate();
					
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
	    
	 })->twiceDaily(1, 13);


  






 $schedule->call(function () {

		$tickers = [];
		$trading = Trading::all();	  
		//$trading = Trading::where('closed', '=', 0)->get();

		foreach ($trading as $result) {
			$tickers[] = $result->ticker;
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
				Trading::where('ticker',$result['attributes']['identifier'])->update(['market_price'=>$result['attributes']['last']]);	
			}
		}

   })->everyMinute();
   
   
   
   
   
   
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
     //   $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
    
