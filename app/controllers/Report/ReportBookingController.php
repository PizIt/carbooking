<?php
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
                    
                    $result->orWhere(function($q)use($dateVal)
                    {
                        $q->whereBetween('book_date_from',$dateVal);
                    });
                    $result->orWhere(function($q)use($dateVal)
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
        return View::make('report.booking',$data);
    }
}