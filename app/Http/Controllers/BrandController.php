<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function store(Request $request)
    {
        DB::table('brands')->insert([
            'brand_name' => $request->brand_name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        DB::table('brands')
            ->where('id', $id)
            ->update([
                'brand_name' => $request->brand_name,
                'updated_at' => now()
            ]);

        return back();
    }

    public function destroy($id)
    {
        DB::table('brands')->where('id', $id)->delete();

        return back();
    }
}