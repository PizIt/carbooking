@extends('default')
@section('brand')
บันทึกการเบิกน้ำมัน
@stop
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                 <div class="row">
                                    <form method="GET" class="form-inline">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>เรียงตามรถ</label>
                                                <select class="form-control border-input" name="id">
                                                   <option value="">ทั้งหมด</option>
                                                    @foreach($car as $c)
                                                        <option value="{{$c->id}}" {{Input::get('id')==$c->id ? 'selected' : ''}}>{{$c->car_no.' '.$c->car_province}}</option>
                                                    @endforeach
                                                 </select>
                                                 </div>
                                                 <div class="form-group">
                                                    <input type="submit" class="btn btn-danger btn-block" value="แสดงข้อมูล">
                                                 </div>
                                        </div>
                                        @if(Session::get('level')==1)
                                        <div class="col-md-5">
                                              <div class="pull-right">
                                                  <a href="{{url('manage/pickup/create')}}" class="btn btn-default">เพิ่มข้อมูลการเบิกน้ำมัน</a>
                                              </div>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="content">
                                            <div class="content table-responsive table-full-width" style="overflow-x:auto;">
                                                <table class="table table-bordered table-striped fix" >
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="1%"><label>#</label></th>
                                                            <th rowspan="2"  width="9%" style="text-align:center"><label>วันที่เบิก</label></th>
                                                            <th rowspan="2" width="5.5%" style="text-align:center"><label>ครั้งที่</label></th>
                                                            <th rowspan="2" width="15%" style="text-align:center"><label>ผู้เบิก</label></th>
                                                            <th colspan="2" width="27%" style="text-align:center"><label>รถที่เบิก</label></th>
                                                            <th colspan="2" width="18%" style="text-align:center"><label>น้ำมัน</label></th>
                                                            <th rowspan="2" width="7%" style="text-align:center"><label>เลขที่ใบสั่งจ่าย</label></th>
                                                            <th colspan="2" style="text-align:center"><label>ระยะทางเบิก</label></th>
                                                            <th rowspan="2" widht="3%" style="text-align:center"><label>จัดการ</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="" style="text-align:center"><label>ทะเบียนรถ</label></th>
                                                            <th width="" style="text-align:center"><label>ประเภท</label></th>
                                                            <th width="" style="text-align:center"><label>ประเภท</label></th>
                                                            <th width="" style="text-align:center"><label>จำนวน</label></th>
                                                            <th width="" style="text-align:center"><label>ครั้งก่อน</label></th>
                                                            <th width="" style="text-align:center"><label>ปัจจุบัน</label></th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                         @if(count($pickup)>0)
                                                        <?php 
                                                           $util = new Util;
                                                           $currentPage = $pickup->getCurrentPage();
                                                           $perPage = $pickup->getPerPage();
                                                           $cnt = ($currentPage*$perPage)-$perPage;
                                                       ?>
                                                       @foreach($pickup as $p)
                                                            <?php 
                                                                 $date = $util->ThaiDate($p->pk_date_save);
                                                                 $month = $util->colvertListMonth($p->pk_month)
                                                            ?>
                                                        <tr>
                                                            <td style="text-align:center">{{++$cnt}}</td>
                                                            <td>{{$date}}</td>
                                                             <td>{{$p->pk_no.' / '.$month}}</td>
                                                            <td>{{$p->mem_name.' '.$p->mem_lname}}</td>
                                                            <td>{{$p->car_no.' '.$p->car_province}}</td>
                                                            <td>{{$p->car_dept}}</td>
                                                            <td>{{$p->pk_type_fuel}}</td>
                                                            <td style="text-align:right">{{$p->pk_qty}}</td>
                                                            <td style="text-align:right">{{$p->pk_order_no}}</td>
                                                            <td style="text-align:right">{{$p->pk_early_km}}</td>
                                                            <td style="text-align:right">{{$p->pk_now_km}}</td>
                                                             <td style="text-align:left">
                                                                    <a href="{{url("manage/pickup/update/$p->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                    <?php if((($p->idmem==Auth::id()) || (Session::get('level')>=3))&&($p->updated==TRUE)) {?>
                                                                    <a href="#" onclick="del({{$p->id}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                                    <?php } ?>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <center>{{$pickup->appends(array('id'=>Input::get('id')))->links()}} </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
    function del(id)
    {
    swal({title:'ต้องการลบข้อมูลหรือไม่' ,type: 'question',showCancelButton: true})
            .then(function(){
                 location.replace('{{URL::to("manage/pickup/delete")}}/'+id);
            });
    }
</script>
@stop
