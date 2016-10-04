@extends('default')
@section('content')  
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form class="form-inline" method="GET">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>แยกตาม</label>
                                                <select class="form-control border-input" name="sort">
                                                    <option value="all" {{(!empty(Input::get('sort'))&&('all'==Input::get('sort'))) ? 'selected' : ''}}>ทั้งหมด</option>
                                                    <option value="dept" {{(!empty(Input::get('sort'))&&('dept'==Input::get('sort'))) ? 'selected' : ''}}>กอง</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>เดือน</label>
                                                <select class="form-control border-input" name="month"> 
                                                    <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ",
                                                "กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
                                                    ?>
                                                    <?php for($i=0 ; $i<sizeof($month);$i++){?>
                                                    <option value="<?php echo $i; ?>" {{(!empty(Input::get('month'))&&($i==Input::get('month'))) ? 'selected' : ''}}><?php echo $month[$i];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>ปี</label>
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
                                    @if(Input::get('sort')=='all')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="header">
                                                <strong>รายงานการเบิกน้ำมันแบบสรุปทั้งหมด</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-bordered table-striped" border="0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="4%" style="text-align:center"><label>#</label></th>
                                                            <th colspan="2" width="20%"  style="text-align:center"><label>ข้อมูลรถ</label></th>
                                                            <th rowspan="2" width="15%"  style="text-align:center"><label>กอง</label></th>
                                                            <th colspan="3" style="text-align:center"><label>ปริมาณน้ำมัน(ลิตร)</label></th>
                                                            <th rowspan="2" style="text-align:center"><label>รวม</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="15%" style="text-align:center"><label>ทะเบียนรถ</label></th>
                                                            <th width="10%" style="text-align:center"><label>ประเภท</label></th>
                                                            <th  width="10%" style="text-align:center"><label>เบนซิลธรรมดา</label></th>
                                                            <th  width="10%" style="text-align:center"><label>เบนซิลซุปเปอร์</label></th>
                                                            <th  width="10%" style="text-align:center"><label>ดีเซล</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @if(count($list)>0)
                                                            <?php 
                                                                $totalAll=0;
                                                                $totalCol3=0;
                                                                $totalCol4=0;
                                                                $totalCol5=0;
                                                                $cnt=1;
                                                            ?>
                                                            @foreach($list as $l)
                                                             <?php $sum=0;
                                                                  if(!empty($l[3])){$sum+=$l[3];$totalCol3+=$l[3];}
                                                                  if(!empty($l[4])){$sum+=$l[4];$totalCol4+=$l[4];}
                                                                  if(!empty($l[5])){$sum+=$l[5];$totalCol5+=$l[5];}
                                                            ;?>
                                                                    <tr>
                                                                        <td style="text-align:center">{{$cnt++;}}</td>
                                                                        <td><a href="#">{{$l[0]}}</a></td>
                                                                        <td>{{$l[1]}}</td>
                                                                        <td>{{$l[2]}}</td>
                                                                        <td style="text-align:right">{{!empty($l[3]) ? $l[3] : '0'}}</td>
                                                                        <td style="text-align:right">{{!empty($l[4]) ? $l[4] : '0'}}</td>
                                                                        <td style="text-align:right">{{!empty($l[5]) ? $l[5] : '0'}}</td>
                                                                        <td style="text-align:center">{{$sum}}</td>
                                                                    </tr>
                                                                    <?php $totalAll+=$sum;?>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="4"></td>
                                                                <td style="text-align:right">{{ number_format($totalCol3);}}</td>
                                                                <td style="text-align:right">{{ number_format($totalCol4);}}</td>
                                                                <td style="text-align:right">{{ number_format($totalCol5); }}</td>
                                                                <td style="text-align:center">{{ number_format($totalAll);}}</td>
                                                            </tr>
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
                                                 <strong>รายงานการเบิกน้ำมันแบบสรุปตามกอง</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-bordered table-striped" border="0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="4%" style="text-align:center"><label>#</label></th>
                                                            <th rowspan="2" width="20%" style="text-align:center"><label>กอง</label></th>
                                                            <th colspan="3" style="text-align:center"><label>ปริมาณน้ำมัน(ลิตร)</label></th>
                                                            <th rowspan="2" style="text-align:center"><label>รวม</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%" style="text-align:center"><label>เบนซิลธรรมดา</label></th>
                                                            <th width="10%" style="text-align:center"><label>เบนซิลซุปเปอร์</label></th>
                                                            <th width="10%" style="text-align:center"><label>ดีเซล</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($list)>0)
                                                        <?php $total = 0;  $cnt=1; ?>
                                                            @foreach($list as $l)
                                                            <?php $sum=0;
                                                                  if(!empty($l[1])){$sum+=$l[1];}
                                                                  if(!empty($l[2])){$sum+=$l[2];}
                                                                  if(!empty($l[3])){$sum+=$l[3];}
                                                            ;?>
                                                                    <tr>
                                                                        <td style="text-align:center">{{  $cnt++;}}</td>
                                                                        <td>{{$l[0]}}</td>
                                                                        <td style="text-align:right">{{!empty($l[1]) ? number_format($l[1]) : '0'}}</td>
                                                                        <td style="text-align:right">{{!empty($l[2]) ? number_format($l[2]) : '0'}}</td>
                                                                        <td style="text-align:right">{{!empty($l[3]) ? number_format($l[3]) : '0'}}</td>
                                                                        <td style="text-align:center">{{ number_format($sum);}}</td>
                                                                    </tr>
                                                           <?php $total += $sum; ?>
                                                            @endforeach
                                                             <td colspan="5"></td>
                                                             <td style="text-align:center">{{number_format($total);}}</td>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop