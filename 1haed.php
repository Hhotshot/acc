<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>HEALTH_CHECK</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
<meta name="description" content="Examples of just how powerful ArchitectUI really is!">
<!-- Disable tap highlight on IE -->
<meta name="msapplication-tap-highlight" content="no">
<link rel="stylesheet" href="./vendors/@fortawesome/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="./vendors/ionicons-npm/css/ionicons.css">
<link rel="stylesheet" href="./vendors/linearicons-master/dist/web-font/style.css">
<link rel="stylesheet" href="./vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
<link href="./styles/css/base.css" rel="stylesheet">
<!-- font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Niramit&display=swap" rel="stylesheet">
<style type="text/css">
    body {
        font-family: 'Niramit', sans-serif;
    }
</style>
<?php include "connect/connect.php" ?>
<!-- format วันที่  -->
<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

$strDate = date('d-m-Y');
// echo "ข้อมูลวันที่: " . DateThai($strDate);
?>