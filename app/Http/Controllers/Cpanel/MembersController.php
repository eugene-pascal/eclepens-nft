<?php

namespace App\Http\Controllers\Cpanel;

use App\Enums\UserStatus;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Requests\Cpanel\Members\Request;
use App\Http\Requests\Cpanel\Partners;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Http\Resources\Cpanel\MemberCollection;
use App\Http\Resources\Cpanel\MemberInvestmentSummCollection;
use App\Jobs\NotifyAdminAboutPartnerActions;
use App\Jobs\NotifyPartnerAboutAdminActions;
use App\Models\Member;
use App\Models\MemberInvestmentSumm;
use App\Models\PartnerMemberConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class MembersController extends Controller
{
    /**
     * Show view template for the members list
     */
    public function list(Request $request)
    {
        return view('cpanel.members.list');
    }

    /**
     * Show view template for a member profile
     */
    public function profile(Member $member, Request $request)
    {
        if ($member->isPartner()) {
            abort(403);
        }
        return view('cpanel.members.profile', [
            'member' => $member
        ]);
    }

    /**
     *  Update account
     */
    public function update(Member $member, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        if ('personal' === $request->tab) {
            $member->status = !empty($request->status) ? UserStatus::ACTIVE : UserStatus::INACTIVE ;
            $this->validate($request, [
                'name' => 'required|min:1',
            ]);
            $data = $request->except(['password', 'status', 'email', 'remember_token']);
            $data = array_map(function($v){
                return (is_null($v)) ? '' : $v ;
            }, $data);
            $member->fill($data);
            $member->save();
        }
        elseif ('password' === $request->tab) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
            ]);
            $member->password = Hash::make($request->password);
            $member->save();
        }
        elseif ('summary_acc' === $request->tab) {
            $this->validate($request, [
                'account_number' => 'required|digits:14',
                'validity_date' => 'required|date|after:today',
                'start_date' => 'required|date',
            ]);

            DB::table('members_account_summary')->updateOrInsert(
                ['member_id' => $member->id],
                [
                    'account_number' => $request->account_number,
                    'start_date' => $request->start_date,
                    'validity_date' => $request->validity_date,
                    'strategy_type' => $request->strategy_type,
                    'capitalization_status' => $request->capitalization_status,
                    'member_id' => $member->id
                ]
            );
        }
        elseif ('summary_inv' === $request->tab) {
            $this->validate($request, [
                'invested_usd' => 'required|numeric',
                'returned_btc' => 'required|numeric',
                'invested_date' => [
                    'required',
                    'date',
                    Rule::unique('members_investment_summary')->where(function ($query) use ($member) {
                        return $query->where('member_id', $member->id);
                    })
                ],
            ]);

            DB::table('members_investment_summary')->insert(
                [
                    'invested_usd' => $request->invested_usd,
                    'returned_btc' => $request->returned_btc,
                    'member_id' => $member->id,
                    'invested_date' => $request->invested_date
                ]
            );
        }

        if ($member->isPartner()) {
            return redirect()->route('partner.profile', ['member'=>$member,] + ($request->tab ? ['tab'=>$request->tab] : [] ) )
                ->with(['successOnUpdate' => true]);
        }
        return redirect()->route('member.profile', ['member'=>$member,] + ($request->tab ? ['tab'=>$request->tab] : [] ) )
            ->with(['successOnUpdate' => true]);
    }

    /**
     * Delete account
     */
    public function delete(Member $member, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $member->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Member account has been deleted.'
        ]);
    }

    /**
     * Get the members list
     */
    public function listForKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Member::where('type_account', \Config::get('constants.session.type.member'))->orderBy('id','DESC');

        if (!empty($queryData)) {
            if (isset($queryData['verified'])&&is_numeric($queryData['verified'])) {
                if (0 == $queryData['verified']) {
                    $query
                        ->where('status','0');
                }
                elseif (1 == $queryData['verified']) {
                    $query
                        ->where('status','1');
                }
            }
            if (!empty($queryData['query_search'])) {
                $query
                    ->where(function ($query) use ($queryData) {
                        $query->where('name', 'like', '%'.trim($queryData['query_search']).'%')
                            ->orWhere('email', 'like', '%'.trim($queryData['query_search']).'%');
                    });
            }
        }
        if (!empty($sortData)) {
            if (Schema::hasColumn('members', $sortData['field'])) {
                $query->orderBy($sortData['field'], $sortData['sort']);
            }
        }

        $onPage = intval($request->pagination['perpage'] ?? 20);
        $pager = $query->paginate($onPage);
        if ($request->page && $pager->isEmpty()) {
            $pager = $query->paginate($onPage, ['*'], 'page', 1);
        }

        return response()->json( [
            'meta'=> new KDTablePaginationCollection($pager),
            'data'=> MemberCollection::collection($pager)
        ]);
    }

}
