<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $filter;
    private $xml;


     function __construct()
    {
        $this->filter = null;
        $this->xml = simplexml_load_file('countries.xml');
    }

    public function index(Request $request){


        if ($request->filter) {
            $this->filter = $request->filter;
        }



        $arr = [];

        foreach($this->xml->children() as $country) {

            preg_match('/^.*\/@([0-9\.-]+),([0-9\.-]+),/',$country->map_url, $results);

            if ($this->filter && (string)$country['zone'] != $this->filter){
                continue;
            }
           $arr[] = [
             'zone' =>  (string)$country['zone'],
             'name' => (string)$country->name,
             'country_native' => (string)$country->name['native'],
             'language' => (string)$country->language,
             'lang_native' => (string)$country->language['native'],
             'currency' => (string)$country->currency,
             'currency_code' => (string)$country->currency['code'],
             'lat' => $results[1],
             'long' => $results[2],

           ];

        }





         usort($arr, function($a, $b) {
             return $a['zone'] <=> $b['zone'];
         });

         array_multisort(array_column($arr, 'zone'), SORT_ASC,
             array_column($arr, 'name'),      SORT_ASC,
             $arr);

         return view('welcome')->with('data',$arr);
    }

    function printCountries(){

        $result = $this->xml->xpath('country');

        $results = [];
        foreach ($result as $res){
            if ($res->currency['code'] != 'EUR') {
                continue;
            }
            array_push($results,(string)$res->name);

        }

        return $results;
    }
}
