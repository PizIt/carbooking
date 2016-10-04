<?php
class MemberController extends Controller
{
    public function getIndex()
    {
        $member = Member::find(Auth::id());
        $data = array('member'=> $member);
        return View::make('member.index',$data);
    }
    
      public function postIndex()
    {
        $inputs = Input::all();
        $member = Member::find(Auth::id());
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
                $photoNewName=date('YmdHis').'.'.$photo->getClientOriginalExtension();
                $photo->move('img/members/',$photoNewName); 
                 $member->mem_pic =$photoNewName;
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
        $member->save();
        }
        return Redirect::back()->with('message','แก้ไขข้อมูลเรียบร้อย');
    }
    
}

