<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class FormController extends Controller
{
    public function index()
    {
        $forms = collect(); // colección vacía por ahora

        return view('admin.forms', compact('forms'));
    }
}
