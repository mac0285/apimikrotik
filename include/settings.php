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

// hide all error
error_reporting(0);

if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

if($id == "settings" && $router == "new"){
  $data = '$data';
$f = fopen('./include/config.php','a');
  fwrite($f,"\n'$'data['new'] = array ('1'=>'new!','new@|@','new#|#','new%','new^','new&Rp','new*10','new(1','new)','new=');");
  fclose($f);
$search = "'$'data";
$replace = (string)"$data";
$file = file("./include/config.php");
$content = file_get_contents("./include/config.php");
$newcontent = str_replace((string)$search, (string)$replace, "$content");
file_put_contents("./include/config.php", "$newcontent");
echo "<script>window.location='./admin.php?id=settings&session=".$router."'</script>";
}
if(substr(formatBytes2($maxtx,2),-2) == "MB" || substr(formatBytes2($maxrx,2),-2) == "MB"){
    $vmaxtx = $maxtx/1000000;
    $vmaxrx = $maxrx/1000000;
  }elseif(substr(formatBytes2($maxtx,2),-2) == "GB" || substr(formatBytes2($maxrx,2),-2) == "GB"){
   $vmaxtx = $maxtx/1000000000;
   $vmaxrx = $maxrx/1000000000;
  }elseif($maxtx == "" || $maxrx== ""){
    $vmaxtx = "";
    $vmaxrx = "";
  }


if(isset($_POST['save'])){

	$siphost = ($_POST['ipmik']);
	$suserhost = ($_POST['usermik']);
	$spasswdhost = encrypt($_POST['passmik']);
    $shotspotname = ($_POST['hotspotname']);
    $sdnsname = ($_POST['dnsname']);
    $scurency = ($_POST['curency']);
    $sreload = ($_POST['areload']);
    $siface = ($_POST['iface']);
    $smaxtx = ($_POST['maxtx']);
    $smaxrx = ($_POST['maxrx']);
    $mbgbtx = ($_POST['mbgbtx']);
    $mbgbrx = ($_POST['mbgbrx']);
    $sesname = ($_POST['sessname']);
    if($smaxtx == ""){$smaxtx = "0";}else{$smaxtx = $smaxtx*$mbgbtx;}
    if($smaxrx == ""){$smaxrx = "0";}else{$smaxrx = $smaxrx*$mbgbrx;}

		$search = array ('1' =>"$session!$iphost","$session@|@$userhost","$session#|#$passwdhost","$session%$hotspotname","$session^$dnsname","$session&$curency","$session*$areload","$session($iface","$session)$maxtx","$session=$maxrx","'$session'");
    $replace = array ('1' =>"$sesname!$siphost","$sesname@|@$suserhost","$sesname#|#$spasswdhost","$sesname%$shotspotname","$sesname^$sdnsname","$sesname&$scurency","$sesname*$sreload","$sesname($siface","$sesname)$smaxtx","$sesname=$smaxrx","'$sesname'");
   
    for ($i=1; $i<12; $i++){ 
    $file = file("./include/config.php");
    $content = file_get_contents("./include/config.php");
    $newcontent = str_replace((string)$search[$i], (string)$replace[$i], "$content");
    file_put_contents("./include/config.php", "$newcontent");
    } 
    $_SESSION["connect"] = "";
		echo "<script>window.location='./admin.php?id=settings&session=".$sesname."'</script>";
		}

}
?>
<script>
  function PassMk(){
    var x = document.getElementById('passmk');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
    function PassAdm(){
    var x = document.getElementById('passadm');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
  }}
</script>

<form autocomplete="off" method="post" action="">  
<div class="row">
	<div class="col-12">
  		<div class="card" >
  			<div class="card-header">
  				<h3 class="card-title"><i class="fa fa-gear"></i> Session Settings &nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer " title="Reload data"></i></h3>
  			</div>
        <div class="card-body overflow">
    	   <div class="row">
			     <div class="col-6">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Session</h3>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tr>
                      <td>Session Name</td>
                      <td><input class="form-control" id="sessname" type="text" name="sessname" title="Session Name" value="<?php if($session == "new"){echo "";}else{ echo $session;} ?>" required="1"/></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-12">
				      <div class="card">
        	     <div class="card-header">
            	   <h3 class="card-title">MikroTik <?php echo $_SESSION["connect"];?></h3>
        	     </div>
        	     <div class="card-body">
				<table class="table table-sm">
					<tr>
	  					<td class="align-middle">IP MikroTik  </td><td><input class="form-control" type="text" size="15" name="ipmik" title="IP MikroTik / IP Cloud MikroTik" value="<?php echo $iphost; ?>" required="1"/></td>
					</tr>
					<tr>
						<td class="align-middle">Username  </td><td><input class="form-control" id="usermk" type="text" size="10" name="usermik" title="User MikroTik" value="<?php echo $userhost; ?>" required="1"/></td>
					</tr>
					<tr>
						<td class="align-middle">Password  </td><td>
							<div class="input-group">
								<div class="input-group-11 col-box-10">
        						<input class="group-item group-item-l" id="passmk" type="password" name="passmik" title="Password MikroTik" value="<?php echo decrypt($passwdhost) ;?>" required="1"/>
        						</div>
            					<div class="input-group-1 col-box-2">
            						<div class="group-item group-item-r pd-2p5 text-center align-middle">
                						<input title="Show/Hide Password" type="checkbox" onclick="PassMk()">
            						</div>
            					</div>
    						</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
								<div class="input-group-4">
									<input class="group-item group-item-md" type="submit" style="cursor: pointer;" name="save" value="Save"/>
								</div>
								<div class="input-group-3">	
									<a class="group-item group-item-md pd-2p5 text-center align-middle" href="./admin.php?id=connect&session=<?php echo $session;?>" title="Test connection to MikroTik ">Connect</a>
								</div>
								<div class="input-group-4">	
										<a class="group-item group-item-md pd-2p5 text-center"  href="./app.php?hotspot=dashboard&session=<?php echo $session;?>" title="Dashboard">Dashboard</a>
              	</div>
              	<div class="input-group-1">	
									<div style="cursor: pointer;" class="group-item group-item-r pd-2p5 text-center" onclick="location.reload();" title="Reload Data"><i class="fa fa-refresh"></i></div>
								</div>
            		</div>	
    					</td>
    				</tr>
				</table>
			</div>
    </div>  		
	</div>
</div>
<div class="col-6">
	<div class="card">
        <div class="card-header">
            <h3 class="card-title">Mikhmon Data</h3>
        </div>
    <div class="card-body">    
	<table class="table table-sm">
	<tr>
	<td class="align-middle">Hotspot Name  </td><td><input class="form-control" type="text" size="15" maxlength="50" name="hotspotname" title="Hotspot Name" value="<?php echo $hotspotname; ?>" required="1"/></td>
	</tr>
	<tr>
	<td class="align-middle">DNS Name  </td><td><input class="form-control" type="text" size="15" maxlength="500" name="dnsname" title="DNS Name [IP->Hotspot->Server Profiles->DNS Name]" value="<?php echo $dnsname; ?>" required="1"/></td>
	</tr>
	<tr>
	<td class="align-middle">Curency  </td><td><input class="form-control" type="text" size="3" maxlength="4" name="curency" title="Curency" value="<?php echo $curency; ?>" required="1"/></td>
	</tr>
	<tr>
	<td class="align-middle">Auto Reload</td><td>
	<div class="input-group">
		<div class="input-group-10">
        	<input class="group-item group-item-l" type="number" min="5" max="3600" name="areload" title="Auto Reload in sec [min 10s]" value="<?php echo $areload; ?>" required="1"/>
    	</div>
            <div class="input-group-2">
                <span class="group-item group-item-r pd-2p5 text-center align-middle">sec</span>
            </div>
        </div>
	</td>
	</tr>
	<tr>
	<td class="align-middle">Traffic Ether  </td><td><input class="form-control" type="number" min="1" max="99" name="iface" title="Traffic Interface" value="<?php echo $iface; ?>" required="1"/></td>
	</tr>
	<tr>
    <td class="align-middle">Max Tx</td><td>
      <div class="input-group">
      	<div class="input-group-9 col-box-8">
        	<input class="group-item group-item-l" type="number" min="0" max="9999" name="maxtx" value="<?php echo $vmaxtx;?>">
        </div>
          <div class="input-group-3 col-box-4">
              <select style="padding: 4.2px;" class="group-item group-item-r" name="mbgbtx" required="1">
				        <option value=1000000>MB</option>
				        <option value=1000000000>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td class="align-middle">Max Rx</td><td>
      <div class="input-group">
      	<div class="input-group-9 col-box-8">
        	<input class="group-item group-item-l" type="number" min="0" max="9999" name="maxrx" value="<?php echo $vmaxrx;?>">
        </div>
          <div class="input-group-3 col-box-4">
              <select style="padding: 4.2px;" class="group-item group-item-r" name="mbgbrx" required="1">
				        <option value=1000000>MB</option>
				        <option value=1000000000>GB</option>
			        </select>
          </div>
      </div>
    </td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</div>
</form>







