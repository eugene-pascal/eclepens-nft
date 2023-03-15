<?php

namespace App\Components;

use App\Models\Member;
use DB;
use Cookie;
use App\Models\User;

class AuthUser
{
    /**
     * @var bool
     */
    private $_isAuthorized = false;

    /**
     * @var App/Models/User
     */
	private $_user;

    public function __construct()
    {
        $session_key = Cookie::get(User::sessionName());
        if (empty($session_key)) {
            $this->_isAuthorized = false;
        } else {
            do {
                $row = DB::table('users_session')
                     ->where('session_key', '=', $session_key)
                     ->where('session_time', '>', time() - User::SESSION_LIVE)
                     ->first();
                if (empty($row) || !$row instanceof \stdClass) {
                    $this->_isAuthorized = false;
                    break;
                }

                $memberTypes = [
                    \Config::get('constants.session.type.member'),
                    \Config::get('constants.session.type.partner')
                ];

                if (isset($row->type) && in_array($row->type, $memberTypes)) {
                    $this->_user = Member::find($row->id); //
                    $this->_user->setAccessType($row->type);
                } else {
                    $this->_user = User::find($row->id);
                    $this->_user->setAccessType($row->type);
                }
                if (isset($this->_user)) {
                    $this->_isAuthorized = true;
                }
            } while(0);
        }
    }

    /**
     * Check if user is authorized
     * @return bool
     */
    public function check()
    {
    	return $this->_isAuthorized;
    }

    /**
     * Get Eloquent model of current user
     * @return App/Models/User
     */
    public function user()
    {
    	return $this->_user;
    }

    /**
     * Check if user is guest
     * @return bool
     */
    public function guest()
    {
        return !$this->_isAuthorized;
    }
}