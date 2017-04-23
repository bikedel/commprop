<?php

namespace App\Http\Controllers;

use App\Complex;
use App\Document;
use App\Http\Controllers\Controller;
use App\Owner;
use App\Property;
use App\Street;
use App\User;
use Auth;
use Carbon;
use Excel;
use Illuminate\Http\Request;
use Storage;

class VueDocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function manageVue()
    {
        return view('dashboard.manage-documents');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items = Document::latest()->paginate(10);

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
            'name'        => 'required',
            'description' => 'required',
            'file'        => 'required|max:10000|mimes:doc,docx,pdf',
        );

        $messsages = array(

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response()->json($validator->errors()->getMessages(), 422);

        }

        // $path = $request->file('file')->store('documents');

        $document = $request->file->getClientOriginalName();

        $request->file->move(public_path('/documents'), $document);

        //    $file = Request::file('file');
        //   $extension = $file->getClientOriginalExtension();
        //   Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

        // remove id from the form request
        //$tosave = $request->except(['confirmpassword']);
        $tosave['name']        = $request->input('name');
        $tosave['description'] = $request->input('description');
        $tosave['path']        = $document;

        // save new owner
        $document = Document::create($tosave);

        return response()->json($document);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatedocument($id, Request $request)
    {

        $rules = array(
            'name'        => 'required',
            'description' => 'required',

        );

        $messsages = array(

        );

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response()->json($validator->errors()->getMessages(), 422);

        }

        //    $path = $request->file('file')->store('documents');
        //    $document = $request->file->getClientOriginalName();
        //    $request->file->move(public_path('documents'), $document);
        //    $tosave['path']        = $document;

        $tosave['name']        = $request->input('name');
        $tosave['description'] = $request->input('description');

        // save new owner
        $document = Document::find($id);
        $document->update($tosave);

        return response()->json($document);
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

        $document = Document::find($id);
        $document->delete();

        return response()->json(['done']);
    }

    public function download($id)
    {

        $document   = Document::find($id);
        $pathToFile = public_path('/documents') . '/' . $document->path;

        return response()->download($pathToFile);
    }

    public function export()
    {

        $now = \Carbon\Carbon::now();

        $documents = Document::all();

        // $owners = collect($ownersRaw);
        //foreach ($owners as &$owner) {
        //    $owner = (array) $owner;
        //}

        //dd($owners);

        Excel::create('Documents_' . $now, function ($excel) use ($documents) {

            $excel->setTitle('Documents ');
            $excel->setCreator('Documents')->setCompany('Sothebys');
            $excel->setDescription('Documents');

            $excel->sheet('Sheet 1', function ($sheet) use ($documents) {
                $sheet->fromArray($documents, null, 'A1', true, true);

                $sheet->freezeFirstRow();

                // Set height for a single row
                $sheet->setHeight(1, 20);

                $sheet->cells('A1:F1', function ($cells) {

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
