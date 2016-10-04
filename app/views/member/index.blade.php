@extends('default')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                ข้อมูลส่วนตัวผู้ใช้งาน
                            </div>
                           
                            <div class="content">
                              <form name="form" data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>ชื่อ</label>
                                            <input type="text" name="mem_name" placeholder="ชื่อ" class="form-control border-input" value="{{!empty($member->mem_name) ? $member->mem_name :''}}" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>นามสกุล</label>
                                            <input type="text" name="mem_lname" placeholder="นามสกุล" class="form-control border-input" value="{{!empty($member->mem_lname) ? $member->mem_lname :''}}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>กอง</label>
                                            <input type="text" name="mem_dept" placeholder="กอง" class="form-control border-input" value="{{!empty($member->mem_dept) ? $member->mem_dept :''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>ตำแหน่ง</label>
                                            <input type="text" name="mem_position" placeholder="ตำแหน่ง" class="form-control border-input" value="{{!empty($member->mem_position) ? $member->mem_position :''}}" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เบอร์โทรศัพท์</label>
                                            <input type="text" name="mem_tel" placeholder="08X-XXXXXXX" class="form-control border-input" value="{{!empty($member->mem_tel) ? $member->mem_tel :''}}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>Username</label>
                                            <input type="text" name="mem_user" placeholder="Username" class="form-control border-input" value="{{!empty($member->mem_user) ? $member->mem_user :''}}" required>
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
                                            <img src="{{URL::to('img/members/'.$member->mem_pic.'')}}" width="250px" height="250px">
                                        </div>
<!--                                        <div class="col-md-3">
                                            <img src="signature.png" width="150px" height="150px">
                                        </div>-->
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