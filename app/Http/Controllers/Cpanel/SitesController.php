<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Requests\Cpanel\Settings\SiteRequest;
use App\Http\Requests\Cpanel\Settings\Request;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Http\Resources\Cpanel\SiteCollection;
use App\Models\Site;
use Illuminate\Support\Facades\Schema;

class SitesController extends Controller
{
    /**
     * Show the list of sites
     */
    public function list(Request $request)
    {
        $list = Site::query()->get();
        return view('cpanel.settings.sites.list', compact('list'));
    }

    /**
     * Show the form for adding a new site record
     */
    public function add(Request $request)
    {
        return view('cpanel.settings.sites.edit');
    }

    /**
     * Show the form for an existed site to edit
     */
    public function edit(Site $site, Request $request)
    {
        return view('cpanel.settings.sites.edit', compact('site'));
    }

    /**
     * Update a site record
     */
    public function update(Site $site, SiteRequest $request)
    {
        $site->name = $request->input('name');
        $site->url = $request->input('url');
        $site->code = $request->input('code');
        $site->is_active = $request->input('is_active',0);
        $site->save();
        return redirect()->route('settings.site.edit', ['site'=>$site->id])
            ->with(['success' => __('Successfully saved!')]);
    }
    /**
     * Create site record
     */
    public function create(SiteRequest $request)
    {
        $site = new Site;
        $site->name = $request->input('name');
        $site->url = $request->input('url');
        $site->code = $request->input('code');
        $site->is_active = $request->input('is_active',0);
        $site->save();
        return redirect()->route('settings.sites')
            ->with(['success' => __('Successfully added!')]);
    }

    /**
     * Remove language
     */
    public function delete(Site $site)
    {
        $site->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Get the sites list
     */
    public function listForKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Site::orderBy('id','DESC');

        if (!empty($queryData)) {
            if (isset($queryData['display'])&&is_numeric($queryData['display'])) {
                if (0 == $queryData['display']) {
                    $query
                        ->where('is_active','0');
                }
                elseif (1 == $queryData['display']) {
                    $query
                        ->where('is_active','1');
                }
            }
            if (!empty($queryData['query_search'])) {
                $query
                    ->where(function ($query) use ($queryData) {
                        $query->where('name', 'like', '%'.trim($queryData['query_search']).'%')
                            ->orWhere('code', 'like', '%'.trim($queryData['query_search']).'%');
                    });
            }
        }
        if (!empty($sortData)) {
            if (Schema::hasColumn('sitea', $sortData['field'])) {
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
            'data'=> SiteCollection::collection($pager)
        ]);
    }


}
