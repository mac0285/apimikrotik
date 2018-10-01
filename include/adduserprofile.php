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
session_start();
// hide all error
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

  $getallqueue = $API->comm("/queue/simple/print", array(
      "?dynamic"=> "false",
    )); 

  if(isset($_POST['name'])){
    $name = ($_POST['name']);
    $sharedusers = ($_POST['sharedusers']);
    $ratelimit = ($_POST['ratelimit']);
    $expmode = ($_POST['expmode']);
    $validity = ($_POST['validity']);
    $graceperiod = ($_POST['graceperiod']);
    $getprice = ($_POST['price']);
    if($getprice == ""){$price = "0";}else{$price = $getprice;}
    $getlock = ($_POST['lockunlock']);
    if($getlock == Enable){$lock = ';[:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';}else{$lock = "";}
    $parent = ($_POST['parent']);
    
      $onlogin1 = ':put (",rem,'.$price.','.$validity.','.$graceperiod.',,'.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"]'; 
			$onlogin2 = ':put (",ntf,'.$price.','.$validity.',,,'.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time]';
			$onlogin3 = ':put (",remc,'.$price.','.$validity.','.$graceperiod.',,'.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user comment=$date-$time on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=mikhmon]';
			$onlogin4 = ':put (",ntfc,'.$price.','.$validity.',,,'.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=mikhmon]';
			
			if($expmode == "rem"){
      $onlogin = $onlogin1.$lock."}}";
			}elseif($expmode == "ntf"){
      $onlogin = $onlogin2.$lock."}}";
			}elseif($expmode == "remc"){
      $onlogin = $onlogin3.$lock."}}";
			}elseif($expmode == "ntfc"){
      $onlogin = $onlogin4.$lock."}}";
			}elseif($expmode == "0" && $price != "" ){
			$onlogin = ':put (",,'.$price.',,,noexp,'.$getlock.',")'.$lock;
			}else{
			$onlogin = "";
			}
    
		$API->comm("/ip/hotspot/user/profile/add", array(
			  		  /*"add-mac-cookie" => "yes",*/
					  "name" => "$name",
					  "rate-limit" => "$ratelimit",
					  "shared-users" => "$sharedusers",
					  "status-autorefresh" => "1m",
					  "transparent-proxy" => "yes",
					  "on-login" => "$onlogin",
            "parent-queue" => "$parent",
			));
			
		$getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
    "?name"=> "$name",
    ));
    $pid =	$getprofile[0]['.id'];
    echo "<script>window.location='./app.php?user-profile=".$pid."&session=".$session."'</script>";
  }
}
?>
<div class="row">
<div class="col-8">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-plus"></i> Add User Profile</h3>
  </div>
  <div class="card-body">
<form autocomplete="off" method="post" action="">
  <div>
    <a class="btn bg-warning" href="./app.php?hotspot=user-profiles&session=<?php echo $session;?>"> <i class="fa fa-close btn-mrg"></i> Close</a>
    <button type="submit" name="save" class="btn bg-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
  </div>
<table class="table">
  <tr>
    <td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Shared Users</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="sharedusers" value="1" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle">Rate limit [up/down]</td><td><input class="form-control" type="text" name="ratelimit" autocomplete="off" value="" placeholder="Example : 512k/1M" ></td>
  </tr>
  <tr>
    <td class="align-middle">Expired Mode</td><td>
      <select class="form-control" onchange="RequiredV();" id="expmode" name="expmode" required="1">
        <option value="">Select...</option>
        <option value="0">None</option>
        <option value="rem">Remove</option>
        <option value="ntf">Notice</option>
        <option value="remc">Remove & Record</option>
        <option value="ntfc">Notice & Record</option>
      </select>
    </td>
  </tr>
  <tr id="validity" style="display:none;">
    <td class="align-middle">Validity</td><td><input class="form-control" type="text" id="validi" size="4" autocomplete="off" name="validity" value="" required="1"></td>
  </tr>
  <tr id="graceperiod" style="display:none;">
    <td class="align-middle">Grace Period</td><td><input class="form-control" type="text" id="gracepi" size="4" autocomplete="off" name="graceperiod" placeholder="5m" value="5m" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle">Price <?php echo $curency;?></td><td><input class="form-control" type="number" size="10" min="0" name="price" value="" ></td>
  </tr>
  <tr>
    <td>Lock User</td><td>
      <select class="form-control" id="lockunlock" name="lockunlock" required="1">
        <option value="Disable">Disable</option>
        <option value="Enable">Enable</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Parent Queue</td>
    <td>
    <select class="form-control " name="parent">
      <option>none</option>
        <?php $TotalReg = count($getallqueue);
        for ($i=0; $i<$TotalReg; $i++){
        
          echo "<option>" . $getallqueue[$i]['name'] . "</option>";
          }
        ?>
    </select>
  </td>
  </tr>
</table>
</form>
</div>
</div>
</div>
<div class="col-4">
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-book"></i> ReadMe</h3>
    </div>
    <div class="card-body">
<table class="table">
    <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Expired Mode adalah kontrol untuk user hotspot.<br>
        Pilihan : Remove, Notice, Remove & Record, Notice & Record.
        <ul>
        <li>Remove : User akan dihapus ketika sudah grace period habis.</li>
        <li>Notice : User tidah dihapus dan akan mendapatkan notifikasi setelah user expired.</li>
        <li>Record : Menyimpan data harga tiap user yang login. Untuk menghitung total penjualan user hotspot dan ditampilkan dalam laporan penjualan.</li>
        </ul>
      </p>
      <p>Grace Period : Tenggang waktu sebelum user dihapus.</p>
      <p>Lock User : Username/Kode voucher hanya bisa digunakan pada 1 perangkat saja.</p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Period.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 5m = 5menit.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Expired Mode is the control for the hotspot user.<br>
        Options : Remove, Notice, Remove & Record, Notice & Record.
        <ul>
        <li>Remove: User will be deleted when the grace period expires.</li>
        <li>Notice: User will not deleted and get notification after user expiration.</li>
        <li>Record: Save the price of each user login. To calculate total sales of hotspot users and displayed in the sales report.</li>
        </ul>
      </p>
      <p>Grace Period : Grace period before user deleted.</p>
      <p>Lock User : Username can only be used on 1 device only.</p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Period.<br>
        [wdhm] Example : 30d = 30days, 12h = 12hours, 5m = 5minutes.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</div>
</div>
</div>
</div>