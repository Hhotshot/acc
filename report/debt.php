<?php
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
include("../session/session_claim.php");
// Koneksi ke database.
#$con_money = new mysqli($host, $username, $password, $database);
#mysqli_set_charset($con_money,"utf8");
$vn = $_GET["vn"];
$hn = $_GET["hn"];
@$vstdate = $_GET["vstdate"];



#ตรวจสอบประเภท_OPD_OR_IPD
$s_check_pt_type = "SELECT pang_stamp_pt_type FROM pang_stamp_paid WHERE pang_stamp_vn='$vn' LIMIT 1 ";
$q_check_pt_type = mysqli_query($con_money,$s_check_pt_type)or die(mysqli_error($con_money));
$r_check_pt_type = mysqli_fetch_array($q_check_pt_type);
$pang_stamp_pt_type = $r_check_pt_type["pang_stamp_pt_type"];
#ตรวจสอบประเภท_OPD_OR_IPD

#Replace_การออกใบทวงหนี้
@session_start();
$pang_stamp_paisanee_user = $_SESSION["UserID"]; #USERที่ออกใบทวงหนี้
$date_now = date("Y-m-d");
if(isset($vstdate)){ ##ถ้ามีค่าvstdateส่งมา_ไม่ต้องReplace_เพราะปริ้นใบเก่า
}else{
    $s_replace_pspp = "REPLACE INTO pang_stamp_paid_paisanee VALUES ('$vn','$hn', '$date_now', '$pang_stamp_paisanee_user');";
    $r_replace_pspp = mysqli_query($con_money,$s_replace_pspp)or die(mysqli_error($con_money));
}
#Replace_การออกใบทวงหนี้


# data_hos
$s_data = "SELECT * FROM $database_ii.data_hos LIMIT 1 ";
$q_data = mysqli_query($con_money,$s_data)or die(mysqli_error($con_money));
$r_data = mysqli_fetch_array($q_data);
# data_hos

#ข้อมูลค้าง_วันที่รับบริการ
if($pang_stamp_pt_type=='OPD'){
    $vn_or_an = "vn";
    $show_pt_type = "ผู้ป่วยนอก";
}elseif($pang_stamp_pt_type=='IPD'){
    $vn_or_an = "an";
    $show_pt_type = "ผู้ป่วยใน";
}
$s_arrear = "SELECT 
                psp.pang_stamp_paid_money AS pang_stamp_paid_money
                ,IFNULL((SELECT SUM(bill_amount) FROM rcpt_print rp WHERE rp.vn=psp.pang_stamp_vn LIMIT 1),0)bill_amount
                ,(SELECT vstdate FROM ovst WHERE $vn_or_an=psp.pang_stamp_vn)vstdate
                FROM $database_ii.pang_stamp_paid psp
                WHERE psp.pang_stamp_vn = '$vn'
                LIMIT 1 ";
$q_arrear = mysqli_query($con_hos, $s_arrear) or die(mysqli_error($con_hos));
$r_arrear = mysqli_fetch_array($q_arrear);
$total_arrear = ($r_arrear["pang_stamp_paid_money"]-$r_arrear["bill_amount"]);
$sub_vstdate_year = substr($r_arrear["vstdate"],0,4);
$sub_vstdate_month = (substr($r_arrear["vstdate"],5,2))+0;
$sub_vstdate_date = substr($r_arrear["vstdate"],8,2);
#ข้อมูลค้าง_วันที่รับบริการ

#ข้อมูลคนไข้
$s_data_patient = " SELECT CONCAT(p.pname,p.fname,' ',p.lname) AS pt_name,p.informaddr 
                    ,CONCAT('บ้านเลขที่ ',p.addrpart)addrpart
                    ,IF(p.moopart='','',CONCAT(' หมู่ที่ ',p.moopart))moopart
                    ,substring_index(t3.full_name,' ',1)tmbpart
                    ,substring_index(substring_index(t3.full_name,' ',2),' ',-1)amppart
                    ,substring_index(substring_index(t3.full_name,' ',3),' ',-1)chwpart
                    ,IF( p.po_code='' OR p.po_code IS NULL ,t3.pocode,p.po_code)AS po_code
                    FROM patient p 
                    left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                    WHERE p.hn = '$hn' LIMIT 1";
$q_data_patient = mysqli_query($con_hos,$s_data_patient)or die(mysqli_error($con_hos));
$r_data_patient = mysqli_fetch_array($q_data_patient);
$pt_name = $r_data_patient["pt_name"];
$addrpart = $r_data_patient["addrpart"];
$moopart = $r_data_patient["moopart"];
$tmbpart = $r_data_patient["tmbpart"];
$amppart = $r_data_patient["amppart"];
$chwpart = $r_data_patient["chwpart"];
$po_code = $r_data_patient["po_code"];
#ข้อมูลคนไข้

$backto="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; //ลิงค์สำหรับกลับมาหน้าเดิม

$content = "";
		

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
</style>

<div style="width:60%;">
    ที่ '.$r_data["data_hos_debt_no"].'
</div>
<div>
    โรงพยาบาล '.$r_data["data_hos_name"].'<BR>'.$r_data["data_hos_address"].'
</div>

<div style="width:55%;">
    &nbsp;
</div>
<div>
    '.$show_head_name.'
</div>

<div style="width:100%;">
    เรื่อง&nbsp;&nbsp;ขอติดตามค่ารักษาพยาบาลค้างชำระ ครั้งที่    
</div>  


<div style="width:100%;">
    เรียน&nbsp;&nbsp;<font style="font-weight: bold;">'.$pt_name.'</font>   
</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่ท่านได้เข้ารับการรักษาพยาบาล จากโรงพยาบาล'.$r_data["data_hos_name"].' ท่านได้เข้ารับบริการรักษาประเภท'.$show_pt_type.'  เมื่อวันที่ '.$sub_vstdate_date.' '.$thai_month_arr[$sub_vstdate_month]." ".($sub_vstdate_year+543).' มีค่ารักษาพยาบาล เป็นจำนวนเงิน '. number_format($total_arrear,2).' บาท ('.baht_text($total_arrear).') ปรากฏว่าท่านยังไม่ได้ชำระเงินจำนวนเงินดังกล่าว ให้แก่โรงพยาบาล'.$r_data["data_hos_name"].'
</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทางโรงพยาบาล'.$r_data["data_hos_name"].' ขอให้ท่านดำเนินการชำระเงินดังกล่าว ให้เสร็จสิ้นภายใน 30 วัน นับจากวันที่ได้รับหนังสือฉบับนี้ หากท่านมีข้อสอบถามเพิ่มเติมสามารถติดต่อสอบถามได้ที่หมายเลขโทรศัพท์ตามที่แจ้งไว้ด้านล่างหนังสือฉบับนี้

</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทั้งนี้ หากท่านได้ชำระเงิน ก่อนที่ท่านจะได้รับหนังสือฉบับนี้ ทางโรงพยาบาล'.$r_data["data_hos_name"].'ต้องขออภัยมา ณ โอกาสนี้ด้วย

</div>

<div style="width:100%;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ และดำเนินการต่อไป

</div>

<div style="width:100%;">
    &nbsp;
</div>
<div style="width:55%;">
    &nbsp;
</div>
<div>
    ขอแสดงความนับถือ
</div>

';


	
$end ='
<div style="width:29%;">
    &nbsp;
</div>
<div style="text-align: center;"><BR>ลงชื่อ__________________________ <BR> ('.$r_data["data_hos_director"].') <BR> '.$r_data["data_hos_director_position"].'โรงพยาบาล'.$r_data["data_hos_name"].'
</div>';

$end.='
<BR><BR>
<div style="width:100%;">
    กลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์    
</div>
<div style="width:100%;">
    '.$r_data["data_hos_debt_contact"].'  
</div>

<div style="width:100%;" style="text-align:center;">
    <font style="font-weight: bold;">'.$r_data["data_hos_attalag"].'<font>  
</div>
';


$font = '
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
</style>

<div style="height:33%;">
    &nbsp;
</div>

<div style="height:33%;">
    <div style="width:15%;">
        <img src="kroot.jpg" width="100" />
    </div>
    <div style="width:40%;">
        <BR>
        โรงพยาบาล '.$r_data["data_hos_name"].'<BR>'.$r_data["data_hos_address"].'  
    </div>
    <div style="width:44%; text-align:right">
        ชำระค่าฝากส่งเป็นรายเดือน
        <BR>
        ใบอณุญาตที่ '.$r_data["data_hos_paisanee_no"].'
        <BR>
        ไปรษณีย์ '.$r_data["data_hos_paisanee_saka"].'
    </div>

    <div style="width:40%;">
        &nbsp;
    </div>
    <div style="width:59%">
        <BR>
        '.$pt_name.' 
        <BR>
        '.$addrpart.$moopart.' '.$tmbpart.'
        <BR>
        '.$amppart.'
        <BR>
        '.$chwpart.'
        <BR>
        '.$po_code.'
    </div>
</div>

<div style="height:33%;">
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
$mpdf->Image('kroot.jpg', 92, 10, 28, 31, 'jpg', '', true, false);
#$mpdf->setHeader('เลขหนังสือ : '.$pang_stamp_send);

#$mpdf->setFooter('{PAGENO}');

$mpdf->WriteHTML($head);

$mpdf->WriteHTML($content);

$mpdf->WriteHTML($end);


$mpdf->AddPage('P');
$mpdf->WriteHTML($font);


$mpdf->Output();

?>