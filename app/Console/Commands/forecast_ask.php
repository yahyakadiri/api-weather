<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class forecast_ask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:ask';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api_key = env('OPENWEATHERMAP_API_KEY');

        $days = $this->ask('How many days to forecast?:');

        $units = $this->choice(
            'what unit of measure?:',
            ['metric', 'imperial'],
        );

        $city = "";
        $country = "";

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast/daily?q={$city},{$country}&cnt={$days}&appid={$this->api_key}");

        $json = $response->json();

        $city_country = $json['city']['name']." (".$json['city']['country'].")";

        $this->line('response:');
        $this->line($city_country);


        foreach($json['list'] as $day_info){
            $weather = $day_info['weather']['description'];
            $temp = $day_info['main']['temp'];
            $time = strftime("%b %d, %Y",strtotime($day_info['dt']));

            $this->line($time);
            $this->line('> Weather: '.$weather);
            $this->line('> Temperature: '.$temp);
        }
    }
}
