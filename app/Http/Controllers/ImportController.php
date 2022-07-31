<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function import(Request $request){
        dd($request->file);
    }
}
