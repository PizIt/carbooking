@extends('default')
@section('content')
<div class="row">
    <div class="col-lg-5">
        <button onClick ="$('#tableID').tableExport({type:'pdf',escape:'false'});">ss</button>
        <table id="tableID">
            <tr>
                <td>Test PDFs</td>
            </tr>
             <tr>
                 <td>ทดสอบๆๆๆ</td>
            </tr>
            </table>
    </div>
    <div id="editor"></div>
</div>
 <script type="text/javascript">

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
@section('costom-style')  <!-- jquery in head-->
<style type="text/css">
@font-face {
    font-family: "TH SarabunPSK";
    src: "{{URL::to('assests/fonts/TH-Sarabun-PSK/THSarabun.ttf')}}";
}
.ace {
    font-family: "TH SarabunPSK";
    font-size: 230%;
}
</style>
@stop