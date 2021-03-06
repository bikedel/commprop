<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Controllers\Controller;
use App\Property;
use App\PropertyType;
use App\SaleType;
use App\Status;
use App\Unit;
use App\User;
use Auth;
use Carbon\Carbon;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use SoapClient;
use SoapHeader;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd("home controller");
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

        //  activity("auth")->log('log_In ' . Auth::user()->name);

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

    public function dashboard()
    {

        $username = Auth::user()->name;
        // activity("Dashboard")->withProperties(['user' => $username])->log('Overview ');

        $useragent = request()->header('User-Agent');
        $ip        = request()->ip();
        $users     = User::all();
        $areas     = Area::all();
        $stypes    = SaleType::all();
        $statuses  = Status::all();
        $units     = Unit::all();
        $ptypes    = PropertyType::all();
        //dd('test pdf');

        // alerts for expirint leases - 6 months
        $today  = Carbon::today();
        $period = Carbon::today()->addMonths(6);

        $alertunits = Unit::where('lease_end', '>', $today)->where('lease_end', '<', $period)->orderBy('lease_end', 'asc')->get();
        $alertunits->load('property');

        $properties = Property::latest()->get();
        $properties->load('units', 'images', 'notes', 'owners');
        return view('dashboard.overview', compact('properties', 'areas', 'stypes', 'ptypes', 'users', 'units', 'alertunits', 'statuses', 'ip', 'useragent'));
    }

    public function dashboardmap()
    {

        $username = Auth::user()->name;
        activity("Dashboard")->withProperties(['user' => $username])->log('Map ');

        Mapper::location('cape town')->map(['zoom' => 10, 'center' => true, 'marker' => false, 'type' => 'HYBRID', 'overlay' => 'NONE']);
        // Mapper::informationWindow('cape town', 'Content');
        // get all properties

        $types = ['Freehold', 'Sectional Title'];

        $stypes   = SaleType::all();
        $ptypes   = PropertyType::all();
        $statuses = Status::all();

        $statuses = $statuses->keyBy('id');
        $stypes   = $stypes->keyBy('id');
        $ptypes   = $ptypes->keyBy('id');

        $areas = Area::all();

        $properties = Property::all();
        $properties->load('images');

        foreach ($properties as $property) {
            //echo $areas[$property->area_id]->name;
            if (sizeof($property->images) > 0) {
                $image = 'property/' . $property->id . '/' . $property->images[0]['name'];
            } else {
                $image = 'img/sothebys_footer.png';
            }
            $link    = "<a href=" . url("/showproperty" . $property->id) . " >VIEW</a>";
            $content = $property->address . '<br>';
            $content = $content . $types[$property->type] . '<br>';
            $content = $content . $stypes[$property->sale_type_id]->name . '<br>';
            $content = $content . $link . '<br>';

            // check for lat and long
            if ($property->long && $property->lat) {

                if ($property->sale_type_id == 2) {
                    Mapper::marker($property->long, $property->lat, ['draggable' => 'true', 'title' => 'Type: ' . $types[$property->type] . ' Erf: ' . $property->erf, 'eventRightClick' => 'window.prompt("Copy and save co-ordinates.","lat: "+event.latLng.lat() + "  lng: "+event.latLng.lng() );', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/green-dot.png"]);
                } elseif ($property->sale_type_id == 1) {
                    Mapper::marker($property->long, $property->lat, ['draggable' => 'true', 'title' => 'Type: ' . $types[$property->type] . ' Erf: ' . $property->erf, 'eventRightClick' => 'window.prompt("Copy and save co-ordinates.","lat: "+event.latLng.lat() + "  lng: "+event.latLng.lng() );', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png"]);
                } else {
                    Mapper::marker($property->long, $property->lat, ['draggable' => 'true', 'title' => 'Type: ' . $types[$property->type] . ' Erf: ' . $property->erf, 'eventRightClick' => 'window.prompt("Copy and save co-ordinates.","lat: "+event.latLng.lat() + "  lng: "+event.latLng.lng() );', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/red-dot.png"]);
                }
            }

        }

        return view('dashboard.map');
    }

    // property24 API
    public function test()
    {
        try {
            $apiauth = array('EMail' => 'test@SothebysCommercial.com', 'Password' => 'Ache!ou5');
            $wsdl    = 'http://www.exdev.property24.com/Services/P24ListingService31.asmx?wsdl';

            $soap     = new SoapClient($wsdl, array('trace' => 1));
            $header[] = new SoapHeader('http://www.property24.com/Services/P24ListingService31', 'AuthHeader', $apiauth);
            $header[] = new SoapHeader('http://www.property24.com/Services/P24ListingService31', 'CredentialsHeader', $apiauth);
            $soap->__setSoapHeaders($header);

            // -- works
            // echoAuthenticated
            //$params['stringToEcho'] = "ok this is working";
            //$data                   = $soap->EchoAuthenticated($params);

            // -- works
            // fetch country 1=South Africa
            //$data = $soap->FetchCountries();

            // fetch agency
            //$fetch_agency_parameter = array('agencyId' => '31171');
            //$params['agencyId'] = 31171;
            //$data               = $soap->FetchAgency($params);

            // fetch franchise
            //$params['agencyId'] = 31171;
            //$data               = $soap->FetchFranchises($params);

            // fetch Suburblist
            //$params['agencyId'] = 31171;
            //$data               = $soap->FetchSuburbList($params);

            // fetch provinces
            //$data = $soap->FetchProvinces(array('countryName' => 'South Africa'));

            // fetch suburbs
            //$data = $soap->FetchSuburbs(array('cityName' => 'Cape Town'));

            // fetch agents
            //$data = $soap->FetchAgents(array('agencyId' => '31171'));

            // fetch agent
            //$data = $soap->FetchAgent(array('agentId' => '31171'));

            // fetch TryFindSuburbId
            //$params['countryName']  = 'South Africa';
            //$params['provinceName'] = 'Western Cape';
            //$params['cityName']     = 'Cape Town';
            //$params['suburbName']   = 'Paarden Eiland';
            //$data                   = $soap->TryFindSuburbId($params);

            // add agent
            //$data = $soap->AddAgent(array('Id' => 1));
        } catch (\SoapFault $e) {
            echo 'Soap Error: ' . $e->getMessage() . '<br>' . ' class: ' . get_class($e);

            restore_error_handler();
            restore_exception_handler();
            set_error_handler('var_dump', 0); // Never called because of empty mask.
            @trigger_error("");
            restore_error_handler();
            dd();

        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            restore_error_handler();
            restore_exception_handler();

            dd();
        } catch (\FatalErrorException $e) {
            echo "Caught exception of class: " . get_class($e) . PHP_EOL;
        }

        dd($data);

        // print_r($data);

        //$properties = get_object_vars($data);
        //print_r($properties);
        /*

        $temps = Temp::all();

        $erf = 10000;

        $faker = Faker::create();
        foreach ($temps as $temp) {

        // check address is not empty

        $erf = $erf + 1;

        $tosave['erf']         = $erf;
        $tosave['title']       = $faker->lastName . ' ' . $faker->word . ' ' . $faker->word;
        $tosave['address']     = $temp->no . ' ' . $temp->name . ' ' . $temp->street . ' ' . $temp->area . ' ' . ', cape town , south africa';
        $tosave['description'] = $faker->paragraph . ' <br> ' . $faker->imageUrl($width = 200, $height = 200);
        $tosave['area_id']     = $faker->numberBetween(1, 100);

        // add lat long
        /*      $add     = urlencode($tosave['address']);
        $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

        $output = json_decode($geocode);

        if ($output->results) {
        $lat = $output->results[0]->geometry->location->lat;
        $lng = $output->results[0]->geometry->location->lng;

        $tosave['lat']  = $lng;
        $tosave['long'] = $lat;
        }
        //dd($lat, $lng, $output);

        $lng = $faker->randomFloat($nbMaxDecimals = null, $min = 18.4, $max = 18.76);
        $lat = $faker->randomFloat($nbMaxDecimals = null, $min = -33.825, $max = -34.05);

        if ($lng <= 18.4) {
        $lng = $faker->randomFloat($nbMaxDecimals = null, $min = 18.4, $max = 18.56);
        }

        $tog = $faker->numberBetween(1, 5);

        if ($tog > 3) {
        $r1 = rand(0, 1000) / 1000;
        $r2 = -rand(0, 1000) / 1000;
        } else {
        $r1 = -rand(0, 1000) / 1000;
        $r2 = rand(0, 1000) / 1000;
        }

        $tosave['lat']  = $lng + ($r1 / 10000);
        $tosave['long'] = $lat + ($r2 / 10000);

        $property = Property::create($tosave);

        for ($i = 1; $i < $tog; $i++) {

        $utosave['property_id']      = $property->id;
        $utosave['property_type_id'] = $faker->numberBetween(1, 5);
        $utosave['sale_type_id']     = $faker->numberBetween(1, 2);
        $utosave['status_id']        = $faker->numberBetween(1, 4);
        $utosave['size']             = $faker->numberBetween(1, 1000);
        $utosave['price']            = $faker->numberBetween(1, 1000);

        $unit = Unit::create($utosave);
        }
        }
         */
        dd("test", $temp);
    }

    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function dropzone()
    {
        return view('dropzone-view');
    }

    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneStore(Request $request)
    {

        $folder    = $request->input('fname');
        $image     = $request->file('file');
        $imageName = time() . $image->getClientOriginalName();
        $image->move(public_path('drop/' . $folder), $imageName);
        return response()->json(['success' => $imageName]);
    }
}
