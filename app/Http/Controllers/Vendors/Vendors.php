<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Vendor\Vendor;

class Vendors extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendors=DB::table('vendors')->get();
        return view('vendors.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $flag=1;
        $vendor_type= Vendors::getEnumValues('vendors','vendor_type');
        $business_type= Vendors::getEnumValues('vendors','business_type');
        return view('vendors.vendors.create',compact('vendor_type','business_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
          Vendor::create($request->all());
          // $url = request()->url();
          // echo $url;
           // if($url=='*/sales'){
           //      return redirect("sales");
           //  }
          // if(request()->is('*/sales')){
          //   return redirect("sales");
          // }
          // else
          return redirect("vendors");       
    }

    public function store1(Request $request)
    {
        //
          Vendor::create($request->all());
          return redirect("sales");
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
        $vendor_type= Vendors::getEnumValues('vendors','vendor_type');
        $business_type= Vendors::getEnumValues('vendors','business_type');
        return view('vendors.vendors.edit',compact('vendor','vendor_type','business_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Vendor $vendor,Request $request)
    {
        //
         $vendor->update($request->input());
        $message = trans('messages.success.updated', ['type' => trans_choice('general.vendors', 1)]);
        flash($message)->success();
        return redirect('vendors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
         $vendor->delete();
        $message = trans('messages.success.deleted', ['type' => trans_choice('general.vendors', 1)]);

            flash($message)->success();
        return redirect('vendors');
    }

    //to retrieve enum values from  database as an array
    public static function getEnumValues($table, $column) {
      $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
      preg_match('/^enum\((.*)\)$/', $type, $matches);
      $enum = array();
      foreach( explode(',', $matches[1]) as $value )
      {
        $v = trim( $value, "'" );
        $enum = array_add($enum, $v, $v);
      }
      return $enum;
    }
}
