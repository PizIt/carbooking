<?php

class Manage_ManageUsabilityCarController extends Controller{
    public function getIndex()
    {
        $useCar = DB::table('members')->join('usability_car','usability_car.us_id_driver','=','members.id')
                                ->orderBy('usability_car.id','desc')->paginate(30);
        $data = array('useCar'=>$useCar);
        return View::make('manage.usability.index',$data);
    }
    public function getCreate()
    {
        $cars = Car::orderBy('car_no','asc')->get();
        $drivers = Member::orderBy('mem_name','asc')->where('mem_level',1)->get();
        $data = array('drivers'=>$drivers,
                      'cars'=>$cars);
        return View::make('manage.usability.form',$data);
    }
    public function getUpdate($id)
    {
        $useCar = UsabilityCar::find($id);
        $cars = Car::orderBy('car_no','asc')->get();
        $drivers = Member::orderBy('mem_name','asc')->where('mem_level',1)->get();
        $data = array('useCar'=>$useCar,'drivers'=>$drivers,'cars'=>$cars);
        return View::make('manage.usability.form',$data);
    }
     public function getDelete($id)
    {
        $useCar = UsabilityCar::find($id);
        // update car count
        $dst=$useCar->us_dst_end-$useCar->us_dst_start;
        $this->updateCarCountDst($id,'delete',$dst);
        $useCar->delete();
        return Redirect::back()->with('message','ลบข้อมูลเรียบร้อย');
    }
    
    public function postCreate()
    {
        $inputs = Input::all();
        $useCar = new UsabilityCar;
        $util = new Util;
        $useCar->us_car_id = $inputs['us_car_id'];
        $useCar->us_id_driver = $inputs['us_id_driver'];
        $useCar->us_location = $inputs['us_location'];
        $useCar->us_name_user = $inputs['us_name_user'];
        $useCar->us_date_start =$util->DateTimeConvertToDate( $inputs['us_date_start']);
        $useCar->us_date_end = $util->DateTimeConvertToDate($inputs['us_date_end']);
        $useCar->us_dst_start= $inputs['us_dst_start'];
        $useCar->us_dst_end = $inputs['us_dst_end'];
        $useCar->us_note= $inputs['us_note'];
        $useCar->save();
        // update car count
        $dst = $inputs['us_dst_end']-$inputs['us_dst_start'];
        $this->updateCarCountDst($inputs['us_car_id'],'insert',$dst);
        return Redirect::back()->with('message','เพิ่มข้อมูลเรียบร้อย');
    }
    public function postUpdate()
    {
        $inputs = Input::all();
        $useCar = UsabilityCar::find($inputs['id']);
        $util = new Util;
        if(is_object($useCar))
        {
            $useCar->us_car_id = $inputs['us_car_id'];
            $useCar->us_id_driver = $inputs['us_id_driver'];
            $useCar->us_location = $inputs['us_location'];
            $useCar->us_name_user = $inputs['us_name_user'];
            $useCar->us_date_start =$util->DateTimeConvertToDate( $inputs['us_date_start']);
            $useCar->us_date_end = $util->DateTimeConvertToDate($inputs['us_date_end']);
            $dstStart = $useCar->us_dst_start;
            $dstEnd = $useCar->us_dst_end;
            $useCar->us_dst_start= $inputs['us_dst_start'];
            $useCar->us_dst_end = $inputs['us_dst_end'];
            $useCar->us_note= $inputs['us_note'];
            $useCar->save();
            // update car count
            $dstNew = $inputs['us_dst_end']-$inputs['us_dst_start'];
            $dstOld = $dstEnd-$dstStart;
            $this->updateCarCountDst($inputs['us_car_id'],$dstOld,$dstNew);
          
        }
        return Redirect::back()->with('message','แก้ไขข้อมูลเรียบร้อย');
    }
    public function  updateCarCountDst($id,$dstOld,$dstNew)
    {
        $car = Car::find($id);
        if(is_object($car))
        {
            if($dstOld=='insert') // insert
            {
                $car->car_dst_count=$car->car_dst_count+$dstNew;
            }
            else if($dstOld=='delete')
            {
                $car->car_dst_count=$car->car_dst_count-$dstNew;
            }
            else if($dstOld>$dstNew)
            {
                $car->car_dst_count=$car->car_dst_count-($dstOld-$dstNew);
            }else if($dstOld<$dstNew)
            {
                $car->car_dst_count=$car->car_dst_count+($dstNew-$dstOld);
            }else 
            {
                return FALSE;
            }
            $car->save();
        }
    }
}

