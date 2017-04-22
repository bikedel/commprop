<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Controllers\Controller;
use App\PropertyType;
use App\SaleType;
use App\Suburb;
use App\Unit;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
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
        activity("Dashboard")->withProperties(['user' => $username])->log('Users ');
        $areas  = Area::all();
        $stypes = SaleType::all();
        $ptypes = PropertyType::all();

        $users = User::latest()->paginate(25);

        //dd($property);
        return view('dashboard.users', compact('users'));
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
        $areas   = Area::all();
        $suburbs = Suburb::all();
        $stypes  = SaleType::all();
        $ptypes  = PropertyType::all();

        $unit = Unit::find($id);
        if ($unit) {
            $unit->load('property', 'images', 'notes', 'owners');
        }
        //dd($unit, $unit->property->id);
        return view('showunit', compact('unit', 'areas', 'suburbs', 'stypes', 'ptypes'));
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
