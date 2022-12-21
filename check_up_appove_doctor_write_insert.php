<?php

include "connect/connect.php";



$vn = (isset($_REQUEST['vn']) ? $_REQUEST['vn'] : '');
$bp = (isset($_REQUEST['bp']) ? $_REQUEST['bp'] : '');
$suggestion = (isset($_REQUEST['suggestion']) ? $_REQUEST['suggestion'] : '');
$suggestion_all = (isset($_REQUEST['suggestion_all']) ? $_REQUEST['suggestion_all'] : '');
$bmi = (isset($_REQUEST['bmi']) ? $_REQUEST['bmi'] : '');
$cbc_red = (isset($_REQUEST['cbc_red']) ? $_REQUEST['cbc_red'] : '');
$cbc_white = (isset($_REQUEST['cbc_white']) ? $_REQUEST['cbc_white'] : '');
$blood = (isset($_REQUEST['blood']) ? $_REQUEST['blood'] : '');
$cbc_white_eo = (isset($_REQUEST['cbc_white_eo']) ? $_REQUEST['cbc_white_eo'] : '');
$fbs = (isset($_REQUEST['fbs']) ? $_REQUEST['fbs'] : '');
$bun = (isset($_REQUEST['bun']) ? $_REQUEST['bun'] : '');
$ur = (isset($_REQUEST['ur']) ? $_REQUEST['ur'] : '');
$ldl = (isset($_REQUEST['ldl']) ? $_REQUEST['ldl'] : '');
$lft = (isset($_REQUEST['lft']) ? $_REQUEST['lft'] : '');
$haf = (isset($_REQUEST['haf']) ? $_REQUEST['haf'] : '');
$urinalysis = (isset($_REQUEST['urinalysis']) ? $_REQUEST['urinalysis'] : '');
$urinalysis_j = (isset($_REQUEST['urinalysis_j']) ? $_REQUEST['urinalysis_j'] : '');
$defecate = (isset($_REQUEST['defecate']) ? $_REQUEST['defecate'] : '');
$pap = (isset($_REQUEST['pap']) ? $_REQUEST['pap'] : '');
$urinalysis_lab = (isset($_REQUEST['urinalysis_lab']) ? $_REQUEST['urinalysis_lab'] : '');
$urinalysis_camera = (isset($_REQUEST['urinalysis_camera']) ? $_REQUEST['urinalysis_camera'] : '');
$pap_comment = (isset($_REQUEST['pap_comment']) ? $_REQUEST['pap_comment'] : '');
$chest_xray = (isset($_REQUEST['chest_xray']) ? $_REQUEST['chest_xray'] : '');
$chest_xray_com = (isset($_REQUEST['chest_xray_com']) ? $_REQUEST['chest_xray_com'] : '');
$check_all_comment = (isset($_REQUEST['check_all_comment']) ? $_REQUEST['check_all_comment'] : '');
$nomal_check = (isset($_REQUEST['nomal_check']) ? $_REQUEST['nomal_check'] : '');
$doctor_check = (isset($_REQUEST['doctor_check']) ? $_REQUEST['doctor_check'] : '');
$d_1 = (isset($_REQUEST['d_1']) ? $_REQUEST['d_1'] : '');
$d_2 = (isset($_REQUEST['d_2']) ? $_REQUEST['d_2'] : '');
$d_3 = (isset($_REQUEST['d_3']) ? $_REQUEST['d_3'] : '');
$d_4 = (isset($_REQUEST['d_4']) ? $_REQUEST['d_4'] : '');
$d_5 = (isset($_REQUEST['d_5']) ? $_REQUEST['d_5'] : '');
$d_6 = (isset($_REQUEST['d_6']) ? $_REQUEST['d_6'] : '');
$d_7 = (isset($_REQUEST['d_7']) ? $_REQUEST['d_7'] : '');
$d_8 = (isset($_REQUEST['d_8']) ? $_REQUEST['d_8'] : '');
$d_9 = (isset($_REQUEST['d_9']) ? $_REQUEST['d_9'] : '');
$d_10 = (isset($_REQUEST['d_10']) ? $_REQUEST['d_10'] : '');
$d_11 = (isset($_REQUEST['d_11']) ? $_REQUEST['d_11'] : '');
$d_12 = (isset($_REQUEST['d_12']) ? $_REQUEST['d_12'] : '');
$d_13 = (isset($_REQUEST['d_13']) ? $_REQUEST['d_13'] : '');
$doctor_comment = (isset($_REQUEST['doctor_comment']) ? $_REQUEST['doctor_comment'] : null);
$procedure = (isset($_REQUEST['procedure']) ? $_REQUEST['procedure'] : null);
$procedure_doc = (isset($_REQUEST['procedure_doc']) ? $_REQUEST['procedure_doc'] : null);
$procedure_1 = (isset($_REQUEST['procedure_1']) ? $_REQUEST['procedure_1'] : null);
$procedure_2 = (isset($_REQUEST['procedure_2']) ? $_REQUEST['procedure_2'] : null);
$procedure_comment = (isset($_REQUEST['procedure_comment']) ? $_REQUEST['procedure_comment'] : null);
$doctor_name = (isset($_REQUEST['doctor_name']) ? $_REQUEST['doctor_name'] : null);

$chec = "select * from appove_doctor where  vn='$vn'";
$r_q = mysqli_query($con_hchkup, $chec);
$row = mysqli_fetch_assoc($r_q);
if ($row['vn'] <> '') {
    echo "<script language=\"JavaScript\">";
    echo "alert('มี่การบันทึกข้อมูลซ้ำ !!! ');window.history.go(-2);";
    echo "</script>";
} else {
    // echo $vn.'<br>'.$bp.'<br>'.$suggestion.'<br>'.$suggestion_all.'<br>'.$bmi.'<br>'.$cbc_red.'<br>'.$cbc_white.'<br>'.$blood.'<br>'
    // .$cbc_white_eo.'<br>'.$fbs.'<br>'.$bun.'<br>'.$ur.'<br>'.$ldl.'<br>'.$lft.'<br>'.$haf.'<br>'.$urinalysis.'<br>'.$urinalysis_j.'<br>'
    // .$defecate.'<br>'.$pap.'<br>'.$pap_comment.'<br>'.$chest_xray.'<br>'.$chest_xray_com.'<br>'.$check_all_comment.'<br>'.$nomal_check.'<br>'
    // .$doctor_check.'<br>'.$d_1.'<br>'.$d_2.'<br>'.$d_3.'<br>'.$d_4.'<br>'.$d_5.'<br>'.$d_6.'<br>'.$d_7.'<br>'
    // .$d_8.'<br>'.$d_9.'<br>'.$d_10.'<br>'.$d_11.'<br>'.$d_12.'<br>'.$d_13.'<br>'.$doctor_comment.'<br>'.$procedure.'<br>'.$procedure_doc
    // .'<br>'.$procedure_1.'<br>'.$procedure_2.'<br>'.$procedure_comment
    // ; 

    $sql_insert = "INSERT INTO `appove_doctor`
 (`vn`,
 `bp`,
 `suggestion`,
 `suggestion_all`,
 `bmi`,
`cbc_red`,
`cbc_white`,
`blood`,
`cbc_white_eo`,
`fbs`,
`bun`,
`ur`,
 `ldl`,
`lft`,
`haf`,
 `urinalysis`,
 `urinalysis_j`,
 `defecate`,
 `pap`,
 `urinalysis_lab`,
 `urinalysis_camera`,
 `doctor_check`,
 `pap_comment`,
 `chest_xray`,
 `chest_xray_com`,
 `check_all_comment`,
 `nomal_check`,
`d_1`, 
`d_2`,
`d_3`, 
`d_4`,
`d_5`,
`d_6`,
`d_7`,
`d_8`,
`d_9`,
`d_10`,
`d_11`,
`d_12`,
 `d_13`,
 `doctor_comment`,
 `procedure`, 
 `procedure_doc`,
 `procedure_1`,
 `procedure_2`,
 `procedure_comment`,
 `doctor_name`) 
 VALUES('$vn',
 '$bp',
 '$suggestion',
 '$suggestion_all',
 '$bmi',
 '$cbc_red',
 '$cbc_white',
 '$blood',
 '$cbc_white_eo',
 '$fbs',
 '$bun',
 '$ur',
 '$ldl',
 '$lft',
 '$haf',
 '$urinalysis',
 '$urinalysis_j',
 '$defecate',
 '$pap',
 '$urinalysis_lab',
 '$urinalysis_camera',
 '$doctor_check',
 '$pap_comment' ,
 '$chest_xray',
 '$chest_xray_com',
 '$check_all_comment',
 '$nomal_check',
 '$d_1',
 '$d_2',
 '$d_3',
 '$d_4',
 '$d_5',
 '$d_6',
 '$d_7',
 '$d_8',
 '$d_9',
 '$d_10',
 '$d_11',
 '$d_12',
 '$d_13',
 '$doctor_comment' ,
 '$procedure',
 '$procedure_doc',
 '$procedure_1',
 '$procedure_2',
 '$procedure_comment',
 '$doctor_name')";
    if (mysqli_query($con_hchkup, $sql_insert)) {
        echo "<script language=\"JavaScript\">";
        echo "alert('บันทึกเรียบร้อย');window.history.go(-1);";
        echo "</script>";
    } else {
        echo "error";
    }
}
