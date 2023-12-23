<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('contact.upload');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('upload');
        $filePath = $file->store('uploads');
        echo $filePath;

        $array = $this->readData(storage_path("app/{$filePath}"));

        var_dump($array);

        try {
            $userId = Auth::id(); // Capture user ID here

            for ($count = 1; $count < count($array); $count++) {
                $userData = explode(';', $array[$count][0]);
                $this->saveContact($userId, $userData);
            }
        } catch (\Exception $e) {
            return redirect()->route('upload.index')->with('error', $e->getMessage());
        }

        return redirect()->route('upload.index')->with('message', 'File uploaded successfully');
    }

    public function saveContact($userId, $contactData)
    {
        $contact = new Contact([
            'user_id' => $userId,
            'first_name' => $contactData[0],
            'last_name'=> $contactData[0],
            'phone_number' => $contactData[1],
        ]);

        $contact->save();
    }



    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
    public function readData ($filePath): array
    {
        $file = fopen($filePath, 'r');
        $data = fgetcsv($file, 1000, ";");
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }
        fclose($file);
        return $array;
    }
    public function retrieveDetails($array,$keys): array
    {
        $array2 = array();
        foreach($array as $key => $value){
            $array2[] =  $value[$keys] ;
        }
        return $array2;
    }

}
