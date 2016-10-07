<?php

class Manage_ManagePickupController extends Controller
{
    public function getIndex()
    {
        $pickup = DB::table('pick_fuel')->join('members','members.id','=','pick_fuel.pk_id_driver')
                ->join('cars','cars.id','=','pick_fuel.pk_car_id')
                ->orderBy('pick_fuel.pk_date_save','desc')
                ->select(DB::raw('pick_fuel.id as id'),DB::raw('pick_fuel.pk_id_driver as idmem'),'pick_fuel.pk_date_save','pick_fuel.pk_type_fuel','pick_fuel.pk_qty',
                        'members.mem_name','mem_lname','cars.car_no','cars.car_province')
                ->paginate(30);
        $data = array('pickup'=>$pickup);
        return View::make('manage.pickup.index',$data);
    }
    public function getCreate()
    {
        $cars = Car::orderBy('car_no','asc')->get();
        $memberPick= Member::orderBy('mem_name','asc')->where('mem_level',1)->get();
        $data = array('memberPick'=>$memberPick,
                      'cars'=>$cars);
        return View::make('manage.pickup.form',$data);
    }
    public function getUpdate($id)
    {
        $pickup = PickFuel::find($id);
        $cars = Car::orderBy('car_no','asc')->get();
        $memberPick= Member::orderBy('mem_name','asc')->where('mem_level',1)->get();
        $data = array('pickup'=>$pickup,'memberPick'=>$memberPick,
                      'cars'=>$cars);
        return View::make('manage.pickup.form',$data);
    }
    public function postCreate()
    {
        $pick = new PickFuel();
        $inputs = Input::all();
        $until = new Util;
        $pick->pk_car_id=$inputs['pk_car_id'];
        $pick->pk_id_driver=$inputs['pk_id_driver'];
        $pick->pk_for=$inputs['pk_for'];
        $pick->pk_date_save=$until->DateConvertToDate($inputs['pk_date_save']);
        $pick->pk_no=$inputs['pk_no'];
        $pick->pk_month=$inputs['pk_month'];
        $pick->pk_details=$inputs['pk_details']; 
        $pick->pk_type_fuel=$inputs['pk_type_fuel'];
        $pick->pk_early_km=$inputs['pk_early_km'];
        $pick->pk_now_km=$inputs['pk_now_km'];
        $pick->pk_qty=$inputs['pk_qty'];
        $pick->pk_order_no=$inputs['pk_order_no'];
        $pick->save();
        return Redirect::back()->with('message','เพิ่มข้อมูลเรียบร้อย');     
    }
    public function postUpdate()
    {
        $inputs = Input::all();
        $until = new Util;
        $pick = PickFuel::find($inputs['id']);
        if(is_object($pick))
        {
            $pick->pk_car_id=$inputs['pk_car_id'];
            $pick->pk_id_driver=$inputs['pk_id_driver'];
            $pick->pk_for=$inputs['pk_for'];
            $pick->pk_date_save=$until->DateConvertToDate($inputs['pk_date_save']);
            $pick->pk_no=$inputs['pk_no'];
            $pick->pk_month=$inputs['pk_month'];
            $pick->pk_details=$inputs['pk_details']; 
            $pick->pk_type_fuel=$inputs['pk_type_fuel'];
            $pick->pk_early_km=$inputs['pk_early_km'];
            $pick->pk_now_km=$inputs['pk_now_km'];
            $pick->pk_qty=$inputs['pk_qty'];
            $pick->pk_order_no=$inputs['pk_order_no'];
            $pick->save();
        }
        return Redirect::back()->with('message','แก้ไขข้อมูลเรียบร้อย');     
    }
}