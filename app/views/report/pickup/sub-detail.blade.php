@extends('default')
@section('brand')
รายละเอียดการเบิกน้ำมัน
@stop
@section('content') 
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form method="" name="form" >
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>วันที่</label>
                                                <?php 
                                                    if(!empty($pickup->pk_date_save))
                                                    {
                                                        $util = new Util;
                                                        $dateSave = $util->DateConvertToView($pickup->pk_date_save);
                                                    }
                                                ?>
                                                <input type="text" id="dateSave" class="form-control border-input" name="pk_date_save" 
                                                       value="{{!empty($pickup->pk_date_save) ? $dateSave: ''}}" disabled style="background-color:#eee">
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <label>เบิกครั้งที่</label>
                                                <input type="text" class="form-control border-input" name="pk_no" value="{{!empty($pickup->pk_no) ? $pickup->pk_no : ''}}" disabled style="background-color:#eee">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>ประจำเดือน</label>
                                                <input type="text" class="form-control border-input" name="" value="{{$pickup->pk_month}}" disabled style="background-color:#eee"> 
                                            </div>                     
                                        </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>ชื่อผู้เบิก</label>
                                            <input type="text" class="form-control border-input" name="" value="{{$driver->mem_name.' '.$driver->mem_lname}}" disabled style="background-color:#eee">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>รถที่ต้องการเบิกน้ำมัน</label>
                                             <input type="text" class="form-control border-input" name="" value="{{$car->car_no.' '.$car->car_province.' ('.$car->car_type.')' }}" disabled style="background-color:#eee">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>ใช้ในงาน</label>
                                            <input type="text" class="form-control border-input" name="pk_for" value="{{!empty($pickup->pk_for) ? $pickup->pk_for : ''}}" disabled style="background-color:#eee">
                                        </div>
                                    </div>
                                        <hr>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>ประเภทน้ำมันที่ต้องการเบิก</label>
                                             <input type="text" class="form-control border-input" name="" value="{{$pickup->pk_type_fuel}}" disabled style="background-color:#eee">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>จำนวน(ลิตร)</label>
                                            <input type="number" class="form-control border-input" name="" value="{{!empty($pickup->pk_qty) ? $pickup->pk_qty : ''}}" disabled style="background-color:#eee">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>รายละเอียดการเบิก</label>
                                            <textarea rows="5" class="form-control border-input" name="" disabled style="background-color:#eee">{{!empty($pickup->pk_details) ? $pickup->pk_details : ''}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label>เบิกครั้งก่อนเข็มไมลค์</label>
                                            <input type="text" class="form-control border-input" name="" value="{{!empty($pickup->pk_early_km) ? $pickup->pk_early_km : ''}}" disabled style="background-color:#eee">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เบิกครั้งนี้เข็มไมลค์</label>
                                            <input type="text" class="form-control border-input" name="" value="{{!empty($pickup->pk_now_km) ? $pickup->pk_now_km : ''}}" disabled style="background-color:#eee">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เลขที่ใบสั่งจ่าย</label>
                                            <input type="text" class="form-control border-input" name="" value="{{!empty($pickup->pk_order_no) ? $pickup->pk_order_no : ''}}" disabled style="background-color:#eee">
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