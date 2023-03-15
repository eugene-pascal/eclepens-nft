<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Get the list of attributes
     */
    public function list(Request $request)
    {

        return view('cpanel.attribute.list', [

        ]);
    }

    /**
     * Show form: Add a new attributes
     */
    public function add(Request $request)
    {
        $langs = Language::active()->orderBy('sort','asc')->get();
        return view('cpanel.attribute.manage', [
            'langs' => $langs
        ]);
    }
}
