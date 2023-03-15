<?php

namespace App\Http\Controllers\Cpanel;

use App\Jobs\SendMail;
use App\Mail\SignupCompleted;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cpanel/dashboard');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function domainsSudoReport(Request $request)
    {
        $this->validate($request, [
            'domains_list' => 'required|string|min:5',
            'radios' => 'required',
            'month_picker1' => 'required|date',
            'month_picker2' => 'required|date|after_or_equal:month_picker1',
        ]);

        $data =  $request->except('_token');
        $domainList  = preg_split('/[\r\n]+/', $data['domains_list']);

        if ($request->ajax()) {
            return ['reportData'=>\SudoApi::getDomains($domainList, $data)];
        }
        return redirect()->route('dashboard', [])
            ->with([
                'successOnReport' => true,
                'reportData' => \SudoApi::getDomains($domainList, $data)
            ]);
    }
}