<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Get the Position that owns the Employee.
     */
    public function post()
    {
        return $this->belongsTo('App\Position');
    }
}
