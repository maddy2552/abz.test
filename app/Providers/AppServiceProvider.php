<?php

namespace App\Providers;

use App\Employee;
use App\Observers\EmployeeObserver;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Observers\PositionObserver;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Position::observe(PositionObserver::class);
        Employee::observe(EmployeeObserver::class);

        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            // убрал из строки все "+()" и пробелы
            $value = str_replace('+', '', $value);
            $value = str_replace('(', '', $value);
            $value = str_replace(')', '', $value);
            $value = str_replace(' ', '', $value);

            // проверка, числовое ли значение
            if(!is_numeric($value)) {
                return false;
            }

            // проверка на длинну значения, длинна передается параметром (пример: phone:12, 12 - длинна номера, которая должна быть)
            if(iconv_strlen($value) !== (int)$parameters[0]) {
                return false;
            }

            // проверка на вхождение "380" в начале строки
            if(!preg_match('/^380\d+/', $value)) {
                return false;
            }

            return true;
        });

        Validator::extend('head', function ($attribute, $value, $parameters, $validator) {
            if($value === null)
            {
                return true;
            }
            else
            {
                $result = Employee::findByNameFirst($value);

                if ($result === null) {
                    return false;
                }
                return true;
            }
        });
    }
}
