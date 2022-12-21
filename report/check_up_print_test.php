
<?php




//เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
//require_once('mpdf/vendor/autoload.php');
require_once __DIR__ . '/mpdf/vendor/autoload.php';

include("../connect/connect.php");
//include("../session/session_claim.php");
// Koneksi ke database.
#$con_money = new mysqli($host, $username, $password, $database);
#mysqli_set_charset($con_money,"utf8");
// $vn = $_GET["vn"];
// $hn = $_GET["hn"];
// @$vstdate = $_GET["vstdate"];

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    //   $strHour= date("H",strtotime($strDate));
    //    $strMinute= date("i",strtotime($strDate));
    //    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

$strDate = date('d-m-Y H:i:s');
// echo "ข้อมูลวันที่: ".DateThai($strDate);


#ตรวจสอบประเภท_OPD_OR_IPD
// $s_check_pt_type = "SELECT pang_stamp_pt_type FROM pang_stamp_paid WHERE pang_stamp_vn='$vn' LIMIT 1 ";
// $q_check_pt_type = mysqli_query($con_money,$s_check_pt_type)or die(mysqli_error($con_money));
// $r_check_pt_type = mysqli_fetch_array($q_check_pt_type);
// $pang_stamp_pt_type = $r_check_pt_type["pang_stamp_pt_type"];
#ตรวจสอบประเภท_OPD_OR_IPD

#Replace_การออกใบทวงหนี้
// @session_start();
// $pang_stamp_paisanee_user = $_SESSION["UserID"]; #USERที่ออกใบทวงหนี้
// $date_now = date("Y-m-d");
// if(isset($vstdate)){ ##ถ้ามีค่าvstdateส่งมา_ไม่ต้องReplace_เพราะปริ้นใบเก่า
// }else{
//     $s_replace_pspp = "REPLACE INTO pang_stamp_paid_paisanee VALUES ('$vn','$hn', '$date_now', '$pang_stamp_paisanee_user');";
//     $r_replace_pspp = mysqli_query($con_money,$s_replace_pspp)or die(mysqli_error($con_money));
// }



$vn = $_REQUEST['vn'];
$sql_chup = "SELECT if(hc.sex='1','ชาย','หญิง')as sexx
,CASE
    WHEN ad.bp=1 THEN 'ปกติ'
    WHEN ad.bp=2 THEN 'ต่ำกว่าปกติ'
		WHEN ad.bp=3 THEN 'สูงกว่าปกติ'
    ELSE   'ไม่ได้ตรวจ'    
END  as  bpp
,CASE
    WHEN ad.suggestion=1 THEN 'ตรวจซ้ำใน 1 ปี'
    WHEN ad.suggestion=2 THEN 'ตรวจยืนยันภายใน 2 เดือน'
		WHEN ad.suggestion=3 THEN 'พบแพทย์ภายใน 1 เดือน'
    ELSE ad.suggestion_all  
END  as  suggestionn
,CASE
WHEN ad.bmi=1 THEN 'กาย (เป็นดัชนีชี้วัดภาวะอ้วนและผอมของบุคคลที่มีความสัมพันธ์กับสุขภาพ)
น้ำหนักอยู่ในเกณฑ์ปกติ (BMI อยู่ระหว่าง 18.5 - 22.9) ดูแลสุขภาพและควบคุมน้ำหนักให้อยู่ในระดับนี้ต่อไป ดัวยการรับประทานอาหารที่มีประโยชน์
ออกกำลังกายสม่ำเสมอ และพักผ่อนให้เพียงพอ '
    WHEN ad.bmi=2 THEN 'น้ำหนักต่ำกว่าปกติ (BMI น้อยกว่า 18.5) แนะนำให้รับประทานอาหารประเภ อย่างเพียงพอต่อความต้องการของร่างกาย และออกกำลังกายอย่างสม่ำเสมอ '
		WHEN ad.bmi=3 THEN 'น้ำหนักเกิน (BMI อยู่ระหว่าง 23.0 - 24.9) ควรควบคุมน้ำหนัก จำกัดอาหารไขมันสูง แป้งและน้ำตาล รวมถึงผลไม่รสหวาน หลีกเลี่ยงเครื่องดื่มมีแอลกอฮอล์ และออกกำลังกายอย่างน้อยสัปดาห์ละ 5 วัน วันละ 30 นาที '
			WHEN ad.bmi=4 THEN 'อ้วน (BMI อยู่ระหว่าง 25.0 - 29.9) ทำานมีภาวะอ้วน มีความเสี่ยงต่อการเกิดโรคเบาหวาน ความดันโลหิตสูง โรคหัวใจและโรคมะเร็งบางจำพวก เช่นมะเร็งลำไส้ใหญ่และมะเร็งเต้านมเป็นต้น ควรลดน้ำหนักอย่างจริงจัง '
			WHEN ad.bmi=5 THEN 'อ้วนมาก (BMI มากกว่า 30) ท่านเป็นโรคอ้วน ที่มีความเสี่ยงสูงต่อการเกิด โรคเบาหวาน โรคหัวใจ โรคความดันโลหิตสูง โรคมะเร็งบางชนิดเช่น มะเร็งลำไส้ใหญ่และมะเร็งเต้านมเป็นต้น ควรพบแพทย์เพื่อลดน้ำหนักอย่างเหมาะสมและถูกวิธี'
    ELSE 'ไม่มีการประมวลผล' 
END  as  bmii
,CASE
    WHEN ad.cbc_red=1 THEN 'ไม่ได้ตรวจ'
    WHEN ad.cbc_red=2 THEN 'ปกติ'
	 WHEN ad.cbc_red=3 THEN 'ซีดเล็กน้อย อาจมีสาเหตุเกิดจากความผิดปกติของระบบสร้างเม็ดเลือด หรือ จากการขาดธาตุเหล็ก เนื่องจากรับประทานอาหารที่มีธาตุเหล็กไม้เพียงพอกับปริมาณที่เสียไป หรือเสียโลหิตจากทางเดินอาหาร ควรรับประทานที่มีธาตุเหล็กเพิ่มขึ้น เช่น
เนื้อสัตว์ ไข้แดง พืชผักสีเขียว เช่น ยอดแค คื่นไช้ ใบแมงลัก และตรวจเลือดซ้ำในอีก 3 เดือน '
				 WHEN ad.cbc_red=4 THEN 'ซีดผิดปกติ ควรพบแพทย์  '
    ELSE 'ไม่มีการประมวลผล' 
END  as  cbc_redd
,CASE
WHEN ad.cbc_white=1 THEN 'ปกติ'
WHEN ad.cbc_white=2 THEN 'ซีดผิดปกติ ควรพบแพทย์  '
ELSE 'ไม่มีการประมวลผล' 
END  as  cbc_whitee
,CASE
WHEN ad.blood=1 THEN 'ปกติ'
WHEN ad.blood=2 THEN 'ซีดผิดปกติ ควรพบแพทย์  '
ELSE 'ไม่มีการประมวลผล' 
END  as  bloodd
,CASE  
WHEN ad.cbc_white_eo=1 THEN 'ปกติ'
WHEN ad.cbc_white_eo=2 THEN 'ซีดผิดปกติ ควรพบแพทย์  '
ELSE 'ไม่มีการประมวลผล' 
END  as  cbc_white_eoo
,CASE  
WHEN ad.fbs=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.fbs=2 THEN 'ปกติ '
WHEN ad.fbs=3 THEN 'ต่ำกว่าปกติ'
WHEN ad.fbs=4 THEN 'สูงกว่าปกติเล็กน้อย ท่านอาจมีภาวะเบาหวานเริ่มต้น
1. แนะนำให้หลีกเลี่ยงอาหารที่มีรสหวาน น้ำตาล ขนมหวาน น้ำอัดลม เป็นต้น รวมทั้งผลไม้ที่มีรสหวาน
2. ควรงดสูบบุหรี่และงดดื่มแอลกอฮอล์
3. ตรวจระดับน้ำตาลในเลือดซ้ำในอีก 1 เดือน หากยังมีค่าสูงผิดปกติควรพบแพทย์ทันที '
WHEN ad.fbs=5 THEN 'สูงกว่าปกติมาก'
ELSE 'ไม่มีการประมวลผล' 
END  as  fbss
,CASE  
WHEN ad.bun=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.bun=2 THEN 'ปกติ '
WHEN ad.bun=3 THEN 'ผิดปกติเล็กน้อย อาจเกิดจากการได้รับยาบางชนิด หรือมีภาวะการทำงานของไต '
WHEN ad.bun=4 THEN 'ผิดปกติ หมายถึง ภาวะไตทำงานขัดข้องจากสาเหตุต่างๆ ควรพบแพทย์ทันที  '
ELSE 'ไม่มีการประมวลผล' 
END  as  bunn
,CASE  
WHEN ad.ur=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.ur=2 THEN 'ปกติ '
WHEN ad.ur=3 THEN 'สูงกว่าปกติเล็กน้อย อาจเกิดจากการรับประทานอาหารประเภทเครื่องในสัตว์ หรือถั่วมากเกินไป รวมทั้งการรับประทาน ยาบางชนิด
หรือแอลกอฮอล์ แนะนำให้ลดการดื่มเหล้า หลีกเลี่ยงการรับประทานอาหารที่มีกรดยูริกสูง เช่น เครื่องในสัตว์ ไข้ปลา ยอดผัก เป็นต้น และ ตรวจเลือดซ้ำในอีก 6 เดือน  '
WHEN ad.ur=4 THEN 'สูงกว่าปกติมาก หมายถึง มีความเสี่ยงต่อการเป็นนิ่วในไต หรือการเป็นเก๊าท์มากกว่าปกติ ควรพบแพทย์ทันที '
ELSE 'ไม่มีการประมวลผล' 
END  as  urr
,CASE  
WHEN ad.ldl=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.ldl=2 THEN 'ปกติ '
WHEN ad.ldl=3 THEN 'สูงกว่าปกติเล็กน้อย
1.ขอให้ท่านทบทวนให้แน่ใจว่าอดอาหารก่อนมาเจาะเลือด 12 ชั่วโมงหรือไม่
2.หลีกเลี่ยงอาหารที่มีโคเลสเตอรอลสูง เช่น ไข่แดง กะทิ ไขมันสัตว์ เนย เป็นต้น
3. ควรออกกำลังกายเพิ่มขึ้นและ กระทำอย่างสม่ำเสมอ พักผ่อนให้เพียงพอ ควรตรวจเลือดซ้ำในอีก 6 เดือน '
WHEN ad.ldl=4 THEN 'สูงกว่าปกติมาก สูงกว่าปกติมากบ่งบอกภาวะไขมันเลือดสูง มีอัตราเสี่ยงในการเกิดโรคเส้นเลือดแดงหัวใจตีบมากกว่าคนทั่วไปควรพบแพทย์
HDL เป็นไขมันดี ช่วยป้องกันโรคหัวใจและหลอดเลือด ควรเพิ่ม HDL โดยการออกกำลังกาย รับประทานอาหารที่มีโอเมก้า3,อาหารที่มีกากใยสูง และธัญพืช  '
ELSE 'ไม่มีการประมวลผล' 
END  as  ldll
,CASE  
WHEN ad.lft=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.lft=2 THEN 'ปกติ '
WHEN ad.lft=3 THEN 'สูงกว่าปกติเล็กน้อย สูงกว่าปกติเล็กน้อย อาจมีความบกพร่องของการทำงานของตับที่มีความรุนแรงน้อย ควรตรวจเลือดซ้ำในอีก 3 เดือน  '
WHEN ad.lft=4 THEN 'สูงกว่าปกติมาก สูงกว่าปกติมาก บ่งบอกการทำงานของตับผิดปกติจากสาเหตุต่างๆ ควรพบแพทย์  '
ELSE 'ไม่มีการประมวลผล' 
END  as  lftt
,CASE  
WHEN ad.haf=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.haf=2 THEN 'ตรวจไม่พบเชื้อ ไวรัสตับอักเสบ บี '
WHEN ad.haf=3 THEN 'สตรวจพบภูมิคุ้มกันต่อเชื้อไวรัสตับอักเสบบี '
WHEN ad.haf=4 THEN 'สูงกว่าปกติเล็กน้อย สูงกว่าปกติเล็กน้อย อาจมีความบกพร่องของการทำงานของตับที่มีความรุนแรงน้อย ควรตรวจเลือดซ้ำในอีก 3 เดือน  '
WHEN ad.haf=5 THEN 'สูงกว่าปกติมาก สูงกว่าปกติมาก บ่งบอกการทำงานของตับผิดปกติจากสาเหตุต่างๆ ควรพบแพทย์
คำแนะนำ ควรตรวจเพื่อติดตามการทำงานของตับอย่างต่อเนื่องทุกๆ 6-12 เดือน '
ELSE 'ไม่มีการประมวลผล' 
END  as  haff
,CASE  
WHEN ad.urinalysis=1 THEN 'ไม่ได้ตรวจ'
WHEN ad.urinalysis=2 THEN 'ปกติ'
WHEN ad.urinalysis=3 THEN 'ผิดปกติ โดยตรวจพบ :  พบน้ำตาล '
WHEN ad.urinalysis=4 THEN 'ผิดปกติ โดยตรวจพบ : อัลบูมิน (โปรตีนไข่ขาว) '
WHEN ad.urinalysis=5 THEN 'ผิดปกติ โดยตรวจพบ :  เลือด  '
WHEN ad.urinalysis=6 THEN 'ผิดปกติ โดยตรวจพบ : Leukocyte  '
ELSE 'ไม่มีการประมวลผล' 
END  as  urinalysiss
,CASE  
WHEN ad.urinalysis_j=1 THEN 'ปกติ'
WHEN ad.urinalysis_j=2 THEN 'ผิดปกติ พบเม็ดเลือดขาว และ/หรือเม็ดเลือดแดงในปัสสาวะเล็กน้อย ควรดื่มน้ำมากๆ ไม่กลั้นปัสสาวะ '
WHEN ad.urinalysis_j=3 THEN 'ผิดปกติ ถ้าเม็ดเลือดแดงมากควรรับการตรวจปัสสาวะ ถ้าเม็ดเลือดขาวมากคือมีอาการอักเสบต้องรับยารักษา และตรวจป้สสาวะซ้ำ ภายใน 2 สัปดาห์  '
ELSE 'ไม่มีการประมวลผล' 
END  as  urinalysis_jj
,CASE  
WHEN ad.defecate=1 THEN 'ไม่ได้ตรวจ '
WHEN ad.defecate=2 THEN 'ปกติ '
WHEN ad.defecate=3 THEN 'ผิดปกติ ถพบมีเลือดปนออกมาในอุจจาระ สมควรได้รับการตรวจเพิ่มเติม'
WHEN ad.defecate=4 THEN 'ผิดปกติ พบพยาธิหรือไข้พยาธิในอุจจาระ  '
ELSE 'ไม่มีการประมวลผล' 
END  as  defecatee
,CASE  
WHEN ad.pap=1 THEN 'ไม่ได้ตรวจ '
WHEN ad.pap=2 THEN 'ปกติ '
WHEN ad.pap=3 THEN 'ผิดปกติ ระบุ'
ELSE 'ไม่มีการประมวลผล' 
END  as  papp
,CASE  
WHEN ad.urinalysis_lab=1 THEN 'ไม่ได้ตรวจ '
WHEN ad.urinalysis_lab=2 THEN 'ปกติ '
WHEN ad.urinalysis_lab=3 THEN 'ผิดปกติ ระบุ'
ELSE 'ไม่มีการประมวลผล' 
END  as  urinalysis_labb
,CASE  
WHEN ad.chest_xray=1 THEN 'ไม่ได้ตรวจ '
WHEN ad.chest_xray=2 THEN 'ปกติ '
ELSE 'ไม่มีการประมวลผล' 
END  as  chest_xrayy
,ad.pap_comment,hc.vstdate as dateservice,hc.hn as hnhn,
hc.*,ad.* 
FROM hpt_check_up hc 
left outer join appove_doctor  ad on  hc.vn=ad.vn

 where  ad.vn='$vn' ";
$r_chup = mysqli_query($con_hchkup, $sql_chup);
$rowpt = mysqli_fetch_array($r_chup);

//fgfgfgfgfgfgfgfgfgfgfgfgfgfg/


//////////ความดันโลหิต//////////////////



$hn = $rowpt['hn'];
$sql_his = "SELECT cc_persist_disease FROM opd_ill_history where  hn ='$hn' ";
$r_h = mysqli_query($con_hos, $sql_his);
$rowh = mysqli_fetch_array($r_h);

// $backto="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; //ลิงค์สำหรับกลับมาหน้าเดิม

$content = "";

$date = date("d/m/Y,H:i:s");
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/custom/temp/dir/path']);
$month_now = (date("m")) + 0;
$year_now = date("Y");
$thai_month_arr = array("0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
$show_head_name = $thai_month_arr[$month_now] . " " . ($year_now + 543);

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

<img src="kroot.jpg" width="50" />
<div style="width:30%;">
     ' . $date . '
</div>
<div><font style="font-weight: bold;">ผลการตรวจสุขภาพประจําปีเจาหน้าที่โรงพยาบาลชัยภูมิ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/3</div>
<div style="width:45%;">
    &nbsp;
</div>
<div>
<font style="font-weight: bold;">โรงพยาลาลชัยภูมิ
</div>
<div style="width:35%;">
&nbsp;
</div>
<div>
<font style="font-weight: bold;">สรุปผลตรวจสุขภาพเจ้าหน้าที่ประจำปี
</div>
<div>
   ชื่อ - สกุล : &nbsp;&nbsp;' . $rowpt['ptname'] . '&nbsp;&nbsp;HN : &nbsp;&nbsp;' . $rowpt['hnhn'] . '&nbsp;&nbsp;หน่วยงาน : &nbsp;&nbsp;โรงพยาบาลชัยภูมิ
</div>

<div style="width:100%;">
    อายุ : &nbsp;&nbsp; ' . $rowpt['age_y'] . '&nbsp;ปี &nbsp;' . $rowpt['age_m'] . '&nbsp;เดือน &nbsp;' . $rowpt['age_d'] . '&nbsp;วัน&nbsp;&nbsp;เพศ : &nbsp;' . $rowpt['sexx'] . '&nbsp;&nbsp;วันที่ตรวจ : &nbsp;' . DateThai($rowpt['dateservice']) . '
</div>  
<div style="width:100%;">
 โรคประจำตัว  &nbsp;&nbsp; : ' . $rowh['cc_persist_disease'] . '
</div>

<div style="width:100%;">
ความดันโลหิต : &nbsp;&nbsp;<font style="font-weight: bold;">' . $rowpt['bpp'] . '
</div>
<div style="width:100%;">
คำแนะนำ : &nbsp;&nbsp;<font style="font-weight: bold;">' . $rowpt['suggestionn'] . '
</div>
<div style="width:100%;">
ค่าดัชนีมวลกาย(BMI) : &nbsp;&nbsp;<font style="font-weight: bold;">' . $rowpt['bmii'] . '
</div>

<div style="width:50%;">

ผลการตรวจทางห้องปฏิบัติการ 
</div>

<div style="width:100%;">
1.การตรวจความสมบูรณ์ของเม็ดเลือดแดง เม็ดเลือดขาว และเกร็ดเลือด (COMPLETE BLOOD COUNT)<br>
&nbsp;&nbsp;1.1. เม็ดเลือดแดง
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['cbc_redd'] . '
  </div>

<div style="width:100%;">
&nbsp;&nbsp;1.2 เม็ดเลือดขาว
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['cbc_whitee'] . '
</div>

<div style="width:100%;">
&nbsp;&nbsp;1.3 เกร็ดเลือด
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['bloodd'] . '
</div>

<div style="width:100%;">
&nbsp;&nbsp;1.4 เม็ดเลือดขาว อีโอสิโนฟิล
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['cbc_white_eoo'] . '
</div>

<div style="width:100%;">
2.ระดับน้ำตาลในเลือด (FBS)
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['fbss'] . '
</div>
<div style="width:100%;">
3.การทำงานของไต (BUN และ CREATININE)
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['bunn'] . '
</div>
<div style="width:100%;">
4.ระดับกรดยูริกในเลือด (URIC ACID)
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['urr'] . '
</div>
<div style="width:100%;">
5.ระดับไขมันโคเลสเตอรอล ไตรกลีเซอร์ไรด์ และแอลดีแอลโคเลสเตอรอลในเลือด (CHOLESTEROL TRIGLYCERIDE และ LDL – CHOLESTEROL)
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['ldll'] . '
</div>
<div style="width:100%;">
6.การทำงานของตับ (LFT)
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['lftt'] . '
</div>
<div style="width:100%;">
7. ผลการตรวจเกี่ยวกับไวรัสตับอักเสบ บี
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['haff'] . '
</div>
<div style="width:100%;">
8.การตรวจปัสสาวะ (URINALYSIS)<br>
&nbsp; &nbsp;  8.1. การตรวจทางเคมี
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['urinalysiss'] . '
</div>
<div style="width:100%;">
&nbsp; &nbsp;  8.2. การตรวจทางกล้องจุลทรรศน์
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['urinalysis_jj'] . '
</div>
';

$h = '
<div style="width:30%;">
     ' . $date . '
</div>

<div><font style="font-weight: bold;">ผลการตรวจสุขภาพประจําปีเจาหน้าที่โรงพยาบาลชัยภูมิ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2/3</div>

<div>
   ชื่อ - สกุล : &nbsp;&nbsp;' . $rowpt['ptname'] . '&nbsp;&nbsp;HN : &nbsp;&nbsp;' . $rowpt['hn'] . '&nbsp;&nbsp;หน่วยงาน : &nbsp;&nbsp;โรงพยาบาลชัยภูมิ
</div>

<div style="width:100%;">
    อายุ : &nbsp;&nbsp; ' . $rowpt['age_y'] . '&nbsp;ปี &nbsp;' . $rowpt['age_m'] . '&nbsp;เดือน &nbsp;' . $rowpt['age_d'] . '&nbsp;วัน&nbsp;&nbsp;เพศ : &nbsp;' . $rowpt['sexx'] . '&nbsp;&nbsp;วันที่ตรวจ : &nbsp;' . DateThai($rowpt['dateservice']) . '
</div>  ';

// $testcheck="1";
// $show_check1 = '<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
// $show_check2 = '<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
// $show_check3 = '<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
// $show_check4 = '<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
// if($testcheck==1){
//     $show_check1 = '<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
// }elseif($testcheck==2){
//     $show_check2 = '<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
// }
// <input name="d_13" value="Y" type="checkbox" class="form-check-input"><br>

// <input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">

// <br>
// '.$show_check1.'test<br>
// '.$show_check2.'test2<br>
$nomal_check=$rowpt['nomal_check'];
if($nomal_check=="Y"){
    $show_nomal ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($nomal_check==""){
    $show_nomal ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}

$doctor_check=$rowpt['doctor_check'];
if($doctor_check=="Y"){
    $show_doc_check ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($doctor_check=''){
    $show_doc_check ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}

$d1=$rowpt['d_1'];
if($d1=="Y"){
    $show_d1 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d1==''){
    $show_d1 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d2=$rowpt['d_2'];
if($d2=="Y"){
    $show_d2 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d2==''){
    $show_d2 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d3=$rowpt['d_3'];
if($d3=="Y"){
    $show_d3 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d3==''){
    $show_d3 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d4=$rowpt['d_4'];
if($d4=="Y"){
    $show_d4 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d4==''){
    $show_d4 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d5=$rowpt['d_5'];
if($d5=="Y"){
    $show_d5 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d5==''){
    $show_d5 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d6=$rowpt['d_6'];
if($d6=="Y"){
    $show_d6 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d6==''){
    $show_d6 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d7=$rowpt['d_7'];
if($d7=="Y"){
    $show_d7 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d7==''){
    $show_d7 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d8=$rowpt['d_8'];
if($d8=="Y"){
    $show_d8 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d8==''){
    $show_d8 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d9=$rowpt['d_9'];
if($d9=="Y"){
    $show_d9 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d9==''){
    $show_d9 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d10=$rowpt['d_10'];
if($d10=="Y"){
    $show_d10 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d10==''){
    $show_d10 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d11=$rowpt['d_11'];
if($d11=="Y"){
    $show_d11 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d11==''){
    $show_d11 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d12=$rowpt['d_12'];
if($d12=="Y"){
    $show_d12 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d12==''){
    $show_d12 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}
$d13=$rowpt['d_13'];
if($d13=="Y"){
    $show_d13 ='<input name="d_13" value="Y" type="checkbox" checked="checked" class="form-check-input">';
}elseif($d13==''){
    $show_d13 ='<input name="d_13" value="Y" type="checkbox" class="form-check-input">';
}



$content2='
___________________________________________________________________________________
<div style="width:100%;">
9. การตรวจอุจจาระ
&nbsp; : &nbsp;<font style="font-weight: bold;"> <u>' . $rowpt['defecatee'] . '</u>
</div>
<div style="width:100%;">
10. ผลการตรวจอื่นๆ <br>
&nbsp;&nbsp;10.1 การตรวจเซลล์ปากมดลูก (pap smear)/HPV DNA 
&nbsp; : &nbsp;<font style="font-weight: bold;"><u>' . $rowpt['pap'] . '</u> &nbsp; ผิดปกติ :'.$rowpt['pap_comment'].'
</div>
<div style="width:100%;">
&nbsp;&nbsp;10.2 เอกซ์เรย์ทรวงอก (Chest X-ray)
&nbsp; : &nbsp;<font style="font-weight: bold;"><u>' . $rowpt['chest_xrayy'] . '</u>&nbsp; ผิดปกติ :'.$rowpt['chest_xray_com'].'
</div>
<div style="width:100%;">
&nbsp;&nbsp;10.3 ผลตรวจอื่นๆ 
&nbsp; : &nbsp;<font style="font-weight: bold;"><u>' . $rowpt['check_all_comment'] .'</u>
</div>
<div style="width:25%;">
&nbsp;
</div>
<div><font style="font-weight: bold;"><h2>สรุป ผลการตรวจสุขภาพประจําปี</h2></div>
<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_nomal. '</font>&nbsp;&nbsp; สุขภาพทั่วไปอยู์ในเกณฑ์ปกติ
</div>
<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_doc_check. '</font>&nbsp;&nbsp; อาจมีปัญหาสุขภาพ โดยตรวจพบ <br>
&nbsp;<font style="font-weight: bold;">' .$show_d1. '</font>&nbsp;&nbsp; ความดันโลหิตสูง 
&nbsp;<font style="font-weight: bold;">' .$show_d2. '</font>&nbsp;&nbsp; มีภาวะซีดผิดปกติ 
&nbsp;<font style="font-weight: bold;">' .$show_d3. '</font>&nbsp;&nbsp; หน้าที่ของไตผิดปกติ 
</div>
<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_d4. '</font>&nbsp;&nbsp; เอกซ์เรย์ปอดผิดปกติ 
&nbsp;<font style="font-weight: bold;">' .$show_d5. '</font>&nbsp;&nbsp; ไขมันในเลือดสูง 
&nbsp;<font style="font-weight: bold;">' .$show_d6. '</font>&nbsp;&nbsp; เอ็นไซม์ตับผิดปกติ 
</div>
<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_d7. '</font>&nbsp;&nbsp; มีเลือดออกในทางเดินอาหาร
&nbsp;<font style="font-weight: bold;">' .$show_d8. '</font>&nbsp;&nbsp; เซลล์เยื่อบุปากมดลูกผิดปกติ
&nbsp;<font style="font-weight: bold;">' .$show_d9. '</font>&nbsp;&nbsp; กรดยูริกสูง 
</div>
<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_d10. '</font>&nbsp;&nbsp; พาหะไวรัสตับอักเสบ บี 
&nbsp;<font style="font-weight: bold;">' .$show_d11. '</font>&nbsp;&nbsp; มีความผิดปกติของทางเดินปัสสาวะ 
&nbsp;<font style="font-weight: bold;">' .$show_d12. '</font>&nbsp;&nbsp; เม็ดเลือดขาว อีโอสิโนฟิลสูง
</div>

<div style="width:100%;">
&nbsp;<font style="font-weight: bold;">' .$show_d13. '</font>&nbsp;&nbsp; น้ำตาลในเลือดสูง 
</div>

<div style="width:100%;">
เรื่องอื่นๆ
&nbsp; : &nbsp;<font style="font-weight: bold;">' . $rowpt['doctor_comment'] .'
</div>

<div style="width:30%;">
&nbsp;
</div>
<div><font style="font-weight: bold;"><h2>ข้อควรปฎิบัติ</h2></div>
<table  style="border:1px solid">
<th>
<tr>

<td>5555555
</td>
</tr></th>
</table>
';
$footer = '';

$end = '
<div style="width:29%;">
    &nbsp;
</div>
<div style="text-align: center;"><BR>ลงชื่อ__________________________ <BR> (' . ') <BR> ' . 'โรงพยาบาล' . '
</div>';

$end .= '
<BR><BR>
<div style="width:100%;">
    กลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์    
</div>
<div style="width:100%;">
    ' . '  
</div>

<div style="width:100%;" style="text-align:center;">
    <font style="font-weight: bold;">55555555555555555555555555555555555' . '<font>  
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
        โรงพยาบาล ' . '<BR>' . '  
    </div>
    <div style="width:44%; text-align:right">
        ชำระค่าฝากส่งเป็นรายเดือน
        <BR>
        ใบอณุญาตที่ ' . '
        <BR>
        ไปรษณีย์ ' . '
    </div>

    <div style="width:40%;">
        &nbsp;
    </div>
    <div style="width:59%">
        <BR>
        ' . ' 
        <BR>
        ' . ' ' . '
        <BR>
        ' . '
        <BR>
        ' . '
        <BR>
        ' . '
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
// $mpdf->Image('kroot.jpg', 92, 10, 28, 31, 'jpg', '', true, false);
#$mpdf->setHeader('เลขหนังสือ : '.$pang_stamp_send);

#$mpdf->setFooter('{PAGENO}');

$mpdf->WriteHTML($head);
$mpdf->WriteHTML($content);

// $mpdf->WriteHTML($end);

$mpdf->AddPage('P');
$mpdf->WriteHTML($h);
$mpdf->WriteHTML($content2);

$mpdf->WriteHTML($footer);

$mpdf->AddPage('P');
$mpdf->WriteHTML($font);


$mpdf->Output();

?>