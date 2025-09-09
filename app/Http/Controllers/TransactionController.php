<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function AddTransaction(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|integer|exists:wallets,id',
            'category_id' => 'required|integer|exists:categories,id',
            'amount' => 'required|integer|min:1',
            'date' => 'required|date|date_format:Y-m-d',
        ]);

        $Transaction = Transaction::create([
            'category_id' => $request->category_id,
            'wallet_id' => $request->wallet_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note
        ]);

        return response([
            'status' => 'success',
            'message' => 'Transaction added successful',
            'data' => [
                'category_id' => $Transaction->category_id,
                'wallet_id' => $Transaction->wallet_id,
                'amount' => $Transaction->amount,
                'note' => $Transaction->note,
                'date' => $Transaction->date,
                'updated_at' => $Transaction->updated_at,
                'created_at' => $Transaction->created_at,
                'id' => $Transaction->id,
            ]
        ],200);
    }

    public function DeleteTransaction(Request $request, $id)
    {
        $Transaction = Transaction::find($id);


        $WalletId = Wallet::where('id', $Transaction->wallet_id)->first();

        if ($request->user()->id != $WalletId->user_id) {
            return response([
                'status' => 'error',
                'message' => 'Forbidden access'
            ],403);
        }

        if (!$Transaction) {
            return response([
                'status' => 'error',
                'message' => 'Not found'
            ], 404);
        }

        return response([
            "status" => "success",
            "message" => "Transaction deleted successful"
        ], 200);
    }



    public function GetTransaction(Request $request)
    {

        $request->validate([
            'page'     => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1',
            'month'    => 'sometimes|integer|between:1,12',
            'year'     => 'sometimes|integer|min:1',
        ]);

        $perPage = $request->input('per_page', 25);


        $query = Transaction::with(['Wallet', 'Category']);

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // paginate otomatis dari Laravel
        $transactions = $query->paginate($perPage);

        return response([
            $transactions
        ],200);
    }
}
