<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class forecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast {city=Santander},{country=ES} {--d|days=1} {--u|units=metric}';
    

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
        
        $city = $this->argument('city');
        $country = $this->argument('country');
        $days = $this->option('days');
        $unit = $this->option('units');

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
