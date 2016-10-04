<?php
class Manage_ManageCarController extends Controller{
  public function getIndex()
    {
      $data = array('car'=> Car::paginate(30));
      return View::make('manage.car.index',$data);
    }
     public function getCreate()
    {
      $driver = Member::orderBy('mem_name','asc')->where('mem_level','=',1)->get();
      $data = array('driver'=>$driver);
      return View::make('manage.car.form',$data);
    }
     public function getUpdate($id)
    {
      $driver = Member::orderBy('mem_name','asc')->where('mem_level','=',1)->get(); 
      $car = Car::find($id);
      $data = array('car'=>$car,
                    'driver'=>$driver);
      return View::make('manage.car.form',$data);
    }
    public function getDelete($id)
    {
      $car = Car::find($id);
      if(!empty($car->car_pic))
      {
          File::delete('img/cars/'.$car->car_pic);
      }
      $car->delete();
      return Redirect::back()->with('message','ลบข้อมูลเรียบร้อย');
    }
    public function postCreate()
    {
        $inputs = Input::all();
        $car = new Car;
        $util = new Util;
        $photoNewName='';
        if(Input::hasFile('car_pic'))
        {
            $photo = Input::file('car_pic');
            $photoNewName = date('YmdHis').'.'.$photo->getClientOriginalExtension();
            $photo->move('img/cars/',$photoNewName);
        }
        $car->car_driver_id = $inputs['car_driver_id'];
        $car->car_no = $inputs['car_no'];
        $car->car_province = $inputs['car_province'];
        $car->car_type = $inputs['car_type'];
        $car->car_pic =  $photoNewName;
        $car->car_dept= $inputs['car_dept'];
        $car->car_color = $inputs['car_color'];
        $car->car_act_exp = $util->DateConvertToDate($inputs['car_act_exp']); 
        $car->car_dst_alert = $inputs['car_dst_alert'];
        $car->save();
        return Redirect::back()->with('message','เพิ่มข้อมูลเรียบร้อย');
    }
    public function postUpdate()
    {
        $inputs = Input::all();
        $car = Car::find($inputs['id']);
        if(is_object($car))
        {
            $photoNewName='';
            if(Input::hasFile('car_pic'))
            {
                if(!empty($car->car_pic))
                {
                    File::delete('img/cars/'.$car->car_pic);
                }
                $photo = Input::file('car_pic');
                $photoNewName = date('YmdHis').'.'.$photo->getClientOriginalExtension();
                $photo->move('img/cars/',$photoNewName);

            }
            $car->car_driver_id = $inputs['car_driver_id'];
            $car->car_no = $inputs['car_no'];
            $car->car_province = $inputs['car_province'];
            $car->car_type = $inputs['car_type'];
            $car->car_pic =  $photoNewName;
            $car->car_dept= $inputs['car_dept'];
            $car->car_color = $inputs['car_color'];
            $dateExp=  explode("-",$inputs['car_act_exp']); // format date dd-mm-yyyy
            $car->car_act_exp = $dateExp[2]."-".$dateExp[1]."-".$dateExp[0]; 
            $car->car_exp_alert = 0; 
            $car->car_dst_alert = $inputs['car_dst_alert'];
            $car->save();
        }
        return Redirect::back()->with('message','แก้ไขข้อมูลเรียบร้อย');
    }

}

