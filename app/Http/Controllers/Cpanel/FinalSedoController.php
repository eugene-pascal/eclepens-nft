<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\FinalSedo\CredentialRequest;
use App\Http\Requests\Cpanel\FinalSedo\Request;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Resources\Cpanel\FinalSedo\CredentialsCollection;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Models\FinalSedoCredential;

class FinalSedoController extends Controller
{
    /**
     * Get the list of credentials
     */
    public function credentialsList(Request $request)
    {
        return view('cpanel.finalsedo.credentials', []);
    }

    /**
     *
     */
    public function credentialAdd(Request $request)
    {
        return view('cpanel.finalsedo.credential_edit');
    }

    /**
     *
     */
    public function credentialsListKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $query = FinalSedoCredential::orderBy('id','DESC');

        $onPage = intval($request->pagination['perpage'] ?? 20);
        $pager = $query->paginate($onPage);
        if ($request->page && $pager->isEmpty()) {
            $pager = $query->paginate($onPage, ['*'], 'page', 1);
        }

        return response()->json( [
            'meta'=> new KDTablePaginationCollection($pager),
            'data'=> CredentialsCollection::collection($pager)
        ]);
    }


    /**
     *
     */
    public function credentialEdit(FinalSedoCredential $credential, Request $request)
    {
        return view('cpanel.finalsedo.credential_edit', compact('credential'));
    }

    /**
     *
     */
    public function credentialUpdate(FinalSedoCredential $credential, CredentialRequest $request)
    {
        $data = $request->except(['extra', 'is_active']);
        $data = array_map(function($v){
            return (is_null($v)) ? '' : $v ;
        }, $data);
        $credential->fill($data);
        $credential->is_active = $request->input('is_active',false);
        $credential->save();
        return redirect()->route('finalsedo.credential.edit', ['credential'=>$credential->id])
            ->with(['success' => __('Successfully saved!')]);
    }

    /**
     * Create language
     */
    public function credentialCreate(CredentialRequest $request)
    {
        $credential = new FinalSedoCredential();
        $credential->username = $request->input('username');
        $credential->password = $request->input('password');
        $credential->partnerid = $request->input('partnerid');
        $credential->signkey = $request->input('signkey');
        $credential->is_active = $request->input('is_active',false);
        $credential->save();
        return redirect()->route('finalsedo.credentials.list')
            ->with(['success' => __('Successfully added!')]);
    }

    /**
     * Remove
     */
    public function credentialDelete(FinalSedoCredential $credential)
    {
        $credential->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
