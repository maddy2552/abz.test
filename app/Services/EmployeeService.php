<?php

namespace App\Services;

use App\Employee;
use App\Position;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Self_;
use function foo\func;

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
        if($head === null){
            return null;
        }
        return Employee::findByNameFirst($head)->id;
    }

    private static function formatPosition($position)
    {
        return Position::find($position);
    }

    public static function uploadPhoto(UploadedFile $photo, $previousPhoto = null)
    {
        if($previousPhoto !== null)
        {
            if(File::exists(public_path('uploads/'.$previousPhoto)))
            {
                //удаляю предыдущее фото
                File::delete(public_path('uploads/'.$previousPhoto));
            }
        }

        // генерация нового имени для файла
        $photoName = Str::random().'.jpg';
        // уменьшение размера, преобразование в jpg, качетсво 80
        $photo = self::formatPhoto($photo);
        // сохраняю на сервере в качестве 80, формат jpg
        $photo->save(public_path() . '/uploads/'.$photoName, 80, 'jpg');

        return $photoName;
    }

    private static function formatPhoto(UploadedFile $photo)
    {
        // загрузка фото и автоповорот
        $photo = Image::make($photo->getPathname())->orientate();
        // уменьшаю размер до 300х300 по центру
        $photo->fit(300, 300, function (){}, 'center');

        return $photo;
    }

    public static function formatData($data)
    {
        $data['phone'] = self::formatPhone($data['phone']);
        $data['salary'] = self::formatSalary($data['salary']);
        $data['date_of_employment'] = self::formatDate($data['date']);
        $data['head'] = self::formatHead($data['head']);
        $data['position_id'] = self::formatPosition($data['position']);

        return $data;
    }
}
