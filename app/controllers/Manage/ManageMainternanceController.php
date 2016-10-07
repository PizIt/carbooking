<?php
class Manage_ManageMainternanceController extends Controller
{
    public function getIndex()
    {
        $sql =  MainternanceCar::join('members','members.id','=','mn_mem_id')
                                ->join('cars','cars.id','=','mn_car_id')
                                ->join('shop','shop.id','=','mn_shop_id');
        $main  =$sql->select(DB::raw('mainternance_car.id as id'),DB::raw('mainternance_car.mn_mem_id as idmem')
                                ,'mn_date_save','mem_name','mem_lname'
                                ,'shop_name','car_no','car_province')
                                ->orderBy('mn_date_save','DESC')->paginate(30);
        $details = $sql->lists('mainternance_car.id');
        $totalPay = MainternanceDetail::whereIn('mnd_mn_id',$details)
                    ->groupBy('mnd_mn_id')
                    ->select('mnd_mn_id',DB::raw("SUM(mnd_qty*mnd_baht) AS total"))->get(); 
        $list[][] = array();
        $util = new Util;
        $row = 0;
        foreach ($main as $m) 
        {
            $list[$row][0] = $util->ThaiDate($m->mn_date_save);
            $list[$row][1] = $m->car_no.' '.$m->car_province;
            $list[$row][2] = $m->mem_name.' '.$m->mem_lname;
            $list[$row][3] = $m->shop_name;
            foreach ($totalPay as $t) 
            {
                if($m->id==$t->mnd_mn_id)
                {
                    $total = $t->total;
                    $vat = $total*.07;
                    $list[$row][4] = number_format($total+$vat,2);
                }
            }
            $list[$row][5]=$m->id;
            $list[$row][6]=$m->idmem;
            $row++;
        }
        $data = array('list'=>$list,'main'=>$main);
        return View::make('manage.mainternance.index',$data);
    }
    public function getCreate()
    {
        $cars = Car::where('car_driver_id',Auth::id())->orderBy('car_no','ASC')->get();
        $member = Member::find(Auth::id());
        $shop = Shop::orderBy('shop_name','ASC')->get();
        $data = array('cars'=>$cars,'member'=>$member,'shop'=>$shop);
        return View::make('manage.mainternance.form',$data);
    }
    public function getUpdateList()
    {
        return Input::get('mnd_list');
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
        $shop = Shop::orderBy('shop_name','ASC')->get();
        $data = array('cars'=>$cars,'member'=>$member,
                      'shop'=>$shop,'main'=>$mainternance,'detail'=>$detail);
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
        $mainternance->mn_shop_id=$inputs['mn_shop_id'];
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
            $mainternance->mn_shop_id=$inputs['mn_shop_id'];
            $mainternance->mn_details=$inputs['mn_details'];
            $mainternance->mn_date_save=$util->DateConvertToDate($inputs['mn_date_save']) ;
            $mainternance->mn_car_dis=$inputs['mn_car_dis'];
            $mainternance->save();
        }
        return Redirect::back()->with('message','บันทึกข้อมูลเรียบร้อย');
    }
    
}

