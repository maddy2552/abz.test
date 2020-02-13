<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'admin_created_id', 'admin_updated_id'
    ];

    /**
     * Get the Employees for the Position.
     */
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    /**
     * Get the User who created the Position.
     */
    public function createdUser()
    {
        return $this->belongsTo('App\User', 'admin_created_id');
    }

    /**
     * Get the User who updated the Position.
     */
    public function updatedUser()
    {
        return $this->belongsTo('App\User', 'admin_updated_id');
    }
}
