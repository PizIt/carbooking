@extends('default')
@section('brand')
รายงานการซ่อมบำรุง
@stop
@section('content')
<?php $disable = 'disabled style=background-color:#eee'; ?>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <strong>ข้อมูลการซ่อมบำรุงรถ</strong>
                            </div>
                            <div class="content">
                                <form method="POST" name="form" data-toggle="validator" role="form">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>หมายเลขทะเบียนรถ</label>
                                            <input type="text" class="form-control border-input" value="{{!empty($car->id) ? $car->car_no.' '.$car->car_province : '' }}" {{$disable}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>เลขระยะทางเมื่อเข้าซ่อม</label>
                                            <input type="text" class="form-control border-input" name="mn_car_dis" value="{{!empty($main->mn_car_dis) ? $main->mn_car_dis : ''}}" {{$disable}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <?php 
                                            $util = new Util;
                                            ?>
                                            <label>วันที่บันทึก</label>
                                            <input type="text" id="dateSave" class="form-control border-input" name="mn_date_save" value="{{!empty($main->mn_date_save) ? $util->DateConvertToView($main->mn_date_save): ''}}" {{$disable}}>
                                        </div>
                                         <div class="col-md-3 form-group">
                                            <label>ชื่อผู้บันทึก</label>
                                            <input type="text" class="form-control border-input" value="{{$member->mem_name.' '.$member->mem_lname}}" {{$disable}}>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>รายละเอียดการซ่อม</label>
                                            <textarea rows="5" class="form-control border-input" name="mn_details" {{$disable}}>{{!empty($main->mn_details) ? $main->mn_details : '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>สถานที่ซ่อม</label>
                                            <textarea rows="5" class="form-control border-input" name="mn_shop" {{$disable}}>{{!empty($main->mn_shop) ? $main->mn_shop : '' }}</textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="header">
                                           <i class="ti-pencil-alt2"></i>รายการซ่อม
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><label>#</label></th>
                                                            <th><label>รายการ</th>
                                                            <th width="10%"><label>จำนวน</label></th>
                                                            <th width="20%"><label>ราคา/หน่วย บาท</label></th>
                                                            <th width="10%"><label>รวม</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($detail)>0)
                                                            <?php $total=0; $cnt=1; ?>
                                                            @foreach($detail as $d)
                                                            <?php $sum =$d->mnd_qty*$d->mnd_baht; ?>
                                                            <tr>
                                                                <td>{{$cnt++}}</td>
                                                                <td>{{$d->mnd_list}}</td>
                                                                <td>{{$d->mnd_qty}}</td>
                                                                <td><?php echo number_format($d->mnd_baht,2); ?></td>
                                                                <td><?php echo number_format($sum,2); ?></td>
                                                            </tr>
                                                            <?php $total+=$sum; ?>
                                                            @endforeach
                                                        <tr>
                                                            <td colspan="4" style="text-align:right"> Vat 7%</td>
                                                            <?php $vat = $total*.07; ?>
                                                            <td colspan="3"><span id="sumVat"><?php echo number_format($vat,2); ?></span> บาท</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align:right"><strong>รวมทั้งหมด</strong></td>
                                                            <td colspan="3"<span id="total"><?php echo number_format($total+$vat,2); ?></span>  บาท</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
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
