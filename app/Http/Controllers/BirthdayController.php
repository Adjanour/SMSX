<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use App\Models\Contact;
use App\Models\MessageTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BirthdayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $birthdays = Birthday::where('user_id',Auth::id())->get();
        return view('birthday.index')->with('birthdays',$birthdays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //retrieve needed resources
        $contacts = Contact::where('user_id',Auth::id())->get();
        $messageTemplates = MessageTemplates::where('user_id',Auth::id())->get();

        return view('birthday.create')->with('contacts',$contacts)->with('message_templates',$messageTemplates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'contact' => 'required',
            'message_template' => 'required',
            'date_of_birth' => 'required|date',
        ]);

        Birthday::create([
            'user_id'=>Auth::id(),
            'contact_id' => $request->input('contact'),
            'message_template' => $request->input('message_template'),
            'birth_date' => $request->input('date_of_birth'),
        ]);

        return redirect()->route('birthdays.index')->with('message', 'Birthday added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
