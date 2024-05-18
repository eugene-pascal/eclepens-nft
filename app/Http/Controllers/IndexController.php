<?php

namespace App\Http\Controllers;

use App\Models\Nft;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (\Auth::guest()) {
            //return redirect()->route('member.login');
        } else {
            //return redirect()->route('dashboard');
        }
        $queryOnNft = Nft::active();

        return view('nerko.index', compact('queryOnNft'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function inquiryNFT()
    {
        return view('nerko.inquiry-nft');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return view('nerko.contact');
    }
}
