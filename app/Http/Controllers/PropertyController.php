<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Controllers\Controller;
use App\Property;
use App\PropertyType;
use App\SaleType;
use App\Suburb;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas   = Area::with('suburbs')->get();
        $suburbs = Suburb::all();
        $stypes  = SaleType::all();
        $ptypes  = PropertyType::all();

        $properties = Property::latest()->paginate(5);
        $properties->load('units', 'images', 'notes', 'owners');
        //dd($areas, $properties);
        return view('dashboard3', compact('properties', 'areas', 'suburbs', 'stypes', 'ptypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $areas   = Area::with('suburbs')->get();
        $suburbs = Suburb::all();
        $stypes  = SaleType::all();
        $ptypes  = PropertyType::all();

        $search_areas = $request->input('areas');

        //dd('search', $search, $request);

        if (sizeof($search_areas) > 0) {
            $properties = Property::latest()->whereIn('area_id', $search_areas)->paginate(5);
        } else {
            $properties = Property::latest()->paginate(5);
        }

        $properties->load('units', 'images', 'notes', 'owners');
        //dd($areas, $properties);
        return view('dashboard3', compact('properties', 'areas', 'suburbs', 'stypes', 'ptypes'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $areas   = Area::with('suburbs')->get();
        $suburbs = Suburb::all();
        $stypes  = SaleType::all();
        $ptypes  = PropertyType::all();

        $property = Property::find($id);
        $property->load('units', 'images', 'notes', 'owners');
        //dd($property);
        return view('showproperty', compact('property', 'areas', 'suburbs', 'stypes', 'ptypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
