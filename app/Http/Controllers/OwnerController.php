<?php

namespace App\Http\Controllers;

use App\Area;
use App\Contact;
use App\ContactType;
use App\Http\Controllers\Controller;
use App\Owner;
use App\Property;
use App\PropertyType;
use App\SaleType;
use Auth;
use Illuminate\Http\Request;

class OwnerController extends Controller
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

        $username = Auth::user()->name;
        activity("Dashboard")->withProperties(['user' => $username])->log('Contacts ');
        $areas  = Area::all();
        $stypes = SaleType::all();
        $ptypes = PropertyType::all();

        $owners = Contact::latest()->paginate(10);

        //dd($property);
        return view('dashboard.contacts', compact('owners', 'areas', 'stypes', 'ptypes'));
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

        $areas  = Area::all();
        $stypes = SaleType::all();
        $ptypes = PropertyType::all();

        $property = Property::find($id);
        $property->load('units', 'images', 'notes', 'owners');

        $username = Auth::user()->name;
        activity("Property")->withProperties(['user' => $username, 'erf' => $property->erf])->log('Show ');

        return view('showproperty', compact('property', 'areas', 'stypes', 'ptypes'));
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

    // list contacts with properties
    public function contactProp($id)
    {

        $types = ContactType::all();

        $types = $types->keyBy('id');
        $props = Contact::find($id);

        $owners = Owner::where('contact_id', '=', $props->id)->get();

        echo $owners->count() . 'properties...' . '<br>';
        foreach ($owners as $owner) {
            echo 'o ' . $owner->property_id . ' ' . $owner->unit_id . ' ' . $types[$owner->contact_type_id]->name . '<br>';
        }

        dd($props, $props->properties);
    }
}
