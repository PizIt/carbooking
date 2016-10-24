<?php
header('Content-type: text/plain; charset=utf-8');
class HomeController extends BaseController {

	public function getIndex()
	{
            return View::make('home');
	}
        public function getDetailEvent()
        {
            $id=Input::get('id');
            $booking = Booking::find($id);
            $bookingCars = $booking->bookingCars->lists('bc_car_id');
            $bookingDrivers = $booking->bookingDrivers->lists('bd_driver_id');
            
            $member = Member::find($booking->book_mem_id);
            $car = Car::whereIn('id',(array)$bookingCars)->get();
            $driver = Member::whereIn('id',(array)$bookingDrivers)->get();
            $util = new Util;
            $dateStart =  $util->ThaiDateTime($booking->book_date_from);
            $dateEnd =  $util->ThaiDateTime($booking->book_date_to);
            $str="";
            $str = '<div class="content table-responsive">';
            $str.='<table class="table">';           
            $str.='<tr width="10%">';
            $str.='<td>ผู้จองรถ</td><td>'.$member->mem_name.' '.$member->mem_lname.' : '.$member->mem_position.'</td>';
            $str.='</tr>';
            $str.='<tr>';
            $str.='<td>เบอร์โทรศัพท์</td><td>'.$member->mem_tel.'</td>';
            $str.='</tr>';
            $str.='<tr>';
            $str.='<td>ใช้เพื่อ</td><td>'.$booking->book_for.'</td>';
            $str.='</tr>';
            $str.='<tr>';
            $str.='<td>เวลาที่ใช้</td><td>'.$dateStart.' ถึง '.$dateEnd.'</td>';
            $str.='</tr>';
            $str.='<tr>';
            $str.='<td>สถานที่ไป</td><td>'.$booking->book_location.'</td>';
            $str.='</tr>';
            if(!empty($booking->book_gps_lon)) // showMap
            {
                $str.='<tr>';
                $str.='<td>แผนที่<input type="hidden" id="lng" value='.$booking->book_gps_lon.'>';
                $str.='<input type="hidden" id="lat" value='.$booking->book_gps_lat.'></td>';
                $str.='<td><a href="#" id="showMap">แสดงแผนที่</a><a href="#" id="hideMap" hidden>ซ่อนแผนที่</a><br>';
                $str.='<div class="card-map" id="layoutMap" hidden><div class="map"><div id="map"></div></div></div></td>';
                $str.='</tr>';
            }
            $str.='<tr>';
            $str.='<td>รายละเอียดการจอง</td><td><div id="mylayout">'.$booking->book_details.'</div></td>';
            $str.='</tr>';
            $str.='<tr>';
            $str.='<td >รายการที่จอง</td>';
            $str.='<td> รถยนต์ '.count($car).' คัน พนักงานขับรถ '.count($driver).' นาย</td>';
            $str.='</tr>';
            $str.='<tr>';
                $str.='<td colspan="2">';
                $str.='<div class="content table-responsive table-full-width">';
                $str.='<table class="table"  cellspacing="0" cellpadding="0">';
                    $str.='<td style="vertical-align: text-top;">รถยนต์<br>';
                    $i=0;
                    foreach ($car as $c) 
                    {
                        $str.=''.++$i.'. '.$c->car_no.' '.$c->car_province.'<br/>';
                    }    
                    $str.='</td>';
                    $str.='<td style="vertical-align: text-top;"> พนักงานขับรถ<br>';
                    $i=0;
                    foreach ($driver as $d) 
                    {
                        $str.=''.++$i.'. '.$d->mem_name.' '.$d->mem_lname.' [ <i class="glyphicon glyphicon-earphone"></i> '.$d->mem_tel.' ] <br/>';
                    }    
                    $str.='</td>';
                $str.='</table>';
                $str.='</div>';
                $str.='</td>';
            $str.='</tr>';
            $str.='</table>';
            $str.="</div>";
                  

            return $str;
        }
        public function getCalendar()
        {   
            $inputs = Input::all();
            $dateVal = [$inputs['start'],$inputs['end']]; // date start - end
            
           $booking = DB::table('booking')->where('booking.book_confirm','=',3)
                   ->where(function($result) use($dateVal){
                    
                    $result->orWhere(function($q)use($dateVal)
                    {
                        $q->whereBetween(DB::raw('DATE(booking.book_date_from)'),$dateVal);
                    });
                    $result->orWhere(function($q)use($dateVal)
                    {
                        $q->whereBetween(DB::raw('DATE(booking.book_date_to)'),$dateVal);
                    });
                    })->get();  
            
            foreach ($booking as $b)
            {
                $member = Member::find($b->book_mem_id);// query members
                $util = new Util;
                $bookTitle = $util->DateTimeConvertToTimeView($b->book_date_from).' ';
                $bookTitle.=$member->mem_name.' '.$member->mem_lname.' : '.$b->book_for;
                $bookTitle.=' : '.$b->book_location;
                $data[] = array(
                'id'=>$b->id,
                'title'=>$bookTitle,
                'start'=>$b->book_date_from,
                'end'=>$b->book_date_to,
                'allDay'=>FALSE
                );
            }
            return json_encode($data);
        }
}
