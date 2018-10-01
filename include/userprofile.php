<?php
/*
 *  Copyright (C) 2018 
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// hide all error
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
    echo'
<html>
<head><title>403 Forbidden</title></head>
<body bgcolor="white">
<center><h1>403 Forbidden</h1></center>
<hr><center>nginx/1.14.0</center>
</body>
</html>
';
}else{


// get user profile
	$getprofile = $API->comm("/ip/hotspot/user/profile/print");
	$TotalReg = count($getprofile);
// count user profile
	$countprofile = $API->comm("/ip/hotspot/user/profile/print", array(
	  "count-only" => "",));
}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header align-middle">
    <h3><i class=" fa fa-pie-chart"></i> User Profile 
    
	</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<div class="overflow box-bordered" style="max-height: 75vh"> 			   
<table id="tFilter" class="table table-bordered table-hover text-nowrap">
  <thead>
  <tr> 
		<th style="min-width:50px;" class="text-center" >
		<?php
		if($countprofile < 2 ){echo "$countprofile item  ";
  		}elseif($countprofile > 1){echo "$countprofile items   ";}
	?></th>
		<th class="align-middle">Name</th>
		<th class="align-middle">Shared<br>Users</th>
		<th class="align-middle">Rate<br>Limit</th>
		<th class="align-middle">Expired Mode</th>
		<th class="align-middle">Validity</th>
		<th class="align-middle">Grace<br>Period</th>
		<th class="text-right align-middle" >Price <?php echo $curency;?></th>
		<th class="align-middle">Lock<br>User</th>
    </tr>
  </thead>
  <tbody>
<?php

for ($i=0; $i<$TotalReg; $i++){
echo "<tr>";
$profiledetalis = $getprofile[$i];
$pid = $profiledetalis['.id'];
$pname = $profiledetalis['name'];
$psharedu = $profiledetalis['shared-users'];
$pratelimit = $profiledetalis['rate-limit'];
$ponlogin = $profiledetalis['on-login'];

echo "<td style='text-align:center;'><a  href='./app.php?remove-user-profile=".$pid . "&session=".$session."' title='Remove User Profile " . $pname . "'><i class='fa fa-minus-square text-danger'></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a title='Open User by profile " .$pname. "'  href='./app.php?hotspot=users&profile=" .$pname . "&session=".$session."'><i class='fa fa-users'></i></a></td>";
echo "<td><a title='Open User Profile " . $pname . "' href='./app.php?user-profile=".$pid."&session=".$session."'><i class='fa fa-edit'></i> $pname</a></td>";
//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
echo "<td>" . $psharedu;echo "</td>";
echo "<td>" . $pratelimit;echo "</td>";

echo "<td>";
$getexpmode = explode(",",$ponlogin);
// get expired mode
$expmode = $getexpmode[1];
if($expmode == "rem"){
	echo "Remove";
}elseif($expmode == "ntf"){
	echo "Notice";
}elseif($expmode == "remc"){
	echo "Remove & Record";
}elseif($expmode == "ntfc"){
	echo "Notice & Record";
}else{
	
}
echo "</td>";
echo "<td>";
// get validity
$getvalid = explode(",",$ponlogin);
echo $getvalid[3];

echo "</td>";
echo "<td>";

$getgracep= explode(",",$ponlogin);
echo $getgracep[4];
echo "</td>";

echo "<td style='text-align:right;'>";
// get price
$getprice = explode(",",$ponlogin);
$price = trim($getprice[2]);
if($price == "" || $price == "0" ){
	  echo "";
}else{
	if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
		echo number_format($price,0,",",".");
	}else{ 
		echo number_format($price); 
	}
}

echo "</td>";
echo "<td>";

$getgracep= explode(",",$ponlogin);
echo $getgracep[6];
echo "</td>";
echo "</tr>";
}
?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
