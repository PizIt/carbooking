<?php
header('Content-type: text/plain; charset=utf-8');
class Report_ReportMainternanceController extends Controller{
    public function getIndex()
    {   
        $inputs = Input::all();
        $year = !empty($inputs['year']) ? $inputs['year'] :null;
        
        $sql  =  MainternanceCar::where(DB::raw('YEAR(mn_date_save)'),$year-543)
                ->join('cars','cars.id','=','mn_car_id')
                ->join('members','members.id','=','mn_mem_id');
        $listMainter =$sql
                ->select('mainternance_car.id','mn_date_save','cars.car_no','cars.car_province','cars.car_type',
                        'cars.car_dept','mem_name','mem_lname')
                ->orderBy('mn_date_save','DESC')
                ->get();
        $listId = $sql->lists('mainternance_car.id');
        $details = MainternanceDetail::whereIn('mnd_mn_id',$listId)
                ->groupBy('mnd_mn_id')
                ->select('mnd_mn_id',DB::raw('SUM(mnd_qty*mnd_baht) AS total'))
                ->get();
        $list = null;
        if((count($listMainter)>0)&&(count($details)>0))
        {
            $list[][] = array();
            $util = new Util;
            $row=0;
            foreach ($listMainter as $l)
            {
                $list[$row][0]=$util->ThaiDate($l->mn_date_save);
                $list[$row][1]=$l->car_no.' '.$l->car_province;
                $list[$row][2]=$l->car_type;
                $list[$row][3]=$l->mem_name.' '.$l->mem_lname;
                $list[$row][4]=$l->car_dept;
                foreach ($details as $d)
                {
                    if($l->id==$d->mnd_mn_id)
                    {
                        $total = $d->total;
                        $vat = $total*.07;
                        $list[$row][5]=$total+$vat;
                    }
                }
                $list[$row][6]=$l->id; // id mainternance
                $row++;
            }
        }   
        $data = array('list'=>$list);
        return View::make('report.mainternance.index',$data);
    }
    public function getDetail($id)
    {
        $mainternance = MainternanceCar::find($id);
        $detail = MainternanceDetail::where('mnd_mn_id',$mainternance->id)->get();
        $car = Car::find($mainternance->mn_car_id);
        $member = Member::find($mainternance->mn_mem_id); 
        $data = array('car'=>$car,'member'=>$member
                      ,'main'=>$mainternance,'detail'=>$detail);
        return View::make('report.mainternance.detail',$data);
    }
}