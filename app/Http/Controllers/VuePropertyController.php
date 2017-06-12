<?php

namespace App\Http\Controllers;

use App;
use App\Agent;
use App\Area;
use App\Contact;
use App\ContactType;
use App\Grade;
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
use IImage;
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

        $agents       = Agent::all();
        $users        = User::all();
        $areas        = Area::with('suburbs')->get();
        $suburbs      = Suburb::orderBy('id')->get();
        $contacts     = Contact::all();
        $stypes       = SaleType::all();
        $ptypes       = PropertyType::all();
        $statuses     = Status::all();
        $contacttypes = ContactType::all();
        $grades       = Grade::all();

        // $streets = Street::on($database)->select('id', 'strStreetName')->get();

        //array_unshift($users, ['name' => 'Select ']);
        $response = [
            'agents'       => $agents,
            'users'        => $users,
            'areas'        => $areas,
            'suburbs'      => $suburbs,
            'contacts'     => $contacts,
            'stypes'       => $stypes,
            'ptypes'       => $ptypes,
            'contacttypes' => $contacttypes,
            'statuses'     => $statuses,
            'grades'       => $grades,
            'user'         => Auth::user()->id,
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

        $id      = $request->input('s_id');
        $erf     = $request->input('s_erf');
        $area    = $request->input('s_area');
        $ptype   = $request->input('s_ptype');
        $stype   = $request->input('s_stype');
        $status  = $request->input('s_status');
        $minsize = $request->input('s_minsize');
        $maxsize = $request->input('s_maxsize');

        $model = Property::first();

        // dont log reset or reload pages
        if ($id == null && $area == null && sizeof($ptype) <= 0 && sizeof($stype) <= 0 && sizeof($status) <= 0 && $minsize == null && $maxsize == null) {
            $action = "Reset";
        } else {
            $action   = "Search";
            $username = Auth::user()->name;
            activity("Database")->performedOn($model)->withProperties(

                ['user'   => $username,
                    'Erf'     => $erf,
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

        if ($id) {
            $items = Property::where('id', "=", $id)->latest()->paginate(15);
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
            //'erf'       => 'required| numeric |unique:properties',
            'title'     => 'required',
            //  'image'   => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'area_id'   => 'required',
            'ownership' => 'required',
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
        $tosave = $request->except(['id']);
        $tosave = $request->except(['area']);
        $tosave = $request->except(['image', 'ownership']);

        $tosave['erf']         = $request->input('erf');
        $tosave['title']       = $request->input('title');
        $tosave['address']     = $request->input('address');
        $tosave['description'] = $request->input('description');
        $tosave['area_id']     = $request->input('area_id');
        $tosave['type']        = $request->input('ownership');

        // check address is not empty
        if (strlen($tosave['address']) > 0) {
            // add lat long
            $add     = urlencode($tosave['address']);
            $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

            $output = json_decode($geocode);
            if (sizeof($output->results) > 0) {
                $lat            = $output->results[0]->geometry->location->lat;
                $lng            = $output->results[0]->geometry->location->lng;
                $tosave['lat']  = $lng;
                $tosave['long'] = $lat;
            }

        }
        //dd($lat, $lng, $output);

        $property = Property::create($tosave);

        $propertyId = $property->id;

        // create directory if it does not exist
        $destinationPath = public_path() . '/property/' . $propertyId;

        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        $all = $request->all();

        $first   = 0;
        $imageid = 0;
        // save images
        if (isset($all['image']) && count($all['image']) > 0) {
            foreach ($all['image'] as $img) {
                // move image to public

                $first = $first + 1;

                $file_name = preg_replace("/[^a-zA-Z0-9.-]/", "", $img->getClientOriginalName());

                $name = time() . $file_name;

                $img = IImage::make($img->getRealPath())->resize(400, 300);
                //   $thumb = IImage::make($img)->resize(80, 60);
                $img->backup();

// write text
                //$img->text('SirComm');

// write text at position
                //$img->text('SirComm', 380, 10);
                //  $img->insert(public_path('/img/watermark.png'));

// use callback to define details

                $img->save(public_path('/property/' . $propertyId) . '/' . $name, 100);

                $img->reset();

// perform other modifications
                $img->resize(120, 80);

                $img->save(public_path('/property/' . $propertyId) . '/t_' . $name, 100);

                //   $img->resize(400, 300, function ($constraint) {
                //       $constraint->aspectRatio();
                //   })->save(public_path('/property/' . $propertyId) . '/' . $name, 80);

//$img = Image::make('public/foo.jpg')->resize(300, 200);

// save file as png with medium quality
                //$img->save('public/bar.png', 60);

                //  $img->move(public_path('/property/' . $propertyId), $name);
                // save to database
                $image              = new Image;
                $image->property_id = $propertyId;
                $image->name        = $name;
                $image->save();

                // store image_id to put in property
                if ($first == 1) {
                    $imageid = $image->id;
                }
            }
        }

        //update prop reference to image
        //$property->image_id = $image->id;
        //$property->save();

        // set image_id as main pic
        if ($imageid) {
            $tosave['image_id'] = $imageid;
        }

        $property->image_id = $imageid;
        $property->update();

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
        $tosave['description']      = $request->input('description');
        $tosave['size']             = $request->input('size');
        $tosave['price']            = $request->input('price');
        $tosave['brochure_users']   = array('');

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
            // 'company'         => 'unique:contacts',
            'firstname'       => 'required',
            'lastname'        => 'required',
            'contact_type_id' => 'required|numeric|min:1',
        );

        $messsages = array(
            'unique'  => 'This company already exists or the lastname, firstame below',
            'min'     => 'This field is required',
            'numeric' => 'This field is required and must be numeric',
        );

        // curent timestamp
        $now = Carbon\Carbon::now();

        // remove id from the form request

        // $tosave = $request->except(['id']);
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

        // no company name and it is not an existing contact
        $savecontact['company'] = $request->input('company');
        if ($request->input('company') == "" && $request->input('checked') == 'false') {
            $savecontact['company'] = $request->input('lastname') . ' ' . $request->input('firstname');
            $tosave['company']      = $request->input('lastname') . ' ' . $request->input('firstname');

            // only validate on new contact
            $tosave = $request->except(['company']);
        }

// only need to validate if not an existing one ie. it is a new contact
        if ($request->input('checked') == 'false') {
            $validator = \Illuminate\Support\Facades\Validator::make($tosave, $rules, $messsages);
            if ($validator->fails()) {
                return response()->json($validator->errors()->getMessages(), 422);
            }
        }
        // existing contact so only save in owners
        if ($request->input('checked') === 'true') {

            // save in owners table
            $saveowner['property_id']     = $request->input('id');
            $saveowner['unit_id']         = $request->input('unit_id');
            $saveowner['contact_id']      = $request->input('selectedContact');
            $saveowner['contact_type_id'] = $request->input('contact_type_id');

            // if contact type not set default to 1
            if (empty($request->input('contact_type_id')) || is_null($request->input('contact_type_id')) || strlen($request->input('contact_type_id') < 1)) {
                $saveowner['contact_type_id'] = 1;
            }

            $owner = Owner::create($saveowner);

        } else {

            // check if contact already exists, else save it
            //$savecontact['company']   = $request->input('company');
            $savecontact['firstname'] = $request->input('firstname');
            $savecontact['lastname']  = $request->input('lastname');
            $savecontact['tel']       = $request->input('tel');
            $savecontact['cell']      = $request->input('cell');
            $savecontact['email']     = $request->input('email');
            $savecontact['website']   = $request->input('website');

            $contact = Contact::create($savecontact);

            // save the contact id
            $saveowner['contact_id'] = $contact->id;
            // save in owners table
            $saveowner['property_id']     = $request->input('id');
            $saveowner['unit_id']         = $request->input('unit_id');
            $saveowner['contact_type_id'] = $request->input('contact_type_id');
            $owner                        = Owner::create($saveowner);

        }

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
    public function updateproperty($id, Request $request)
    {

        //change database
        //$property = new Property;

        $tosave['erf']         = $request->input('erf');
        $tosave['street']      = $request->input('street');
        $tosave['title']       = $request->input('title');
        $tosave['address']     = $request->input('address');
        $tosave['description'] = $request->input('description');

        $rules = array(

        );

        $messsages = array(
            //   'erf.unique'     => 'This field must be unique',
            //   'erf.required'   => 'This field is required',
            //   'erf.numeric'    => 'This field must be a number',
            //   'title.required' => 'This field is required',

        );

        $validator = \Illuminate\Support\Facades\Validator::make($tosave, $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors

            return response()->json($validator->errors()->getMessages(), 422);

        }

        $edit       = Property::find($id);
        $propertyId = $edit->id;

        //$tosave['area_id']     = $request->input('area_id');

        $tosave = $request->except(['id']);
        $tosave = $request->except(['query_myTextEditBox']);
        $tosave = $request->except(['image']);
        $tosave = $request->except(['addimage']);
        $tosave = $request->except(['theimageOrder', 'ownership', 'addimage']);

        // update properties

        // check address is not empty
        if (strlen($tosave['address']) > 0) {
            // add lat long
            $add     = urlencode($tosave['address']);
            $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

            $output = json_decode($geocode);

            if (sizeof($output->results) > 0) {
                $lat            = $output->results[0]->geometry->location->lat;
                $lng            = $output->results[0]->geometry->location->lng;
                $tosave['lat']  = $lng;
                $tosave['long'] = $lat;
            } else {
                $tosave['lat']  = 0;
                $tosave['long'] = 0;

            }

        }

        $all = $request->all();
        // save images

//set main image
        if (isset($all['image']) && count($all['image']) > 0) {
            $imageCount = 0;

            foreach ($all['image'] as $img) {
                $imageCount = $imageCount + 1;

            }
        }

        // store image_id - position
        $mainimage_id = strpos($request->input('theimageOrder'), "<") - 1;
        $new_image_id = substr($request->input('theimageOrder'), 0, $mainimage_id);

        // check image_id
        if ($new_image_id && $new_image_id > 0) {
            $tosave['image_id'] = $new_image_id;

        } else {
            $tosave['image_id'] = 0;
        }

        $tosave['type'] = $request->input('ownership');

        // create directory if it does not exist
        $destinationPath = public_path() . '/property/' . $propertyId;

        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        if (isset($all['addimage']) && count($all['addimage']) > 0) {
            foreach ($all['addimage'] as $img) {
                // move image to public

                $file_name = preg_replace("/[^a-zA-Z0-9.-]/", "", $img->getClientOriginalName());
                $name      = time() . $file_name;
                $img       = IImage::make($img->getRealPath())->resize(400, 300);
                $img->backup();
                $img->save(public_path('property/' . $propertyId) . '/' . $name, 100);
                $img->reset();
                $img->resize(120, 80);
                $img->save(public_path('property/' . $propertyId) . '/t_' . $name, 100);
                $image              = new Image;
                $image->property_id = $propertyId;
                $image->name        = $name;
                $image->save();
            }
        }
        //  $tosave = $request->except(['addimage']);
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
    public function delimage(Request $request)
    {

        //  $prop = Property::find($id)->delete();

        //  $directory = public_path() . '/property/' . $id;

        //  $success = File::deleteDirectory($directory);
        $user        = Auth::user()->id;
        $id          = $request->input('id');
        $property_id = $request->input('property_id');
        $image       = $request->input('image');

        $directory = public_path() . '/property/' . $property_id . '/';

        File::delete($directory . $image);
        File::delete($directory . 't_' . $image);

        $update = Image::find($id);

        $update->destroy($id);

        return response()->json(['data' => $update]);
    }

    public function delowner(Request $request)
    {

        //  $prop = Property::find($id)->delete();

        //  $directory = public_path() . '/property/' . $id;

        //  $success = File::deleteDirectory($directory);
        $user = Auth::user()->id;
        $id   = $request->input('id');

        $update = Owner::find($id);

        $update->destroy($id);

        return response()->json(['data' => $update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateunit($id, Request $request)
    {

        //  $prop = Property::find($id)->delete();

        //  $directory = public_path() . '/property/' . $id;

        //  $success = File::deleteDirectory($directory);
        $user   = Auth::user()->id;
        $unit   = $id;
        $update = Unit::find($unit);

        $tosave = $request->except(['id']);
        $tosave = $request->except(['erf']);

        $update->update($tosave);

        return response()->json(['data' => $update]);
    }

    public function clearbrochures()
    {

        $user = Auth::user()->id;

        // get all set units
        $units = Unit::where('brochure_users', '!=', '[]')->orderBy('property_id')->get();

        foreach ($units as $unit) {

            // check if the user_id is already in the array
            // remove it if it is

            $field = $unit->brochure_users;
            //    echo implode(" ", $field) . '<br>';

            if (($key = array_search($user, $field)) !== false) {
                unset($field[$key]);
                $field = array_values($field);

                //  echo '  saveing ' . implode(" ", $field) . '<br>';

                $unit->brochure_users = $field;
                $unit->save();
            }

        }

        return response()->json(['data' => true]);
    }

    public function setbrochure(Request $request)
    {

        //  $prop = Property::find($id)->delete();

        //  $directory = public_path() . '/property/' . $id;

        //  $success = File::deleteDirectory($directory);
        $user   = Auth::user()->id;
        $unit   = $request->input('unit_id');
        $update = Unit::find($unit);
        $return = false;
        // $tosave['brochure_users'] = $update->brochure_users . ',' . Auth::user()->id;

        // check if the user_id is already in the array
        // remove it if it is
        // add it if not
        $field = $update->brochure_users;

        if (($key = array_search($user, $field)) !== false) {
            unset($field[$key]);
            $field  = array_values($field);
            $return = false;

        } else {
            array_push($field, $user);
            $return = true;
        }

        $tosave['brochure_users'] = $field;

        $update->update($tosave);

        return response()->json(['data' => $return]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listbrochure(Request $request)
    {

        //  $prop = Property::find($id)->delete();

        //  $directory = public_path() . '/property/' . $id;

        //  $success = File::deleteDirectory($directory);
        $user  = Auth::user()->id;
        $units = Unit::where('brochure_users', '!=', '[]')->orderBy('property_id')->get();
        $units->load('property');

        $response = [
            'brochures' => $units,
        ];

        return response()->json($response);

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

    public function createPdf($myinput, Request $request)
    {

        // get inputs
        // agent
        // brochure_test
        // client

        $input = (explode(",", $myinput));

        $zoom          = $input[5];
        $note          = $input[4];
        $brochure_type = $input[3];
        $client        = $input[2];
        $brochure_text = $input[1];
        $footer        = $input[0];

        // remove odd characters from client and brochure_text and note
        //  '~~ ' = /
        //  '~~~ ' = \

        $client        = str_replace(" ~~ ", "/", $client);
        $client        = str_replace(" ~~~ ", "\\", $client);
        $brochure_text = str_replace(" ~~ ", "/", $brochure_text);
        $brochure_text = str_replace(" ~~~ ", "\\", $brochure_text);
        $note          = str_replace(" ~~ ", "/", $note);
        $note          = str_replace(" ~~~ ", "\\", $note);

        $agent = $input[0];

        if (!$agent) {
            $agent = 1;
        }

        //dd($agent, $zoom);

        if ($footer == 1) {
            $footer = 'footer_1.html';
        } else {
            $footer = 'footer_2.html';
        }
        //   $agentid = Agent::find($agent);
        $footer = 'footer_' . $agent . '.html';

        //dd($footer);

        //   $footer = route('brochurefooter', ['id' => $agent]);

        //  $footer = \View::make('agent_footer', compact('agent'))->render();

        // $temp = Storage::disk('footer')->put('footer__' . $agent->id . '.html', $footer, 'public');

        //dd($footer);

        //  dd($request, $footer, $client, $myinput);
        $users    = User::all();
        $areas    = Area::all();
        $grades   = Grade::all();
        $suburbs  = Suburb::all();
        $stypes   = SaleType::all();
        $ptypes   = PropertyType::all();
        $statuses = Status::all();

        $statuses = $statuses->keyBy('id');
        $grades   = $grades->keyBy('id');
        $stypes   = $stypes->keyBy('id');
        $ptypes   = $ptypes->keyBy('id');
        $suburbs  = $suburbs->keyBy('id');

        // get all units for brochure
        $user     = Auth::user()->id;
        $username = Auth::user()->name;
        // $units = Unit::where('brochure_users', '!=', '[]')->where('brochure_users', 'like', "%[$user%")->orWhere('brochure_users', 'like', "%$user]%")->orWhere('brochure_users', 'like', "%,$user,%")->orderBy('property_id')->get();
        //  $units->load('property');

        $items = Property::whereHas('units', function ($query) use ($user) {$query->where('brochure_users', '!=', '[]')->where('brochure_users', 'like', "%[$user%")->orWhere('brochure_users', 'like', "%$user]%")->orWhere('brochure_users', 'like', "%,$user,%");})->with(['units' => function ($query) use ($user) {$query->where('brochure_users', '!=', '[]')->where('brochure_users', 'like', "%[$user%")->orWhere('brochure_users', 'like', "%$user]%")->orWhere('brochure_users', 'like', "%,$user,%");}])->with('images', 'notes', 'owners')->get();

        $log_units = '';
        $log_ids   = '';
        $markers   = '';
        $locations = array();
        $loop      = 0;

        foreach ($items as $item) {
            $loop = $loop + 1;
            if ($brochure_type == 0) {
                $marker = '&markers=label:' . $loop . '%7C' . $item->long . ',' . $item->lat;
            } else {
                $marker = '&markers=icon:http://www.sircommdb.co.za/marker32_' . $loop . '.png%7Clabel:' . $loop . '%7C' . $item->long . ',' . $item->lat;
            }
            $markers = $markers . $marker;
            array_push($locations, $item->address);
            $log_units = $log_units . ',' . $item->erf;
            $log_ids   = $log_ids . ',' . $item->id;
            foreach ($item->units as $unit) {
                $log_units = $log_units . '-' . $unit->id;
                $log_ids   = $log_ids . '-' . $unit->id;
            }

        }

        //   dd("pdf", $units, $items);

        activity("Brochure")->withProperties(['user' => $username, 'client' => $client, 'brief' => $brochure_text, 'agent' => $agent, 'erfs' => $log_units, 'ids' => $log_ids])->log('PDF ');

        // $img = Barryvdh\Snappy\Facades\SnappyImage::loadView('readme');
        // return $img->download('test.pdf');

        //dd('test pdf');
        //  $item = Property::find($item);
        //  $item->load('units', 'images', 'notes', 'owners');
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

        if ($brochure_type == 0) {

            // type 1 brochure
            if ($items->count() > 0) {
                return PDF::loadView('pdf.brochure', compact('items', 'areas', 'suburbs', 'grades', 'ptypes', 'stypes', 'statuses', 'users', 'markers', 'locations', 'client', 'brochure_text', 'note', 'zoom'))->setOption('outline', true)->setOption('margin-top', 0)->setOption('margin-bottom', 45)->setOption('footer-line', false)->setOption('footer-html', url($footer))->download('Property_brochure_erf_' . $item->id . '.pdf');
            } else {

                return redirect()->back();
            }

        } else {
            // type 2 brochure
            if ($items->count() > 0) {
                return PDF::loadView('pdf.brochure_2', compact('items', 'areas', 'suburbs', 'grades', 'ptypes', 'stypes', 'statuses', 'users', 'markers', 'locations', 'client', 'brochure_text', 'note', 'zoom'))->setOption('outline', true)->setOption('margin-top', 0)->setOption('margin-bottom', 45)->setOption('footer-line', false)->setOption('footer-html', url($footer))->download('Property_brochure_erf_' . $item->id . '.pdf');
            } else {

                return redirect()->back();
            }

        }
        // ->setOption('header-center', 'Page [page]')
        //->setOption('toc', true)
        //->setOption('cover', "hello")
        //->setOption('header-center', date('D d M Y'))

        //  return response()->json(['done']);
        //->setOption('footer-html', "<img src = '{{public_path()}}/img/sothebys_logo_flat.jpeg' />")
        //return PDF::loadView('pdf.brochure', compact('item', 'areas', 'ptypes', 'stypes', 'users'))->setOption('margin-bottom', 0)->setOption('footer-center', 'Page [page]')->setOption('cover', $cover)->download('Property_brochure_erf' . $item->erf . '.pdf');

    }

    public function brochurefooter($id)
    {
        //dd("brochure footer " . $id);
        $agent = Agent::find($id);

        return view('agent_footer', compact('agent'));
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
