<?php
header('Content-type: text/plain; charset=utf-8');
class Report_ReportBookingController extends Controller{
    public function getIndex()
    {
        $inputs = Input::all();
        $listBooking = DB::table('members')
                    ->join('booking' ,'booking.book_mem_id','=','members.id')
                    ->orderBy('booking.id','DESC');
        if(!empty($inputs['dateStart'])&&!empty($inputs['dateEnd'])) 
        {
            $util = new Util;
            $dateStart = $util->DateConvertToDate($inputs['dateStart']);
            $dateEnd = $util->DateConvertToDate($inputs['dateEnd']);
            $dateVal = array($dateStart,$dateEnd);
            $listBooking->where(function($result) use($dateVal){
                    
                    $result->where(function($q)use($dateVal)
                    {
                        $q->whereBetween('book_date_from',$dateVal);
                    });
                    $result->where(function($q)use($dateVal)
                    {
                        $q->whereBetween('book_date_to',$dateVal);
                    });
                });
        }
        if(!empty($inputs['member'])) // ยังไม่เสร็จ
        {
            $memberName = $inputs['member'];
            $listBooking->where(DB::raw('concat(members.mem_name,members.mem_lname)'),'LIKE','%'.$memberName.'%');
        }
        if(!empty($inputs['dept']))
        {
            $dept = $inputs['dept'];
            $listBooking->where('members.mem_dept','=',$dept);
        }
        $listPage = $listBooking->paginate(30);
        $data = array('listBooking'=>$listPage);
        return View::make('report.booking.index',$data);
    }
    public function getDetail($id)
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
        return View::make('report.booking.detail',$data);
    }
}