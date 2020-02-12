<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $positions = Position::query();
        return Datatables::of($positions)
            ->addColumn('action', function ($position) {
                return '<a href="'.route('positions.edit', $position->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button data-id="'.route('positions.destroy', $position->id).'" data-toggle="modal" data-target="#exampleModal" class="btn btn-xs btn-danger btn-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })

            ->editColumn('updated_at', function ($position) {
                return $position->updated_at->format('d.m.y');
            })
            ->make(true);
    }
}
