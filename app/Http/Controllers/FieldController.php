<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('field.index', ['fields' => Field::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('field.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFieldRequest $request)
    {
        Field::create($request->validated());
        return redirect()->route('fields.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        return view('field.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        return view('field.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        $field->update($request->validated());
        return redirect()->route('fields.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('fields.index');
    }
}
