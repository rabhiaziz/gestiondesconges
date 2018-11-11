<?php

namespace App\Modules\Vacation\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model {

    //
    public $timestamps = true;

    protected $table = 'vacations';

    protected $dates = ['start_date','end_date'];

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'comment',
        'employer_id'
    ];


    public function employer()
    {
        return $this->belongsTO('App\Modules\Employer\Models\Employer', 'employer_id', 'id');
    }

}
