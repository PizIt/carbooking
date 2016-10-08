<?php
class NotificationController extends Controller
{
    public function getIndex()
    {
        $alertUseCar=null;
        $alertActExp=null;
        $level = Session::get('level');
        $str="";
        $sqlAlertUseCar = Car::where(DB::raw('(car_dst_alert-car_dst_count)'),'<=',500)
                ->select('id','car_no','car_province',DB::raw('car_dst_alert-car_dst_count AS dst'))
                ->orderBy('dst','ASC');
        $sqlAlertActExp = Car::where('car_exp_alert',1) 
                ->select('id','car_no','car_province',DB::raw('DATEDIFF(car_act_exp,CURDATE()) AS valDate'))
                ->orderBy('valDate','ASC');
        if($level==4) // นายก แสดงรายการรถทั้งหมด
        {
            $alertUseCar=$sqlAlertUseCar->get();
            $alertActExp=$sqlAlertActExp->get();
        }
        else if($level==3) // ผอ กอง แสดงเฉพาะในกอง
        {
            $alertUseCar=$sqlAlertUseCar->where('car_dept','=',$member->mem_dept)->get();
            $alertActExp=$sqlAlertActExp->where('car_dept','=',$member->mem_dept)->get();
        }
        else if($level==1) // พขร สดงเฉพาะที่รับผิดชอบ
        {
            $alertUseCar=$sqlAlertUseCar->where('car_driver_id','=',Auth::id())->get();
            $alertActExp=$sqlAlertActExp->where('car_driver_id','=',Auth::id())->get();
        }
        foreach ($alertUseCar as $u)
        {
            $str .= '<li><a href="#">'.$u->car_no.' '.$u->car_province.' อีก '.$u->dst.' กม. ครบระยะ</a></li>';
          
        }
        foreach ($alertActExp as $a)
        {
            if($a->valDate>0)
            {
                $str .= '<li><a href="#">'.$a->car_no.' '.$a->car_province.' | อีก '.$a->valDate.' วัน พรบ.หมดอายุ</a></li>';
            }
            else  if($a->valDate==0)
            {
                 $str .= '<li><a href="#">'.$a->car_no.' '.$a->car_province.' | พรบ. หมดอายุวันนี้ </a></li>';
            }
            else if($a->valDate<0)
            {
                $str .= '<li><a href="#">'.$a->car_no.' '.$a->car_province.' | พรบ. หมดอายุแล้ว '.(($a->valDate)*(-1)).' วัน</a></li>';
            }
        }
        return $str;
    }
  
}