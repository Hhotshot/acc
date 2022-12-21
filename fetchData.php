<?php 
require_once('connect/connect.php');
 
function get_city($con_hos , $term){ 
 $query = "SELECT concat(pname,fname,'  ',p.lname)as fullname FROM patient WHERE cid LIKE '%".$term."%' ORDER BY hn ASC";
 $result = mysqli_query($con_hos, $query); 
 $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
 return $data; 
}
 
if (isset($_GET['term'])) {
 $getCity = get_city($con_hos, $_GET['term']);
 $cityList = array();
 foreach($getCity as $city){
 $cityList[] = $city['fullname'];
 }
 echo json_encode($cityList);
}
?>