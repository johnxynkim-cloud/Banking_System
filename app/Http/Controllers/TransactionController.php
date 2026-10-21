<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TransactionController extends Controller {
    public function index() {
        $transactions = Transaction::with('account')->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create() {
        $accounts = Account::all();
        return view('transactions.create', compact('accounts'));
    }

    public function store(Request $request) {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $account = Account::findOrFail($request->account_id);

        if ($request->type === 'withdrawal') {
            $potentialBalance = $account->balance - $request->amount;
            if ($potentialBalance < $account->minimum_balance) {
                return back()->withErrors(['amount' => 'Insufficient funds: Withdrawal breaches the minimum balance limit.'])->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request) {
                Transaction::create([
                    'account_id' => $request->account_id,
                    'type' => $request->type,
                    'amount' => $request->amount,
                    'reference_number' => 'REF-' . strtoupper(uniqid()),
                    'notes' => $request->notes,
                ]);
            });

            return redirect()->route('transactions.index')->with('success', 'Transaction processed successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}