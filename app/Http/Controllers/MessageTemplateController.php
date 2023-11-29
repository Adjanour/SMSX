<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplates;
use App\Models\MessageVariable;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('message-template.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $message_variables = MessageVariable::where('user_id',Auth::id())->get();
        return view('message-template.create')->with('message_variables',$message_variables);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'templateName' => 'required',
            'content'=>'required|max:120'
        ]);
        $messageTemplate = new MessageTemplates(
            [
                'user_id'=>Auth::id(),
                'title'=>$request->templateName,
                'content'=> $request->content,
            ]
        );
        $messageTemplate -> save();

        return to_route('templates.create')->with('success','Template Created successfully')->with('message','Template created successfully');
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
