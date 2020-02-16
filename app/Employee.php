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
    public static $count = 0;
    public static function checkIerarchy($emplId)
    {
        $emp = Employee::find($emplId);
        if($emp->head !== null)
        {
            self::$count++;
            dump(self::$count);
            self::checkIerarchy($emp->head);
        }
        return self::$count;
    }

    public static $ierar = 0;
    public static function checkReverse($emplId)
    {
        $emp = Employee::where('head', '=', $emplId)->get();
        $emp->each(function ($employee, $key) {
            self::$ierar++;
            dump(self::$ierar);
            self::checkReverse($employee->id);
        });

        return self::$ierar;
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
