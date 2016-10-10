@extends('default')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                    <a href="{{url('manage/member/index')}}" class="btn btn-default">
                                        <i class="glyphicon glyphicon-arrow-left"></i> กลับ
                                    </a>
                            </div>
                            <div class="content">
                              <form name="form" data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>ชื่อ</label>
                                            <input type="text" name="mem_name" placeholder="ชื่อ" class="form-control border-input" value="{{!empty($member->mem_name) ? $member->mem_name :''}}">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>นามสกุล</label>
                                            <input type="text" name="mem_lname" placeholder="นามสกุล" class="form-control border-input" value="{{!empty($member->mem_lname) ? $member->mem_lname :''}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>กอง</label>
                                            <select class="form-control border-input" name="mem_dept">
                                                <option value="ช่าง" {{((!empty($member->mem_dept))&&($member->mem_dept=='ช่าง'))? 'selected': ''}}>ช่าง</option>
                                                <option value="คลัง" {{((!empty($member->mem_dept))&&($member->mem_dept=='คลัง'))? 'selected': ''}}>คลัง</option>
                                                <option value="การศึกษา" {{((!empty($member->mem_dept))&&($member->mem_dept=='การศึกษา'))? 'selected': ''}}>การศึกษา</option>
                                                <option value="สาธารณสุขและสิ่งแวดล้อม" {{((!empty($member->mem_dept))&&($member->mem_dept=='สาธารณสุขและสิ่งแวดล้อม'))? 'selected': ''}}>สาธารณสุขและสิ่งแวดล้อม</option>
                                                <option value="วิชาการและแผนงาน" {{((!empty($member->mem_dept))&&($member->mem_dept=='วิชาการและแผนงาน'))? 'selected': ''}}>วิชาการและแผนงาน</option>
                                                <option value="สวัสดีการสังคม" {{((!empty($member->mem_dept))&&($member->mem_dept=='สวัสดีการสังคม'))? 'selected': ''}}}}>สวัสดีการสังคม</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>ตำแหน่ง</label>
                                            <input type="text" name="mem_position" placeholder="ตำแหน่ง" class="form-control border-input" value="{{!empty($member->mem_position) ? $member->mem_position :''}}" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เบอร์โทรศัพท์</label>
                                            <input type="text" name="mem_tel" placeholder="08X-XXXXXXX" class="form-control border-input" value="{{!empty($member->mem_tel) ? $member->mem_dept :''}}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>Username</label>
                                            <input type="text" name="mem_user" placeholder="Username" class="form-control border-input" 
                                                   value="{{!empty($member->mem_user) ? $member->mem_user :''}}"
                                                   {{Request::segment(3)=='create' ? '' : 'disabled style=background-color:#eee'}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Password</label>
                                            <input type="password" name="mem_pass" placeholder="Password" class="form-control border-input" value="{{!empty($member->mem_pass) ? $member->mem_pass :''}}" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>อีเมล์</label>
                                            <input type="email" name="mem_email" placeholder="test@domain.com" class="form-control border-input" value="{{!empty($member->mem_email) ? $member->mem_email :''}}" data-error="อีเมล์ไม่ถูกต้อง">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>รูปประจำตัว</label>
                                            <input type="file" name="mem_pic" class="form-control border-input">
                                        </div>
<!--                                        <div class="col-md-3">
                                            <label>ลายเซ็นต์</label>
                                            <input type="file" name="mem_sig" class="form-control border-input" value="11111">
                                        </div>-->
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>ระดับสมาชิก</label>
                                            <select class="form-control border-input" name="mem_level">
                                                <option value="2" {{(!empty($member->mem_level)&&($member->mem_level=="2")) ? 'selected' :''}}>ผู้ขอใช้รถ</option>
                                                <option value="1" {{(!empty($member->mem_level)&&($member->mem_level=="1")) ? 'selected' :''}}>พนักงานขับรถ</option>
                                                <option value="3" {{(!empty($member->mem_level)&&($member->mem_level=="3")) ? 'selected' :''}}>ผู้อำนวยการกอง</option>
                                                <option value="4" {{(!empty($member->mem_level)&&($member->mem_level=="4")) ? 'selected' :''}}>หัวหน้าสำนักปลัด</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>
                                    @if(!empty($member->id))  
                                       <input type="hidden" name="id" value="{{$member->id}}">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-1">
                                         
                                            <input type="submit" class="btn btn-danger btn-block" value="บันทึก">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="reset" class="btn btn-default btn-block" value="ล้าง">
                                        </div>
                                    </div>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop