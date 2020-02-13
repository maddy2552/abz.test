<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'date_of_employment'];

    /**
     * Get the Position that owns the Employee.
     */
    public function position()
    {
        return $this->belongsTo('App\Position');
    }
}
