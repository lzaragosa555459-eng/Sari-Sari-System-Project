<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class CreditController extends Controller
{
    public function index()
    {
        $credits = DB::select("
            SELECT 
                c.id,
                c.customer_name,
                c.address,
                c.contact_number,
                s.total_amount,
                COALESCE(SUM(cp.amount_paid - cp.change), 0) AS amount_paid,
                s.total_amount - COALESCE(SUM(cp.amount_paid - cp.change), 0) AS balance,
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
        ");

        $creditPayments = DB::select("
            SELECT
                cp.*,
                c.customer_name
            FROM credit_payments cp
            LEFT JOIN credits c ON cp.credit_id = c.id
            ORDER BY cp.payment_date DESC, cp.created_at DESC
        ");

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
    // 1. Validate input (IMPORTANT: must match your form)
    $request->validate([
        'credit_id'       => 'required|exists:credits,id',
        'amount_tendered' => 'required|numeric|min:0.01',
        'payment_date'    => 'required|date',
        'method'          => 'required|string|max:255',
    ]);

    // 2. Get credit + total paid so far
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
        return back()->with('error', 'Credit record not found.');
    }

    // 3. Compute remaining balance
    $remainingBalance = $credit->total_amount - $credit->total_paid;

    if ($remainingBalance <= 0) {
        return back()->with('error', 'This credit is already fully paid.');
    }

    // 4. Amount user gave
    $amountTendered = (float) $request->amount_tendered;

    if ($amountTendered <= 0) {
        return back()->with('error', 'Invalid payment amount.');
    }

    // 5. Compute applied payment + change
    $amountPaid = min($amountTendered, $remainingBalance);
    $change = $amountTendered - $amountPaid;

    // 6. INSERT PAYMENT (FIXED VERSION)
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
        $amountPaid,
        $change,
        $request->payment_date,
        $request->method,
    ]);

    // 7. Update store cash ONLY for cash
    if (strtolower($request->method) === 'cash') {
        $cash = DB::selectOne("SELECT * FROM store_cash LIMIT 1");

        if ($cash) {
            DB::update("
                UPDATE store_cash
                SET current_balance = current_balance + ?,
                    total_income = total_income + ?,
                    updated_at = NOW()
                WHERE id = ?
            ", [
                $amountPaid,
                $amountPaid,
                $cash->id
            ]);
        }
    }

    // 8. Response message
    if ($change > 0) {
        return back()->with(
            'success',
            'Payment recorded. Change: ₱' . number_format($change, 2)
        );
    }

    return back()->with('success', 'Payment recorded successfully.');
}
}
