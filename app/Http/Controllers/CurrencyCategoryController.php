<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Currencies;
use Illuminate\Http\Request;

class CurrencyCategoryController extends Controller
{

    public function GetAllCurrencies(Request $request)
    {
        $Currencies = Currencies::all();

        return response([
            'message' => 'Get all currencies successful',
            'data' => [
                $Currencies
            ]
        ], 200);
    }

    public function GetAllCategories(Request $request)
    {
        $Category = Category::all();

        return response([
            'message' => 'Get all categories successful',
            'data' => [
                $Category
            ]
        ], 200);
    }
}
