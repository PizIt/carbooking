<?php
header('Content-type: text/plain; charset=utf-8');
class Manage_ManageMemberController extends Controller{
    public function getIndex()
    {
        $data = array(
            'member'=>Member::paginate(30)
        );
        return View::make('manage.member.index',$data);
    }
    public  function getCreate()
    {
        return View::make('manage.member.form');
    }
     public  function getUpdate($id)
    {
        $member = Member::find($id);
        $data = array('member'=>$member);
        return View::make('manage.member.form',$data);
    }
     public  function getDelete($id)
    {
        $member = Member::find($id);
        $member->delete();
        return Redirect::back()->with('message','ลบข้อมูลเรียบร้อย');
    }
    public function postCreate()
    {
        $inputs = Input::all();
        $member = new Member;
        $photoNewName='';
        
        $rule = array('mem_user'=>'unique:members,mem_user');
        $validation =  Validator::make($inputs,$rule);
        if($validation->fails())
        {
            dd('if validation');
            return Redirect::back()->withErrors($validation)->withInput();
        }
        else
        {   
             if(Input::hasFile('mem_pic'))
            {
                $photo = Input::file('mem_pic');
                $photoNewName=date('YmdHis').'.'.$photo
                        ->getClientOriginalExtension();
                $photo->move('img/members/',$photoNewName); 
                $member->mem_pic = $photoNewName;
            }
            else
            {   // check default pic 1 = driver
                if($inputs['mem_level']==1)
                {
                     $member->mem_pic = 'driver.png';
                }
                else
                {
                     $member->mem_pic = 'member.png';
                }
            }
            $member->mem_name = $inputs['mem_name'];
            $member->mem_lname= $inputs['mem_lname'];
            $member->mem_dept = $inputs['mem_dept'];
            $member->mem_position = $inputs['mem_position'];
            $member->mem_tel = $inputs['mem_tel'];
            $member->mem_user = $inputs['mem_user'];
            $member->mem_pass = $inputs['mem_pass'];
            $member->mem_email = !empty($inputs['mem_email'])?$inputs['mem_email']:'';
            $member->mem_sig = 'null';
            $member->mem_level = $inputs['mem_level'];
            $member->save();
            return Redirect::back()->with('message','เพิ่มข้อมูลเรียบร้อย');
        }
    }
     public  function postUpdate()
    {
        $inputs = Input::all();
        $member = Member::find($inputs['id']);
        if(is_object($member))
        {
             $photoNewName='';
            if(Input::hasFile('mem_pic'))
            {
                if(!empty($member->mem_pic))
                {
                    File::delete('img/members/'.$member->mem_pic);
                }
                $photo = Input::file('mem_pic');
                $photoNewName=date('YmdHis').'.'.$photo
                        ->getClientOriginalExtension();
                $photo->move('img/members/',$photoNewName); 
                $member->mem_pic =$photoNewName;
            }
        $member->mem_name = $inputs['mem_name'];
        $member->mem_lname= $inputs['mem_lname'];
        $member->mem_dept = $inputs['mem_dept'];
        $member->mem_position = $inputs['mem_position'];
        $member->mem_tel = $inputs['mem_tel'];
        $member->mem_pass = $inputs['mem_pass'];
        $member->mem_email = !empty($inputs['mem_email'])? $inputs['mem_email']:'null';
        $member->mem_sig = 'null';
        $member->mem_level = $inputs['mem_level'];
        $member->save();
        // change name member
        $memberName = $member->mem_name.' '.$member->mem_lname;
        Session::put('name',$memberName);
        }
        return Redirect::back()->with('message','แก้ไขข้อมูลเรียบร้อย');
    }
    
    
}
