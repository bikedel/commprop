<?php

namespace App\Http\Controllers;

use App\Complex;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Owner;
use App\Property;
use App\Street;
use App\User;
use Auth;
use Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class VueContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function manageVue()
    {
        return view('dashboard.manage-contacts');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items = Contact::latest()->paginate(10);

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
     * Get the select dropdown info
     *
     * @return \Illuminate\Http\Response
     */
    public function selects(Request $request)
    {

        // set database
        $database = Auth::user()->getDatabase();

        //change database
        $property = new Property;
        $property->changeConnection($database);

        $streets = Street::on($database)->select('id', 'strStreetName')->get();

        $complexes = Complex::on($database)->select('id', 'strComplexName')->get();

        $owners = Owner::on($database)->select('id', 'strIDNumber')->get();

        //array_unshift($users, ['name' => 'Select ']);
        $response = [
            'streets'   => $streets,
            'complexes' => $complexes,
            'owners'    => $owners,
        ];

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $search)
    {

        // set database
        $database = Auth::user()->getDatabase();

        //change database
        $owner = new Property;
        $owner->changeConnection($database);

        $items = Owner::on($database)->where('strIDNumber', 'like', $search . '%')->latest()->paginate(10);

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
            'company'   => 'required',
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email|unique:contacts,email',
            'tel'       => 'Numeric',
            'cell'      => 'Numeric',

        );

        $messsages = array(

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response()->json($validator->errors()->getMessages(), 422);

        }

        // remove id from the form request
        //$tosave = $request->except(['confirmpassword']);
        $tosave['company']   = $request->input('company');
        $tosave['firstname'] = $request->input('firstname');
        $tosave['lastname']  = $request->input('lastname');
        $tosave['email']     = $request->input('email');
        $tosave['tel']       = $request->input('tel');
        $tosave['cell']      = $request->input('cell');
        $tosave['website']   = $request->input('website');

        // save new owner
        $contact = Contact::create($tosave);

        return response()->json($contact);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecontact($id, Request $request)
    {

        $rules = array(
            'company'   => 'required',
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email', Rule::unique('contacts')->ignore($id),
            'tel'       => 'Numeric',
            'cell'      => 'Numeric',

        );

        $messsages = array(

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response()->json($validator->errors()->getMessages(), 422);

        }

        // remove id from the form request
        //$tosave = $request->except(['confirmpassword']);

        $tosave['company']   = $request->input('company');
        $tosave['firstname'] = $request->input('firstname');
        $tosave['lastname']  = $request->input('lastname');
        $tosave['email']     = $request->input('email');
        $tosave['tel']       = $request->input('tel');
        $tosave['cell']      = $request->input('cell');
        $tosave['website']   = $request->input('website');

        // save new owner
        $contact = Contact::find($id);
        $contact->update($tosave);

        return response()->json($contact);
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

        $contact = Contact::find($id);
        $contact->delete();

        return response()->json(['done']);
    }

    public function export()
    {

        $now = \Carbon\Carbon::now();

        $contacts = Contact::all();

        // $owners = collect($ownersRaw);
        //foreach ($owners as &$owner) {
        //    $owner = (array) $owner;
        //}

        //dd($owners);

        Excel::create('Contacts_' . $now, function ($excel) use ($contacts) {

            $excel->setTitle('Contacts ');
            $excel->setCreator('Contacts')->setCompany('Sothebys');
            $excel->setDescription('Contacts');

            $excel->sheet('Sheet 1', function ($sheet) use ($contacts) {
                $sheet->fromArray($contacts, null, 'A1', true, true);

                $sheet->freezeFirstRow();

                // Set height for a single row
                $sheet->setHeight(1, 20);

                $sheet->cells('A1:J1', function ($cells) {

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

    }
}
