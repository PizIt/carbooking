<?php
class Manage_ManageMainternanceController extends Controller
{
    public function getIndex()
    {
        $sql  =  MainternanceCar::join('cars','cars.id','=','mn_car_id')
                ->join('members','members.id','=','mn_mem_id');
        $listMainter =$sql
                ->select(DB::raw('mainternance_car.id AS id'),DB::raw('mainternance_car.mn_mem_id AS idmem')
                        ,'mn_date_save','cars.car_no','cars.car_province','cars.car_type',
                        'cars.car_dept','mem_name','mem_lname')
                ->orderBy('mn_date_save','DESC')
                ->paginate(30);
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
                $list[$row][6]=$l->idmem;
                $list[$row][7]=$l->id;
                $row++;
            }
        }   
        $data = array('list'=>$list,'main'=>$listMainter);
        return View::make('manage.mainternance.index',$data);
    }
    public function getCreate()
    {
        $cars = Car::where('car_driver_id',Auth::id())->orderBy('car_no','ASC')->get();
        $member = Member::find(Auth::id());
        $data = array('cars'=>$cars,'member'=>$member);
        return View::make('manage.mainternance.form',$data);
    }
    public function postUpdateList()
    {
       $detail = new MainternanceDetail;
       $detail->mnd_mn_id = Input::get('id');
       $detail->mnd_list = Input::get('mnd_list');
       $detail->mnd_qty = Input::get('mnd_qty');
       $detail->mnd_baht = Input::get('mnd_baht');
       $detail->save();
       return 'success';
    }
    public function getUpdate($id)
    {
        $mainternance = MainternanceCar::find($id);
        $detail = MainternanceDetail::where('mnd_mn_id',$mainternance->id)->get();
        $cars = Car::where('car_driver_id',$mainternance->mn_mem_id)->orderBy('car_no','ASC')->get();
        
        $member = Member::find($mainternance->mn_mem_id); 
        $data = array('cars'=>$cars,'member'=>$member
                      ,'main'=>$mainternance,'detail'=>$detail);
        return View::make('manage.mainternance.form',$data);
    }
    public function getDelete($id)
    {
       $mainternance = MainternanceCar::find($id);
       $mainternance->delete();
       return Redirect::back()->with('message','ลบข้อมูลรียบร้อย');
    }
    public function getDeleteList($id)
    {
        $list = MainternanceDetail::find($id);
        $list->delete();
        return Redirect::back()->with('message','ลบรายการเรียบร้อย');
    }
    public function postCreate()
    {
        $mainternance = new MainternanceCar;
        $util = new Util;
        $inputs = Input::all();
        $mainternance->mn_car_id= $inputs['mn_car_id'];
        $mainternance->mn_shop=$inputs['mn_shop'];
        $mainternance->mn_mem_id=Auth::id();
        $mainternance->mn_details=$inputs['mn_details'];
        $mainternance->mn_date_save=$util->DateConvertToDate($inputs['mn_date_save']) ;
        $mainternance->mn_car_dis=$inputs['mn_car_dis'];
        $mainternance->save();
        $id = $mainternance->id;
        return Redirect::to('manage/mainternance/update/'.$id.'')->with('message','เพิ่มข้อมูลเรียบร้อย');
    }
    public function postUpdate()
    {
        $inputs = Input::all();
        $util = new Util;
        $mainternance = MainternanceCar::find($inputs['id']);
        if(is_object($mainternance))
        {  
            $mainternance->mn_car_id= $inputs['mn_car_id'];
            $mainternance->mn_shop=$inputs['mn_shop'];
            $mainternance->mn_details=$inputs['mn_details'];
            $mainternance->mn_date_save=$util->DateConvertToDate($inputs['mn_date_save']) ;
            $mainternance->mn_car_dis=$inputs['mn_car_dis'];
            $mainternance->save();
        }
        return Redirect::back()->with('message','บันทึกข้อมูลเรียบร้อย');
    }
}

