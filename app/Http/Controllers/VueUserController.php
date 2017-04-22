<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Complex;
use App\Http\Controllers\Controller;
use App\Owner;
use App\Property;
use App\Role;
use App\Street;
use App\User;
use Auth;
use Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class VueUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function manageVue()
    {
        return view('dashboard.manage-users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items  = User::latest()->paginate(10);
        $roles  = Role::all();
        $agents = Agent::all();

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
            'roles'      => $roles,
            'agents'     => $agents,

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
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'agent_id' => 'Numeric',
            'role_id'  => 'Numeric',
            'password' => 'required',
            'password' => 'required|confirmed|min:8',

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
        $tosave['name']     = $request->input('name');
        $tosave['email']    = $request->input('email');
        $tosave['agent_id'] = $request->input('agent_id');
        $tosave['role_id']  = $request->input('role_id');
        $tosave['password'] = bcrypt($request->input('password'));

        // save new owner
        $user = User::create($tosave);

        return response()->json($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateuser($id, Request $request)
    {

        $rules = array(
            'name'     => 'required',
            'email'    => 'required|email', Rule::unique('users')->ignore($id),
            'agent_id' => 'Numeric',
            'role_id'  => 'Numeric',
            'password' => 'required',
            'password' => 'required|confirmed|min:8',

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

        $tosave['name']     = $request->input('name');
        $tosave['email']    = $request->input('email');
        $tosave['agent_id'] = $request->input('agent_id');
        $tosave['role_id']  = $request->input('role_id');
        $tosave['password'] = bcrypt($request->input('password'));

        // save new owner
        $user = User::find($id);
        $user->update($tosave);

        return response()->json($user);
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

        $user = User::find($id);
        $user->delete();

        return response()->json(['done']);
    }

    public function export()
    {

        $now = \Carbon\Carbon::now();

        $users = User::all();

        // $owners = collect($ownersRaw);
        //foreach ($owners as &$owner) {
        //    $owner = (array) $owner;
        //}

        //dd($owners);

        Excel::create('Users_' . $now, function ($excel) use ($users) {

            $excel->setTitle('Users ');
            $excel->setCreator('Users')->setCompany('Sothebys');
            $excel->setDescription('Users');

            $excel->sheet('Sheet 1', function ($sheet) use ($users) {
                $sheet->fromArray($users, null, 'A1', true, true);

                $sheet->freezeFirstRow();

                // Set height for a single row
                $sheet->setHeight(1, 20);

                $sheet->cells('A1:I1', function ($cells) {

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
