<?php
/*
 *  Copyright (C) 2018  
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
session_start();
// hide all error
error_reporting(0);

ini_set('max_execution_time', 300);

if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{
  
  $srvlist = $API->comm("/ip/hotspot/print");
  
  if(isset($_POST['qty'])){
    $qty = ($_POST['qty']);
    $server = ($_POST['server']);
    $user = ($_POST['user']);
    $userl = ($_POST['userl']);
    $prefix = ($_POST['prefix']);
    $char = ($_POST['char']);
    $profile = ($_POST['profile']);
    $timelimit = ($_POST['timelimit']);
		$datalimit = ($_POST['datalimit']);
		$adcomment = ($_POST['adcomment']);
		$mbgb = ($_POST['mbgb']);
    if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
		if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
		if($adcomment == ""){$adcomment = "";}else{$adcomment = $adcomment;}
    $getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$profile"));
    $ponlogin = $getprofile[0]['on-login'];
    $getvalid = explode(",",$ponlogin)[3];
		$getprice = explode(",",$ponlogin)[2];
		$getlock = explode(",",$ponlogin)[6];
    $_SESSION['ubp'] = $profile;
    $commt = $user . "-" . rand(100,999) . "-" . date("m.d.y") . "-" .$adcomment;
    
    $gen = '<?php $genu="'. $commt . "-" . $profile . "-" . $getvalid . "-" . $getprice . "-" . $timelimit ."-" . $datalimit . "-" . $getlock .'";?>';
    $temp = './voucher/temp.php';
		$handle = fopen($temp, 'w') or die('Cannot open file:  '.$temp);
		$data = $gen;
		fwrite($handle, $data);
    
		$a = array ("1"=>"","",1,2,2,3,3,4);

    if($user=="up"){
		for($i=1;$i<=$qty;$i++){
			if($char == "lower"){
			$u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$userl);
		  }elseif($char == "upper"){
		  $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
		  }elseif($char == "upplow"){
		  $u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
		  }elseif($char == "mix"){
		  $u[$i]= substr(str_shuffle("123456789123456789123456789abcdefghijklmnopqrstuvwxyz"), -$userl);
		  }elseif($char == "mix1"){
		  $u[$i]= substr(str_shuffle("123456789123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
		  }elseif($char == "mix2"){
		  $u[$i]= substr(str_shuffle("123456789123456789123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), -$userl);
		  }
		  if($userl == 3){
				$p[$i]= rand(100,999);
			}elseif($userl == 4){
				$p[$i]= rand(1000,9999);
			}elseif($userl == 5){
				$p[$i]= rand(10000,99999);
			}elseif($userl == 6){
				$p[$i]= rand(100000,999999);
			}elseif($userl == 7){
				$p[$i]= rand(1000000,9999999);
			}elseif($userl == 8){
				$p[$i]= rand(10000000,99999999);
			}
			
			$u[$i] = "$prefix$u[$i]";
		}
		
		for($i=1;$i<=$qty;$i++){
			$API->comm("/ip/hotspot/user/add", array(
			"server" => "$server",
			"name" => "$u[$i]",
			"password" => "$p[$i]",
			"profile" => "$profile",
			"limit-uptime" => "$timelimit",
			"limit-bytes-total" => "$datalimit",
			"comment" => "$commt",
			));
		}}
		
		if($user=="vc"){
		  $shuf = ($userl-$a[$userl]);
		for($i=1;$i<=$qty;$i++){
        if($char == "lower"){
          $u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$shuf);
        }elseif($char == "upper"){
          $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$shuf);
        }elseif($char == "upplow"){
          $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), -$shuf);
        }
        if($userl == 3){
			  	$p[$i]= rand(1,9);
			  }elseif($userl == 4 || $userl == 5){
			  	$p[$i]= rand(10,99);
			  }elseif($userl == 6 || $userl == 7){
			  	$p[$i]= rand(100,999);
			  }elseif($userl == 8){
			  	$p[$i]= rand(1000,9999);
			  }

	      $u[$i] = "$prefix$u[$i]$p[$i]";
	      
	      if($char == "num"){
	      if($userl == 3){
			  	$p[$i]= rand(100,999);
			  }elseif($userl == 4){
			  	$p[$i]= rand(1000,9999);
			  }elseif($userl == 5){
			  	$p[$i]= rand(10000,99999);
			  }elseif($userl == 6){
			  	$p[$i]= rand(100000,999999);
			  }elseif($userl == 7){
			  	$p[$i]= rand(1000000,9999999);
			  }elseif($userl == 8){
			  	$p[$i]= rand(10000000,99999999);
			  }

	      $u[$i] = "$prefix$p[$i]";
	      }
	      if($char == "mix"){
			  	$p[$i]= substr(str_shuffle("123456789123456789123456789abcdefghijklmnopqrstuvwxyz"), -$userl);
			  

	      $u[$i] = "$prefix$p[$i]";
	      }
	      if($char == "mix1"){
			  	$p[$i]= substr(str_shuffle("123456789123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
			  

	      $u[$i] = "$prefix$p[$i]";
	      }
	      if($char == "mix2"){
			  	$p[$i]= substr(str_shuffle("123456789123456789123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), -$userl);
			  

	      $u[$i] = "$prefix$p[$i]";
	      }
	      
		}
		for($i=1;$i<=$qty;$i++){
			$API->comm("/ip/hotspot/user/add", array(
			"server" => "$server",
			"name" => "$u[$i]",
			"password" => "$u[$i]",
			"profile" => "$profile",
			"limit-uptime" => "$timelimit",
			"limit-bytes-total" => "$datalimit",
			"comment" => "$commt",
			));	
		}}
		
		
	if($qty < 2){
		  echo "<script>window.location='./app.php?hotspot-user=".$u[1]."&session=".$session."'</script>";
		}else{
			echo "<script>window.location='./app.php?hotspot-user=generate&session=".$session."'</script>"; 
		} 		
}

  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  include_once('./voucher/temp.php');
  $genuser = explode("-",$genu);
  $umode = $genuser[0];
  $ucode = $genuser[1];
  $udate = $genuser[2];
  $uprofile = $genuser[4];
	$uvalid = $genuser[5];
	$ucommt = $genuser[3];
	if($uvalid == ""){$uvalid = "-";}else{$uvalid = $uvalid;}
	$uprice = $genuser[6];
	if($uprice == "0"){$uprice = "-";}else{$uprice = $uprice;}
	$utlimit = $genuser[7];
	if($utlimit == "0"){$utlimit = "-";}else{$utlimit = $utlimit;}
	$udlimit = $genuser[8];
	if($udlimit == "0"){$udlimit = "-";}else{$udlimit = formatBytes($udlimit,2);}
	$ulock = $genuser[9];
	$urlprint = "$umode-$ucode-$udate-$ucommt";
	if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
		$uprice = $curency." ".number_format($uprice,0,",",".");
	}else{
	$uprice = $curency." ".number_format($uprice);
}
}
?>
<div class="row">
	
<div class="col-8">
<div class="card box-bordered">
	<div class="card-header">
		<h3><i class="fa fa-user-plus"></i> Generate User </h3> <i id="loader" style="display: none;" ><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i>
	</div>
	<div class="card-body">
<form autocomplete="off" method="post" action="">
	<div>
		<?php if($_SESSION['ubp'] != ""){
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=".$_SESSION['ubp']."&session=".$session."'> <i class='fa fa-close'></i> Close</a>";
}else{
    echo "    <a class='btn bg-warning' href='./app.php?hotspot=users&profile=all&session=".$session."'> <i class='fa fa-close'></i> Close</a>";
}
?>
	<a class="btn bg-info" title="Open User List by Profile <?php if($_SESSION['ubp'] == ""){echo "all";}else{echo $uprofile;}?>" href="./app.php?hotspot=users&profile=<?php if($_SESSION['ubp'] == ""){echo "all";}else{echo $uprofile;}?>&session=<?php echo $session;?>"> <i class="fa fa-users"></i> User List</a>
    <button type="submit" name="save" onclick="loader()" class="btn bg-primary" title="Generate User"> <i class="fa fa-save"></i> Generate</button>
    <a class="btn bg-secondary" title="Print Default" href="./voucher/print.php?id=<?php echo $urlprint;?>&qr=no&session=<?php echo $session;?>" target="_blank"> <i class="fa fa-print"></i> Print</a>
    <a class="btn bg-danger" title="Print QR" href="./voucher/print.php?id=<?php echo $urlprint;?>&qr=yes&session=<?php echo $session;?>" target="_blank"> <i class="fa fa-qrcode"></i> QR</a>
    <a class="btn bg-info" title="Print Small" href="./voucher/print.php?id=<?php echo $urlprint;?>&small=yes&session=<?php echo $session;?>" target="_blank"> <i class="fa fa-print"></i> Small</a>
</div>
<table class="table">
  <tr>
    <td class="align-middle">Qty</td><td><div><input class="form-control " type="number" name="qty" min="1" max="500" value="1" required="1"></div></td>
  </tr>
  <tr>
    <td class="align-middle">Server</td>
    <td>
		<select class="form-control " name="server" required="1">
			<option>all</option>
				<?php $TotalReg = count($srvlist);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $srvlist[$i]['name'] . "</option>";
				  }
				?>
		</select>
	</td>
	</tr>
	<tr>
    <td class="align-middle">User Mode</td><td>
			<select class="form-control " onchange="defUserl();" id="user" name="user" required="1">
				<option value="up">Username & Pasword</option>
				<option value="vc">Username = Pasword</option>
			</select>
		</td>
	</tr>
  <tr>
    <td class="align-middle">User Length</td><td>
      <select class="form-control " id="userl" name="userl" required="1">
        <option>4</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Prefix</td><td><input class="form-control " type="text" size="4" maxlength="4" autocomplete="off" name="prefix" value=""></td>
  </tr>
  <tr>
    <td class="align-middle">Character</td><td>
      <select class="form-control " name="char" required="1">
				<option id="lower" style="display:block;" value="lower">abcd</option>
				<option id="upper" style="display:block;" value="upper">ABCD</option>
				<option id="upplow" style="display:block;" value="upplow">aBcD</option>
				<option id="lower1" style="display:none;" value="lower">abcd1234</option>
				<option id="upper1" style="display:none;" value="upper">ABCD1234</option>
				<option id="upplow1" style="display:none;" value="upplow">aBcD1234</option>
				<option id="mix" style="display:block;" value="mix">1ab2c34d</option>
				<option id="mix1" style="display:block;" value="mix1">1AB2C34D</option>
				<option id="mix2" style="display:block;" value="mix2">1aB2c34D</option>
				<option id="num" style="display:none;" value="num">1234</option>
			</select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Profile</td><td>
			<select class="form-control " onchange="GetVP();" id="uprof" name="profile" required="1">
				<?php $TotalReg = count($getprofile);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $getprofile[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
	<tr>
    <td class="align-middle">Time Limit</td><td><input class="form-control " type="text" size="4" autocomplete="off" name="timelimit" value=""></td>
  </tr>
	<tr>
    <td class="align-middle">Data Limit</td><td>
      <div class="input-group">
      	<div class="input-group-10 col-box-9">
        	<input class="group-item group-item-l" type="number" min="0" max="9999" name="datalimit" value="<?php echo $udatalimit;?>">
    	</div>
          <div class="input-group-2 col-box-3">
              <select style="padding:4.2px;" class="group-item group-item-r" name="mbgb" required="1">
				        <option value=1048576>MB</option>
				        <option value=1073741824>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
	<tr>
    <td class="align-middle">Comment</td><td><input class="form-control " type="text" title="No special characters" id="comment" autocomplete="off" name="adcomment" value=""></td>
  </tr>
   <tr >
    <td  colspan="4" class="align-middle"  id="GetValidPrice"></td>
  </tr>
</table>
</form>
</div>
</div>
</div>

<div class="col-4">
	<div class="card">
		<div class="card-header">
			<h3><i class="fa fa-ticket"></i> Generate Terakhir</h3>
		</div>
		<div class="card-body">
<table class="table table-bordered">
 <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
 	echo '
  <tr>
  	<td>Kode Generate</td><td>'.$ucode.'</td>
  </tr>
  <tr>
  	<td>Tanggal</td><td>'.$udate.'</td>
  </tr>
  <tr>
  	<td>Profile</td><td>'.$uprofile.'</td>
  </tr>
  <tr>
  	<td>Validity</td><td>'.$uvalid.'</td>
  <tr>
  	<td>Time Limit</td><td>'.$utlimit.'</td>
  </tr>
  <tr>
  	<td>Data Limit</td><td>'.$udlimit.'</td>
  </tr>
  <tr>
  	<td>Price</td><td>'.$uprice.'</td>
  </tr>
  <tr>
  	<td>Lock User</td><td>'.$ulock.'</td>
  </tr>';
      }else{
    echo '
  <tr>
  	<td>Generate Code</td><td>'.$ucode.'</td>
  </tr>
  <tr>
  	<td>Date</td><td>'.$udate.'</td>
  </tr>
  <tr>
  	<td>Profile</td><td>'.$uprofile.'</td>
  </tr>
  <tr>
  	<td>Validity</td><td>'.$uvalid.'</td>
  <tr>
  	<td>Time Limit</td><td>'.$utlimit.'</td>
  </tr>
  <tr>
  	<td>Data Limit</td><td>'.$udlimit.'</td>
  </tr>
  <tr>
  	<td>Price</td><td>'.$uprice.'</td>
  </tr>
  <tr>
  	<td>Lock User</td><td>'.$ulock.'</td>
  </tr>';  	
      }
      ?>
  <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
       <p style="padding:0px 5px;">
        Generate User dengan Time Limit.<br>
        Sebaiknya Time Limit < Validity.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Generate User with Time Limit.<br>
        Preferably  Time Limit < Validity.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</div>
</div>
</div>
<script>
	function loader(){
		document.getElementById('loader').style='display:block;';
	}
// get valid $ price
function GetVP(){
  var prof = document.getElementById('uprof').value;
  var url = "./process/getvalidprice.php?name=";
  var session = "&session=<?php echo $session;?>"
  var getvalidprice = url+prof+session
  $("#GetValidPrice").load(getvalidprice);
}
</script>
</div>