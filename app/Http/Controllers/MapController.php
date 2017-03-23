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

        activity("Google")->log('Map');
/*
// add lat long
//$add = urlencode("11 belair, constantia");
$add     = urlencode("25 jutland place, gauteng");
$geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM");

$output    = json_decode($geocode);
$town      = '';
$city      = '';
$city_area = '';

foreach ($output->results[0]->address_components as $component) {
if (in_array('street_number', $component->types)) {
//$this->streetNumber = $component->long_name;
} elseif (in_array('locality', $component->types)) {
$city = $component->long_name;
//$this->locality = $component->long_name;
} elseif (in_array('postal_town', $component->types)) {
//$this->town = $component->long_name;
} elseif (in_array('sublocality', $component->types)) {
//$this->town = $component->long_name;
$city_area = $component->long_name;
} elseif (in_array('administrative_area_level_2', $component->types)) {
//$this->country = $component->long_name;
} elseif (in_array('country', $component->types)) {
//$this->country = $component->long_name;
} elseif (in_array('administrative_area_level_1', $component->types)) {
//$this->district = $component->long_name;
$province = $component->long_name;
} elseif (in_array('postal_code', $component->types)) {
//$this->postcode = $component->long_name;
} elseif (in_array('route', $component->types)) {
//$this->streetAddress = $component->long_name;
}
}

$lat = $output->results[0]->geometry->location->lat;
$lng = $output->results[0]->geometry->location->lng;

$tosave['lat']  = $lng;
$tosave['long'] = $lat;

$status            = $output->status;
$formatted_address = $output->results[0]->formatted_address;

dd($status, $lat, $lng, $formatted_address, $province, $city, $city_area, $output);
 */
//marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png')
        Mapper::location('cape town')->map(['zoom' => 10, 'center' => true, 'marker' => false, 'type' => 'HYBRID', 'overlay' => 'NONE']);
        // Mapper::informationWindow('cape town', 'Content');
        // get all properties
        $areas      = Area::all();
        $properties = Property::all();
        $properties->load('images');

        foreach ($properties as $property) {
            //echo $areas[$property->area_id]->name;
            if (sizeof($property->images) > 0) {
                $image = 'property/' . $property->id . '/' . $property->images[0]['name'];
            }
            $link    = "<a href=" . url("/showproperty" . $property->id) . " >VIEW</a>";
            $content = 'Erf : ' . $property->erf . '<br>';
            $content = $content . $property->type . '<br>';
            $content = $content . $property->status . '<br>';
            $content = $content . $link . '<br>';

            // check for lat and long
            if ($property->long && $property->lat) {

                if ($property->status == "To Let") {
                    Mapper::marker($property->long, $property->lat, ['title' => $property->type . 'Erf: ' . $property->erf, 'eventRightClick' => 'console.log("right click");', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/green-dot.png"]);
                } elseif ($property->status == "For Sale") {
                    Mapper::marker($property->long, $property->lat, ['title' => $property->type . 'Erf: ' . $property->erf, 'eventRightClick' => 'console.log("right click");', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png"]);
                } else {
                    Mapper::marker($property->long, $property->lat, ['title' => $property->type . 'Erf: ' . $property->erf, 'eventRightClick' => 'console.log("right click");', 'content' => $content . '<br> <img src=' . $image . '  style="width:120px;" />', 'scale' => 13, 'animation' => 'DROP', 'icon' => "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"]);
                }
            }

            //  $m->setIcon("http://maps.google.com/mapfiles/ms/icons/purple-dot.png");

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
