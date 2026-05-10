<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        DB::table('categories')->insert([
            'category_name' => $request->category_name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'category_name' => $request->category_name,
                'updated_at' => now()
            ]);

        return back();
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return back();
    }


}