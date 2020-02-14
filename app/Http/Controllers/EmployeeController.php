<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Position;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create', [
            'positions' => Position::all(),
        ]);
    }

    /**
     * Process autocomplete ajax request.
     *
     * @param  Request  $request
     * @return string
     */
    public function find(Request $request)
    {
        $search = $request->get('term');
        $result = Employee::where('full_name', 'LIKE', "%{$search}%")
            ->limit(8)
            ->get();
        $resultArr = [];
        foreach ($result as $employee)
        {
            array_push($resultArr, $employee->full_name);
        }
        return Json::encode($resultArr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validatedData = $request->validated();
        $formatedData = EmployeeService::formatData($validatedData);
        $formatedData['photo'] = EmployeeService::uploadPhoto($validatedData['photo']);

        Employee::create([
            'photo' => $formatedData['photo'],
            'full_name' => $formatedData['fullName'],
            'phone' => $formatedData['phone'],
            'email' => $formatedData['email'],
            'salary' => $formatedData['salary'],
            'head' => $formatedData['head'],
            'date_of_employment' => $formatedData['date'],
            'position_id' => $formatedData['position']->id
        ]);

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
