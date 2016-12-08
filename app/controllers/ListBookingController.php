<?php
header('Content-type: text/plain; charset=utf-8');
class ListBookingController extends Controller{
    public function getIndex()
    {   
        $listBooking = DB::table('booking')
                    ->join('members' ,'members.id','=','booking.book_mem_id')
                    ->orderBy('booking.id','DESC')
                    ->select(DB::raw('booking.id AS id'),DB::raw('members.id AS idmem')
                            ,'mem_name','mem_lname','book_for','book_location','book_type'
                            ,'book_date_from','book_date_to','book_confirm')
                    ->paginate(30);
        $data = array('listBooking'=>$listBooking);
        return View::make('listbooking.index',$data);
    }
    public function getUpdate($id)
    {
        $booking = Booking::find($id);
        $member = Member::find($booking->book_mem_id);
        $carBook = DB::table('cars')->join('booking_car','cars.id','=','booking_car.bc_car_id')
                                    ->where('booking_car.bc_book_id','=',$id)
                                    ->orderBy('cars.car_no','asc')->get();
        $driverBook = DB::table('members')->join('booking_driver','members.id','=','booking_driver.bd_driver_id')
                                    ->where('booking_driver.bd_book_id','=',$id)
                                    ->orderBy('members.mem_name','asc')->get();
        $leader = !empty($booking->book_id_leader) ? Member::find($booking->book_id_leader) : null ;
        $master = !empty($booking->book_id_master) ? Member::find($booking->book_id_master) : null ;
        $data = array('booking'=>$booking,'member'=>$member,
                      'leader'=>$leader,'master'=>$master,
                      'driverBook'=>$driverBook,'carBook'=>$carBook);
        return View::make('listbooking.form',$data);
    }
     public function getDelete($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
        return Redirect::back()->with('message','ลบข้อมูลเรียบร้อย');
    }
    public function postUpdate()
    {
        $inputs = Input::all();
        $booking = Booking::find($inputs['id']);
        if(is_object($booking))
        {
            $booking->book_for = $inputs['book_for'];
            $booking->book_location = $inputs['book_location'];
            $booking->book_details = $inputs['book_details'];
            $booking->book_gps_lat = !empty($inputs['lat'])? $inputs['lat'] : '';
            $booking->book_gps_lon = !empty($inputs['lng'])? $inputs['lng'] : '';
            $booking->book_note_leader	 = !empty($inputs['book_note_leader'])? $inputs['book_note_leader'] : '';
            $booking->book_note_master = !empty($inputs['book_note_master'])? $inputs['book_note_master'] : '';
            // confirm
            $confrim = $booking->book_confirm;
            $confrimLeader = !empty($inputs['confirm_leader']) ? $inputs['confirm_leader'] : '';
            $confrimMaster = !empty($inputs['confirm_master']) ? $inputs['confirm_master']:'';
            //dd($confrimMaster);
            if(!empty($confrimLeader)&&(Session::get('level')==3)) // confirm=2
            {
                if((($confrim >= 1)&&($confrim <= 3)))
                { 
                    if($confrimLeader > 0)
                    {
                        if($booking->book_type=='ในเขตพื้นที่')
                        {
                            $confrim = 3;
                        }else if($booking->book_type=='นอกเขตพื้นที่')
                        {
                           $confrim = $confrimLeader;
                        }                 
                    }
                    else
                    {
                        $confrim = 0;
                    }
                }
                else if($confrimLeader!=0 && $booking->book_type=='ในเขตพื้นที่') // confirm == 0
                {
                        $confrim = 3;   
                }
                $booking->book_id_leader =  Auth::id();
            }
            if((($confrimMaster!='')&&(!empty($booking->book_id_master)))||(Session::get('level')==4)) // confirm=3
            {
                if($confrimMaster == 3)
                {
                 $confrim =$confrimMaster;
                }
                else
                {
                 $confrim=0;
                }
                $booking->book_id_master=Auth::id();
            }
            $booking->book_confirm=$confrim;
            $booking->save();
        }
        return Redirect::back()->with('message','บันทึกข้อมูลเรียบร้อย');
    }
    public function getPrint()
    {
//        include '/assets/mpdf/mpdf.php';
//        
//        $html = "ob_get_contents();" ;       //เก็บค่า html ไว้ใน $html 
//        ob_end_clean();
//        $pdf = new mPDF('th', 'A4-L', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
//        $pdf->SetAutoFont();
//        $pdf->SetDisplayMode('fullpage');
//        $pdf->WriteHTML($html, 2);
       // $pdf->Output("MyPDF/MyPDF.pdf");         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด
        return View::make('listbooking.print');
    }
}
