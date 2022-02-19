<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\college;

class collegeCont extends Controller
{
    function show()
    {
        $data = college::all();
        return view('view', ['members' => $data]);
    }
}
