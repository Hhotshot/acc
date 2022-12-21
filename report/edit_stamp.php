<?php

function DateThai($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strDay $strMonthThai $strYear";
}

const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
const BAHT_TEXT_TWENTY = 'ยี่';
const BAHT_TEXT_INTEGER = 'ถ้วน';
const BAHT_TEXT_BAHT = 'บาท';
const BAHT_TEXT_SATANG = 'สตางค์';
const BAHT_TEXT_POINT = 'จุด';

/**
 * Convert baht number to Thai text
 * @param double|int $number
 * @param bool $include_unit
 * @param bool $display_zero
 * @return string|null
 */
function baht_text ($number, $include_unit = true, $display_zero = true)
{
    if (!is_numeric($number)) {
        return null;
    }

    $log = floor(log($number, 10));
    if ($log > 5) {
        $millions = floor($log / 6);
        $million_value = pow(1000000, $millions);
        $normalised_million = floor($number / $million_value);
        $rest = $number - ($normalised_million * $million_value);
        $millions_text = '';
        for ($i = 0; $i < $millions; $i++) {
            $millions_text .= BAHT_TEXT_UNITS[6];
        }
        return baht_text($normalised_million, false) . $millions_text . baht_text($rest, true, false);
    }

    $number_str = (string)floor($number);
    $text = '';
    $unit = 0;

    if ($display_zero && $number_str == '0') {
        $text = BAHT_TEXT_NUMBERS[0];
    } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
        $current_number = (int)$number_str[$i];

        $unit_text = '';
        if ($unit == 0 && $i > 0) {
            $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
            if ($current_number == 1 && $previous_number > 0) {
                $unit_text .= BAHT_TEXT_ONE_IN_TENTH;
            } else if ($current_number > 0) {
                $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
            }
        } else if ($unit == 1 && $current_number == 2) {
            $unit_text .= BAHT_TEXT_TWENTY;
        } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
            $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
        }

        if ($current_number > 0) {
            $unit_text .= BAHT_TEXT_UNITS[$unit];
        }

        $text = $unit_text . $text;
        $unit++;
    }

    if ($include_unit) {
        $text .= BAHT_TEXT_BAHT;

        $satang = explode('.', number_format($number, 2, '.', ''))[1];
        $text .= $satang == 0
            ? BAHT_TEXT_INTEGER
            : baht_text($satang, false) . BAHT_TEXT_SATANG;
    } else {
        $exploded = explode('.', $number);
        if (isset($exploded[1])) {
            $text .= BAHT_TEXT_POINT;
            $decimal = (string)$exploded[1];
            for ($i = 0; $i < strlen($decimal); $i++) {
                $text .= BAHT_TEXT_NUMBERS[$decimal[$i]];
            }
        }
    }

    return $text;
}

	//เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
	//require_once('mpdf/vendor/autoload.php');
	require_once __DIR__ . '/mpdf/vendor/autoload.php';

#$host     = "192.168.1.254";// Server database
#$username = "sa";     // Username database
#$password = "sa";     // Password database
#$database = "money_bn";     // Nama database
include("../connect/connect.php");
// include("../session/session_claim.php");
// Koneksi ke database.
#$con_money = new mysqli($host, $username, $password, $database);
#mysqli_set_charset($con_money,"utf8");
// $pang_stamp_id = $_GET["pang_stamp_id"];
#$hn = $_GET["hn"];
#@$vstdate = $_GET["vstdate"];



#ตรวจสอบประเภท_OPD_OR_IPD
#$s_check_pt_type = "SELECT pang_stamp_pt_type FROM pang_stamp_paid WHERE pang_stamp_vn='$vn' LIMIT 1 ";
#$q_check_pt_type = mysqli_query($con_money,$s_check_pt_type)or die(mysqli_error($con_money));
#$r_check_pt_type = mysqli_fetch_array($q_check_pt_type);
#$pang_stamp_pt_type = $r_check_pt_type["pang_stamp_pt_type"];
#ตรวจสอบประเภท_OPD_OR_IPD

#ข้อมูล pang_stamp
// $s_pang_stamp = " SELECT ps.pang_stamp_hn, ps.pang_stamp, ps.pang_stamp_vstdate, ps.pang_stamp_uc_money
//                     ,ps.pang_stamp_edit_user, ps.pang_stamp_send
//                     ,pses.edit_old_money, pses.edit_new_money
//                     FROM pang_stamp ps
//                     lEFT JOIN pang_stamp_edit_send pses ON ps.pang_stamp_edit_send_id=pses.pang_stamp_edit_send_id
//                     WHERE ps.pang_stamp_id = '$pang_stamp_id' LIMIT 1";
// $q_pang_stamp = mysqli_query($con_money,$s_pang_stamp)or die(mysqli_error($con_money));
// $r_pang_stamp = mysqli_fetch_array($q_pang_stamp);
// $pang_stamp_hn = $r_pang_stamp["pang_stamp_hn"];
// $pang_stamp = $r_pang_stamp["pang_stamp"];
// $pang_stamp_vstdate = $r_pang_stamp["pang_stamp_vstdate"];
// $pang_stamp_uc_money = $r_pang_stamp["pang_stamp_uc_money"];
// $pang_stamp_send = $r_pang_stamp["pang_stamp_send"];
// $edit_old_money = $r_pang_stamp["edit_old_money"];
// $edit_new_money = $r_pang_stamp["edit_new_money"];
#ข้อมูล pang_stamp

# data_hos
// $s_data = "SELECT * FROM $database_ii.data_hos LIMIT 1 ";
// $q_data = mysqli_query($con_money,$s_data)or die(mysqli_error($con_money));
// $r_data = mysqli_fetch_array($q_data);
# data_hos


#ข้อมูลคนไข้
// $s_data_patient = " SELECT p.pname
//                     FROM patient p 
//                     left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
//                     WHERE p.hn = '999999999' LIMIT 1";
// $q_data_patient = mysqli_query($con_hos,$s_data_patient)or die(mysqli_error($con_hos));
// $r_data_patient = mysqli_fetch_array($q_data_patient);

#ข้อมูลคนไข้

$backto="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; //ลิงค์สำหรับกลับมาหน้าเดิม


		

$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/custom/temp/dir/path']);
$month_now = (date("m"))+0;
$year_now = date("Y");
$thai_month_arr=array("0"=>"","1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน","7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
@$show_head_name= $thai_month_arr[$month_now]." ".($year_now+543);
$head = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
		
	}
	td{
   		word-break:break-all;
		font-size: 10pt;
	}
    div{
        #border:1;
        white-space: normal;
        font-size:11pt;
        float:left;
    }
    p{
        white-space: normal;
    }
    bold{
        font-weight: bold;
    }

</style>



<div style="width:41%;">
    <img src="kroot.jpg" width="100" />
</div>
<div style="width:40%;">
    <BR><BR>
    <font style="font-weight: bold;font-size:20px;">บันทึกข้อความ</font 
</div>



';
	
$end ='

<div style="width:100%;">
    <font style="font-weight: bold;">ส่วนราชการ</font> งานประกันสุขภาพฯ โรงพยาบาล'.$r_data["data_hos_name"].'     
</div>

<div style="width:100%;">
    <font style="font-weight: bold;">ที่</font>............................................................................. <font style="font-weight: bold;">วันที่</font> '.DateThai( date("Y-m-d") ).'
</div>

<div style="width:100%;">
    <font style="font-weight: bold;">เรื่อง </font>ขอปรับปรุงแก้ไขยอดลูกหนี้รายงานทางบัญชี ปรับปรุงยอดเงิน
</div>

<hr>

<div style="width:100%;">
    <font style="font-weight: bold;">เรียน </font>ผู้อำนวยการโรงพยาบาล'.$r_data["data_hos_name"].'
</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="font-weight: bold;text-decoration:underline;">ความเป็นมา</font>

</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลุ่มงานประกันสุขภาพฯ ขอปรับปรุงยอดเงินรายการ HN '.$pang_stamp_hn.' วันที่รับบริการ '.DateThai($pang_stamp_vstdate).' ผังบัญชี '.$pang_stamp.' ตามเลขที่หนังสือที่ส่ง '.$pang_stamp_send.' โดยปรับปรุงยอดลูกหนี้จากยอดเดิม '.number_format($edit_old_money,2).' บาท เป็นยอดลูกหนี้ใหม่จำนวน '.number_format($edit_new_money,2).' บาท
</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="font-weight: bold;text-decoration:underline;">ข้อเสนอ</font>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ


<div style="width:29%;">
    &nbsp;
</div>
<div style="text-align: center;"><BR>ลงชื่อ__________________________ <BR> ('.$r_data["data_hos_claim"].') <BR>หัวหน้ากลุ่มงานประกันสุขภาพ และสารสนเทศทางการแพทย์
</div>
<BR><BR>


<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="font-weight: bold;text-decoration:underline;">อนุมัติ</font>

<div style="width:7%;">
    &nbsp;
</div>
<div style="width:45%;text-align: center;"><BR>ลงชื่อ__________________________ <BR> ('.$r_data["data_hos_director"].') <BR> '.$r_data["data_hos_director_position"].'โรงพยาบาล'.$r_data["data_hos_name"].'
</div>
<div style="width:20%;">
    &nbsp;
</div>


';


?>

<style>

div.a {
  position: relative;
  width: 100%;
  height: 10px;
  border: 0px solid red;
}

div.b {
  position: absolute;
  left: auto;
  width: 50%;
  border: 1px solid blue;
  text-align: center;
} 

div.c {
  position: absolute;
  right: 0%;
  width: 50%;
  border: 1px solid green;
  text-align: center;
}

</style>
<?php


$mpdf->AddPage('P');
#$mpdf->Image('kroot.jpg', 92, 10, 28, 31, 'jpg', '', true, false);
#$mpdf->setHeader('เลขหนังสือ : '.$pang_stamp_send);

#$mpdf->setFooter('{PAGENO}');

$mpdf->WriteHTML($head);

#$mpdf->WriteHTML($content);

$mpdf->WriteHTML($end);


$mpdf->Output();

?>