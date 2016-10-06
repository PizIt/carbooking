@extends('default')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="header">
                                              <div class="pull-right">
                                                  <a href="{{url('manage/pickup/create')}}" class="btn btn-info">เพิ่มข้อมูลการเบิกน้ำมัน</a>
                                              </div>
                                        </div>
                                        <div class="content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th style="text-align:center"><label>#</label></th>
                                                    <th><label>วันที่เบิก</label></th>
                                                    <th><label>ชื่อผู้เบิก</label></th>
                                                    <th><label>รถที่ใช้เบิก</label></th>
                                                    <th><label>ประเภทน้ำมัน</label></th>
                                                    <th><label>จำนวน</label></th>
                                                    <th style="text-align:center"><label>จัดการ</label></th>
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
                                                            ?>
                                                            <tr>
                                                                <td style="text-align:center">{{++$cnt}}</td>
                                                                <td>{{$date}}</td>
                                                                <td>{{$p->mem_name.' '.$p->mem_lname}}</td>
                                                                <td>{{$p->car_no.' '.$p->car_province}}</td>
                                                                <td>{{$p->pk_type_fuel}}</td>
                                                                <td>{{$p->pk_qty}}</td>
                                                                <td style="text-align:center">
                                                                            <a href="{{url("manage/pickup/update/$p->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                            <a href="#" onclick="del({{$p->id}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                                </td>
                                                            </tr>
                                                       @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <center>{{$pickup->links()}} </center>
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
