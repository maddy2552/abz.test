<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionRequest $request)
    {
        $validatedData = $request->validated();
        Position::create([
            'name' => $validatedData['name'],
        ]);
        return redirect()->route('positions.index');
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
        $position = Position::findOrFail($id);
        return view('positions.edit', ['position' => $position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StorePositionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePositionRequest $request, $id)
    {
        $validatedData = $request->validated();
        Position::find($id)->update(['name' => $validatedData['name']]);
        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::destroy($id);
        return redirect()->route('positions.index');
    }
}
