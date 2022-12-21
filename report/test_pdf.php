
<?php
// const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
// const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
// const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
// const BAHT_TEXT_TWENTY = 'ยี่';
// const BAHT_TEXT_INTEGER = 'ถ้วน';
// const BAHT_TEXT_BAHT = 'บาท';
// const BAHT_TEXT_SATANG = 'สตางค์';
// const BAHT_TEXT_POINT = 'จุด';



//เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
//require_once('mpdf/vendor/autoload.php');
require_once __DIR__ . '/mpdf/vendor/autoload.php';

include("../connect/connect.php");

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->AddPage('P');
$mpdf->AddPage('P');
$mpdf->Output();
?>