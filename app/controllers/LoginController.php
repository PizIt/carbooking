<?php

class LoginController extends Controller 
{
   
     public function getIndex()
   {
         if (Request::ajax())
        {
            $username = Input::get('username');
            $password = Input::get('password');
            $member = Member::where('mem_user','=',$username)
                            ->where('mem_pass','=',$password)->first();
            if(count($member)>0)
            {
                Auth::login($member);
                $level = $member->mem_level;
                $memberName = $member->mem_name.' '.$member->mem_lname;
                if($level!=2)
                {
                    $alertUseCar=null;
                    $alertActExp=null;
                    $sqlAlertUseCar = Car::where(DB::raw('(car_dst_alert-car_dst_count)'),'<=',500);
                    $sqlAlertActExp = Car::where('car_exp_alert',1);
                    if($level==4) // นายก แสดงรายการรถทั้งหมด
                    {
                        $alertUseCar=$sqlAlertUseCar->count();
                        $alertActExp=$sqlAlertActExp->count();
                    }
                    else if($level==3) // ผอ กอง แสดงเฉพาะในกอง
                    {
                        $alertUseCar=$sqlAlertUseCar->where('car_dept','=',$member->mem_dept)->count();
                        $alertActExp=$sqlAlertActExp->where('car_dept','=',$member->mem_dept)->count();
                    }
                    else if($level==1) // พขร สดงเฉพาะที่รับผิดชอบ
                    {
                        $alertUseCar=$sqlAlertUseCar->where('car_driver_id','=',Auth::id())->count();
                        $alertActExp=$sqlAlertActExp->where('car_driver_id','=',Auth::id())->count();
                    }
                  $notification = $alertUseCar+$alertActExp;
                  Session::put('notification',$notification);
                }
                Session::put('name',$memberName);
                Session::put('level',$level);
                return "success";
            }
             return "fail";
        }
        return Redirect::to('home');
   }
   public  function getLogout()
  {
      Auth::logout();
      Session::flush();
      return Redirect::to('home');
  }
}
