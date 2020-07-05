<?php

use Illuminate\Database\Seeder;

use App\Country;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();

        $response = Http::get('https://restcountries.eu/rest/v2/all');
        if ( ! $response->ok() ) {
            throw new Exception('Failed to retrieve countries');
        }

        $countries = array();
        foreach ( $response->json() as $country ) {
            $country = Country::create([
                'code'  => $country['alpha3Code'],
                'name'  => $country['name']
            ]);

            $country->save();
        }
    }
}
