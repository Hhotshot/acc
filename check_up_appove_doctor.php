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

                                    <div class="btn-actions-pane-right actions-icon-btn">
                                        <div class="d-inline-block dropdown">
                                            <a href="check_up_appove_doctor_write.php?vn=<?php echo $row_em['vn'] ?>"><button type="button" class="btn-shadow dropdown-toggle btn btn-info">
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

                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $sql_chup = "SELECT * FROM hpt_check_up where  vn='$vn'";
                                    $r_chup = mysqli_query($con_hchkup, $sql_chup);
                                    $row = mysqli_fetch_array($r_chup);
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
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc">
                                        <?php

                                        $sql_l = "SELECT if(l.lab_order_result=l.lab_items_normal_value_ref,'ปกติ','')as resulf,l.*,lh.sex FROM  hpt_lab_check_up l 
                                        left outer join  hpt_check_up   lh  on  l.vn=lh.vn
                                        where  l.vn='$vn'  and  l.lab_order_result <>''  group by l.lab_items_name ";
                                        $re_l = mysqli_query($con_hchkup, $sql_l);
                                        ?>
                                        <thead align="center">
                                            <tr>
                                                <th colspan="6">ผลตรวจจากห้องปฎิบัติการ</th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    ลำดับที่
                                                </th>
                                                <th>
                                                    รายการที่ตรวจ
                                                </th>
                                                <th>
                                                    ค่าที่ตรวจได้
                                                </th>
                                                <th>
                                                    ค่าปกติ
                                                </th>
                                                <th>
                                                    หน่วย
                                                </th>
                                                <th>
                                                    การแปลผล
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i  =  1;
                                            while ($rowl = mysqli_fetch_assoc($re_l)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $i ?></center>
                                                    </td>
                                                    <td><?= $rowl['lab_items_name'] ?></td>
                                                    <td><?= $rowl['lab_order_result'] ?></td>
                                                    <td><?php
                                                        if ($rowl['range_check'] == 'Y' &&  $rowl['range_check'] <> ''  &&  $rowl['range_check'] <> 'N' &&  $rowl['lab_items_normal_value_ref']=='') {
                                                            if ($rowl == '1') {
                                                                echo  'เพศชาย ค่าปกติ :' . number_format($rowl['range_check_min'], 2) . ' - ' . number_format($rowl['range_check_max'], 2);
                                                            } elseif ($rowl['sex'] == '2') {
                                                                echo   'เพศหญิง ค่าปกติ :' . number_format($rowl['range_check_min_female'], 2) . ' - ' . number_format($rowl['range_check_max_female'], 2);
                                                            }
                                                        } else {
                                                            echo $rowl['lab_items_normal_value_ref'];
                                                        }
                                                        ?></td>
                                                    <td><?= $rowl['lab_items_unit'] ?></td>
                                                    <td>
                                                        <center><?php
                                                                if ($rowl['resulf'] == '') {
                                                                    if ($rowl['range_check'] == 'Y' &&  $rowl['range_check'] <> '' &&  $rowl['range_check'] <> 'N') {
                                                                        if ($rowl['sex'] == '1') {
                                                                            if ($rowl['lab_order_result'] >= $rowl['range_check_min'] && $rowl['lab_order_result'] <= $rowl['range_check_max']) {
                                                                                echo  "<font color='green'><b>ปกติ</b></font>";
                                                                            } elseif ($rowl['lab_order_result'] < $rowl['range_check_min']) {
                                                                                echo  "<font color='#FFCC66'><b>ต่ำกว่ามาตรฐาน</b></font>";
                                                                            } elseif ($rowl['lab_order_result'] > $rowl['range_check_max']) {
                                                                                echo  "<font color='red'><b>มากว่าค่ามาตรฐาน</b></font>";
                                                                            }
                                                                        } elseif ($rowl['sex'] == '2') {
                                                                            if ($rowl['lab_order_result'] >= $rowl['range_check_min_female'] && $rowl['lab_order_result'] <= $rowl['range_check_max_female']) {
                                                                                echo  "<font color='green'><b>ปกติ</b></font>";
                                                                            } elseif ($rowl['lab_order_result'] < $rowl['range_check_min_female']) {
                                                                                echo  "<font color='#FFCC66'><b>ต่ำกว่ามาตรฐาน</b></font>";
                                                                            } elseif ($rowl['lab_order_result'] > $rowl['range_check_max_female']) {
                                                                                echo   "<font color='red'><b>มากว่าค่ามาตรฐาน</b></font>";
                                                                            }
                                                                        }
                                                                    } elseif ($rowl['lab_items_normal_value_ref'] <> $rowl['lab_order_result']) {
                                                                        echo "<i>#NUM</i>";
                                                                    }
                                                                } else {
                                                                    echo "<font color='green'><b>ปกติ</b></font>";
                                                                }
                                                                ?>
                                                        </center>
                                                    </td>
                                                <?php $i++;
                                            } ?>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc">
                                        <?php

                                        $sql_x = "SELECT l.*,lh.sex FROM  hpt_xray_check_up l 
                                        left outer join  hpt_check_up   lh  on  l.vn=lh.vn
                                        where  l.vn='$vn' ";
                                        $re_x = mysqli_query($con_hchkup, $sql_x);
                                        ?>
                                        <thead align="center">
                                            <tr>
                                                <th colspan="3">ผลการตรวจเอ็กซเรย์ทรวงอก</th>
                                            </tr>
                                            <tr>
                                                <th>รายการที่ตรวจ</th>
                                                <th>ผลตรวจ</th>
                                                <th>วันเวลาที่ตรวจ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i  =  1;
                                            while ($rowx = mysqli_fetch_assoc($re_x)) { ?>
                                                <tr>
                                                    <td><?= $rowx['xray_items_name'] ?></td>
                                                    <td><?= $rowx['report_text'] ?></td>
                                                    <td><?= $rowx['order_date_time'] ?></td>
                                                <?php  } ?>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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