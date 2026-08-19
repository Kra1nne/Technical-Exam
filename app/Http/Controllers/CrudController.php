<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index(Request $request)
    {
        $query = Family::query();

        return view('welcome', compact('query'));
    }
}
