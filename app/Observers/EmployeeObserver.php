<?php

namespace App\Observers;

use App\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    /**
     * Handle the employee "created" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "creating" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function creating(Employee $employee)
    {
        $employee->admin_created_id = Auth::user()->id;
        $employee->admin_updated_id = Auth::user()->id;
    }

    /**
     * Handle the employee "updated" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "updating" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function updating(Employee $employee)
    {
        $employee->admin_updated_id = Auth::user()->id;
    }

    /**
     * Handle the employee "deleted" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "deleting" event.
     * Переподчинение сотрудников
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function deleting(Employee $employee)
    {
        // Нахожу всех подчиненных удаляемого сотрудника.
        $employees = Employee::where('head', '=', $employee->id)->get();
        // Если таковых не имеется - ничего не делаю.
        if($employees->isNotEmpty())
        {
            // Нахожу начальника удаляемого сотрудника
            $employeeHead = Employee::find($employee->head);

            // Прохожу по каждому подчиненному удаляемого сотрудника
            $employees->each(function ($employee, $key) use ($employeeHead){
                // Если у удаляемого сотрудника есть начальник, то даю ему в подчинение подчиненных удаляемого сотрудника
                // Если начальника нет - ставлю поле "head" подчиненных в null
                if($employeeHead !== null)
                {
                    // Проверка, чтобы не назначить сотрудника начальником самого себя
                    $employee->update([
                        'head' => ($employee->id !== $employeeHead->id) ? $employeeHead->id : null
                    ]);
                }
                else
                {
                    $employee->update([
                        'head' => null,
                    ]);
                }
            });
        }
    }

    /**
     * Handle the employee "restored" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     *
     * @param  \App\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
