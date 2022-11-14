<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\City_en;
use App\Models\Country;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create()
    {
        $country = Country::all();
        return view('admin.test.create');
    }

    public function cites($id = null){
        $cities = City::where('country_id',$id)->get();
        return view('admin.test.city',compact('cities'));
    }

    public function cites_en($id = null){
        $cities = City_en::where('country_en_id',$id)->get();
        return view('admin.test.city',compact('cities'));
    }

    public function store(Request $request)
    {
        $address = Address::create([
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'country_en_id' => $request->country_en_id,
            'city_en_id' => $request->city_en_id,
        ]);

        return redirect()->back();
    }


    public function address()
    {
        $address = Address::orderBy('id','desc')->get();
        return view('admin.test.show_address',compact('address'));
    }
}
