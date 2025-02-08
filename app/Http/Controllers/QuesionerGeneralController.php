<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\QuesionerGeneral;
use App\Http\Requests\StoreQuesionerGeneralRequest;
use App\Http\Requests\UpdateQuesionerGeneralRequest;

class QuesionerGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    public function index()
    {
        $quesionerGenerals = QuesionerGeneral::all();
        return view('admin.qsgeneraltable', compact('quesionerGenerals'));
    }

    // Method untuk publik
    public function create()
    {
        return view('qsrangking.qs_general'); // Sesuaikan dengan view form publik
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuesionerGeneralRequest $request)
    {
        $validatedQUesionerData = $request->validated();

        QuesionerGeneral::create([
            'respondent_type' => $validatedQUesionerData['general_respondent_type'],
            'firstname' => $validatedQUesionerData['general_firstname'],
            'lastname' => $validatedQUesionerData['general_lastname'],
            'institution' => $validatedQUesionerData['general_institution'],
            'activity_name' => $validatedQUesionerData['general_activity_name'],
            'activity_date' => Carbon::createFromDate($validatedQUesionerData['general_activity_date'])->format('Y-m-d'),
            'country' => $validatedQUesionerData['general_country'],
            'email' => $validatedQUesionerData['email'],
            'phone' => $validatedQUesionerData['phone'],
            'survey_2023' => $validatedQUesionerData['general_survey2023'],
            'survey_2024' => $validatedQUesionerData['general_survey2024']
        ]);

        // return redirect(route('qs-general.index'));
        return redirect()->route('home')->with('success', 'Form submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuesionerGeneral $quesionerGeneral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuesionerGeneral $quesionerGeneral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuesionerGeneralRequest $request, QuesionerGeneral $quesionerGeneral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuesionerGeneral $quesionerGeneral)
    {
        //
    }
}
