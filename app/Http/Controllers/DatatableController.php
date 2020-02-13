<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPositions()
    {
        $positions = Position::query();
        return Datatables::of($positions)
            ->addColumn('action', function ($position) {
                return '<a href="'.route('positions.edit', $position->id).'"><span style="font-size: 2em; color: dimgrey" class="fa fa-edit"></span></a>
                        <a href="" data-id="'.route('positions.destroy', $position->id).'" data-toggle="modal" data-target="#exampleModal" class="btn-delete"><span style="font-size: 2em; color: dimgrey" class="fa fa-trash"></span></a>';
            })
            ->editColumn('updated_at', function ($position) {
                return $position->updated_at->format('d.m.y');
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployees()
    {
        $employees = Employee::query()->with(['position']);
        return Datatables::of($employees)
            ->addColumn('action', function ($employee) {
                return '<a href="'.route('employees.edit', $employee->id).'"><span style="font-size: 2em; color: dimgrey" class="fa fa-edit"></span></a>
                        <a href="" data-id="'.route('employees.destroy', $employee->id).'" data-toggle="modal" data-target="#exampleModal" class="btn-delete"><span style="font-size: 2em; color: dimgrey" class="fa fa-trash"></span></a>';
            })
            ->editColumn('position_id', function ($employee) {
                return $employee->position->name;
            })
            ->editColumn('date_of_employment', function ($employee) {
                return $employee->date_of_employment->format('d.m.y');
            })
            ->editColumn('phone', function ($employee) {
                return substr($employee->phone, 0, 4).' ('.substr($employee->phone, 4, 2).') '.substr($employee->phone, 6, 7);
            })
            ->make(true);
    }
}
