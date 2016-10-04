@extends('default')
@section('content') 
 <div class="content">
            <div class="container-fluid">           
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <strong>รายการจองรถ </strong>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                    <td><label>#</label></td>
                                    <td><label>ผู้จอง</label></td>
                                    <td><label>ใช้เพื่อ</label></td>
                                    <td><label>สถานที่เดินทาง</label></td>
                                    <td style="text-align: center"><label>วันเวลา</label></td>
                                    <td><label>สถานะ</label></td>
                                    <td><label>จัดการ</label></td>
                                    </thead>
                                    <tbody>
                                        @if(count($listBooking)>=0)
                                        <?php $util = new Util;  $cnt=1;?>
                                        @foreach($listBooking as $l)
                                        <?php 
                                        $status = $l->book_confirm;
                                        $color = "";
                                        if($status=='1' || $status=='2')
                                        {
                                            $status = "รอการอนุมัติ";
                                            $color = "text-warning";
                                        }else  if($status=='3'){
                                            $status = "อนุมัติแล้ว";
                                            $color = "text-success"; 
                                        }
                                        else if($status=='0'){
                                            $status = "ไม่อนุมัติ";
                                            $color = "text-danger"; 
                                        }
                                        ?>
                                        <tr>
                                            <td>{{$cnt++;}}</td>
                                            <td class="text-info">{{$l->mem_name.' '.$l->mem_lname}}</td>
                                            <td>{{$l->book_for}}</td>
                                            <td>{{$l->book_location}}</td>
                                            <td style="text-align: center">{{$util->ThaiDateTime($l->book_date_from).' - '.$util->ThaiDateTime($l->book_date_to)}}</td>
                                            <td class="<?=$color?>"><?=$status?></td>
                                            <td>
                                                <a href="{{URL::to('listbooking/update/'.$l->id)}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                @if(Session::get('level')>=3)
                                                <a href="#" onclick="confirm({{$l->id}})"><i class="glyphicon glyphicon-random"></i></a>&nbsp;
                                                @endif
                                                <a href="#" onclick="print({{$l->id}})"><i class="glyphicon glyphicon-print"></i></a>&nbsp;
                                                <a href="#" onclick="del({{$l->id}})"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <hr>
                                <center>
                                    {{$listBooking->links()}}
                                    <input type="hidden" name="id" id="val" value="">
                                </center>
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
                     location.replace('{{URL::to("listbooking/delete")}}/'+id);
                });
    }
    function print(id)
    {
        $.ajax({
            type:'get',
            url:'{{URL::to("listbooking/print")}}/'+id,
            success: function (data) {
                
            }
        });
    }
</script>
@stop
<!--Export PDFs-->
@section('costom-js') 
<script type="text/javascript" src="{{URL::to('assets/exportPDF/tableExport.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/exportPDF/jquery.base64.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/exportPDF/jspdf/libs/sprintf.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/exportPDF/jspdf/jspdf.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/exportPDF/jspdf/libs/base64.js')}}"></script>
@stop
