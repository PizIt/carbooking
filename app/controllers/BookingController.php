<?php
class BookingController extends Controller{
    public function getIndex()
    {
        $member = Member::find(Auth::id());
        $data = array('member'=>$member);
        return View::make('booking.index',$data);
    }  
    public function postIndex() 
    {
        $inputs = Input::all();
        $util = new Util; 
        $booking = new Booking;
        $booking->book_for = $inputs['book_for'];
        $booking->book_location = $inputs['book_location'];
        $booking->book_gps_lon=!empty($inputs['lon']) ? $inputs['lon'] : '';
        $booking->book_gps_lat=!empty($inputs['lat']) ? $inputs['lat'] : '';
        $booking->book_details = $inputs['book_details'];
        $booking->book_type = $inputs['book_type'];
        $booking->book_date_from = $util->DateTimeConvertToDate($inputs['book_date_from']);
        $booking->book_date_to = $util->DateTimeConvertToDate($inputs['book_date_to']);
        $booking->book_mem_id = Auth::id();
        if(Session::get('level')==3)
        {
            $booking->book_confirm=2;
            $booking->book_id_leader=Auth::id();
        }else if(Session::get('level')==4)
        {
            $booking->book_confirm=3;
            $booking->book_id_master=Auth::id();
        }
        if($booking->save())
        {
            //Insert Booking Cars
            foreach ($inputs['bc_car_id'] as $c)
            {
                $bookingCars = new BookingCar;
                $bookingCars->bc_book_id = $booking->id;
                $bookingCars->bc_car_id = $c;
                $bookingCars->save();
            }
            //Insert Booking Drivers 
              foreach ($inputs['bd_driver_id'] as $d)
            {
                $bookingDrivers = new BookingDriver;
                $bookingDrivers->bd_book_id = $booking->id;
                $bookingDrivers->bd_driver_id = $d;
                $bookingDrivers->save();
            }
        }
        return Redirect::to('listbooking')->with('message','จองรถเรียบร้อยแล้ว');
    }
    public function getCarAndDriver()
    {   
        $inputs = Input::all();
        $util = new Util;
        $dateStart= $util->DateTimeConvertToDate($inputs['dateStart']);
        $dateEnd =  $util->DateTimeConvertToDate($inputs['dateEnd']);
        
        $dateVal = array($dateStart,$dateEnd);
        // status 1 = warning ; 2 = warning ; 3 = confirm
        $booking = Booking::where('book_confirm','=',3)->where(function($result) use($dateVal){
                    
                    $result->orWhere(function($q)use($dateVal)
                    {
                        $q->whereBetween('book_date_from',$dateVal);
                    });
                    $result->orWhere(function($q)use($dateVal)
                    {
                        $q->whereBetween('book_date_to',$dateVal);
                    });
                })->lists('id');
        //dd($booking)      ;  
        $data= (array)$booking;

        $carBusy = BookingCar::distinct('bc_car_id')->whereIn('bc_book_id',$data)->lists('bc_car_id');
        $driverBusy= BookingDriver::distinct('bd_driver_id')->whereIn('bd_book_id',$data)->lists('bd_driver_id');
        
        // Car & Driver Free
        $carBusyId= (array)$carBusy;
        $driverBusyId= (array)$driverBusy;
        //dd($driverBusyId);
        
        $carFree = Car::WhereNotIn('id',$carBusyId)->where('car_status','Y')->get();    
        $driverFree = Member::WhereNotIn('id',$driverBusyId)->where('mem_level',1)->get(); 
        //dd($driverFree);
       
        $str="";
            $str.='<div class="col-md-6">';
            $str.='<div class="header">';
            $str.='<strong>รายการรถที่ว่าง</strong><strong  class="text-danger"> (เลือกอย่างน้อย 1 รายการ)</strong>';
            $str.='</div>';
            $str.=' <div class="content table-responsive table-full-width">';
            
            $str.='<table class="table table-striped">';
            $str.='<tr>';
            $str.='<th>#</th>';
            $str.='<th>รูปรถ</th>';
            $str.=' <th>ป้ายทะเบียน</th>';
            $str.='<th>ประเภท</th>';
            $str.='<th>เลือก</th>';
            $str.='</tr>';

            $str.= '<tbody>';
            if(count($carFree)>0)
            {   $cnt = 0;
                foreach ($carFree as $c) 
                {
                    $urlImg = URL::to('img/cars/'.$c->car_pic);
                    $str.= '<tr>';
                    $str.= '<td>'.++$cnt.'</td>';
                    $str.= '<td><img src="'.$urlImg.'" class="img-rounded" width="80px" height="80px"></td>';
                    $str.= '<td>'.$c->car_no.' '.$c->car_province.'</td>';
                    $str.= '<td>'.$c->car_type.'</td>';
                    $str.= '<td><input type="checkbox" value="'.$c->id.'" name="bc_car_id[]"></td>';
                    $str.= '</tr>';
                }
            }
            else
            {
                 $str.= '<tr>';
                 $str.= '<td colspan="5"><center><strong>ไม่มีรายการรถที่ว่าง</strong></center></td>';
                 $str.= '</tr>';
            }
            $str.= '</tbody>';
            $str.= '</table>';
            $str.='</div>';
            $str.='</div>';


            // Table Driver
            $str.='<div class="col-md-5">';
            $str.='<div class="header">';
            $str.='<strong>พนักงานขับรถ</strong> <strong  class="text-danger"> (เลือกอย่างน้อย 1 รายการ)</strong>';
            $str.='</div>';
            $str.='<div class="content table-responsive table-full-width">';
            $str.='<table class="table table-striped">';
            $str.='<tr>';
            $str.='<th>#</th>';
            $str.='<th>รูป</th>';
            $str.=' <th>ชื่อพนักงงานขับรถ</th>';
            $str.='<th>เลือก</th>';
            $str.='</tr>';
            

            $str.= '<tbody>';
            if(count($driverFree)>0)
            { 
                $cnt = 0;
                foreach ($driverFree as $d) 
                {
                    $urlImg = URL::to('img/members/'.$d->mem_pic);
                    $str.= '<tr>';
                    $str.= '<td>'.++$cnt.'</td>';
                    $str.= '<td><img src="'.$urlImg.'" class="img-rounded" width="80px" height="80px"></td>';
                    $str.= '<td>'.$d->mem_name.' '.$d->mem_lname.'</td>';
                    $str.= '<td><input type="checkbox" value="'.$d->id.'"  name="bd_driver_id[]"></td>';
                    $str.= '</tr>';
                 }
            }
            else
            {
                 $str.= '<tr>';
                 $str.= '<td colspan="4"><center><strong>ไม่มีพนักงานที่ว่าง</strong></center></td>';
                 $str.= '</tr>';
            }
            $str.= '</tbody>';
            $str.= '</table>';
            $str.='</div>';
            $str.='</div>';

        return $str;
    }
}