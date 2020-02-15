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

    public static $iLevel = 0;

    /**
     * Get the Position that owns the Employee.
     */
    public function position()
    {
        return $this->belongsTo('App\Position')->withDefault([
            'name' => 'Not set.'
        ]);
    }

    public function chief()
    {
        return $this->belongsTo('App\Employee', 'head');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee', 'head', 'id');
    }

    public static function findByNameFirst($name)
    {
        return Employee::where('full_name', '=', trim($name))->first();
    }

    public static function checkIerarchy($emplId)
    {
        dd(Employee::find($emplId)->chief);
        if($emp !== null)
        {
            self::$iLevel++;
            self::checkIerarchy($emp->head);
        }
        else
        {
            return self::$iLevel;
        }
    }

    public static function findByNameAsArr(string $name, int $limit)
    {
        $result = Employee::where('full_name', 'LIKE', "%{$name}%")
            ->limit($limit)
            ->get();

        $foundNames = [];
        foreach ($result as $employee)
        {
            array_push($foundNames, $employee->full_name);
        }

        return $foundNames;
    }
}
