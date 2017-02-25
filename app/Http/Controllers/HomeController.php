<?php

namespace App\Http\Controllers;

use App\Area;
use App\Property;
use App\PropertyType;
use App\SaleType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function readme()
    {

        return view('readme');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$properties = Property::has('Unit')->where('area_id', '2')->get();
        $properties = Property::has('Units')->paginate(5);
        $properties->load('Images');
        $areas  = Area::all();
        $stypes = SaleType::all();
        $ptypes = PropertyType::all();
        //dd($properties, $areas);

        $select_area    = 0;
        $select_minsize = "";
        $select_maxsize = "";
        $select_ptype   = 0;
        $select_stype   = 0;

        $search = "";

        //   return view('home', compact('properties', 'areas', 'stypes', 'ptypes', 'select_area', 'select_minsize', 'select_maxsize', 'select_ptype', 'select_stype', 'search'));
        return view('manage-properties');
    }

    public function propsearch(Request $request)
    {

        $areas  = Area::all();
        $stypes = SaleType::all();
        $ptypes = PropertyType::all();

        $area    = $request->input('area');
        $ptype   = $request->input('ptype');
        $stype   = $request->input('stype');
        $minsize = $request->input('minsize');
        $maxsize = $request->input('maxsize');

        if (empty($minsize)) {
            $sminsize       = 0;
            $minsize        = 0;
            $select_minsize = "";
        } else {
            $sminsize       = $minsize;
            $select_minsize = $minsize;
        }

        if (empty($maxsize)) {
            $smaxsize       = 999999;
            $maxsize        = 999999;
            $select_maxsize = "";
        } else {
            $smaxsize       = $maxsize;
            $select_maxsize = $maxsize;
        }

        if ($area == 0) {
            $sarea       = "All Areas";
            $aaction     = ">";
            $select_area = 0;
        } else {
            $sarea       = $areas[$area - 1]->name;
            $select_area = $area;
            $aaction     = "=";
        }
        if ($ptype == 0) {
            $sptype       = "All Types";
            $paction      = ">";
            $select_ptype = 0;
        } else {
            $sptype       = $ptypes[$ptype - 1]->name;
            $paction      = "=";
            $select_ptype = $ptype;
        }
        if ($stype == 0) {
            $sstype       = "To Let or Rent";
            $saction      = ">";
            $select_stype = 0;
        } else {
            $sstype       = $stypes[$stype - 1]->name;
            $saction      = "=";
            $select_stype = $stype;
        }

        $properties = Property::where('area_id', $aaction, $area)->whereHas('units', function ($query) use ($ptype, $paction, $stype, $saction, $minsize, $maxsize) {
            $query->where('size', '>', $minsize)->where('size', '<', $maxsize)->where('property_type_id', $paction, $ptype)->where('sale_type_id', $saction, $stype);

        })->with('Images')->paginate(5);

        /*
        $properties = DB::table('properties')
        ->join('units', 'properties.id', '=', 'units.property_id')

        ->select('properties.*', 'units.*')
        ->where('units.size', '>', $minsize)
        ->where('units.size', '<', $maxsize)
        ->where('units.property_type_id', $paction, $ptype)
        ->where('units.sale_type_id', $saction, $stype)
        ->paginate(5);
         */
        /*
        $properties = Unit::where('size', '>', $minsize)->where('size', '<', $maxsize)->where('property_type_id', $paction, $ptype)->where('sale_type_id', $saction, $stype)->with('property')->paginate(5);
         */
        //dd($properties);
        // dd($area, $aaction, $stype, $minsize, $maxsize, $request, $properties);

        //dd($properties, $areas);
        //return Redirect()->back()->withInput($request->input());
        $search = ' [' . $properties->total() . "] " . "&nbsp;&nbsp;&nbsp;&nbsp;" . $sarea . ' | ' . $sstype . ' | ' . $sptype . ' | ' . $sminsize . ' | ' . $smaxsize;

        return view('home', compact('properties', 'areas', 'stypes', 'ptypes', 'search', 'select_area', 'select_minsize', 'select_maxsize', 'select_ptype', 'select_stype'));
    }

    public function test()
    {
        dd("test");
    }
}
