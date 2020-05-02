<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotesRequest;
use App\Notes;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psy\Util\Json;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (object)[
            'error' => null,
            'notes' => []
        ];
        try{
            $data->notes =Notes::orderBy('id','DESC')->get();
            return response()->json($data);
        }
        catch (Exception $e){
            $data->error = $e;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotesRequest $request)
    {
        $data = (object)[
            'error' => null,
            'note' => []
        ];
        try {
            $newNote = Notes::create($request->all());
            $data->note = $newNote;
            return response()->json($data);
        }
        catch (\Exception $error) {
            $data->error ="Error lors de la creation";
            return response()->json($data->error,"404");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function show(Notes $notes, $id)
    {
        $data = (object)[
            'error' => null,
            'notes' => []
        ];
        try{
            $data->notes =Notes::findOrFail($id);
            return response()->json($data);
        }
        catch (\Exception $e){
            $data->error = "Cet identifiant est inconnu";
            return response()->json($data,"404");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function edit(Notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function update(NotesRequest $request, $id)
    {
        $data = (object)[
            'error' => null,
            'notes' => []
        ];
        try{
            $data->notes =Notes::findOrFail($id)->update($request->all());
            $data->notes = Notes::findOrFail($id);
            return response()->json($data);
        }
        catch (Exception $e ){
            $data->error = "Cet identifiant est inconnu";
            return response()->json($data,"404");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notes $notes,$id)
    {
        $data = (object)[
            'error' => null,
            'notes' => []
        ];
        try{
            Notes::findOrFail($id)->delete();
        }
        catch (\Exception $e){
            $data->error = "Cet identifiant est inconnu";
            return response()->json($data,"404");
        }
    }
}
