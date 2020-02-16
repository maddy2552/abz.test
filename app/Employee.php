<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public static $count = 0;

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

    public static function checkHierarchy($emplId)
    {
        if($emplId === null){
            return 0;
        }
        $emp = Employee::find($emplId);
        if($emp->head !== null)
        {
            self::$count++;
            self::checkHierarchy($emp->head);
        }
        return self::$count;
    }

    public static function checkHierarchyReverse($emplId)
    {
        if($emplId === null) {
            return 0;
        }
        if($emp = Employee::where('head', '=', $emplId)->get()) {
            $result = [0];
            $emp->each(function ($employee, $key) use (&$result){
                $result[] = 1 + self::checkHierarchyReverse($employee->id);
            });
            return max($result);
        }
        else return 0;
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
