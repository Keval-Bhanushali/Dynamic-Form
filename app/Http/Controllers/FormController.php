<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Field;
use App\Models\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('form.index', ['forms' => Form::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormRequest $request)
    {
        $form = Form::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->fields) {
            foreach ($request->fields as $fieldData) {
                $field = Field::create([
                    'label' => $fieldData['label'],
                    'type' => $fieldData['type'],
                ]);
                $form->fields()->attach($field->id, ['is_required' => $fieldData['is_required']]);
            }
        }

        return redirect()->route('forms.show', $form)->with('success', 'Form created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $form->load(['fields', 'submissions']);

        return view('form.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $form->load('fields');
        $fields = $form->fields->map(function ($field) {
            return [
                'label' => $field->label,
                'type' => $field->type,
                'is_required' => $field->pivot->is_required,
            ];
        })->toArray();

        return view('form.edit', compact('form', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        $form->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Remove existing fields
        $form->fields()->detach();

        // Add new fields
        if ($request->fields) {
            foreach ($request->fields as $fieldData) {
                $field = Field::create([
                    'label' => $fieldData['label'],
                    'type' => $fieldData['type'],
                ]);
                $form->fields()->attach($field->id, ['is_required' => $fieldData['is_required']]);
            }
        }

        return redirect()->route('forms.show', $form)->with('success', 'Form updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();

        return redirect()->route('forms.index')->with('success', 'Form deleted successfully!');
    }
}
