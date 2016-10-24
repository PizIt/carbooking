@extends('default')
@section('brand')
ปฏิธินการใช้รถ
@stop
@section('costom-style')
<style>
	#calendar {
		max-width: 1000px;
		margin: 0 auto;
	}
        div#mylayout{ 
        display:block; 
        width:300px; 
        word-wrap:break-word; 
} 

</style>@stop
@section('content')
<div class="content">
    <div class="container-fluid">           
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div id='wrap'>
                        <br>
                        <div id='calendar'></div>
                        <br>
                    </div>
                </div>
            </div>
    </div>
</div>
 
<script>
   $(document).ready(function() {
        $('#calendar').fullCalendar({
            lang:'th',
            header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                },
            eventLimit: true, // allow "more" link when too many events
            events:'home/calendar',
            allDaySlot:true,
            eventColor: '#5cb85c',
            displayEventTime :false,
            eventClick:function(event){
            if(event.id){
                        $('#ShowEventDetails').modal('show'),
                        $.ajax({
                            type:'get',
                            url:'home/detail-event?id='+event.id,
                            success:function(data)
                            {                                   
                                $('#EventDetails').html(data);
                                $.loadShowMap();
                            }
                        })
                        return false;
                }
            }
        })
        $.loadShowMap = function()
        {
            $(document).ready(function(){
                $('#showMap').click(function(){
                    var url='https://maps.googleapis.com/maps/api/js?key=AIzaSyAt7OP8jq0nhzMKFqd7AIKTvU_4N43_81M';
                    $.getScript(url).done(function(){
                        initMap();
                        $('#layoutMap').fadeIn('slow');
                        $('#showMap').hide();
                        $('#hideMap').show();
                    });
                });
                $('#hideMap').click(function(){
                    $('#layoutMap').fadeOut('slow');
                    $('#showMap').show();
                    $('#hideMap').hide();
                });
            });
        }
        function initMap() {
            var lat = parseFloat($('#lat').val());
            var lng = parseFloat($('#lng').val());
            var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 15
            });
            var marker = new google.maps.Marker ({map:map,
              animation:google.maps.Animation.BOUNCE,
              position : {lat: lat, lng: lng}
            });
        } 
    });    
</script>
@stop
@section('costom-html')
<div class="modal fade"  id="ShowEventDetails" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel"> 
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">รายละเอียดการจองรถ</h4>
          </div>
          <div class="modal-body" id="EventDetails">
              <!--Ajax-->
          </div>
          <div class="modal-footer">
              <div class="pull-left">
<!--                หมายเหตุ : ...-->
              </div>
          </div>
        </div>
      </div>
    </div>
@stop
@section('costom-js')
        <link rel='stylesheet' href='{{URL::to('assets/fullcalendar/fullcalendar.min.css')}}'/>
        <script src='{{URL::to('assets/fullcalendar/lib/jquery.min.js')}}'></script>
        <script src='{{URL::to('assets/fullcalendar/lib/moment.min.js')}}'></script>
        <script src='{{URL::to('assets/fullcalendar/fullcalendar.min.js')}}'></script>
        <script src='{{URL::to('assets/fullcalendar/lang-all.js')}}'></script>
@stop