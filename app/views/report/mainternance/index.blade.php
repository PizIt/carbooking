@extends('default')
@section('brand')
รายงานการซ่อมบำรุง
@stop
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-bordered table-striped" border="0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="5%" style="text-align: center"><label>#</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>วันที่ซ่อม</label></th>
                                                            <th colspan="3" width="20%" style="text-align:center"><label>ข้อมูลรถที่ซ่อม</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>กอง</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>จำนวนเงิน</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="15%" style="text-align:center"><label>ทะเบียนรถ</label></th>
                                                            <th width="10%" style="text-align:center"><label>ประเภท</label></th>
                                                            <th width="10%" style="text-align:center"><label>พขร.ที่รับผิดชอบรถ</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($list)>0)
                                                            <?php $cnt=1; $sum=0;?>
                                                            @foreach($list as $l)
                                                                <tr>
                                                                    <td style="text-align: center">{{$cnt++}}</td>
                                                                    <td><a href="{{URL::to('report/mainternance/detail/'.$l[6])}}" target="_blank">{{$l[0];}}</a></td>
                                                                    <td>{{$l[1];}}</td>
                                                                    <td>{{$l[2];}}</td>
                                                                    <td>{{$l[3];}}</td>
                                                                    <td>{{$l[4];}}</td>                                                          
                                                                    <td style="text-align:right">{{number_format($l[5]);}}</td>
                                                                </tr>
                                                                <?php $sum +=$l[5]; ?>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="6" style="text-align: center"><label>รวม</label></td>
                                                                <td style="text-align: right">{{number_format($sum);}}</td>
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
