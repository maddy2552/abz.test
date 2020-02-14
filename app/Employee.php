<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'photo',
        'phone',
        'position_id',
        'salary',
        'date_of_employment',
        'head'
    ];

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

    public static function findByName($name)
    {
        return Employee::where('full_name', '=', trim($name))->first();
    }
}
