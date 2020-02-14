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
