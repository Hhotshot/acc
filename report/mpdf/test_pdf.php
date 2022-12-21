<?php

require_once __DIR__ . '/mpdf/vendor/autoload.php';

include("../connect/connect.php");


$html .=

 "  


<!DOCTYPE html>
<html>
<head>
    <title>Applicant Information Sheet</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
<div class=' header-logos text-center'>
    <img src='headerimage/logo1.png' width='270' height='90' class=''>
    <img src='headerimage/logo2.png' width='170' height='130' class='' >
    <img src='headerimage/logo3.png' width='180' height='90' class=''>
</div>
<div class='container top-head'>
    <p class='form-hrm'>FORM-HRM-R-003</p>
    <hr>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
    <div class='profile-pic'></div>
    <p class='blackened-head'>APPLICANTS INFORMATION SHEET</p>
        <form class='head-form'>
            <span class='detail1'>Date</span><span class='user-texts'>:</span><span class='user-texts bold'> Nicky Jacobo</span><br>
            <span class='detail2'>Position</span><span class='user-texts'>:</span> <span class='choice1 '>1st choice</span><span class='user-texts'>:</span> <span class='user-texts bold'>Information Technology</span><span class='choice2'> 2nd choice</span><span class='user-texts'>: </span><span class='user-texts bold'>Hotel Management</span><br>
            <span class='detail3'>Salary Expectation</span><span class='user-texts'>:</span><span class='user-texts bold'>100,000</span><br>
            <span class='detail4'>Availability to Start</span><span class='user-texts'>: </span><span class='user-texts bold'>Anytime</span><br>

        </form>
    <p class='blackened peros'>PERSONAL INFORMATION</p>

    </div>  

</div><!-- End of top-head -->

<!--==========================================
PERSONAL INFORMATION
============================================= -->
<div class='container personal-information'>
    <table>
      <tr class='zero-row'>
        <th colspan='6' >NAME: <span class='outs'>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class='lastname ' style='font-weight: 900;'>JACOBO</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <span class='firstname' style='font-weight: 900;'>NICKY</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class='midname' style='font-weight: 800;'>CABALU</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


            <span class='lastnamedet'>(last name)</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class='firstnamedet'>(first name)</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span  class='midnamedet'>(middle name)</span>
        </th>
      </tr>
      <tr class='first-row'>
        <td>NICKNAME<br><span class='user-texts bold'>Nicks</span></td>
        <td>BIRTHDATE (mm/dd/yyyy)<br><span class='user-texts bold'>10/25/1994</span></td>
        <td>BIRTHPLACE<br><span class='user-texts bold'>Tokyo Japan</span></td>
        <td>AGE<br><span class='user-texts bold'>18</span></td>
        <td>HEIGHT<br><span class='user-texts bold'>5'7'</span></td>
        <td>WEIGHT<br><span class='user-texts bold'>60kg</span></td>
      </tr>
      <tr class='second-row'>
        <td  colspan='6'>CITY ADDRESS: <span class='bold'>Plaridel Bulacan</span> </td>
      </tr>
       <tr class='third-row'>
        <td  colspan='6'>PROVINCIAL ADDRESS: <span  class='bold'>Plaridel Bulacan</span> </td>
      </tr>
      <tr class='fourth-row'>
        <td rowspan='2' ><span class='residentstatus'>RESIDENTIAL STATUS:</span>
        <form>
            <input type='checkbox' name='gender' value='own' checked='checked'> &nbsp;Own House<br>
            <input type='checkbox' name='gender' value='rent'> &nbsp;Rent<br>
            <input type='checkbox' name='gender' value='other' > &nbsp;Others (specify): <span class='bold'>Own Mansion</span>
        </form> 
      </td>
        <td rowspan='2'><span class='gender'>GENDER:</span>
        <form>
        <input type='checkbox' name='gender' value='male' checked='checked'> &nbsp;Male<br>
        <input type='checkbox' name='gender' value='female' > &nbsp;Female<br>
        </form>
        </td>
        <td colspan='2'>
        MOBILE TEL. #: <span  class='bold outs'>0926-107-4423</span><br><br>
        RESIDENCE  TEL. #:  <span  class='bold outs'>02-25429</span>

      </td>
        <td colspan='2' >EMAIL ADDRESS:<br><span  class='bold outs'>yinkciworks@gmail.com</span></td>
      </tr>
      <tr class='fifth-row'>
        <td colspan='4'>CIVIL STATUS:<br>
            <input type='checkbox' name='civil-stat' value='single' checked='checked'> &nbsp;Single&nbsp;&nbsp;
            <input type='checkbox' name='civil-stat' value='married' > &nbsp;Married&nbsp;
            <input type='checkbox' name='civil-stat' value='single-parent' > &nbsp;Single Parent&nbsp;
            <input type='checkbox' name='civil-stat' value='widow' > &nbsp;Widow&nbsp;
            <input type='checkbox' name='civil-stat' value='other-status'> &nbsp;Others: 
            <span  class='bold'>Complicated</span>
        </td>
      </tr>
        <tr class='sixth-row'>
            <td colspan='2' rowspan='2'>Nationality<br><br>
            <input type='checkbox' name='filipino' value='filipino' checked='checked'> &nbsp;Filipino<br>
            <input type='checkbox' name='othersnationalit' value='female' > &nbsp;Others (specify): 
            <span  class='bold outs'>Alien Gender</span>
            </td>
            <td colspan='4'>SSS:
                <span  class='bold'>29-7098-7685-456</span>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                TIN:
                <span  class='bold'>29-7098-7685-456</span>
            </td>
        </tr>
        <tr class='seventh-row'>
        <td colspan='4'>CURRENT ACTIVITIES:
            <span  class='bold'>Nandemonai</span>
        </td>
        </tr>
    </table>
<!--==========================================
EMPLOYMENT HISTORY
============================================= -->
    <p class='blackened'>EMPLOYMENT HISTORY</p>
    <table class='table-two'>
        <tr>
        <th>COMPANY NAME</th>
        <th>LAST POSITION</th>
        <th>IMMEDIATE SUPERIOR</th>
        <th>CONTACT NUMBER</th>
        <th>INCLUSIVE DATES</th>
        <th>REASON FOR LEAVING</th>
        <th>SALARY</th>
        </tr>

        <tr class='table2-first-row'>
        <td><span  class='bold'>iConcept Global</span></td>
        <td><span  class='bold'>Web Developer</span></td>
        <td><span  class='bold'>Supervisor</span></td>
        <td><span  class='bold'>0926-107-4423</span></td>
        <td><span  class='bold'>Oct 25 1994</span></td>
        <td><span  class='bold'>Mayaman na</span></td>
        <td><span  class='bold'>100,000</span></td>
        </tr>

        <tr class='table2-first-row'>
        <td><span  class='bold'>iConcept Global</span></td>
        <td><span  class='bold'>Web Developer</span></td>
        <td><span  class='bold'>Supervisor</span></td>
        <td><span  class='bold'>0926-107-4423</span></td>
        <td><span  class='bold'>Oct 25 1994</span></td>
        <td><span  class='bold'>Mayaman na</span></td>
        <td><span  class='bold'>100,000</span></td>
        </tr>
        <tr class='table2-first-row'>
        <td><span  class='bold'>iConcept Global</span></td>
        <td><span  class='bold'>Web Developer</span></td>
        <td><span  class='bold'>Supervisor</span></td>
        <td><span  class='bold'>0926-107-4423</span></td>
        <td><span  class='bold'>Oct 25 1994</span></td>
        <td><span  class='bold'>Mayaman na</span></td>
        <td><span  class='bold'>100,000</span></td>
        </tr>

        <tr class='table2-first-row'>
        <td><span  class='bold'>iConcept Global</span></td>
        <td><span  class='bold'>Web Developer</span></td>
        <td><span  class='bold'>Supervisor</span></td>
        <td><span  class='bold'>0926-107-4423</span></td>
        <td><span  class='bold'>Oct 25 1994</span></td>
        <td><span  class='bold'>Mayaman na</span></td>
        <td><span  class='bold'>100,000</span></td>
        </tr>   
    </table>
<!--==========================================
FAMILY BACKGROUND
============================================= -->
<p class='blackened'>FAMILY BACKGROUND</p>
<table class='table-three'>
        <tr>
            <th></th>
            <th>NAME</th>
            <th>AGE</th>
            <th>OCCUPATION</th>
            <th>COMPANY/SCHOOL</th>
        </tr>
        <tr>
            <td>Father</td>
            <td><span   class='bold'>Nicky Jacobo</span></td>
            <td><span   class='bold'>18</span></td>
            <td><span   class='bold'>Web Developer</span></td>
            <td><span   class='bold'>Secret</span></td>
        </tr>   
        <tr>
            <td>Mother</td>
            <td><span   class='bold'>Nicky Jacobo</span></td>
            <td><span   class='bold'>18</span></td>
            <td><span   class='bold'>Web Developer</span></td>
            <td><span   class='bold'>Secret</span></td>
        </tr>
        <tr>
            <td rowspan='4'>Brothers &amp; Siters</td>
            <td><span class='bold'>Nicky Jacobo</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>
        </tr>
        <tr>
            <td><span class='bold'>Nicky Jacobo</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>   
        </tr>
        <tr>
            <td><span class='bold'>Nicky Jacobo</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>   
        </tr>
        <tr>
            <td><span class='bold'>Nicky Jacobo</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>           
        </tr>
        <tr>
            <td>Spouse</td>
            <td><span class='bold'>Not available</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>   
        </tr>
        <tr>
            <td>Children</td>
            <td><span class='bold'>Not available</span></td>
            <td><span class='bold'>18</span></td>
            <td><span class='bold'>Web Developer</span></td>
            <td><span class='bold'>Secret</span></td>   
        </tr>
</table>
<!--==========================================
REFERENCES
============================================= -->
<p class='blackened'>REFERENCES</p>
<table class='table-four'>
        <tr>
            <th>NAME</th>
            <th>POSITION</th>
            <th>COMPANY</th>
            <th>ADDRESS</th>
            <th>CONTACT NO.</th>
        </tr>
        <tr>
            <td><span class='bold centerme'>Shana Hirai</span></td>
            <td><span class='bold centerme'>Flame Haze</span></td>
            <td><span class='bold centerme'>Shakugan no Shana</span></td>
            <td><span class='bold centerme'>Anime</span></td>
            <td><span class='bold centerme'>0926-107-4423</span></td>
        </tr>
        <tr>
            <td rowspan='9' colspan='3' class='etu'>How did you know of the opening?<br>
            <input type='checkbox' name='opening' value='news' checked> &nbsp;Newspaper Ad  &nbsp; &nbsp; <br>
            <input type='checkbox' name='opening' value='school'> &nbsp;School Placement  &nbsp; &nbsp;<br>
            <input type='checkbox' name='opening' value='walkin'> &nbsp;Walk-in<br>
            <input type='checkbox' name='opening' value='referal' checked> &nbsp;Referral of: <span class='bold outs'>Friend</span> <br>

            <input type='checkbox' name='opening' value='other-ads' checked> &nbsp;Others (specify): <span class='bold outs'>Facebook Ads</span><br><br>

            </td>
            <td  rowspan='9' colspan='2'>
                <span class='emergency italic'>In case of emergency please contact:</span><br>
                Name: <span class='bold'> Sakai Yuji</span><br>
                Contact No.: <span class='bold'>0926-107-4423</span><br>
                Relation to you: <span class='bold'>Tomodachi</span><br><br>
            </td>
        </tr>


</table>
<p class='ihereby'>I hereby certify that the above information is true and correct and I hereby authorize Cabalen to verify the said information.</p>
<table class='last-part'>
    <tr>
        <th><span class=''>&emsp;&emsp;&emsp;signed already</span><br><br>
        <span class='sign-details'>&emsp;Applicant&#39;s Signature</span></th>
        <th><span class=''>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Oct 23 2017</span><br><br>
        <span class='date-details'>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Date</span></th>
    </tr>
</table>
</div>
</body>
</html>


";


$mpdf=new mPDF('utf-8', 'Letter', 0, '', 2, 2, 12, 2, 2, 2);
$mpdf->WriteHTML($html);
$mpdf->SetDisplayMode('fullpage');
 $mpdf->shrink_tables_to_fit = 1;
$mpdf->Output();

?>