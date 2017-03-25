<?php

namespace App\Http\Controllers;

use App;
use App\Area;
use App\Contact;
use App\ContactType;
use App\Http\Controllers\Controller;
use App\Image;
use App\Note;
use App\Owner;
use App\Property;
use App\PropertyType;
use App\SaleType;
use App\Status;
use App\Suburb;
use App\Unit;
use App\User;
use Auth;
use Carbon;
use File;
use Illuminate\Http\Request;
use PDF;
use Response;
use Storage;

class VuePropertyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function manageVue()
    {
        //date_default_timezone_set('Africa/Johannesburg');
        return view('manage-properties');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items = Property::latest()->paginate(15);
        $items->load('units', 'images', 'notes', 'owners');

        //  $streets = Street::on($database)->select('id', 'strStreetName')->get();

        //  $complexes = Complex::on($database)->select('id', 'strComplexName')->get();

        //  $owners = Owner::on($database)->select('id', 'strIDNumber')->get();

        //array_unshift($users, ['name' => 'Select ']);
        $response = [
            'pagination' => [
                'total'        => $items->total(),
                'per_page'     => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'from'         => $items->firstItem(),
                'to'           => $items->lastItem(),
            ],
            'data'       => $items,
            //   'streets'    => $streets,
            //   'complexes'  => $complexes,
            //  'owners'     => $owners,
        ];

        return response()->json($response);
    }

    /**
     * Get the select dropdown info
     *
     * @return \Illuminate\Http\Response
     */
    public function selects(Request $request)
    {

        $users        = User::all();
        $areas        = Area::with('suburbs')->get();
        $suburbs      = Suburb::orderBy('id')->get();
        $contacts     = Contact::all();
        $stypes       = SaleType::all();
        $ptypes       = PropertyType::all();
        $statuses     = Status::all();
        $contacttypes = ContactType::all();

        // $streets = Street::on($database)->select('id', 'strStreetName')->get();

        //array_unshift($users, ['name' => 'Select ']);
        $response = [
            'users'        => $users,
            'areas'        => $areas,
            'suburbs'      => $suburbs,
            'contacts'     => $contacts,
            'stypes'       => $stypes,
            'ptypes'       => $ptypes,
            'contacttypes' => $contacttypes,
            'statuses'     => $statuses,
        ];

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function search(Request $request, $search)
    public function search(Request $request)
    {

        $areas    = Suburb::select('id')->get();
        $stypes   = SaleType::select('id')->get();
        $statuses = Status::select('id')->get();
        $ptypes   = PropertyType::select('id')->get();

        $erf     = $request->input('s_erf');
        $area    = $request->input('s_area');
        $ptype   = $request->input('s_ptype');
        $stype   = $request->input('s_stype');
        $status  = $request->input('s_status');
        $minsize = $request->input('s_minsize');
        $maxsize = $request->input('s_maxsize');

        $model = Property::first();

        // dont log reset or reload pages
        if ($erf == null && $area == null && sizeof($ptype) <= 0 && sizeof($stype) <= 0 && sizeof($status) <= 0 && $minsize == null && $maxsize == null) {
            $action = "Reset";
        } else {
            $action = "Search";
            activity("Database")->performedOn($model)->withProperties(

                ['Erf'    => $erf,
                    'area'    => $area,
                    'ptype'   => $ptype,
                    'stype'   => $stype,
                    'status'  => $status,
                    'minsize' => $minsize,
                    'maxsize' => $maxsize,

                ])->log($action);
        }

        // sel is the selected areas - vue issue with v-model
        $sel     = $request->input('sel');
        $noseach = 0;

        if (sizeof($ptype) <= 0) {
            $ptype = $ptypes->toArray();
        } else {
            $noseach = 1;
            $ptype   = explode(',', $ptype);
        }

        if (sizeof($stype) <= 0) {
            $stype = $stypes->toArray();
        } else {
            $noseach = 1;
            $stype   = explode(',', $stype);
        }

        if (sizeof($status) <= 0) {
            $status = $statuses->toArray();
        } else {
            $noseach = 1;
            $status  = explode(',', $status);
        }

        // get search criteria
        if (empty($minsize)) {
            $minsize = 0;
        } else {
            $sminsize = $minsize;
            $noseach  = 1;
        }

        if (empty($maxsize)) {
            $maxsize = 999999;
        } else {
            $smaxsize = $maxsize;
            $noseach  = 1;
        }

        // if array is empty then select all areas
        if (sizeof($area) <= 0) {
            $area = $areas;
        } else {
            $noseach = 1;
            $area    = $sel;
        }

        /* $items = Property::where('area_id', $aaction, $area)->whereHas('units', function ($query) use ($ptype, $paction, $stype, $saction, $minsize, $maxsize) {
        $query->where('size', '>', $minsize)->where('size', '<', $maxsize)->where('property_type_id', $paction, $ptype)->where('sale_type_id', $saction, $stype);

        })->with('images', 'units')->paginate(5);
         */

        //   $items = Property::where('area_id', $aaction, $area)->with('images', 'units')->where('units.size', '>', $minsize)->where('size', '<', $maxsize)->where('property_type_id', $paction, $ptype)->where('sale_type_id', $saction, $stype)->paginate(5);

        // GOOD  returns only properties with units matching criteria BUT all units
        //$items = Property::where('area_id', $aaction, $area)->whereHas('units', function ($query) use ($minsize) {$query->where('size', $minsize);})->with('images')->paginate(5);

        // find erf

        if ($erf) {
            $items = Property::where('erf', "=", $erf)->latest()->paginate(15);
            $items->load('units', 'images', 'notes', 'owners');
        } else {

            // if nosearch is set then do search else return all
            if ($noseach == 1) {
                $items = Property::whereIn('area_id', $area)->whereHas('units', function ($query) use ($status, $ptype, $stype, $minsize, $maxsize) {$query->where('size', '>', $minsize)->where('size', '<', $maxsize)->whereIn('property_type_id', $ptype)->whereIn('sale_type_id', $stype)->whereIn('status_id', $status);})->with(['units' => function ($query) use ($status, $ptype, $stype, $minsize, $maxsize) {$query->where('size', '>', $minsize)->where('size', '<', $maxsize)->whereIn('property_type_id', $ptype)->whereIn('sale_type_id', $stype)->whereIn('status_id', $status);}])->with('images', 'notes', 'owners')->latest()->paginate(15);

            } else {

                $items = Property::latest()->paginate(15);
                $items->load('units', 'images', 'notes', 'owners');

            }
        }
        // GOOD Returns all properties and only units matching criteria
        // $items = Property::where('area_id', $aaction, $area)->with(['units' => function ($query) use ($minsize) {$query->where('size', $minsize);}])->with('images')->paginate(5);

        // $items = Property::where('area_id', $aaction, $area)->latest()->paginate(5)->appends(['search' => $search]);

        //  $items->load('units', 'images');

        //array_unshift($users, ['name' => 'Select ']);
        $response = [
            'pagination' => [
                'total'        => $items->total(),
                'per_page'     => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'from'         => $items->firstItem(),
                'to'           => $items->lastItem(),
            ],
            'data'       => $items,

        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'erf'     => 'required| numeric |unique:properties',
            'title'   => 'required',
            //  'image'   => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'area_id' => 'required',

        );

        $messsages = array(
            'erf.unique'     => 'This field is must be unique',
            'erf.required'   => 'This field is required',
            'erf.numeric'    => 'This field must be numeric',
            'title.required' => 'This field is required',
            'image.required' => 'This field is required',
            'image.mimes'    => 'This field accepts jpg, png only',
            'image.max'      => 'This field can only handle images < 2mb',

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            //$request->merge(array('strStreetNo' => '999'));
            return response()->json($validator->errors()->getMessages(), 422);

        }

        // remove id from the form request
        $tosave['erf']         = $request->input('erf');
        $tosave['title']       = $request->input('title');
        $tosave['address']     = $request->input('address');
        $tosave['description'] = $request->input('description');
        $tosave['area_id']     = $request->input('area_id');

        $tosave = $request->except(['id']);
        $tosave = $request->except(['area']);
        $tosave = $request->except(['image']);

        // check address is not empty
        if (strlen($tosave['address']) > 0) {
            // add lat long
            $add     = urlencode($tosave['address']);
            $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

            $output = json_decode($geocode);

            $lat = $output->results[0]->geometry->location->lat;
            $lng = $output->results[0]->geometry->location->lng;

            $tosave['lat']  = $lng;
            $tosave['long'] = $lat;
        }
        //dd($lat, $lng, $output);

        $property = Property::create($tosave);

        $propertyId = $property->id;

        // create directory if it does not exist
        $destinationPath = public_path() . '/property/' . $propertyId;

        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

/*
// image name and copy to
$imageName = $propertyId . '_' . time() . '.' . $request->image->getClientOriginalExtension();

// copy uploaded file to directory
$request->image->move(public_path('/property/' . $propertyId), $imageName);

// insert image into images
$image              = new Image;
$image->property_id = $propertyId;
$image->name        = $imageName;
$image->save();

 */
        $all = $request->all();
        // save images
        if (isset($all['image']) && count($all['image']) > 0) {
            foreach ($all['image'] as $img) {
                // move image to public

                $file_name = preg_replace("/[^a-zA-Z0-9.-]/", "", $img->getClientOriginalName());

                $name = time() . $file_name;
                $img->move(public_path('/property/' . $propertyId), $name);
                // save to database
                $image              = new Image;
                $image->property_id = $propertyId;
                $image->name        = $name;
                $image->save();
            }
        }

        //update prop reference to image
        //$property->image_id = $image->id;
        //$property->save();

        return response()->json($property);
        //return response()->json(['test' => 'all data ok so far.'], 422);
        //return Redirect::back()->withInput()->withErrors(['test' => 'Your error message.'], 400);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addunit(Request $request)
    {

        $rules = array(
            'property_type_id' => 'numeric|min:1',
            'sale_type_id'     => 'numeric|min:1',
            'status_id'        => 'numeric|min:1',
            'size'             => 'numeric|min:0',
            'price'            => 'numeric|min:0',
        );

        $messsages = array(
            'min'     => 'This field is required',
            'numeric' => 'This field is required and must be numeric',
        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->getMessages(), 422);
        }

        // remove id from the form request
        $tosave['property_id']      = $request->input('property_id');
        $tosave['property_type_id'] = $request->input('property_type_id');
        $tosave['sale_type_id']     = $request->input('sale_type_id');
        $tosave['status_id']        = $request->input('status_id');
        $tosave['size']             = $request->input('size');
        $tosave['price']            = $request->input('price');

        $tosave = $request->except(['id']);

        $unit = Unit::create($tosave);

        return response()->json($unit);
        //return response()->json(['test' => 'all data ok so far.'], 422);
        //return Redirect::back()->withInput()->withErrors(['test' => 'Your error message.'], 400);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addnote(Request $request)
    {

        $rules = array(

        );

        $messsages = array(

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->getMessages(), 422);
        }

        // curent timestamp
        $now = Carbon\Carbon::now();

        // remove id from the form request
        $tosave['property_id'] = $request->input('id');
        $tosave['unit_id']     = $request->input('unit_id');
        $tosave['description'] = $request->input('newnote');
        $tosave['date']        = $now;
        $tosave['user_id']     = Auth::user()->id;

        // $tosave = $request->except(['id']);

        $note = Note::create($tosave);

        return response()->json($note);
        //return response()->json(['test' => 'all data ok so far.'], 422);
        //return Redirect::back()->withInput()->withErrors(['test' => 'Your error message.'], 400);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addowner(Request $request)
    {

        $rules = array(
            'contact_type_id' => 'required|numeric|min:1',
        );

        $messsages = array(
            'min'     => 'This field is required',
            'numeric' => 'This field is required and must be numeric',
        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->getMessages(), 422);
        }

        // curent timestamp
        $now = Carbon\Carbon::now();

        // remove id from the form request
        $tosave['property_id']     = $request->input('id');
        $tosave['unit_id']         = $request->input('unit_id');
        $tosave['company']         = $request->input('company');
        $tosave['firstname']       = $request->input('firstname');
        $tosave['lastname']        = $request->input('lastname');
        $tosave['tel']             = $request->input('tel');
        $tosave['cell']            = $request->input('cell');
        $tosave['email']           = $request->input('email');
        $tosave['website']         = $request->input('website');
        $tosave['contact_type_id'] = $request->input('contact_type_id');
        // $tosave = $request->except(['id']);

        $owner = Owner::create($tosave);

        return response()->json($owner);
        //return response()->json(['test' => 'all data ok so far.'], 422);
        //return Redirect::back()->withInput()->withErrors(['test' => 'Your error message.'], 400);

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

        //change database
        $property = new Property;

        $rules = array(
            'erf'   => 'required| numeric ',
            'title' => 'required',
        );

        $messsages = array(
            'erf.unique'     => 'This field must be unique',
            'erf.required'   => 'This field is required',
            'erf.numeric'    => 'This field must be a number',
            'title.required' => 'This field is required',

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors

            return response()->json($validator->errors()->getMessages(), 422);

        }

        $edit = Property::find($id);

        $tosave['erf']         = $request->input('erf');
        $tosave['title']       = $request->input('title');
        $tosave['address']     = $request->input('address');
        $tosave['description'] = $request->input('description');
        $tosave['area_id']     = $request->input('area_id');

        $tosave = $request->except(['id']);
        $tosave = $request->except(['query_myTextEditBox']);
        $tosave = $request->except(['image']);
        // update properties

        // check address is not empty
        if (strlen($tosave['address']) > 0) {
            // add lat long
            $add     = urlencode($tosave['address']);
            $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

            $output = json_decode($geocode);

            $lat = $output->results[0]->geometry->location->lat;
            $lng = $output->results[0]->geometry->location->lng;

            $tosave['lat']  = $lng;
            $tosave['long'] = $lat;
        }

        $edit->update($tosave);

        return response()->json($edit);
        //  return response()->json(['test' => 'all data ok so far.'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $prop = Property::find($id)->delete();

        $directory = public_path() . '/property/' . $id;

        $success = File::deleteDirectory($directory);

        return response()->json(['done']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteunit($id)
    {

        $unit = Unit::find($id)->delete();

        return response()->json(['done']);
    }

    public function createPdf($item)
    {

        activity("Brochure")->withProperties(

            ['Property' => $item])->log('PDF ');

        // $img = Barryvdh\Snappy\Facades\SnappyImage::loadView('readme');
        // return $img->download('test.pdf');

        $users   = User::all();
        $areas   = Area::all();
        $suburbs = Suburb::all();
        $stypes  = SaleType::all();
        $ptypes  = PropertyType::all();
        //dd('test pdf');
        $item = Property::find($item);
        $item->load('units', 'images', 'notes', 'owners');
        // $items->load('units', 'images', 'notes', 'owners');

        // $pdf = PDF::loadView('pdf.property', ['items' => $items]);

        // return $pdf->download('Property_brochure' . $items->id . '.pdf');
        //return PDF::loadFile('http://localhost/laravel/commprop/public/manage-properties')->stream('localhost.pdf');

        // $pdf = new Pdf('http:://www.google.com');
        // $pdf->download("google.pdf");
        //  Mapper::location('cape town')->map(['zoom' => 10, 'center' => true, 'marker' => false, 'type' => 'HYBRID', 'overlay' => 'NONE']);
        //->setOrientation('landscape')
        // PDF::loadHTML($html)->setOption('footer-center', 'Page [page]')->save('myfile.pdf');
        $cover = '<div class="flexme" <h1>Sotheby Brochure</h1></div>';

        return PDF::loadView('pdf.brochure', compact('item', 'areas', 'suburbs', 'ptypes', 'stypes', 'users'))->setOption('margin-bottom', 10)->setOption('footer-center', 'Page [page]')->setOption('header-center', date('D d M Y'))->download('Property_brochure_erf' . $item->erf . '.pdf');
        //  return response()->json(['done']);
        //->setOption('footer-html', "<img src = '{{public_path()}}/img/sothebys_logo_flat.jpeg' />")
        //return PDF::loadView('pdf.brochure', compact('item', 'areas', 'ptypes', 'stypes', 'users'))->setOption('margin-bottom', 0)->setOption('footer-center', 'Page [page]')->setOption('cover', $cover)->download('Property_brochure_erf' . $item->erf . '.pdf');

    }

    public function export()
    {
/*
$now    = \Carbon\Carbon::now();
$buyers = Buyer::select('*')->get();

//$buyers->load('users');

Excel::create('Buyers_' . $now, function ($excel) use ($buyers) {

$excel->setTitle('Exported Buyers ');
$excel->setCreator('Buyers')->setCompany('Sothebys');
$excel->setDescription('Buyers');

$excel->sheet('Sheet 1', function ($sheet) use ($buyers) {
$sheet->fromArray($buyers, null, 'A1', true, true);

// Add as very first
//   $sheet->prependRow(2, array(
//       '', '',
//   ));

// Sets all borders
//$sheet->setAllBorders('thin');

// Set border for cells
//$sheet->setBorder('A1', 'thin');

// Set border for range
//$sheet->setBorder('A1:E1', 'thin');
// Freeze first row
$sheet->freezeFirstRow();

// Set height for a single row
$sheet->setHeight(1, 20);

$sheet->cells('A1:U1', function ($cells) {

// manipulate the range of cells
// Set black background
$cells->setBackground('#008DB7');

// Set with font color
$cells->setFontColor('#ffffff');

// Set font
$cells->setFont(array(
'family' => 'Verdana',
'size'   => '12',
'bold'   => false,

));

//$cells->setBorder('solid', 'solid', 'solid', 'solid');

});

});
})->export('xls');
 */
    }
}
