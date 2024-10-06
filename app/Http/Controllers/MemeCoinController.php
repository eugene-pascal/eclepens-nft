<?php

namespace App\Http\Controllers;

use App\Models\Nft;
use Illuminate\Http\Request;

class MemeCoinController extends Controller
{
    public function pageTRX()
    {
        return view('nerko.meme.page');
    }
}
