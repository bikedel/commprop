<?php

namespace App\Http\Controllers;

use App\Area;
use App\Property;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class MapController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Mapper::location('cape town')->map(['zoom' => 10, 'center' => true, 'marker' => false, 'type' => 'STREET', 'overlay' => 'NONE']);
        // get all properties
        $areas      = Area::all();
        $properties = Property::all();
        $properties->load('images');

        foreach ($properties as $property) {
            //echo $areas[$property->area_id]->name;
            if (sizeof($property->images) > 0) {
                $image = 'property/' . $property->id . '/' . $property->images[0]['name'];
            }
            $content = 'Erf : ' . $property->erf . '<br>';
            $content = $content . $property->type . '<br>';
            $content = $content . $property->status . '<br>';

            // check for lat and long
            if ($property->long && $property->lat) {
                Mapper::marker($property->long, $property->lat, ['title' => $property->type . 'Erf: ' . $property->erf, 'eventRightClick' => 'console.log("right click");', 'symbol' => 'circle', 'strokeColor' => '#FFFFFF', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP']);
            }
            //  echo 'erf ' . $property->erf . ' <BR>';
            //  echo 'long ' . $property->long . ' <BR>';
            //  echo 'lat ' . $property->lat . ' <BR>';
            //echo 'property/' . $property->id . '/' . $property->images[0]['name'];

        }
        //dd($properties);
        //   bradcornford/Googlmapper
        //
        // dd("map controller");

        // Mapper::map(52.381128999999990000, 0.470085000000040000)->marker(53.381128999999990000, -1.470085000000040000, ['markers' => ['symbol' => 'circle', 'scale' => 1000, 'animation' => 'DROP']]);
        // Mapper::marker(53.381128999999990000, -1.470085000000040000);
        // Mapper::marker(53.381128999999990000, -1.470085000000040000, ['symbol' => 'circle', 'scale' => 1000]);
        // Mapper::streetview(53.381128999999990000, -1.470085000000040000, 1, 1, ['ui' => false]);

        // Mapper::map(-33.9249, 18.4241);
        // Mapper::marker(-33.9249, 18.43, ['symbol' => 'circle', 'scale' => 10]);
        // Mapper::marker(-33.91, 18.43, ['symbol' => 'circle', 'scale' => 10]);
        // Mapper::informationWindow(-33.91, 18.42, 'Content');

        //  Mapper::location('cape town')->map(['zoom' => 12, 'center' => true, 'marker' => false, 'type' => 'HYBRID', 'overlay' => 'TRAFFIC']);

        //Mapper::marker(-33.9249, 18.43, ['symbol' => 'circle', 'scale' => 12]);

        // Mapper::marker(-34.0257608, 18.423078900000064, ['title' => 'Commercial To Let', 'eventRightClick' => 'console.log("right click");', 'symbol' => 'circle', 'strokeColor' => '#FFFFFF', 'content' => 'Ref: 4567846<br> <img src="property/1/1.jpg" style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP']);
        // Mapper::marker(-34.024717, 18.418508999999972, ['title' => 'Residential For Sale', 'symbol' => 'circle', 'strokeColor' => '#FFFFFF', 'content' => 'Ref: 4567846<br> <img src="property/76/1487583097_F7A4402.jpg" style="width:120px;" />', 'scale' => 13, 'animation' => 'BOUNCE']);
        // Mapper::polygon([['latitude' => -34.02183300000001, 'longitude' => 18.419715999999994], ['latitude' => -33.9248685, 'longitude' => 18.6], ['latitude' => -33.98, 'longitude' => 18.65]], ['editable' => 'true'], ['strokeColor' => '#000000', 'strokeOpacity' => 0.1, 'strokeWeight' => 2, 'fillColor' => '#FFFFFF']);

        return view('map');
    }

}
