<?php

namespace App\Http\Controllers;

use App\Models\Currencies;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function AddWalet(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'currency_code' => 'required'
        ]);

        $Currency = Currencies::where('code', $request->currency_code)->first();

        if (!$Currency) {
            return response([
                'message' => 'Currency Not found'
            ], 404);
        }

        $Wallets = Wallet::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
            'currency_id' => $Currency->id
        ]);


        $Wallets->with('Currency');

        return response([
            'status' => 'success',
            'message' => 'Wallet added successful',
            'data' => [
                'name' => $Wallets->name,
                'user_id' => $Wallets->user_id,
                'updated_at' => $Wallets->updated_at,
                'created_at' => $Wallets->created_at,
                'id' => $Wallets->id,
                'currency_code' => $Wallets->Currency->name
            ]
        ],200);
    }

    public function UpdateWalet(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);


        $Chekuser = Wallet::where('user_id', $request->user()->id)->first();

        if (!$Chekuser) {
            return response([
                'status' => 'error',
                'message' => 'Forbiden Access'
            ], 403);
        }

        $Wallets = Wallet::find($id);


        if (!$Wallets) {
            return response([
                'status' => 'error',
                'message' => 'Not found'
            ], 404);
        }


        $Wallets->update([
            'name' => $request->name,
            'user' => $request->user()->id,
        ]);

        $Wallets->with('Currency');


        return response([
            'status' => 'success',
            'message' => 'Wallet Updated successful',
            'data' => [
                'name' => $Wallets->name,
                'user_id' => $Wallets->user_id,
                'updated_at' => $Wallets->updated_at,
                'created_at' => $Wallets->created_at,
                'id' => $Wallets->id,
                'currency_code' => $Wallets->Currency->name
            ]
        ], 200);
    }


    public function DeleteWallet(Request $request, $id)
    {
        $Wallets = Wallet::find($id);

        $CheckUser = Wallet::where('user_id', $request->user()->id);

        if (!$CheckUser) {
            return response([
                'status' => 'error',
                'message' => 'Forbiden Access'
            ], 403);
        }

        if (!$Wallets) {
            return response([
                'status' => 'error',
                'message' => 'Not found'
            ], 404);
        }
    }


    public function GetAllWallets(Request $request)
    {
        $Wallets = Wallet::with('Currency')->where('user_id', $request->user()->id)->get();

        return response([
            'status' => 'success',
            'message' => 'Get All wallets successful',
            'data' => [
                'wallets' => $Wallets->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'user_id' => $data->user_id,
                        'name' => $data->name,
                        'created_at' => $data->created_at,
                        'updated_at' => $data->updated_at,
                        'deleted_at' => $data->deleted_at,
                        'currency_code' => $data->Currency->name,
                    ];
                })

            ]
        ], 200);
    }

    public function GetDetailWallets(Request $request, $id)
    {
        $Wallets = Wallet::where('id', $id)->first();

        $Wallets->with('Currency');

        $Checkuser = Wallet::where('user_id', $request->user()->id)->first();

        if (!$Wallets) {
            return response([
                'status' => 'error',
                'message' => 'Not found'
            ], 404);
        }

        if (!$Checkuser) {
            return response([
                'status' => 'error',
                'message' => 'Forbiden Access'
            ], 403);
        }


        return response([
            'status' => 'success',
            'message' => 'Get Detail wallets successful',
            'data' => [
                'wallets' => [
                    'id' => $Wallets->id,
                    'message' => $Wallets->user_id,
                    'name' => $Wallets->name,
                    'created_at' => $Wallets->created_at,
                    'updated_at' => $Wallets->updated_at,
                    'deleted_at' => $Wallets->deleted_at,
                    'currency_code' => $Wallets->Currency->name,
                ]
            ]
        ], 200);
    }
}
