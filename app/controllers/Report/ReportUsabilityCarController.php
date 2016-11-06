<?php
header('Content-type: text/plain; charset=utf-8');
class Report_ReportUsabilityCarController extends Controller{
    public function getIndex()
    {
        $inputs = Input::all();
        $month = !empty($inputs['month']) ? $inputs['month']: null; // null
        $year = !empty($inputs['year']) ? ''.($inputs['year']-543): null; // null
        $list=null;
        if(!empty($inputs['sort']) && $inputs['sort'] =='cars')
        {
            $sql = UsabilityCar::where(DB::raw('YEAR(usability_car.us_date_start)'),$year);
            if($month!=0)
            {
                $sql->where(DB::raw('MONTH(usability_car.us_date_start)'),$month);
            }
            if(Session::get('level')==1)
            {
                $casr = Car::where('car_driver_id',Auth::id())->lists('id');
                $sql->whereIn(DB::raw('usability_car.us_car_id'),$casr);
            }
            $sql->join('cars','cars.id','=','usability_car.us_car_id');

            $listUse =  $sql->groupBy('usability_car.us_car_id')
                        ->select('cars.id','cars.car_no','cars.car_province','cars.car_type','cars.car_dept')
                        ->get();
            
            $detailsSum = $sql->groupBy('usability_car.us_car_id')
                        ->select('us_car_id',DB::raw('SUM(us_dst_end-us_dst_start) AS totalDst')
                                ,DB::raw('COUNT(usability_car.id) AS totalUse'))->get();
            if((count($listUse)>0)&&(count($detailsSum)>0))
            {
                $list[][] = array();
                $row = 0;
                foreach ($listUse as $l)
                {   
                    $list[$row][0] = $l->car_no.' '.$l->car_province;
                    $list[$row][1] = $l->car_type;
                    $list[$row][2] = $l->car_dept;
                    foreach ($detailsSum as $d)
                    {
                        if($l->id==$d->us_car_id)
                        {
                            $list[$row][3] = $d->totalUse;
                            $list[$row][4] = $d->totalDst;
                        }
                    }
                    $list[$row][5] = $l->id;
                    $row++;
                }
           
            }
        }
        else //  by driver
        {
            $sql = UsabilityCar::where(DB::raw('YEAR(usability_car.us_date_start)'),$year);
            if($month!=0)
            {
                $sql->where(DB::raw('MONTH(usability_car.us_date_start)'),$month);
            }
            $sql->join('members','members.id','=','usability_car.us_id_driver');
            
            $listUse =  $sql->groupBy('usability_car.us_id_driver')
                        ->select('members.id','members.mem_name','members.mem_lname','members.mem_dept')
                        ->get();
            
            $detailsSum = $sql->groupBy('usability_car.us_id_driver')
                        ->select('us_id_driver',DB::raw('SUM(us_dst_end-us_dst_start) AS totalDst')
                                ,DB::raw('COUNT(usability_car.id) AS totalUse'))->get();
            if((count($listUse)>0)&&(count($detailsSum)>0))
            {
                $list[][] = array();
                $row = 0;
                foreach ($listUse as $l)
                {   
                    $list[$row][0] = $l->mem_name.' '.$l->mem_lname;
                    $list[$row][1] = $l->mem_dept;
                    foreach ($detailsSum as $d)
                    {
                        if($l->id==$d->us_id_driver)
                        {
                            $list[$row][2] = $d->totalUse;
                            $list[$row][3] = $d->totalDst;
                        }
                    }
                    $row++;
                }
            }
        }
        $data = array('list'=>$list);
        return View::make('report.usability.index',$data);
    }
    public function getDetail($idCar,$month,$year)
    {
        $car = Car::find($idCar);
        $driver = Member::find($car->car_driver_id);
        $sql= UsabilityCar::where(DB::raw('YEAR(us_date_start)'),'=',($year-543))->where('us_car_id','=',$idCar);
        $util = new Util;
        $txtDate="";
        if($month > 0) // 0 = all month
        {
             $sql=$sql->where(DB::raw('MONTH(us_date_start)'),'=',$month);
             $month=$util->listMonth($month);
             $txtDate =$month.' / ';
        }
        $useCar=$sql->join('members','members.id','=','us_id_driver')
                ->select('us_name_user','us_location','us_date_start','us_date_end','us_dst_start','us_dst_end','mem_name','mem_lname','us_note')
                ->paginate(30);
        // label date
        
        $txtDate .=($year);
        $data = array('car'=>$car,'driver'=>$driver,'txtDate'=>$txtDate,'usecar'=>$useCar);
        return View::make('report.usability.detail',$data);
    }
}
