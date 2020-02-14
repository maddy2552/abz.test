<?php

namespace App\Services;

use App\Employee;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EmployeeService
{
    private static function formatPhone($phone)
    {
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = trim($phone);
        return $phone;
    }

    private static function formatSalary($salary)
    {
        $salary = str_replace('.', '', $salary);
        return (int)$salary;
    }

    private static function formatDate($date)
    {
        $date = Carbon::parse($date)->format('Y-m-d');
        return $date;
    }

    private static function formatHead($head)
    {
        return Employee::findByName($head)->id;
    }

    private static function formatPosition($position)
    {
        return Position::find($position);
    }

    public static function uploadPhoto(UploadedFile $photo)
    {
        $photoName = Str::random().'.'.$photo->getClientOriginalExtension();
        $photo->move(public_path() . '/uploads/', $photoName);
        return $photoName;
    }

    public static function formatData($data)
    {
        $data['phone'] = self::formatPhone($data['phone']);
        $data['salary'] = self::formatSalary($data['salary']);
        $data['date'] = self::formatDate($data['date']);
        $data['head'] = self::formatHead($data['head']);
        $data['position'] = self::formatPosition($data['position']);

        return $data;
    }
}
