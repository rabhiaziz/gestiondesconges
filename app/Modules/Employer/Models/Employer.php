<?php

namespace App\Modules\Employer\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model {
    //
    public $timestamps = true;

    protected $table = 'employers';

    protected $fillable = [
        'name',
        'role_id'
    ];

    public function role()
    {
        return $this->hasOne('App\Modules\Employer\Models\Role', 'id', 'role_id');
    }

    public function Vacations()
    {
        return $this->hasMany('App\Modules\Vacation\Models\Vacation', 'employer_id', 'id');
    }
}
