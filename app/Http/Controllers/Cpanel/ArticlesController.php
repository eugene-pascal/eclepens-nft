<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\Articles\EditRequest;
use App\Http\Requests\Cpanel\Articles\Request;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Resources\Cpanel\ArticleCollection;
use App\Http\Resources\Cpanel\CategoryCollection;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticlesController extends Controller
{
    /**
     * Show the page for showing of list articles
     */
    public function list(Request $request)
    {
        return view('cpanel.articles.list');
    }

    /**
     * Show the page for adding a new article
     */
    public function add(Request $request)
    {
        return view('cpanel.articles.manage');
    }

    /**
     * Show the page for editing of article
     */
    public function edit(Article $article)
    {
        return view('cpanel.articles.manage', compact('article'));
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

        $model = new Article($postData);
        if ($model->save()) {
            $this->_tagsUpdate($model, $request);
        }

        return redirect()->route('content.articles.list')
            ->with(['success' => __('Successfully added')]);
    }


    /**
     * Update an article
     */
    public function update(Article $article, EditRequest $request)
    {
        $postData = $request->all();
        if (!isset($postData['display'])) {
            $postData['display'] = 0;
        }
        $postData = array_map(function($v){
                return ($v === null) ? '' : $v;
            }, $postData);
        $article->fill($postData);
        $article->save();

        if (!empty($postData['categories'])) {
            $article->categories()->sync($postData['categories']);
        }
        $this->_tagsUpdate($article, $request);

        return redirect()->route('content.article.edit', ['article'=>$article->id])
            ->with(['success' => __('Updated')]);
    }

    /**
     * Get the articles list
     */
    public function listForKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Article::orderBy('id','DESC');

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
                        $query->where('title', 'like', '%'.trim($queryData['query_search']).'%')
                            ->orWhere('code_unique', 'like', '%'.trim($queryData['query_search']).'%')
                            ->orWhere('code_name', 'like', '%'.trim($queryData['query_search']).'%');
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
            'data'=> ArticleCollection::collection($pager)
        ]);
    }

    /**
     * Delete an article
     */
    public function delete(Article $article, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $article->deleteWithRelations();
        return response()->json([
            'status' => 'success',
            'message' => 'Member account has been deleted.'
        ]);
    }

    /**
     * Uploads the medias
     */
    public function uploadMedia(Article $article, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $result = [];
        if ($request->hasFile('file')) {
            $result = $article->addMediaFromRequest('file')->toMediaCollection(Article::_MEDIA_COLLECTION_NAME);
        }

        return response()->json([
            'status' => 'success',
            'result' => $result
        ]);
    }

    /**
     * Delete the media
     */
    public function deleteMedia(Article $article, Media $media, Request $request)
    {
        $media->delete();
        return [
            'status' => 'success'
        ];
    }

    /**
     * Updates the tags that belong to the article
     */
    private function _tagsUpdate(Article $article, $request): void {
        $tagsArr = json_decode($request->input('tags_names','[]'), true);
        $tagsArr = !empty($tagsArr) ? Arr::flatten($tagsArr) : [] ;
        $slugsArr = array_map(function($value) {
            return Str::slug($value,'-');
        }, $tagsArr);

        if (!empty($tagsArr)) {
            $detachedIds = Arr::pluck($article->tags()->select('id')->whereNotIn('slug',$slugsArr)->get()->toArray(),'id');
            $article->tags()->detach($detachedIds);
            // remove all tags empty
            Tag::doesntHave('articles')->doesntHave('nft')->delete();
            $attachedSlugs = Arr::pluck($article->tags()->select('slug')->whereIn('slug',$slugsArr)->get()->toArray(),'slug');
            foreach ($tagsArr as $tagName) {
                $slugName = Str::slug($tagName,'-');
                if (in_array($slugName,$attachedSlugs)) {
                    continue;
                }
                $tag = Tag::query()->where('slug','=', $slugName)->first();
                if ($tag) {
                    $article->tags()->attach($tag->id);
                } else {
                    $tag = new Tag(['name' => $tagName]);
                    $article->tags()->save($tag);
                }
            }
        } else
        if ($article->exists) {
            $detachedIds = Arr::pluck($article->tags()->select('id')->get()->toArray(),'id');
            $article->tags()->detach($detachedIds);
            // remove all tags empty
            Tag::doesntHave('articles')->doesntHave('nft')->delete();
        }
    }

    /**
     * Show the page for showing of list categories
     */
    public function categoriesList(Request $request)
    {
        return view('cpanel.articles.categories-list');
    }

    /**
     * Show the page for adding a new category
     */
    public function categoryAdd(Request $request)
    {
        return view('cpanel.articles.category-edit');
    }

    /**
     * Show the page for editing of category
     */
    public function categoryEdit(Category $category)
    {
        return view('cpanel.articles.category-edit', compact('category'));
    }

    /**
     * Update or Create a category
     */
    public function categoryManage(Category $category, Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:64'
        ]);

        $category->name = $request->input('name');
        $category->is_active = $request->input('is_active', 0);
        if ($category->exists === false) {
            $maxPrior = Category::max('prior');
            $category->prior = $maxPrior ? $maxPrior + 1 : 1 ;
        }
        $category->save();
        return redirect()->route('content.article.category.edit', ['category'=>$category])
            ->with(['success' => __('Updated')]);
    }

    /**
     * Get the categories list
     */
    public function categoriesListForKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Category::query();

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
                        $query->where('name', 'like', '%'.trim($queryData['query_search']).'%');
                    });
            }
        }

        if (!empty($sortData)) {
            if (Schema::hasColumn('categories', $sortData['field'])) {
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
            'data'=> CategoryCollection::collection($pager)
        ]);
    }

    /**
     * Delete an article
     */
    public function categoryDelete(Category $category, Request $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category has been deleted.'
        ]);
    }

    /**
     * Moving categories and change `prior` field accordingly
     */
    public function categoryMovePrior(string $direction, string $ids,  Request $request)
    {
        list($id1, $id2) = explode('-', $ids);
        $cat1 = Category::where('prior', $id1)->first();
        $cat2 = Category::where('prior', $id2)->first();
        if (!isset($cat1) || !isset($cat2)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category has been moved'
            ]);
        }
        $prior = $cat1->prior;
        $cat1->prior = $cat2->prior;
        $cat2->prior = $prior;
        $cat1->save();
        $cat2->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Category has been moved'
        ]);
    }
}
