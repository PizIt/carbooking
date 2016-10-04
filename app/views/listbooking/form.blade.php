@extends('default')
@section('content')  
  <div class="content">
            <div class="container-fluid">                  
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="header">
                                    <h4 class="title">รายละเอียดการจองรถ</h4>
                                </div>
                                <div class="content">
                                    <form method="POST" name="form" data-toggle="validator" role="form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ชื่อผู้จอง</label>
                                                    <input type="text" class="form-control border-input"  value="{{$member->mem_name." ".$member->mem_lname}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_position}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_tel}}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ประเภท</label>
                                                    <select class="form-control border-input" name="book_type" readonly>
                                                        <option value="ภายใน" {{!empty($booking->book_type=='ภายใน')?'selected':''}}>ภายใน</option>
                                                        <option value="ภายนอก" {{!empty($booking->book_type=='ภายนอก')?'selected':''}}>ภายนอก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันเวลาที่เดินทาง</label>
                                                    <?php 
                                                    $util = new Util;
                                                    $dateStart = $util->DateTimeConvertToView($booking->book_date_from) ;      
                                                    $dateEnd = $util->DateTimeConvertToView($booking->book_date_to) ;
                                                    ?>
                                                    <input type="text" id="dateStart" name="book_date_from"  class="form-control border-input" placeholder="dd/MM/YYYY HH:ii" value="{{substr($dateStart,0,16)}}" readonly>
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่</label>
                                                    <input type="text" id="dateEnd" name="book_date_to" class="form-control border-input" placeholder="dd/MM/YYYY HH:ii" value="{{substr($dateEnd,0,16)}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ใช้เพื่อ</label>
                                                    <input type="text" name="book_for" class="form-control border-input" placeholder="จุดประสงค์การใช้งาน" value="{{$booking->book_for}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>สถานที่เดินทาง</label>
                                                    <input type="text" name="book_location" class="form-control border-input" placeholder="ไปที่ไหน" value="{{$booking->book_location}}">
                                                </div>
                                            </div>
                                        </div>
                                            <a href="#" id="openMap">แสดงแผนที่</a>
                                            <div class="card-map" id="rowMap">
                                                <div class="header">
                                                    <h4 class="title">Google Maps</h4>
                                                </div>
                                                <div class="map">
                                                    <div id="map"></div>
                                                </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>รายละเอียดเพิ่มเติม</label>
                                                    <textarea rows="5" name="book_details" class="form-control border-input">{{$booking->book_details}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="row">
                                        <div class="col-md-6">
                                            <div class="header">
                                                <strong>รายการรถที่จอง</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <tr>
                                                    <th>#</th>
                                                    <th>รูปรถ</th>
                                                    <th>ป้ายทะเบียน</th>
                                                    <th>ประเภท</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php $cnt=0;?>
                                                        @foreach($carBook as $c)
                                                        <tr>
                                                            <td><?=++$cnt?></td>
                                                            <td><img src="{{URL::to('img/cars/'.$c->car_pic.'')}}" width="80px" height="80px"></td>
                                                            <td>{{$c->car_no.' '.$c->car_province}}</td>
                                                            <td>{{$c->car_type}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="header">
                                                <strong>พนักงานขับรถที่จอง</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <tr>
                                                    <th>#</th>
                                                    <th>รูป</th>
                                                    <th>ชื่อพนักงงานขับรถ</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php $cnt=0;?>
                                                        @foreach($driverBook as $d)
                                                        <tr>
                                                            <td><?=++$cnt?></td>
                                                            <td><img src="{{URL::to('img/members/'.$d->mem_pic.'')}}" width="80px" height="80px"></td>
                                                            <td>{{$d->mem_name.' '.$d->mem_lname}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                               
                                            </div>
                                        </div>
                                    </div>
                                       
                                        <hr>
                                       <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped">
                                                <tr style="text-align:center">
                                                    <td colspan="2"><strong>ความเห็นของหัวหน้าสำนักปลัด</strong></td>
                                                    <td colspan="2"><strong>ความเห็นของนายกเทศมนตรี</strong></td>                                                 
                                                </tr>
                                                <tr style="text-align:center">
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_leader" value="2" 
                                                                   {{$booking->book_confirm >= 2  ? 'checked' : ''}} {{Session::get('level') >= 3 ? '':'disabled'}}>
                                                            <strong class="text-success">อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    <td style="width:25%">
                                                        <label>
                                                                <input type="radio" class="border-input" name="confirm_leader" value="0" 
                                                                    {{$booking->book_confirm == 0  ? 'checked' : ''}} {{Session::get('level') >=3 ? '':'disabled'}}>
                                                            <strong class="text-danger">ไม่อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_master" value="3" 
                                                                   {{$booking->book_confirm ==3  ? 'checked' : ''}} {{Session::get('level')==4 ? '':'disabled'}}>
                                                            <strong class="text-success">อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_master" value="0" 
                                                                   {{$booking->book_confirm == 0  ? 'checked' : ''}} {{Session::get('level')==4 ? '':'disabled'}}>
                                                            <strong class="text-danger">ไม่อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                </tr>
                                                 <tr style="text-align:center">
                                                     <td colspan="2"><strong>หมายเหตุ  </strong>
                                                            <input type="text" name="book_note_leader" class="form-control border-input" placeholder="หมายเหตุ" 
                                                                   value="{{!empty($booking->book_note_leader) ? $booking->book_note_leader : ''}}" {{Session::get('level')==3 ? '':'readonly style="background-color:beige;"'}}>
                                                     </td>
                                                     <td colspan="2"><strong>หมายเหตุ  </strong>
                                                            <input type="text" name="book_note_master" class="form-control border-input" placeholder="หมายเหตุ" 
                                                                   value="{{!empty($booking->book_note_master) ? $booking->book_note_master : ''}}" {{Session::get('level')==4 ? '':'readonly style="background-color:beige;"'}}>
                                                     </td>                                                 
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lat" id="lat" value="{{!empty($booking->book_gps_lat) ? $booking->book_gps_lat:''}}">
                                        <input type="hidden" name="lng" id="lng" value="{{!empty($booking->book_gps_lon) ? $booking->book_gps_lon:''}}">
                                        <input type="hidden" name="id" value="{{$booking->id}}">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-danger btn-fill btn-wd">บันทึก</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                           </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
  $('#openMap').click(function(){
    if($('#openMap').text()=='แสดงแผนที่')
    {
        $( "#rowMap" ).fadeIn( "slow");
        $('#openMap').text('ซ่อนแผนที่');
    }else
    {
         $( "#rowMap" ).fadeOut( "slow");
         $('#openMap').text('แสดงแผนที่');
    }
})
 window.onload= function(){
        $('#rowMap').hide();
    } 
       function initMap() {
          var lat = {{!empty($booking->book_gps_lat)?$booking->book_gps_lat:'17.485257695007665'}};
          var lng = {{!($booking->book_gps_lon)?$booking->book_gps_lon:'101.73062393839837'}};
          var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 15
          });
          var marker = new google.maps.Marker ({map:map,draggable:true,
              animation:google.maps.Animation.BOUNCE,
              position : {lat: lat, lng: lng}
          });
        //get lat&lan
        marker.addListener('dragend',function(){
            var position = marker.getPosition();
            $('#lat').val(position.lat());
            $('#lng').val(position.lng());
        });
        } 
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAt7OP8jq0nhzMKFqd7AIKTvU_4N43_81M&callback=initMap"async defer></script>
@stop