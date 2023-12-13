<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Requests\Cpanel\Nft\EditRequest;
use App\Http\Requests\Cpanel\Nft\Request;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Http\Resources\Cpanel\NftCollection;
use App\Models\Nft;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NftController extends Controller
{
    /**
     * Show the page for showing of list NFT
     */
    public function list(Request $request)
    {
        return view('cpanel.nft.list');
    }

    /**
     * Show the page for adding a new NFT
     */
    public function add(Request $request)
    {
        return view('cpanel.nft.manage');
    }

    /**
     * Show the page for editing of NFT
     */
    public function edit(Nft $nft)
    {
        return view('cpanel.nft.manage', compact('nft'));
    }

    /**
     * Create a new article depending on request
     */
    public function create(EditRequest $request)
    {
        $postData = $request->all();
        if (!isset($postData['display'])) {
            $postData['display'] = 0;
        }
        $postData = array_map(function($v){
            return ($v === null) ? '' : $v;
        }, $postData);

        $model = new Nft($postData);
        if ($model->save()) {
            $this->_tagsUpdate($model, $request);
        }

        return redirect()->route('content.nft.list')
            ->with(['success' => __('Successfully added')]);
    }
    /**
     * Get the NFT list
     */
    public function listForKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Nft::orderBy('id','DESC');

        if (!empty($queryData)) {
            if (isset($queryData['display'])&&is_numeric($queryData['display'])) {
                if (0 == $queryData['display']) {
                    $query
                        ->where('display','0');
                }
                elseif (1 == $queryData['display']) {
                    $query
                        ->where('display','1');
                }
            }
            if (!empty($queryData['query_search'])) {
                $query
                    ->where(function ($query) use ($queryData) {
                        $query->where('name', 'like', '%'.trim($queryData['query_search']).'%');
                    });
            }
            if (isset($queryData['tags'])) {
                $tagsArr = json_decode($queryData['tags'], true);
                $tagsArr = !empty($tagsArr) ? Arr::flatten($tagsArr) : [] ;
                $slugsArr = array_map(function($value) {
                    return Str::slug($value,'-');
                }, $tagsArr);

                $query
                    ->whereHas('tags', function (Builder $query) use ($slugsArr) {
                        $query->whereIn('slug', $slugsArr);
                    });
            }
        }
        if (!empty($sortData)) {
            if (Schema::hasColumn('articles', $sortData['field'])) {
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
            'data'=> NftCollection::collection($pager)
        ]);
    }

    /**
     * Updates the tags that belong to the NFT
     */
    private function _tagsUpdate(Nft $nft, $request): void {
        $tagsArr = json_decode($request->input('tags_names','[]'), true);
        $tagsArr = !empty($tagsArr) ? Arr::flatten($tagsArr) : [] ;
        $slugsArr = array_map(function($value) {
            return Str::slug($value,'-');
        }, $tagsArr);

        if (!empty($tagsArr)) {
            $detachedIds = Arr::pluck($nft->tags()->select('id')->whereNotIn('slug',$slugsArr)->get()->toArray(),'id');
            $nft->tags()->detach($detachedIds);
            // remove all tags empty
            Tag::doesntHave('articles')->doesntHave('nft')->delete();
            $attachedSlugs = Arr::pluck($nft->tags()->select('slug')->whereIn('slug',$slugsArr)->get()->toArray(),'slug');
            foreach ($tagsArr as $tagName) {
                $slugName = Str::slug($tagName,'-');
                if (in_array($slugName,$attachedSlugs)) {
                    continue;
                }
                $tag = Tag::query()->where('slug','=', $slugName)->first();
                if ($tag) {
                    $nft->tags()->attach($tag->id);
                } else {
                    $tag = new Tag(['name' => $tagName]);
                    $nft->tags()->save($tag);
                }
            }
        } else
            if ($nft->exists) {
                $detachedIds = Arr::pluck($nft->tags()->select('id')->get()->toArray(),'id');
                $nft->tags()->detach($detachedIds);
                // remove all tags empty
                Tag::doesntHave('articles')->doesntHave('nft')->delete();
            }
    }

    /**
     * Update the NFT
     */
    public function update(Nft $nft, EditRequest $request)
    {
        $postData = $request->all();
        if (!isset($postData['display'])) {
            $postData['display'] = 0;
        }
        $postData = array_map(function($v){
            return ($v === null) ? '' : $v;
        }, $postData);
        $nft->fill($postData);
        $nft->save();
        
        $this->_tagsUpdate($nft, $request);

        return redirect()->route('content.nft.edit', ['nft'=>$nft->id])
            ->with(['success' => __('Updated')]);
    }

    /**
     * Delete an article
     */
    public function delete(Nft $nft, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $nft->deleteWithRelations();
        return response()->json([
            'status' => 'success',
            'message' => 'Member account has been deleted.'
        ]);
    }

    /**
     * Uploads the medias
     */
    public function uploadMedia(Nft $nft, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $result = [];
        if ($request->hasFile('file')) {
            $result = $nft->addMediaFromRequest('file')->toMediaCollection(Nft::_MEDIA_COLLECTION_NAME);
        }
        return response()->json([
            'status' => 'success',
            'result' => $result
        ]);
    }

    /**
     * Delete the media
     */
    public function deleteMedia(Nft $nft, Media $media, Request $request)
    {
        $media->delete();
        return [
            'status' => 'success'
        ];
    }

}
