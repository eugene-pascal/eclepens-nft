<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\Settings\LanguageRequest;
use App\Models\Language;
use App\Http\Requests\Cpanel\Settings\Request;

class LanguagesController extends Controller
{
    /**
     * Show the list of languages
     */
    public function list(Request $request)
    {
        $list = Language::query()
            ->orderBy('sort','ASC')
            ->get();
        return view('cpanel.settings.languages.list', compact('list'));
    }

    /**
     * Show the form for a new language to add
     */
    public function add(Request $request)
    {
        return view('cpanel.settings.languages.edit');
    }

    /**
     * Show the form for existed language to edit
     */
    public function edit(Language $lang, Request $request)
    {
        return view('cpanel.settings.languages.edit', compact('lang'));
    }

    /**
     * Update language
     */
    public function update(Language $lang, LanguageRequest $request)
    {
        $lang->lang_name = $request->input('lang_name');
        $lang->lang_code = $request->input('lang_code');
        $lang->is_active = $request->input('is_active',false);
        $lang->save();
        return redirect()->route('settings.languages')
            ->with(['success' => __('Successfully saved!')]);
    }
    /**
     * Create language
     */
    public function create(LanguageRequest $request)
    {
        $maxSort = (int)Language::max('sort');
        $lang = new Language;
        $lang->lang_name = $request->input('lang_name');
        $lang->lang_code = $request->input('lang_code');
        $lang->is_active = $request->input('is_active',false);
        $lang->sort = $maxSort + 1;
        $lang->save();
        return redirect()->route('settings.languages')
            ->with(['success' => __('Successfully added!')]);
    }

    /**
     * Remove language
     */
    public function delete(Language $lang)
    {
        $lang->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Sorting languages
     */
    public function sort(Request $request)
    {
        $orders = $request->input('order', []);
        $sortIndex = 0;
        foreach ($orders as $order) {
            Language::where('id', $order)->update(['sort' => ++$sortIndex]);
        }
        return response()->json([
            'status' => 'success'
        ]);
    }
}
