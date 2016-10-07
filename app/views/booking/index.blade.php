@extends('default')
@section('content')  
  <div class="content">
            <div class="container-fluid">   
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="header">
                                    <strong>รายละเอียดการจอง</strong>
                                </div>
                                <div class="content">
                                    <form  method="POST" id="form" name="form" data-toggle="validator" role="form" onsubmit="validateList();return false;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ชื่อผู้จอง</label>
                                                    <input type="text" class="form-control border-input"  value="{{$member->mem_name." ".$member->mem_lname}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_position}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_tel}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ประเภท</label>
                                                    <select class="form-control border-input" name="book_type">
                                                        <option value="ภายใน">ภายใน</option>
                                                        <option value="ภายนอก">ภายนอก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันเวลาที่เดินทาง</label>
                                                    <input type="text" id="dateStart" name="book_date_from"  class="form-control border-input" placeholder="dd-MM-YYYY HH:ii" value="" required>
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่</label>
                                                    <input type="text" id="dateEnd" name="book_date_to" class="form-control border-input" placeholder="dd-MM-YYYY HH:ii" value="" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ใช้เพื่อ</label>
                                                    <input  type="text" name="book_for" class="form-control border-input" placeholder="จุดประสงค์การใช้งาน" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>สถานที่เดินทาง </label>
                                                    <input type="text" name="book_location" class="form-control border-input" placeholder="ไปที่ไหน" required>
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
                                                    <textarea  rows="5" id="details" name="book_details" class="form-control border-input"></textarea>
                                                </div>
                                            </div>
                                        </div>                                       
                                        <div class="row" id="listFree" hidden>
                                            <!--Content Cars&Drivers-->
                                        </div>
                                        <input type="hidden" name="lat" id="lat">
                                         <input type="hidden" name="lon" id="lng">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-danger btn-fill btn-wd" onclick="validateList()">จองรถ</button>
                                        </div>
                                    </form>
                                </div>
                           </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    function validateList()
    {
      var carsID = $("input[name^='bc_car_id']");
      var driversID = $("input[name^='bd_driver_id']");
      var cntCar = 0;
      var cntDriver = 0;
      //count check drivers ans cars
      for(i=0;i<carsID.length;i++)
      {
        if(carsID.eq(i).is(':checked'))
        {
            cntCar++;
        }
      }
      for(i=0;i<driversID.length;i++)
      {
        if(driversID.eq(i).is(':checked'))
        {
            cntDriver++;
        } 
      }
      if((cntCar > 0) && (cntDriver > 0))
      {
        $('#form').submit();
      }
      else
      {
            swal({title:'ผิดพลาด',text:'โปรดตรวจสอบรายการที่จอง',type:'error'});   
      }
    }
    $('#dateStart').datetimepicker({
        value:'',
        format:'d-m-Y H:i',
        yearOffset:543
    });
    $('#dateEnd').datetimepicker({
        value:'',
        format:'d-m-Y H:i',
        yearOffset:543
    });

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
    $(document).ready(function(){
	$("#dateStart").blur(function(){
            var dateStart = $("#dateStart").val();
            var dateEnd = $("#dateEnd").val();
            $.list(dateStart,dateEnd); 
	});
        $("#dateEnd").blur(function(){
            var dateStart = $("#dateStart").val();
            var dateEnd = $("#dateEnd").val();
            $.list(dateStart,dateEnd); 
	});
        $.list = function(dateStart,dateEnd){
          if((dateStart!="")&&(dateEnd!="")){
                    // Select Car And Driver 
                    $.ajax({
                       type: 'get' ,
                       url: "booking/car-and-driver?dateStart="+dateStart+"&dateEnd="+dateEnd,
                       success: function (data) {
                           $("#listFree").html(data);
                           $("#listFree").fadeIn('slow');
                        }
                    });
          }
        } 
        
    });
    window.onload= function(){
        $('#rowMap').hide();
    } 
       function initMap() {
          var lat = 17.485257695007665;
          var lng = 101.73062393839837;
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