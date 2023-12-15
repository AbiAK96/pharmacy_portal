<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\QuotationItem;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuotationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class QuatationController extends Controller
{
   public function index()
   {
      $id = Auth::user()->getId();
      $quotations = Quotation::where('user_id',$id)->get();
      $allquotations = Quotation::all();

      foreach ($allquotations as $qus) {
         $user = User::where('id',$qus->user_id)->first();
         $qus->user_id = $user->name;
      }

      return view('quotations')
            ->with('quotations',$quotations)
            ->with('allquotations',$allquotations);
   }

   public function create($id)
   {
      
       $prescription = Prescription::where('id',$id)->first();
       //dd($prescriptions);

    return view('quotations_create')->with('prescription',$prescription);
   }

   public function store(Request $request,$id)
   {
      $prescription = Prescription::where('id',$id)->first();

      $user = User::where('id',$prescription->user_id)->first();
      
      
      $quotation = new Quotation();
      $quotation->user_id = $prescription->user_id;
      $quotation->prescription_id = $id;
      $quotation->total = $request->total;
      $quotation->note = $prescription->note;
      $quotation->delivery_address = $prescription->delivery_address;
      $quotation->delivery_date = $prescription->delivery_date;
      $quotation->save();
      
      for ($i=1; $i <= $request->row_count  ; $i++) 
      { 
         $quotation_item = new QuotationItem();
         $quotation_item->quotation_id = $quotation->id; 
         $quotation_item->drug = $request['drug_'.$i.''];
         $quotation_item->unit_price = $request['unit_'.$i.''];
         $quotation_item->quantity = $request['quantity_'.$i.''];
         $quotation_item->save();
      }
      $quotation_items = QuotationItem::where('quotation_id',$quotation->id)->get();
      Mail::to($user->email)->send(new QuotationEmail($user,$quotation,$quotation_items));
      $prescription->is_executed = true ;
      $prescription->update();

      \Session::flash('flash_message','Quotation Created Successfully.');
      return redirect(route('quotations'));
   }

   public function edit($id)
   {
      $quotation = Quotation::where('id',$id)->first();
      $quotation_items = QuotationItem::where('quotation_id',$id)->get();

      return view('quotations_edit')->with('quotation',$quotation)
                                    ->with('quotation_items',$quotation_items);
   }

   public function update($id, Request $request)
   {
      $quotation = Quotation::where('id',$id)->first();
      $quotation->type = $request->status;
      $quotation->update();

      \Session::flash('flash_message','Quotation updated Successfully.');
      return redirect(route('quotations'));
   }
}
