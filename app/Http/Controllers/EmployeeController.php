<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Position;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $names = Employee::findByNameAsArr($search, 8);
        return Json::encode($names);
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

        if(Employee::checkHierarchy($formatedData['head']) >= 5)
        {
            $request->session()->flash('error', 'Maximum submission level is 5.');
            return redirect()->route('employees.create')->withInput();
        }

        Employee::create([
            'photo' => $formatedData['photo'],
            'full_name' => $formatedData['fullName'],
            'phone' => $formatedData['phone'],
            'email' => $formatedData['email'],
            'salary' => $formatedData['salary'],
            'head' => $formatedData['head'],
            'date_of_employment' => $formatedData['date_of_employment'],
            'position_id' => $formatedData['position_id']->id
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
        $employee = Employee::with(['position', 'chief'])->find($id);
        $positions = Position::all();
        return view('employees.edit', [
            'employee' => $employee,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeRequest $request, $id)
    {
        $validatedData = $request->validated();
        $employee = Employee::find($id);
        $formatedData = EmployeeService::formatData($validatedData);

        if($employee->id === $formatedData['head'])
        {
            $request->session()->flash('error', 'You cannot set yourself as the head.');
            return redirect()->route('employees.edit', $id);
        }

        $iLevel = Employee::checkHierarchy($formatedData['head']) + Employee::checkHierarchyReverse($employee->id);

        if($iLevel >= 5)
        {
            $request->session()->flash('error', 'Maximum submission level is 5.');
            return redirect()->route('employees.edit', $id)->withInput();
        }


        $formatedData['photo'] = EmployeeService::uploadPhoto($validatedData['photo'], $employee->photo);

        $employee->update([
            'photo' => $formatedData['photo'],
            'full_name' => $formatedData['fullName'],
            'phone' => $formatedData['phone'],
            'email' => $formatedData['email'],
            'salary' => $formatedData['salary'],
            'head' => $formatedData['head'],
            'date_of_employment' => $formatedData['date_of_employment'],
            'position_id' => $formatedData['position_id']->id
        ]);


        $employee->update([$formatedData]);

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if(File::exists(public_path('uploads/'.$employee->photo)))
        {
            File::delete(public_path('uploads/'.$employee->photo));
        }
        $employee->delete();
        return redirect()->route('employees.index');
    }
}
