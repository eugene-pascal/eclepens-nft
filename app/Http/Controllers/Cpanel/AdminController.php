<?php

namespace App\Http\Controllers\Cpanel;

use App\Enums\UserStatus;
use App\Http\Requests\Cpanel\Admin\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the list
     */
    public function list(Request $request)
    {
        $employeesList = User::orderBy('id','DESC')->paginate(15);
        $constants = UserStatus::class;
        return view('cpanel.admin.list', compact('employeesList','constants'));
    }

    /**
     * Show form for adding of new employee
     */
    public function add(Request $request)
    {
        $constants = UserStatus::class;
        $rolesArr = [];
        return view('cpanel.admin.add', compact('constants', 'rolesArr'));
    }

    /**
     * Create account
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);

        $data = $request->except(['password_confirmation', 'status','role']);
        $data = array_map(function($v){
                return (is_null($v)) ? '' : $v ;
            }, $data);

        $employee = new User($data);
        $employee->password = Hash::make($request->password);
        $employee->status = !empty($request->status) ? UserStatus::ACTIVE : UserStatus::INACTIVE ;
        $employee->save();

        return redirect()->route('employees.manage', ['employee'=>$employee, 'tab'=>'personal'])
            ->with(['success' => 'Successfully created !']);
    }

    /**
     * Show form for management of employee
     */
    public function manage(User $employee, Request $request)
    {
        $constants = UserStatus::class;
        $rolesArr = [];
        return view('cpanel.admin.manage', compact('employee','constants','rolesArr'));
    }

    /**
     *  Update account
     */
    public function update(User $employee, Request $request)
    {
        if ('personal' === $request->tab) {
            $employee->status = !empty($request->status) ? UserStatus::ACTIVE : UserStatus::INACTIVE ;
            $this->validate($request, [
                'name' => 'required|min:6',
            ]);
            $data = $request->except(['password', 'status', 'email', 'remember_token']);
            $data = array_map(function($v){
                    return (is_null($v)) ? '' : $v ;
                }, $data);
            $employee->fill($data);
            $employee->save();
        }
        elseif ('password' === $request->tab) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
            ]);
            $employee->password = Hash::make($request->password);
            $employee->save();
        } 
        elseif ('role' === $request->tab) {
            $this->validate($request, [
                'role' => 'required',
            ]);
            $doesItNeedToAdd = true;
            if ($employee->roles->count()) {
                foreach ($employee->roles->pluck('name','id') as $roleId => $roleName) {
                    if ($request->role == $roleName) {
                        $doesItNeedToAdd = false;
                    } else {
                        $employee->removeRole($roleName);
                    }
                }
            }
            if ($doesItNeedToAdd) {
                $employee->assignRole( $request->role );
            }
        }

        return redirect()->route('employees.manage', ['employee'=>$employee,] + ($request->tab ? ['tab'=>$request->tab] : [] ) )
            ->with(['success' => 'Successfully saved!']);
    }

    /**
     * Delete employee
     */
    public function delete(User $employee)
    {
        if (User::count()<=1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Last account cannot be removed !'
            ]);
        }
        $employee->delete();
        return response()->json([
            'status' => 'success'
        ]);
    } 

    /**
     * Match email If exist return true
     */
    public function matchEmail(Request $request)
    {
        $isEmailExist = (bool)User::where('email',$request->email)->count();
        return response()->json([
            'valid' => !$isEmailExist
        ]);
    }
}
