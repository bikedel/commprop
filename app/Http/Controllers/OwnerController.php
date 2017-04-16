<?php

namespace App\Http\Controllers;

use App\Area;
use App\Contact;
use App\ContactType;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Owner;
use App\OwnershipType;
use App\Property;
use App\PropertyType;
use App\SaleType;
use App\Status;
use App\Suburb;
use App\User;
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

        $owners = Contact::latest()->paginate(25);

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

        $types   = $types->keyBy('id');
        $contact = Contact::find($id);

        $owners = Owner::where('contact_id', '=', $contact->id)->get();

        $p = [];
        //   echo $owners->count() . 'properties...' . '<br>';
        foreach ($owners as $owner) {
            //  echo 'o ' . $owner->property_id . ' ' . $owner->unit_id . ' ' . $types[$owner->contact_type_id]->name . '<br>';
            array_push($p, $owner->property_id);
        }

        $properties = Property::find($p); // returns a collection of models

        //dd($props, $p, $properties);

        $username = Auth::user()->name;
        activity("Contacts")->withProperties(['contact' => $id])->log('Show Properties ');

        $users        = User::all();
        $areas        = Area::all();
        $grades       = Grade::all();
        $suburbs      = Suburb::all();
        $stypes       = SaleType::all();
        $ptypes       = PropertyType::all();
        $statuses     = Status::all();
        $contacts     = Contact::all();
        $contacttypes = ContactType::all();
        $ownerships   = OwnershipType::all();

        $users        = $users->keyBy('id');
        $statuses     = $statuses->keyBy('id');
        $grades       = $grades->keyBy('id');
        $stypes       = $stypes->keyBy('id');
        $ptypes       = $ptypes->keyBy('id');
        $suburbs      = $suburbs->keyBy('id');
        $contacts     = $contacts->keyBy('id');
        $contacttypes = $contacttypes->keyBy('id');
        $ownerships   = $ownerships->keyBy('id');

        // $properties = Property::latest()->paginate(25);
        $properties->load('units', 'images', 'notes', 'owners');
        //dd($areas, $properties);
        return view('dashboard.contactproperty', compact('properties', 'areas', 'suburbs', 'stypes', 'ptypes', 'ownerships', 'contact'));

    }
}
