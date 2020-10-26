<?php

namespace App\Http\Controllers;

use Fcp\AnimalBreedsSearch\AnimalBreedsSearchFacades;
use Fcp\AnimalBreedsSearch\Models\Breed;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request                   $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $animalType = $request->get('animal_type');
        $breed = $request->get('breed');

        $breeds = AnimalBreedsSearchFacades::search($animalType, $breed);

        return response()->json(['breeds' => $breeds]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Breed         $breed
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breed = AnimalBreedsSearchFacades::find($id);
        return response()->json($breed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Breed         $breed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Breed $breed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Breed         $breed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breed $breed)
    {
        //
    }
}
