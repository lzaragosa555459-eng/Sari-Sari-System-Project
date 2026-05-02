<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = DB::select("
            SELECT 
                c.id AS customer_id,
                u.id AS user_id,
                u.name,
                u.email,
                c.contact_number,
                c.address,
                c.created_at
            FROM customers c
            INNER JOIN users u ON c.user_id = u.id
            ORDER BY c.id DESC
        ");

        return view('customers', compact('customers'));
    }
}