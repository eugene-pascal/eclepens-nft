<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Node\Scalar\String_;

class User extends Authenticatable
{
    use Notifiable;

    /** 
     * @const
     */
    const SESSION_LIVE = 36000;

    /**
     * @var string
     */
    protected $type = 'admin';

    /**
     * @var string 
     * @static
     */
    protected static $sessionKey;

    /**
     * table name
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Getting session key
     * @return string
     */
    public function getSessionKey()
    {
        if (!isset($this->id)) {
            return '';
        }
        if (!empty(self::$sessionKey)) {
            return self::$sessionKey;
        }
        $pool = "azpoxslkcdiuvfjmbgnhqiruwyetPDSOLAKZMXNCBVJDHFGYQTWRE0291837465!~`)@(#*$&%^,<>?;:]}[{|";
        self::$sessionKey = $this->name."|".time().'.';
        while (strlen(self::$sessionKey)<100) {
            self::$sessionKey.= $pool[rand(0,(strlen($pool)-1))];
        }
        return self::$sessionKey;
    }

    /**
     * @static
     * @return string
     */
    public static function sessionName()
    {
        return 'sessionlp';
    }

    /**
     * @return String
     */
    public function getFullName():String
    {
        return $this->name;
    }

    /**
     * Set access type
     */
    public function setAccessType($type)
    {
        $this->type = $type;
    }

    /**
     * Get access type
     */
    public function getAccessType():string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isAdmin():bool
    {
        return $this->type === \Config::get('constants.session.type.admin');
    }

    /**
     * @return bool
     */
    public function isMember():bool
    {
        if (isset($this->type_account)) {
            return $this->type_account === \Config::get('constants.session.type.member');
        }
        return $this->type === \Config::get('constants.session.type.member');
    }

    /**
     * @return bool
     */
    public function isPartner():bool
    {
        if (isset($this->type_account)) {
            return $this->type_account === \Config::get('constants.session.type.partner');
        }
        return $this->type === \Config::get('constants.session.type.partner');
    }

    /**
     * @param $permArr
     * @return bool
     */
    public function checkPermissions($permArr):bool
    {
        return in_array($this->type, $permArr);
    }
}
