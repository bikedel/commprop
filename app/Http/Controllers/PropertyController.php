<?php

namespace App\Http\Controllers;

use App\Area;
use App\Contact;
use App\ContactType;
use App\Grade;
use App\Http\Controllers\Controller;
use App\OwnershipType;
use App\Property;
use App\PropertyType;
use App\SaleType;
use App\Status;
use App\Suburb;
use App\User;
use Auth;
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

        $username = Auth::user()->name;
        activity("Dashboard")->withProperties(['user' => $username])->log('Property ');

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

        $properties = Property::latest()->paginate(25);
        $properties->load('units', 'images', 'notes', 'owners');
        //dd($areas, $properties);
        return view('dashboard.property', compact('properties', 'areas', 'suburbs', 'stypes', 'ptypes', 'ownerships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $username = Auth::user()->name;
        activity("Dashboard")->withProperties(['user' => $username])->log('Property search ');
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
        return view('dashboard.property', compact('properties', 'areas', 'suburbs', 'stypes', 'ptypes'));
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

        $users        = User::all();
        $areas        = Area::all();
        $grades       = Grade::all();
        $suburbs      = Suburb::all();
        $stypes       = SaleType::all();
        $ptypes       = PropertyType::all();
        $statuses     = Status::all();
        $contacts     = Contact::all();
        $contacttypes = ContactType::all();

        $users        = $users->keyBy('id');
        $statuses     = $statuses->keyBy('id');
        $grades       = $grades->keyBy('id');
        $stypes       = $stypes->keyBy('id');
        $ptypes       = $ptypes->keyBy('id');
        $suburbs      = $suburbs->keyBy('id');
        $contacts     = $contacts->keyBy('id');
        $contacttypes = $contacttypes->keyBy('id');

        $property = Property::find($id);
        $property->load('units', 'images', 'notes', 'owners');

        $username = Auth::user()->name;
        activity("Property")->withProperties(['user' => $username, 'erf' => $property->erf, 'id' => $property->id])->log('Show ');
        //dd($property);
        $stat1 = 0;
        $stat2 = 0;
        $stat3 = 0;
        $stat4 = 0;
        foreach ($property->units as $unit) {
            if ($unit->status_id == 1) {
                $stat1 = $stat1 + 1;
            }
            if ($unit->status_id == 2) {
                $stat2 = $stat2 + 1;
            }
            if ($unit->status_id == 3) {
                $stat3 = $stat3 + 1;
            }
            if ($unit->status_id == 4) {
                $stat4 = $stat4 + 1;
            }
        }

        return view('showproperty', compact('property', 'users', 'areas', 'grades', 'statuses', 'suburbs', 'contacts', 'contacttypes', 'stypes', 'ptypes', 'stat1', 'stat2', 'stat3', 'stat4'));
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
