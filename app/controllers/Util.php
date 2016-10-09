<?php
//2016-09-06 08:00:00 date Dormat
//list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
//list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
class Util 
{
    public function DateTimeConvertToDate($datetime) //dmYHis to YmdHis
    {
         $dateSplit = explode("-",$datetime);
         $timeSplit = explode(" ",$dateSplit[2]);
         $dateFarmat = ($timeSplit[0]-543).'-'.$dateSplit[1].'-'.$dateSplit[0]." ".$timeSplit[1];
        return $dateFarmat;
    }
    public function DateConvertToDate($date) //dmY to Ymd
    {
         $dateSplit = explode("-",$date);
         $dateFarmat = ($dateSplit[2]-543).'-'.$dateSplit[1].'-'.$dateSplit[0];
        return $dateFarmat;
    }
    public function DateConvertToView($date) //Ymd to dmY
    {
         $dateSplit = explode("-",$date);
         $dateFarmat = $dateSplit[2].'-'.$dateSplit[1].'-'.($dateSplit[0]+543);
        return $dateFarmat;
    }
     public function DateTimeConvertToView($datetime) //YmdHis to dmYHis
    {
         $dateSplit = explode("-",$datetime);
         $timeSplit = explode(" ",$dateSplit[2]);
         $dateFarmat = $timeSplit[0].'-'.$dateSplit[1].'-'.$dateSplit[0]." ".$timeSplit[1];
        return $dateFarmat;
    }
     public function DateTimeConvertToTimeView($datetime) //YmdHis to H:i
    {   
         $dateSplit = explode(" ",$datetime);
         $timeSplit = explode(":",$dateSplit[1]);
         $timeFarmat = $timeSplit[0].':'.$timeSplit[1];
        return $timeFarmat;
    }
    public function ThaiDate($date) {
	list($Y,$m,$d) = explode('-',$date);
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	$m = $this->listMonth($m);
		return $d." ".$m." ".$Y;
    }
     public function ThaiDateTime($dateTime) {
        list($date,$time) = explode(' ',$dateTime); // แยกวันที่ กับ เวลาออกจากกัน
        list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	$m = $this->listMonth($m);
		return $d." ".$m." ".$Y." ".$H.':'.$i;
    }
    public function listMonth($m){
        switch($m) {
		case "01":	$m = "ม.ค."; break;
		case "02":	$m = "ก.พ."; break;
		case "03":	$m = "มี.ค."; break;
		case "04":	$m = "เม.ย."; break;
		case "05":	$m = "พ.ค."; break;
		case "06":	$m = "มิ.ย."; break;
		case "07":	$m = "ก.ค."; break;
		case "08":	$m = "ส.ค."; break;
		case "09":	$m = "ก.ย."; break;
		case "10":	$m = "ต.ค."; break;
		case "11":	$m = "พ.ย."; break;
		case "12":	$m = "ธ.ค."; break;
	}
        return $m;
    }
     public function colvertListMonth($m){
        switch($m) {
		case "มาราคม":	$m = "ม.ค."; break;
		case "กุมภาพันธ์":	$m = "ก.พ."; break;
		case "มีนาคม":	$m = "มี.ค."; break;
		case "เมษายน":	$m = "เม.ย."; break;
		case "พฤษภาคม":	$m = "พ.ค."; break;
		case "มิถุนายน":	$m = "มิ.ย."; break;
		case "กรกฎาคม":	$m = "ก.ค."; break;
		case "สิงหาคม":	$m = "ส.ค."; break;
		case "กันยายน":	$m = "ก.ย."; break;
		case "ตุลาคม":	$m = "ต.ค."; break;
		case "พฤศจิกายน":$m = "พ.ย."; break;
		case "ธันวาคม":	$m = "ธ.ค."; break;
	}
        return $m;
    }

}
