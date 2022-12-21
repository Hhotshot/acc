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

include("../connect/connect.php");
include("../session/session_claim.php");


$pang_stamp_send = $_GET["pang_stamp_send"];
@$pang_stamp_edit = $_GET["pang_stamp_edit"];

if($pang_stamp_edit==""){
    $sql = "SELECT *
            ,(SELECT (IFNULL(MAX(pang_stamp_edit),0)) AS max_edit FROM pang_stamp_send WHERE pang_stamp_send='$pang_stamp_send')check_edit
            FROM pang_stamp_send WHERE pang_stamp_send='$pang_stamp_send' AND pang_stamp_edit IS NULL LIMIT 100 ";
}elseif($pang_stamp_edit!=""){
    $sql = "SELECT * FROM pang_stamp_send WHERE pang_stamp_send='$pang_stamp_send' AND pang_stamp_edit='$pang_stamp_edit' LIMIT 100 ";
}



$result = mysqli_query($con_money,$sql)or die(mysqli_error($con_money));


$s_data = "SELECT * FROM $database_ii.data_hos LIMIT 1 ";
$q_data = mysqli_query($con_money,$s_data)or die(mysqli_error($con_money));
$r_data = mysqli_fetch_array($q_data);

#หัวหน้าการเงิน 15
$s_h_money = " SELECT data_hos_money , data_hos_money_position FROM data_hos LIMIT 1 "; #database_iii =  con manager
$q_h_money = mysqli_query($con_money,$s_h_money)or die(mysqli_error($con_money));
$r_h_money = mysqli_fetch_array($q_h_money);
$head_money = $r_h_money["data_hos_money"];
$head_money_position = $r_h_money["data_hos_money_position"];
#หัวหน้าการเงิน 15



#หัวหน้างานประกัน
$s_h_claim = " SELECT data_hos_claim, data_hos_claim_position FROM data_hos LIMIT 1"; #database_iii =  con manager
$q_h_claim = mysqli_query($con_money,$s_h_claim)or die(mysqli_error($con_money));
$r_h_claim = mysqli_fetch_array($q_h_claim);
$head_claim = $r_h_claim["data_hos_claim"];
$head_claim_position = $r_h_claim["data_hos_claim_position"];
#หัวหน้างานประกัน



#หัวหน้าการเงิน 0046
$s_director = " SELECT data_hos_director,data_hos_director_position FROM data_hos LIMIT 1 "; #database_iii =  con manager
$q_director = mysqli_query($con_money,$s_director)or die(mysqli_error($con_money));
$r_director = mysqli_fetch_array($q_director);
$director_name = $r_director["data_hos_director"];
$p1 = $r_director["data_hos_director_position"];
$p2 = $r_director["p1"];
$p3 = $r_director["p2"];
#หัวหน้าการเงิน 0046



$concat_vn="";
$concat_vn_all="";
$backto="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; //ลิงค์สำหรับกลับมาหน้าเดิม
// สำหรับ Export Eclaim

	$content = "";
	if (mysqli_num_rows($result) > 0) {
		$i = 1;
    $total_pang_stamp_send_money = 0;
    $total_pang_stamp_send_visit = 0;

		while($row = mysqli_fetch_array($result)){
    $sub_year = substr($row["pang_stamp_send_date"],0,4);
    $sub_month = (int)$sub_month_zero = substr($row["pang_stamp_send_date"],5,2);
    $sub_date = substr($row["pang_stamp_send_date"],8,2);
    @$check_edit = $row["check_edit"]; #ตรวจสอบว่าเป็น ฉบับแก้ไขหรือไม่
    @$pang_stamp_edit_result = $row["pang_stamp_edit"]; #ตรวจสอบว่าเป็น ฉบับแก้ไขหรือไม่

    if($check_edit>0){
        $pang_stamp_send = $row['pang_stamp_send']." (ฉบับแก้ไขที่ ".$check_edit." ) ";
    }elseif($pang_stamp_edit_result==1){
        $pang_stamp_send = $row['pang_stamp_send'];
    }elseif($pang_stamp_edit_result>1){
        $pang_stamp_send = $row['pang_stamp_send']." (ฉบับแก้ไขที่ ".($pang_stamp_edit_result-1)." ) ";
    }else{
        $pang_stamp_send = $row['pang_stamp_send'];
    }

    if($row['pang_stamp_send_money_kor_tok']==0){$kor_tok="";}else{$kor_tok=' ('.$row['pang_stamp_send_money_kor_tok'].')';}
			$content .= 
			'
			<style>
				td{
					vertical-align: top;
				}
			</style>
			
			<tr  style="border:1px solid #000;">
				<td style="border-right:1px solid #000;padding:3px;text-align:center;"  >'.$i.'</td>	
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:left;"  >'.$row['pang_stamp_send_pang'].'</td> 
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:center;"  >'.$row['pang_stamp_send_visit'].'</td>
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:right;"  >'.number_format($row['pang_stamp_send_money'],2).$kor_tok.'</td>
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:left;"  >('.baht_text($row['pang_stamp_send_money']).')</td>
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:left;"  >'.$row['pang_stamp_send_responsible'].'</td>
        <td style="white-space: nowrap;border-right:1px solid #000;text-align:left;"  ></td>
			</tr>';
      
      $total_pang_stamp_send_money = $total_pang_stamp_send_money+$row['pang_stamp_send_money'];
      $total_pang_stamp_send_visit = $total_pang_stamp_send_visit+$row['pang_stamp_send_visit'];
      $i++;
		} # Loop while $row

		
	}
		
	
	//mysqli_close($con_hos);
	
//$mpdf = new mPDF();
//$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/custom/temp/dir/path']);
//$date_now = date("Y-m-d");
$thai_month_arr=array("0"=>"","1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน","7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
$show_head_name="ประจำวันที่ ".$sub_date." เดือน ".$thai_month_arr[$sub_month]." ปี ".($sub_year+543);
$head = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
		
	}
	td{
   		word-break:break-all;
		font-size: 10pt;
	}
</style>
<p style="text-align:right;"><span style="border: 1px solid;">เลขหนังสือ '.$pang_stamp_send.'</span></p>
<h3 style="text-align:center;">สรุปลูกหนี้โรงพยาบาล'.$r_data["data_hos_name"].'</h3>
<p>'.$show_head_name.'</p>


<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12pt;margin-top:8px;">
    <tr style="border:1px solid #000;padding:4px;">
    	<td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> No. </td>
      <td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> เลขผัง </td>
      <td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> จำนวน Visit </td>
      <td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> จำนวนลูกหนี้ (ข้อตกลง) </td>
      <td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> จำนวนลูกหนี้ (text) </td>
      <td align="center"  style="border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> ผู้รับผิดชอบผัง </td>
      <td align="center"  style="white-space: nowrap;border-right:1px solid #000;padding:4px;text-align:center;" width="auto"> หมายเหตุ </td>
    </tr>



</thead>
	<tbody>


  ';


	
$end = "</tbody>
</table>";
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

$end .= "รวมทั้งสิ้น ".($total_pang_stamp_send_visit)." รายการ  รวมยอดเงิน ".number_format($total_pang_stamp_send_money, 2)." บาท (".baht_text($total_pang_stamp_send_money).")";
$end .="<div style='text-align: center;position: relative;width: 100%;height: 200px;border: 0px solid red;'> ___________________________________________________________________________________________________________________________ <BR> ขอรับรองว่าค่าบริการทางการแพทย์ดังกล่าวถูกต้องตามที่เรียก";

$end .="<div style='float:left;left: auto;width: 30%;border: 0px solid blue;text-align: center;'><BR>ลงชื่อ__________________________ <BR> (".$head_claim.") <BR> ".$head_claim_position." <BR> วันที่_____/_____________/______ </div>";

$end .="<div style='float:left;left: auto;width: 30%;border: 0px solid blue;text-align: center;'><BR>ลงชื่อ__________________________ <BR> (".$head_money.") <BR> ".$head_money_position." <BR> วันที่_____/_____________/______ </div>";

$end .="<div style='float:left;right: 0%;width: 39%;border: 0px solid green;text-align: center;'>
        <BR>ลงชื่อ__________________________ 
        <BR> (".$director_name.
        ")<BR> ".$p1." ";
if(isset($p2)){
    $end .="<BR> ".$p2." ";
}
if(isset($p3)){
    $end .="<BR> ".$p3." ";
}

$end .="<BR> วันที่_____/_____________/______ </div>";
$end .="</div>";
$mpdf->AddPage('L');

$mpdf->setHeader('เลขหนังสือ : '.$pang_stamp_send);

$mpdf->setFooter('{PAGENO}');

$mpdf->WriteHTML($head);

$mpdf->WriteHTML($content);

$mpdf->WriteHTML($end);

$mpdf->Output();

?>