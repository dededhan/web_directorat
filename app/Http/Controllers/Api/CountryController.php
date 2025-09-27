<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Monarobase\CountryList\CountryListFacade as Countries;

class CountryController extends Controller
{

    public function index()
    {
        try {
            $countriesList = Countries::getList('en', 'php');

            $formattedCountries = [];
            foreach ($countriesList as $code => $name) {
                $formattedCountries[] = ['code' => $code, 'name' => $name];
            }

            return response()->json($formattedCountries);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not retrieve country list.'], 500);
        }
    }
}
