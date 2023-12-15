<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function index()
    {
        $id = Auth::user()->getId();
        $prescriptions = Prescription::where('user_id',$id)->get();
        $allprescriptions = Prescription::all();

        foreach ($allprescriptions as $pres) {
            $user = User::where('id',$pres->user_id)->first();
            $pres->user_id = $user->name;
        }

        return view('prescription')
             ->with('prescriptions', $prescriptions)
             ->with('allprescriptions',$allprescriptions);
    }

    public function create()
    {
        return view('prescription_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => ['string', 'max:255'],
            'delivery_address' => ['required', 'string', 'max:255'],
            'delivery_date' => ['required', 'string', 'max:255'],
        ]);

        $image = $request->file('image');
        $image1 = $request->file('image1');
        $image2 = $request->file('image2');
        $image3 = $request->file('image3');
        $image4 = $request->file('image4');

        $path = 'prescription1'."_".time().".".$image->getClientOriginalExtension();
        $return = $image->move(public_path('/pres/'), $path);

        if(isset($image1))
        {
            $path1 = 'prescription2'."_".time().".".$image1->getClientOriginalExtension();
            $return1 = $image1->move(public_path('/pres/'), $path1);
        } else {$path1 = null;}

        if(isset($image2))
        {
            $path2 = 'prescription3'."_".time().".".$image2->getClientOriginalExtension();
            $return2 = $image2->move(public_path('/pres/'), $path2);
        } else {$path2 = null;}

        if(isset($image3))
        {
            $path3 = 'prescription4'."_".time().".".$image3->getClientOriginalExtension();
            $return3 = $image3->move(public_path('/pres/'), $path3);
        } else {$path3 = null;}

        if(isset($image4))
        {
            $path4 = 'prescription5'."_".time().".".$image4->getClientOriginalExtension();
            $return4 = $image4->move(public_path('/pres/'), $path4);
        } else {$path4 = null;}

        $id = Auth::user()->getId();

        Prescription::create([
            'user_id'=>$id,
            'image'=>$path,
            'image1'=>$path1,
            'image2'=>$path2,
            'image3'=>$path3,
            'image4'=>$path4,
            'note'=>$request->note,
            'delivery_address'=>$request->delivery_address,
            'delivery_date'=>$request->delivery_date,
            ]);

        \Session::flash('flash_message','Prescription Created Successfully.');
        return redirect(route('prescription'));
    }
}
