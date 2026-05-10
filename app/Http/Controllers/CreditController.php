<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class CreditController extends Controller
{
    // Replace your index() method with this version
    public function index()
    {
        $credits = DB::select("
            SELECT 
                c.id,
                c.customer_name,
                c.address,
                c.contact_number,
                s.total_amount,
                COALESCE(SUM(cp.amount_paid), 0) AS amount_paid,
                (s.total_amount - COALESCE(SUM(cp.amount_paid), 0)) AS balance,
                c.due_date
            FROM credits c
            LEFT JOIN sales s ON c.sale_id = s.id
            LEFT JOIN credit_payments cp ON c.id = cp.credit_id
            GROUP BY 
                c.id,
                c.customer_name,
                c.address,
                c.contact_number,
                s.total_amount,
                c.due_date
            ORDER BY c.id DESC
        ");

        // Group all payments by credit_id
        $creditPayments = DB::table('credit_payments')
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('credit_id');

        return view('credits', compact('credits', 'creditPayments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'customer_name' => 'required',
            'balance' => 'required',
            'due_date' => 'required',
        ]);

        DB::table('credits')->insert([
            'sale_id' => $request->sale_id,
            'customer_name' => $request->customer_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'balance' => $request->balance,
            'due_date' => $request->due_date,
            'status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::forget('credit_checkout');

        return redirect()->route('pos')
            ->with('success', 'Credit saved successfully!');
    }


    public function store_payment(Request $request)
    {
        $request->validate([
            'credit_id'       => 'required|exists:credits,id',
            'amount_tendered' => 'required|numeric|min:0.01',
            'payment_date'    => 'required|date',
            'method'          => 'required|string|max:255',
        ]);

        $credit = DB::selectOne("
            SELECT
                c.id,
                s.total_amount,
                COALESCE(SUM(cp.amount_paid), 0) AS total_paid
            FROM credits c
            LEFT JOIN sales s ON c.sale_id = s.id
            LEFT JOIN credit_payments cp ON c.id = cp.credit_id
            WHERE c.id = ?
            GROUP BY c.id, s.total_amount
        ", [$request->credit_id]);

        if (!$credit) {
            return back()->with('error', 'Credit not found.');
        }

        $remainingBalance = $credit->total_amount - $credit->total_paid;

        if ($remainingBalance <= 0) {
            return back()->with('error', 'Already fully paid.');
        }

        $amountTendered = (float) $request->amount_tendered;

        if ($amountTendered <= 0) {
            return back()->with('error', 'Invalid amount.');
        }

        // APPLY LOGIC
        $appliedToDebt = min($amountTendered, $remainingBalance);
        $change = max(0, $amountTendered - $remainingBalance);

        DB::insert("
            INSERT INTO credit_payments (
                credit_id,
                amount_paid,
                `change`,
                payment_date,
                method,
                created_at,
                updated_at
            )
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $request->credit_id,
            $appliedToDebt,
            $change,
            $request->payment_date,
            $request->method,
        ]);

        if (strtolower($request->method) === 'cash') {
            DB::update("
                UPDATE store_cash
                SET current_balance = current_balance + ?,
                    total_income = total_income + ?,
                    updated_at = NOW()
            ", [$appliedToDebt, $appliedToDebt]);
        }

        return back()->with('success', 'Payment recorded successfully.');
    }
}
