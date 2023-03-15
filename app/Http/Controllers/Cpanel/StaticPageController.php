<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\StaticPage\EditRequest;
use App\Http\Requests\Cpanel\StaticPage\Request;
use App\Models\Language;
use App\Models\StaticPage;
use App\Models\StaticPageLocalization;

class StaticPageController extends Controller
{
    /**
     * Get the list of pages
     */
    public function list(Request $request)
    {
        $list = StaticPage::whereIsRoot()
            ->orderBy('_lft','ASC')
            ->get();

        return view('cpanel.static.list', compact('list'));
    }

    /**
     * Show form: Add a new page
     */
    public function add(Request $request)
    {
        $parent_id = $request->input('parent_id', null);
        $position  = $request->input('position', null);
        $langs = Language::active()->orderBy('sort','asc')->get();
        return view('cpanel.static.manage', compact('parent_id','position', 'langs'));
    }

    /**
     * Show form: edit page
     */
    public function edit(StaticPage $page)
    {
        $langs = Language::active()->orderBy('sort','asc')->get();
        return view('cpanel.static.manage', compact('page', 'langs'));
    }

    /**
     * Create a new page depending on request
     */
    public function create(EditRequest $request)
    {
        $postData = $request->all();
        if (!isset($postData['display'])) {
            $postData['display'] = 0;
        }
        $pageInsertionDone = false;
        $page_id = 0;
        do {
            $parent_id = $request->input('parent_id', null);
            $position  = $request->input('position', null);

            if (!isset($parent_id) || !is_numeric($parent_id) || empty($position) || !in_array($position, ['child','after'])) {
                break;
            }
            $parentPage = StaticPage::find($parent_id);
            if (!$parentPage) {
                break;
            }
            if ('child' === $position) {
                $newPage = $parentPage->children()->create($postData);
                $pageInsertionDone = true;
                $page_id = $newPage->id;
            } else
                if ('after' === $position) {
                    $newPage = new StaticPage($request->all());
                    if ($newPage->save()) {
                        $newPage->insertAfterNode($parentPage);
                        $pageInsertionDone = true;
                        $page_id = $newPage->id;
                    }
                }
        } while (false);

        if (!$pageInsertionDone) {
            $newPage = new StaticPage($postData);
            $newPage->save();
            $page_id = $newPage->id;
        }
        if ($page_id > 0) {
            $localModel = new StaticPageLocalization();
            $localModel->static_page_id = $page_id;
            $localModel->language_id = $request->input('language_id');
            $localModel->name = $request->input('name');
            $localModel->header = $request->input('header');
            $localModel->text = $request->input('text');
            $localModel->title = $request->input('title');
            $localModel->description = $request->input('description');
            $localModel->keywords = $request->input('keywords');
            $result = $localModel->save();
        }

        return response()->json([
            'status' => isset($result)&&$result ? 'success' : 'error',
            'page_id' => $page_id,
            'action' => 'create'
        ]);
    }


    /**
     * Update page
     */
    public function update(StaticPage $page, EditRequest $request)
    {
        $postData = $request->all();
        if (!isset($postData['display'])) {
            $postData['display'] = 0;
        }
        $page->fill($postData);
        $page->save();

        $localModel = StaticPageLocalization::updateOrCreate([
                'static_page_id' => $page->id, 'language_id' => $request->input('language_id')
            ], [
                'name' => $request->input('name'),
                'header' => $request->input('header'),
                'text' => $request->input('text'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords')
            ]);

        return response()->json([
            'status' => 'success',
            'page_id' => $page->id,
            'action' => 'update'
        ]);
    }

    /**
     * Sorting pages
     */
    public function sort(Request $request)
    {
        if ($request->newIndex < $request->oldIndex) {
            // insert before
            $draggedPageItem = StaticPage::find( $request->order[$request->newIndex] );
            $beforePageItem  = StaticPage::find( $request->order[$request->newIndex+1] );
            $result = $draggedPageItem->insertBeforeNode($beforePageItem);
        } else
            if ($request->newIndex > $request->oldIndex) {
                // insert after
                $draggedPageItem = StaticPage::find( $request->order[$request->newIndex] );
                $afterPageItem  = StaticPage::find( $request->order[$request->newIndex-1] );
                $result = $draggedPageItem->insertAfterNode($afterPageItem);
            }

        return response()->json([
            'status' => $result ? 'success' : 'error' ,
        ]);
    }

    /**
     * Getting child pages in response
     *
     * @param StaticPage $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function descendants(StaticPage $page)
    {
        $descendants = [];
        foreach ($page->descendants()->orderBy('_lft','ASC')->get() as $iter=>$item) {
            $descendants[$iter] = $item;

            $localizationItem = $item->staticPageLocalization()->whereHas('language', function ($query) {
                $query->where('languages.sort',1);
            })->first();
            $descendants[$iter]->name = $localizationItem->name;
            $descendants[$iter]->header = $localizationItem->header;
            $descendants[$iter]->linkBtnEdit = route('page.edit', ['page' => $item->id]);
            $descendants[$iter]->linkBtnDelete = route('page.delete', ['page' => $item->id]);
        }
        return response()->json([
            'status' => 'success',
            'descendants' => $descendants,
        ]);
    }

    /**
     * Remove the page
     *
     * @param StaticPage $page
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(StaticPage $page)
    {
        $page->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
