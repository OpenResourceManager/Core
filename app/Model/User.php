<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_identifier',
        'active',
        'name_prefix',
        'name_first',
        'name_middle',
        'name_last',
        'name_postfix',
        'name_phonetic',
        'username'
    ];

    public function rooms()
    {
        return $this->hasMany('App\Model\Room');
    }

    public function emails()
    {
        return $this->hasMany('App\Model\Email');
    }

    public function phones()
    {
        return $this->hasMany('App\Model\Phone');
    }
}
