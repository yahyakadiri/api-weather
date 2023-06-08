<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class current extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current {city=Santander},{country=ES} {--u|units=metric}';

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
        $unit = $this->option('units');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&appid={$this->api_key}");

        $json = $response->json();

        $city_country = $json['name']." (".$json['sys']['country'].")";
        $weather = $json['weather'][0]['description'];
        $temp = $json['main']['temp'];
        $time = strftime("%b %d, %Y",strtotime($json['dt']));

        $this->line('response:');
        $this->line($city_country);
        $this->line($time);
        $this->line('> Weather: '.$weather);
        $this->line('> Temperature: '.$temp);
        
    }
}
