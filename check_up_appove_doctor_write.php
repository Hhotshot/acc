<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use Mpdf\Tag\Br;

    include "1haed.php";
    @$vn = $_GET['vn'];
    ?>
</head>

<body>
    <?php include "2navbar.php"; ?>
    <?php // include "3menu_left.php"; 
    ?>
    <div class="app-container">
        <!--navebar-->
        <!--navebar-->
        <div class="app-main">
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="tabs-animation">
                            <div class="main-card mb-3 card">
                                <div class="card-header-tab card-header">

                                    <div class="card-header-title font-size-lg text-capitalize fw-normal">

                                        <i class="lnr-user icon-gradient bg-arielle-smile"> :: </i>
                                        <div>
                                            <?php
                                            $sql_em  = "SELECT * FROM hpt_check_up where vn='$vn'";
                                            $q_em = mysqli_query($con_hchkup, $sql_em);
                                            $row_em = mysqli_fetch_array($q_em);
                                            if ($vn == " ") {
                                                echo "ไม่มีข้อมูล";
                                            }
                                            echo '<font color="red" "><h3><b> ข้อมูล : ' . $row_em['ptname'] . '</b></h3></font>'; ?>
                                        </div>

                                    </div>

                                    <!-- <div class="btn-actions-pane-right actions-icon-btn">
                                        <div class="d-inline-block dropdown">
                                            <a href="check_up_appove_doctor_write_insert.php?vn<?php echo $row_em['vn'] ?>"><button type="button" class="btn-shadow dropdown-toggle btn btn-info">
                                                    <span class="btn-icon-wrapper pe-2 opacity-7">
                                                        <i class="fa fa-pen"></i>
                                                    </span>
                                                    บันทึกข้อมูล
                                                </button></a>
                                            <a href="report/check_up_print.php?vn=<?php echo $row_em['vn'] ?>"><button type="button" class="btn-shadow dropdown-toggle btn btn-success">
                                                    <span class="btn-icon-wrapper pe-2 opacity-7">
                                                        <i class="fa fa-print"></i>
                                                    </span>
                                                    พิมพ์
                                                </button></a>
                                        </div>

                                    </div> -->
                                </div>
                                <div class="card-body">
                                    <?php
                                    $sql_chup = "SELECT * FROM hpt_check_up where  vn='$vn'";
                                    $r_chup = mysqli_query($con_hchkup, $sql_chup);
                                    $row = mysqli_fetch_array($r_chup);

                                    $sql_h = "SELECT oh.cc_persist_disease FROM ovst o
                                        left outer join opd_ill_history  oh  on o.hn=o.hn
                                         where o.vn='$vn' limit 1 ";
                                    $re_h = mysqli_query($con_hos, $sql_h);
                                    $rowh = mysqli_fetch_assoc($re_h);
                                    ?>
                                    <div class="card-header-tab card-header">
                                        <div style="width:100%;">
                                            <font style="font-weight: bold;font-size:20px;">เลขบัตรประชาชน &nbsp;:&nbsp; <u><?php echo $row['cid'] ?></u></font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">HN &nbsp; : &nbsp; <u><?php echo $row['hn'] ?></u></font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">อายุ &nbsp; : &nbsp; <u><?php echo $row['age_y'] ?></u> &nbsp; ปี
                                                &nbsp; <u><?php echo $row['age_m'] ?></u> เดือน &nbsp; <u><?php echo $row['age_d'] ?></u> &nbsp;วัน
                                            </font>

                                        </div>
                                    </div>
                                    <div class="card-header-tab card-header">
                                        <div style="width:100%;">
                                            <font style="font-weight: bold;font-size:20px;">วันที่ตรวจ&nbsp; :&nbsp; <u><?php echo DateThai($row['vstdate']) ?></u></font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">น้ำหนัก &nbsp;:&nbsp; <u><?php echo $row['bw'] ?></u> กก.</font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">ส่วนสูง &nbsp; : &nbsp; <u><?php echo $row['height'] ?></u> ซม.</font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">ควมดันโลหิต &nbsp; : &nbsp; <u><?php echo number_format($row['bps']) . '/' . number_format($row['bpd']); ?></u> &nbsp; มม.ปรอท</font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">ชีพจร &nbsp; : &nbsp; <u><?php echo number_format($row['pulse']) ?></u> &nbsp;ครั้ง/วินาที</font>
                                        </div>
                                    </div>
                                    <div class="card-header-tab card-header">
                                        <div style="width:100%;">
                                            <font style="font-weight: bold;font-size:20px;">BMI &nbsp; :&nbsp; <u><?php echo number_format($row['bmi'], 2) ?></u></font>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font style="font-weight: bold;font-size:20px;">โรคประจำตัว &nbsp; : &nbsp; <u><?php echo @$rowh['cc_persist_disease'] ?></u> &nbsp;</font>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $sql_l = "SELECT if(l.lab_order_result=l.lab_items_normal_value_ref,'ปกติ','')as resulf,l.*,lh.sex FROM  hpt_lab_check_up l 
                                        left outer join  hpt_check_up   lh  on  l.vn=lh.vn
                                        where  l.vn='$vn'  and  l.lab_order_result <>''  group by l.lab_items_name ";
                                $re_l = mysqli_query($con_hchkup, $sql_l);
                                $rowl = mysqli_fetch_assoc($re_l);
                                ?>


                                <?php

                                $sql_x = "SELECT l.*,lh.sex FROM  hpt_xray_check_up l 
                                        left outer join  hpt_check_up   lh  on  l.vn=lh.vn
                                        where  l.vn='$vn' ";
                                $re_x = mysqli_query($con_hchkup, $sql_x);
                                ?>

                            </div>
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">ความดันโลหิต</h5>
                                    <div>
                                        <form action="check_up_appove_doctor_write_insert.php" method="POST" enctype="multipart/form-data">

                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bp" type="radio" class="form-check-input" value="1">ปกติ
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bp" type="radio" class="form-check-input" value="2">ต่ำกว่าปกติ
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bp" type="radio" class="form-check-input" value="3">สูงกว่าปกติ
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <!-- ความดันโลหิต -->
                                            <div class="divider"></div>

                                            <h5 class="card-title">คำแนะนำ</h5>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="suggestion" type="radio" class="form-check-input" value="1" required>ตรววจซ้ำใน 1 ปี
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="suggestion" type="radio" class="form-check-input" value="2">ตรวจยืนยันภายใน 2 เดือน
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="suggestion" type="radio" class="form-check-input" value="3">พบแพทย์ภายใน 1 เดือน
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <!-- <input name="suggestion" type="radio" class="form-check-input"> -->
                                                <label class="form-label form-check-label"></label>อื่นๆ
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <label class="form-label form-check-label"></label>
                                                <input type="text" name="suggestion_all" class="form-control" id="staticEmail2" placeholder="ระบุ">
                                            </div>
                                            <!-- คำแนะนำ -->
                                            <div class="divider"></div>

                                            <h5 class="card-title" title="image tooltip">ค่าดัชนีมวลกาย (เป็นดัชนีชี้วัดภาวะอ้วนและผอมของบุคคลที่มีความสัมพันธ์กับสุขภาพ)</h5>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bmi" value="1" type="radio" class="form-check-input" <?php if ($row['bmi'] >= '18.5' and $row['bmi'] <= '22.9') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?>>
                                                น้ำหนักอยู่ในเกณฑ์ปกติ <b>(BMI อยู่ระหว่าง 18.5 - 22.9)</b> ดูแลสุขภาพและควบคุมน้ำหนักให้อยู่ในระดับนี้ต่อไป ดัวยการรับประทานอาหารที่มีประโยชน์
                                                ออกกำลังกายสม่ำเสมอ และพักผ่อนให้เพียงพอ
                                                <label class="form-label form-check-label"></label>
                                            </div><br>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bmi" value="2" type="radio" class="form-check-input" <?php if ($row['bmi'] < '18.5') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?>>น้ำหนักต่ำกว่าปกติ <b>(BMI น้อยกว่า 18.5)</b> แนะนำให้รับประทานอาหารประเภ
                                                อย่างเพียงพอต่อความต้องการของร่างกาย และออกกำลังกายอย่างสม่ำเสมอ
                                                <label class="form-label form-check-label"></label>
                                            </div><br>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bmi" value="3" type="radio" class="form-check-input" <?php if ($row['bmi'] >= '23' and $row['bmi'] <= '24.9') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?>>
                                                น้ำหนักเกิน <b>(BMI อยู่ระหว่าง 23.0 - 24.9)</b> ควรควบคุมน้ำหนัก จำกัดอาหารไขมันสูง แป้งและน้ำตาล รวมถึงผลไม่รสหวาน หลีกเลี่ยงเครื่องดื่มมีแอลกอฮอล์
                                                และออกกำลังกายอย่างน้อยสัปดาห์ละ 5 วัน วันละ 30 นาที
                                                <label class="form-label form-check-label"></label>
                                            </div><br>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bmi" value="4" type="radio" class="form-check-input" <?php if ($row['bmi'] >= '25' and $row['bmi'] <= '29.9') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?>>
                                                อ้วน <b>(BMI อยู่ระหว่าง 25.0 - 29.9)</b> ทำานมีภาวะอ้วน มีความเสี่ยงต่อการเกิดโรคเบาหวาน ความดันโลหิตสูง โรคหัวใจและโรคมะเร็งบางจำพวก
                                                เช่นมะเร็งลำไส้ใหญ่และมะเร็งเต้านมเป็นต้น ควรลดน้ำหนักอย่างจริงจัง
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <div class="position-relative form-check form-check-inline">
                                                <input name="bmi" value="5" type="radio" class="form-check-input" <?php if ($row['bmi'] >= '30') {
                                                                                                                        echo 'checked="checked"';
                                                                                                                    } ?>>
                                                อ้วนมาก <b>(BMI มากกว่า 30)</b> ท่านเป็นโรคอ้วน ที่มีความเสี่ยงสูงต่อการเกิด โรคเบาหวาน โรคหัวใจ โรคความดันโลหิตสูง โรคมะเร็งบางชนิดเช่น
                                                มะเร็งลำไส้ใหญ่และมะเร็งเต้านมเป็นต้น ควรพบแพทย์เพื่อลดน้ำหนักอย่างเหมาะสมและถูกวิธ
                                                <label class="form-label form-check-label"></label>
                                            </div>
                                            <!-- BMI -->
                                            <div class="divider"></div>
                                            <center>
                                                <h5 class="card-title">ผลการตรวจทางห้องปฏิบัติการ
                                                 
                                                    <div class="dropdown d-inline-block">
                                                        <button type="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" class="mb-2 me-2 dropdown-toggle btn btn-danger">
                                                          ดูผลแลป
                                                        </button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl dropdown-menu">
                                                            <div class="dropdown-menu-header">
                                                                <div class="dropdown-menu-header-inner bg-sunny-morning">
                                                                    <!-- <div class="menu-header-image" style="background-image: url('images/dropdown-header/city3.jpg');"></div> -->
                                                                    <div class="menu-header-content text-dark">
                                                                        <h5 class="menu-header-title">ผลตรวจจากห้องปฎิบัติการ</h5>
                                                                        <!-- <h6 class="menu-header-subtitle">Manage all of your options</h6> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-menu grid-menu-xl grid-menu-3col">
                                                                <div class="g-0 row">
                                                                    <div class="col-sm-6 col-xl-4">
                                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                            <!-- <i class="lnr-license btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                          <b>  รายการแลป</b>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xl-4">
                                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                            <!-- <i class="lnr-map btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                            <b>   ค่าปกติ</b>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xl-4">
                                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                            <!-- <i class="lnr-music-note btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                            <b>   ผลตรวจ</b>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $l_s = "SELECT * from  hpt_lab_check_up
                                                              where  vn='$vn'  and  lab_order_result is not null GROUP BY lab_items_code,vn  ";
                                                                $l_r = mysqli_query($con_hchkup, $l_s);

                                                                ?>

                                                                <?php while ($rowl = mysqli_fetch_assoc($l_r)) {  ?>
                                                                    <div class="g-0 row">
                                                                        <div class="col-sm-6 col-xl-4">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                                <!-- <i class="lnr-heart btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                                <?= $rowl['lab_items_name'] ?>
                                                                            </button>

                                                                        </div>
                                                                        <div class="col-sm-6 col-xl-4">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                                <!-- <i class="lnr-heart btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                                <?= $rowl['lab_items_normal_value_ref'] ?>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-sm-6 col-xl-4">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                                <!-- <i class="lnr-heart btn-icon-wrapper btn-icon-lg mb-3"></i> -->
                                                                                <?= $rowl['lab_order_result'] ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider"></div>
                                                                <?php   } ?>


                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>

                                    </h5>
                                    </center>
                                    <h5 class="card-title">1.การตรวจความสมบูรณ์ของเม็ดเลือดแดง เม็ดเลือดขาว และเกร็ดเลือด (Complete blood count)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp; <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_red" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <h5 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;1.1. เม็ดเลือดแดง</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_red" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_red" value="3" type="radio" class="form-check-input">ซีดเล็กน้อย อาจมีสาเหตุเกิดจากความผิดปกติของระบบสร้างเม็ดเลือด หรือ จากการขาดธาตุเหล็ก
                                        เนื่องจากรับประทานอาหารที่มีธาตุเหล็กไม้เพียงพอกับปริมาณที่เสียไป หรือเสียโลหิตจากทางเดินอาหาร ควรรับประทานที่มีธาตุเหล็กเพิ่มขึ้น เช่น <br>
                                        เนื้อสัตว์ ไข้แดง พืชผักสีเขียว เช่น ยอดแค คื่นไช้ ใบแมงลัก และตรวจเลือดซ้ำในอีก 3 เดือน
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_red" value="4" type="radio" class="form-check-input">ซีดผิดปกติ <b>ควรพบแพทย์</b>
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <!-- เม็ดเลือดแดง -->
                                    <h5 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;1.2 เม็ดเลือดขาว</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_white" value="1" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_white" value="2" type="radio" class="form-check-input">ซีดผิดปกติ <b>ควรพบแพทย์</b>
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <br>
                                    <h5 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;1.3 เกร็ดเลือด</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="blood" value="1" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="blood" value="2" type="radio" class="form-check-input">ซีดผิดปกติ <b>ควรพบแพทย์</b>
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <!-- เกร็ดเลือด -->
                                    <br>
                                    <h5 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;1.4 เม็ดเลือดขาว อีโอสิโนฟิล</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_white_eo" value="1" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="cbc_white_eo" value="2" type="radio" class="form-check-input">ซีดผิดปกติ <b>ควรพบแพทย์</b>
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <!-- เม็ดเลือดขาว อีโอสิโนฟล -->
                                    <br>
                                    <h5 class="card-title">2.ระดับน้ำตาลในเลือด (FBS)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="fbs" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="fbs" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="fbs" value="3" type="radio" class="form-check-input">ต่ำกว่าปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="fbs" value="4" type="radio" class="form-check-input">สูงกว่าปกติเล็กน้อย ท่านอาจมีภาวะเบาหวานเริ่มต้น <br>
                                        1. แนะนำให้หลีกเลี่ยงอาหารที่มีรสหวาน น้ำตาล ขนมหวาน น้ำอัดลม เป็นต้น รวมทั้งผลไม้ที่มีรสหวาน <br>
                                        2. ควรงดสูบบุหรี่และงดดื่มแอลกอฮอล์ <br>
                                        3. ตรวจระดับน้ำตาลในเลือดซ้ำในอีก 1 เดือน หากยังมีค่าสูงผิดปกติ<b>ควรพบแพทย์ทันที</b>
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="fbs" value="5" type="radio" class="form-check-input">สูงกว่าปกติมาก <b>ควรพบแพทย์ทันที</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- fbs -->
                                    <h5 class="card-title"> 3.การทำงานของไต (BUN และ Creatinine)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="bun" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="bun" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="bun" value="3" type="radio" class="form-check-input">ผิดปกติเล็กน้อย อาจเกิดจากการได้รับยาบางชนิด หรือมีภาวะการทำงานของไต
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="bun" value="4" type="radio" class="form-check-input">ผิดปกติ หมายถึง ภาวะไตทำงานขัดข้องจากสาเหตุต่างๆ <b>ควรพบแพทย์ทันที</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- การทำงานของไต -->
                                    <h5 class="card-title"> 4.ระดับกรดยูริกในเลือด (Uric acid)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ur" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ur" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ur" value="3" type="radio" class="form-check-input"><b>สูงกว่าปกติเล็กน้อย</b> อาจเกิดจากการรับประทานอาหารประเภทเครื่องในสัตว์ หรือถั่วมากเกินไป รวมทั้งการรับประทาน ยาบางชนิด <br> หรือแอลกอฮอล์
                                        แนะนำให้ลดการดื่มเหล้า หลีกเลี่ยงการรับประทานอาหารที่มีกรดยูริกสูง เช่น เครื่องในสัตว์ ไข้ปลา ยอดผัก เป็นต้น และ ตรวจเลือดซ้ำในอีก 6 เดือน
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ur" value="4" type="radio" class="form-check-input"><b>สูงกว่าปกติมาก</b> หมายถึง มีความเสี่ยงต่อการเป็นนิ่วในไต หรือการเป็นเก๊าท์มากกว่าปกติ <b>ควรพบแพทย์ทันที</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- ระดับกรดยูริกในเลือด -->

                                    <h5 class="card-title"> 5.ระดับไขมันโคเลสเตอรอล ไตรกลีเซอร์ไรด์ และแอลดีแอลโคเลสเตอรอลในเลือด (Cholesterol Triglyceride และ LDL – Cholesterol)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ldl" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ldl" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ldl" value="3" type="radio" class="form-check-input">สูงกว่าปกติเล็กน้อย <br>
                                        1.ขอให้ท่านทบทวนให้แน่ใจว่าอดอาหารก่อนมาเจาะเลือด 12 ชั่วโมงหรือไม่ <br>
                                        2.หลีกเลี่ยงอาหารที่มีโคเลสเตอรอลสูง เช่น ไข่แดง กะทิ ไขมันสัตว์ เนย เป็นต้น <br>
                                        3. ควรออกกำลังกายเพิ่มขึ้นและ กระทำอย่างสม่ำเสมอ พักผ่อนให้เพียงพอ ควรตรวจเลือดซ้ำในอีก 6 เดือน
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="ldl" value="4" type="radio" class="form-check-input"><b>สูงกว่าปกติมาก</b> สูงกว่าปกติมากบ่งบอกภาวะไขมันเลือดสูง มีอัตราเสี่ยงในการเกิดโรคเส้นเลือดแดงหัวใจตีบมากกว่าคนทั่วไป<b>ควรพบแพทย์</b><br>
                                        HDL เป็นไขมันดี ช่วยป้องกันโรคหัวใจและหลอดเลือด ควรเพิ่ม HDL โดยการออกกำลังกาย รับประทานอาหารที่มีโอเมก้า3,อาหารที่มีกากใยสูง และธัญพืช
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- ระดับไขมันโคเลสเตอรอล -->

                                    <h5 class="card-title"> 6.การทำงานของตับ (LFT)</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="lft" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="lft" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="lft" value="3" type="radio" class="form-check-input"><b>สูงกว่าปกติเล็กน้อย </b>
                                        สูงกว่าปกติเล็กน้อย อาจมีความบกพร่องของการทำงานของตับที่มีความรุนแรงน้อย <b>ควรตรวจเลือดซ้ำในอีก 3 เดือน</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="lft" value="4" type="radio" class="form-check-input"><b>สูงกว่าปกติมาก</b> สูงกว่าปกติมาก บ่งบอกการทำงานของตับผิดปกติจากสาเหตุต่างๆ <b>ควรพบแพทย์</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- การทำงานของตับ -->

                                    <h5 class="card-title"> 7. ผลการตรวจเกี่ยวกับไวรัสตับอักเสบ บี</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="haf" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="haf" value="2" type="radio" class="form-check-input">ตรวจไม่พบเชื้อ ไวรัสตับอักเสบ บี
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="haf" value="3" type="radio" class="form-check-input">ตรวจพบภูมิคุ้มกันต่อเชื้อไวรัสตับอักเสบบี
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="haf" value="4" type="radio" class="form-check-input"><b>สูงกว่าปกติเล็กน้อย </b>
                                        สูงกว่าปกติเล็กน้อย อาจมีความบกพร่องของการทำงานของตับที่มีความรุนแรงน้อย <b>ควรตรวจเลือดซ้ำในอีก 3 เดือน</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="haf" value="5" type="radio" class="form-check-input"><b>สูงกว่าปกติมาก</b> สูงกว่าปกติมาก บ่งบอกการทำงานของตับผิดปกติจากสาเหตุต่างๆ <b>ควรพบแพทย์</b>
                                        <br>คำแนะนำ ควรตรวจเพื่อติดตามการทำงานของตับอย่างต่อเนื่องทุกๆ 6-12 เดือน
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    <!-- ผลการตรวจเกี่ยวกับไวรัสตับอักเสบ -->

                                    <h5 class="card-title"> 8.การตรวจปัสสาวะ (Urinalysis)</h5>
                                    <h5 class="card-title"> &nbsp;&nbsp;&nbsp;&nbsp;8.1. การตรวจทางเคมี</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>

                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                       ผิดปกติ โดยตรวจพบ :
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="3" type="radio" class="form-check-input"> น้ำตาล
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="4" type="radio" class="form-check-input"> อัลบูมิน (โปรตีนไข่ขาว)
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="5" type="radio" class="form-check-input">เลือด
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis" value="6" type="radio" class="form-check-input"> Leukocyte
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <br>                              
                                    <h5 class="card-title"> &nbsp;&nbsp;&nbsp;&nbsp; 8.2. การตรวจทางกล้องจุลทรรศน์</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis_j" value="1" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis_j" value="2" type="radio" class="form-check-input">ผิดปกติ พบเม็ดเลือดขาว และ/หรือเม็ดเลือดแดงในปัสสาวะเล็กน้อย ควรดื่มน้ำมากๆ ไม่กลั้นปัสสาวะ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="urinalysis_j" value="3" type="radio" class="form-check-input">ผิดปกติ ถ้าเม็ดเลือดแดงมากควรรับการตรวจปัสสาวะ ถ้าเม็ดเลือดขาวมากคือมีอาการอักเสบต้องรับยารักษา และตรวจป้สสาวะซ้ำ ภายใน 2 สัปดาห์
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <br>

                                    <h5 class="card-title"> 9. การตรวจอุจจาระ</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="defecate" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="defecate" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                       ผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="defecate" value="3" type="radio" class="form-check-input">พบมีเลือดปนออกมาในอุจจาระ สมควรได้รับการตรวจเพิ่มเติม
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="defecate" value="4" type="radio" class="form-check-input"> พบพยาธิหรือไข้พยาธิในอุจจาระ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <!-- การตรวจทางกล้องจุลทรรศน์ -->

                                    <h5 class="card-title"> 10. ผลการตรวจอื่นๆ</h5>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <!-- <input name="pap" type="radio" class="form-check-input">-->
                                        10.1 การตรวจเซลล์ปากมดลูก (pap smear)/HPV DNA <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="pap" value="1" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="pap" value="2" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <!-- <input name="pap" type="radio" class="form-check-input"> -->
                                        ผิดปกติ ระบุ : <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <label class="form-label form-check-label"></label>
                                        <input type="text" name="pap_comment" class="form-control" id="staticEmail2" placeholder="ข้อมูลผิดปกติ">
                                    </div><br> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <!-- การตรวจเซลล์ปากมดลูก -->

                                    <div class="position-relative form-check form-check-inline">
                                        <!-- <input name="radio1" type="radio" class="form-check-input"> -->
                                        10.2 เอกซ์เรย์ทรวงอก (Chest X-ray)
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="chest_xray" value="N" type="radio" class="form-check-input">ไม่ได้ตรวจ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="chest_xray" value="1" type="radio" class="form-check-input">ปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <!-- <input name="radio1" type="radio" class="form-check-input"> -->
                                        ผิดปกติ ระบุ :
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <label class="form-label form-check-label"></label>
                                        <input type="text" name="chest_xray_com" class="form-control" id="staticEmail2" placeholder="ข้อมูลผิดปกติ">
                                    </div>
                                    <br> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <!-- เอกซ์เรย์ทรวงอก -->
                                    <div class="position-relative form-check form-check-inline">
                                        <!-- <input name="radio1" type="radio" class="form-check-input"> -->
                                        10.3 ผลตรวจอื่นๆ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative ">
                                        <label class="form-label form-check-label"></label>
                                        <textarea class="form-control" name="check_all_comment" placeholder="ตรวจอื่นๆ" id="message" rows="3" style="height: 102px;"> </textarea>
                                    </div>
                                    <!-- ตรวจอื่นๆ -->
                                    <div class="divider"></div>

                                    <center><b>
                                            <div class="position-relative form-check form-check-inline">
                                                สรุป ผลการตรวจสุขภาพ
                                            </div>
                                        </b> </center>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="nomal_check" value="Y" type="checkbox" class="form-check-input"><b>สุขภาพทั่วไปอยู์ในเกณฑ์ปกติ</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="doctor_check" value="Y" type="checkbox" class="form-check-input"><b>อาจมีปัญหาสุขภาพ โดยตรวจพบ</b>
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_1" value="Y" type="checkbox" class="form-check-input">ความดันโลหิตสูง
                                        <label class="form-label form-check-label"></label>
                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_2" value="Y" type="checkbox" class="form-check-input">มีภาวะซีดผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_3" value="Y" type="checkbox" class="form-check-input">หน้าที่ของไตผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_4" value="Y" type="checkbox" class="form-check-input">เอกซ์เรย์ปอดผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_5" value="Y" type="checkbox" class="form-check-input">ไขมันในเลือดสูง
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_6" value="Y" type="checkbox" class="form-check-input">เอ็นไซม์ตับผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_7" value="Y" type="checkbox" class="form-check-input">มีเลือดออกในทางเดินอาหาร
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_8" value="Y" type="checkbox" class="form-check-input">เซลล์เยื่อบุปากมดลูกผิดปกติ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_9" value="Y" type="checkbox" class="form-check-input">กรดยูริกสูง
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_10" value="Y" type="checkbox" class="form-check-input">พาหะไวรัสตับอักเสบ บี
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_11" value="Y" type="checkbox" class="form-check-input">มีความผิดปกติของทางเดินปัสสาวะ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_12" value="Y" type="checkbox" class="form-check-input">เม็ดเลือดขาว อีโอสิโนฟิลสูง
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="d_13" value="Y" type="checkbox" class="form-check-input">น้ำตาลในเลือดสูง
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative ">เรื่องอื่นๆ
                                        <label class="form-label form-check-label"></label>
                                        <textarea class="form-control" name="doctor_comment" placeholder="ตรวจอื่นๆ" id="message" rows="2" style="height: 102px;"> </textarea>
                                    </div>
                                    <div class="divider"></div>
                                    <center>
                                        <b>
                                            <div class="position-relative form-check form-check-inline">
                                                ข้อควรปฏิบัติ
                                            </div>
                                        </b>
                                    </center>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="procedure" value="Y" type="checkbox" class="form-check-input">พบแพทย์เพื่อหาสาเหตุ และรักษาต่อไป เรื่อง
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <div class="position-relative form-check form-check-inline">
                                        <label class="form-label form-check-label"></label>
                                        <input type="text" name="procedure_doc" class="form-control" id="staticEmail2" placeholder="เรื่องพบแพทย์">
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="procedure_1" value="Y" type="checkbox" class="form-check-input">ควรออกกำลังกายให้สม่ำเสมอ รับประทานอาหารที่เป็นประโยชน์และพักผ่อนให้เพียงพอ
                                        <label class="form-label form-check-label"></label>
                                    </div>
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative form-check form-check-inline">
                                        <input name="procedure_2" value="Y" type="checkbox" class="form-check-input"> ควรปฏิบัติตามคำแนะนำในเบื้องต้น และควรตรวจสุขภาพเมื่อครบ 1 ปี
                                        <label class="form-label form-check-label"></label>
                                    </div><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="position-relative ">อื่นๆ
                                        <label class="form-label form-check-label"></label>
                                        <textarea class="form-control" name="procedure_comment" placeholder="ตรวจอื่นๆ" id="message" rows="2" style="height: 102px;"> </textarea>
                                    </div>
                                    <input type="hidden" name="vn" value="<?php echo $row_em['vn'] ?>">
                                    <div class="divider"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-info mb-3"> <i class="fa fa-pen"></i> บันทึกข้อมูล</button>
                                            <a href="report/check_up_print.php?vn=<?php echo $row_em['vn'] ?>"> <button type="button" class="btn btn-success mb-3"> <i class="fa fa-print"></i> พิมพ์</button></a>
                                        </div>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div id="popover-content-0" class="d-none">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-success">
                    <div class="menu-header-image opacity-5" style="background-image: url('images/dropdown-header/abstract2.jpg');"></div>
                    <div class="menu-header-content">
                        <h5 class="menu-header-title">ผลแลป</h5>
                        <!-- <h6 class="menu-header-subtitle">Manage all of your options</h6> -->
                    </div>
                </div>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item-header nav-item">Activity</li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        Chat
                        <div class="ms-auto badge rounded-pill bg-info">8</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">Recover Password</a>
                </li>
                <li class="nav-item-divider nav-item"></li>
                <li class="nav-item-btn nav-item">
                    <button class="btn-wide btn-shadow btn btn-danger btn-sm">Cancel</button>
                </li>
            </ul>

        </div>

        <!-- ความดันโลหิตสูง
มีภาวะซีดผิดปกติ
หนาที่ของไตผิดปกติ
เอกซเรยปอดผิดปกติ
ไขมันในเลือดสูง
เอ็นไซมตับผิดปกติ
มีเลือดออกในทางเดินอาหาร
เซลลเยื่อบุปากมดลูกผิดปกติ
กรดยูริกสูง
พาหะไวรัสตับอักเสบ บี
มีความผิดปกติของทางเดินปสสาวะ
เม็ดเลือดขาว อีโอสิโนฟลสูง
น้ำตาลในเลือดสูง -->
    </div>
    <?php include "6plugin.php"; ?>
    <script>
        $(function() {
            $("#skill_input").autocomplete({
                source: "fetch_cid.php",
            });
        });
    </script>
</body>


</html>


<!-- <div class="row g-3">
    <div class="col-auto">
        <label for="staticEmail2" class="visually-hidden">Email</label>
        <input type="text" class="form-control" id="staticEmail2" value="email@example.com">
    </div>
    <div class="col-auto">
        <label for="inputPassword2" class="visually-hidden">Password</label>
        <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </div>
</div>
<div class="divider"></div> -->

<!-- <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Inline</h5>
                                        <div>
                                            <form class="mt -3">
                                                <div class="position-relative form-check form-check-inline">
                                                     <input type="checkbox" class="form-check-input"> Some input
                                                    <label class="form-label form-check-label"></label>
                                                </div>
                                                <div class="position-relative form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"> Some other input
                                                    <label class="form-label form-check-label"></label>
                                                </div>
                                            </form>
                                            <div class="divider"></div>
                                            <form class="row g-3">
                                                <div class="col-auto">
                                                    <label for="staticEmail2" class="visually-hidden">Email</label>
                                                    <input type="text" class="form-control" id="staticEmail2" value="email@example.com">
                                                </div>
                                                <div class="col-auto">
                                                    <label for="inputPassword2" class="visually-hidden">Password</label>
                                                    <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> -->

<!-- <center><?php

                //   if ($rowl['range_check'] == 'Y') {
                //       if ($rowl['sex'] == '1') {
                //           if ($rowl['lab_order_result'] >= $rowl['range_check_min'] && $rowl['lab_order_result'] <= $rowl['range_check_max']) {
                //               echo  'ปกติ';
                //           } elseif ($rowl['lab_order_result'] < $rowl['range_check_min']) {
                //               echo  'ต่ำกว่ามาตรฐาน';
                //           } elseif ($rowl['lab_order_result'] > $rowl['range_check_max']) {
                //               echo  'มากว่าค่ามาตรฐาน';
                //           }
                //         }elseif($rowl['sex'] == '2'){
                //           if ($rowl['lab_order_result'] >= $rowl['range_check_min_female'] && $rowl['lab_order_result'] <= $rowl['range_check_max_female']) {
                //               echo  'ปกติ';
                //           } elseif ($rowl['lab_order_result'] < $rowl['range_check_min_female']) {
                //               echo  'ต่ำกว่ามาตรฐาน';
                //           } elseif ($rowl['lab_order_result'] > $rowl['range_check_max_female']) {
                //               echo  'มากว่าค่ามาตรฐาน';
                //           }
                //         }
                //   } 
                ?>
                                                      </center> -->