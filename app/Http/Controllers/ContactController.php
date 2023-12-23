<?php

namespace App\Http\Controllers;

use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::where('user_id',Auth::id())->get();
        return view('contact.index')->with('contacts',$contacts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request -> validate([
            'first_name' => 'required|max:120',
            'last_name' =>'required',
            'phone_number' =>'required',
            'description'=>'required',
            'email'=>'required'
        ]);

        $contact = new Contact(
            [
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
                'email'=> $request->email
            ]
        );

        $contact -> save();

        return to_route('contact.index')->with('success','Contact Created successfully');

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
    public function  edit(Contact $contact)
    {
        //
        if ($contact -> user_id != Auth::id())
        {
            return abort(403);
        }
        return view('contact.edit')->with('contact',$contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Contact $contact,Request $request)
    {
        //
        if ($contact -> user_id != Auth::id())
        {
            return abort(403);
        }
        $request -> validate([
            'first_name' => 'required|max:120',
            'last_name' =>'required',
            'phone_number' =>'required',
            'description'=>'required',
            'email'=>'required'
        ]);

        $contact -> update(
            [
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
                'email'=> $request->email
            ]
        );
        $contacts = Contact::where('user_id',Auth::id())->get();
        return to_route('contact.index')->with('sucess','Note updated successfully');
    }
    public function upload(){

    }
    public function uploadIndex(){
        return view('contact.upload');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
