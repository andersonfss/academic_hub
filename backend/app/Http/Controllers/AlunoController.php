<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function store(Request $request)
    {
        dd($request->usuario);

        return response()->json(['message' => 'usuario cadastrado com sucesso !'], 200);
    }
}
