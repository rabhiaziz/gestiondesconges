<?php

namespace App\Modules\Employer\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    //
    public $timestamps = true;

    protected $table = 'roles';

    protected $fillable = [
        'role',
    ];

   /* public function employer()
    {
        return $this->belongsTO('App\Modules\Employer\Models\Employer', 'role_id', 'id');
    }*/
}
