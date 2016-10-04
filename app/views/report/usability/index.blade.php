@extends('default')
@section('brand')
รายงานการใช้งานรถ
@stop
@section('content') 
 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form class="form-inline">
                                       
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>แยกตาม</label>
                                                <select class="form-control border-input" name="sort">
                                                    <option value="cars" {{(!empty(Input::get('sort'))&&('cars'==Input::get('sort'))) ? 'selected' : ''}}>รถ</option>
                                                    <option value="driver" {{(!empty(Input::get('sort'))&&('driver'==Input::get('sort'))) ? 'selected' : ''}}>พนักงานขับรถ</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>ประจำเดือน</label>
                                                <select class="form-control border-input" name="month">
<!--                                                    <option value="all" {{(!empty(Input::get('month'))&&('all'==Input::get('month'))) ? 'selected' : ''}}>ทุกเดือน</option>-->
                                                  <?php $month = array("ทุกเดือน","มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ",
                                                "กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
                                                    ?>
                                                    <?php for($i=0 ; $i<sizeof($month);$i++){?>
                                                    <option value="<?php echo $i; ?>" {{$i==Input::get('month') ? 'selected' : ''}}><?php echo $month[$i];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>ปี </label>
                                                <select class="form-control border-input" name="year">
                                                    <?php 
                                                    $yearNow = date('Y')+543;
                                                    for($yearEnd=2558;$yearEnd<=$yearNow;$yearNow--) { 
                                                        ?>
                                                    <option value="<?php echo $yearNow; ?>" {{(!empty(Input::get('year'))&&($yearNow==Input::get('year'))) ? 'selected' : ''}}><?php echo $yearNow; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-danger btn-block" value="แสดงข้อมูล">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @if(Input::get('sort')=='cars')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="header">
                                                    <strong>รายงานแบบตามสรุปตามรถ</strong>
                                                </div>
                                                <div class="content table-responsive table-full-width">
                                                    <table class="table table-bordered table-striped" border="0">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" width="4%" style="text-align:center"><label>#</label></th>
                                                                <th colspan="2" width="15%"  style="text-align:center"><label>ข้อมูลรถ</label></th>
                                                                <th rowspan="2" width="10%"  style="text-align:center"><label>กอง</label></th>
                                                                <th colspan="2" style="text-align:center"><label>ข้อมูลการใช้งาน</label></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="15%" style="text-align:center"><label>ทะเบียนรถ</label></th>
                                                                <th width="10%" style="text-align:center"><label>ประเภท</label></th>
                                                                <th width="10%" style="text-align:center"><label>จำนวนครั้งที่ใช้(ครั้ง)</label></th>
                                                                <th width="10%" style="text-align:center"><label>ระยะทางรวม(กิโลเมตร)</label></th>                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($list)>0)
                                                            <?php $cnt=1;?>
                                                                @foreach($list as $l)
                                                                <tr>
                                                                    <td style="text-align:center">{{$cnt++;}}</td>
                                                                    <td><a href="{{URL::to('report/usability/detail/'.$l[5].'/'.Input::get('month').'/'.Input::get('year'))}}" target="_blank">{{$l[0];}}</a></td>
                                                                    <td>{{$l[1];}}</td>
                                                                    <td>{{$l[2];}}</td>
                                                                    <td style="text-align:center">{{$l[3];}}</td>
                                                                    <td style="text-align:right">{{number_format($l[4]);}}</td>
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="header">
                                                    <strong>รายงานแบบตามสรุปตามพนักงานขับรถ</strong>
                                                </div>
                                                <div class="content table-responsive table-full-width">
                                                    <table class="table table-bordered table-striped" border="0">
                                                        <thead>
                                                            <tr>
                                                                <th width="4%" style="text-align:center"><label>#</label></th>
                                                                <th width="10%" style="text-align:center"><label>ชื่อพนักงานขับรถ</label></th>
                                                                <th width="20%" style="text-align:center"><label>กอง</label></th>
                                                                <th width="20%" style="text-align:center"><label>จำนวนครั้งที่ใช้รถ</label></th>
                                                                <th width="20%" style="text-align:center"><label>ระยะทางที่ขับ</label></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($list)>0)
                                                                @foreach($list as $l)
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td><a href="#">{{$l[0];}}</a></td>
                                                                    <td>{{$l[1];}}</td>
                                                                    <td align="right">{{$l[2];}}</td>
                                                                    <td align="right">{{number_format($l[3])}}</td>                                                          
                                                                </tr>
                                                                @endforeach
                                                            @endif                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                             </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
