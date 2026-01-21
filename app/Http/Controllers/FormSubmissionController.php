<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Formsubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Formsubmission::with('form')->paginate(10);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('submission.partials.submissions-table', compact('submissions'))->render(),
                'pagination' => $submissions->links('pagination::bootstrap-5')->toHtml(),
                'hasMorePages' => $submissions->hasMorePages(),
                'current_page' => $submissions->currentPage(),
                'per_page' => $submissions->perPage(),
                'total' => $submissions->total()
            ]);
        }

        return view('submission.index', ['submissions' => $submissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Form $form)
    {
        return view('submission.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Form $form)
    {
        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        $data = [];
        foreach ($form->fields as $field) {
            $data[$field->label] = $validated['data'][$field->id] ?? null;
        }

        Formsubmission::create([
            'form_id' => $form->id,
            'data' => json_encode($data),
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Formsubmission $submission)
    {
        $submission->load('form.fields');

        return view('submission.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formsubmission $submission)
    {
        $submission->load('form.fields');

        return view('submission.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formsubmission $submission)
    {
        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        $data = [];
        foreach ($submission->form->fields as $field) {
            $data[$field->label] = $validated['data'][$field->id] ?? null;
        }

        $submission->update(['data' => json_encode($data)]);

        return redirect()->route('submissions.show', $submission)->with('success', 'Submission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formsubmission $submission)
    {
        $submission->delete();

        return redirect()->route('forms.show', $submission->form)->with('success', 'Submission deleted successfully!');
    }
}
