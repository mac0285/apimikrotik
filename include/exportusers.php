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
ini_set('max_execution_time', 300);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{

  $getuser = $API->comm("/ip/hotspot/user/print");
	$TotalReg = count($getuser);
	
  $counttuser = $API->comm("/ip/hotspot/user/print", array(
	 "count-only" => ""));
}
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3><i class="fa fa-users"></i> Export Hotspot Users | <strong class="pointer" onclick="exportTableToCSV('export-user-hotspot-mikhmon-<?php echo date("Y-m-d");?>.txt')" title="Download User List"><i class="fa fa-download"></i> Download</strong>
    </h3>
    
</div>
<div class="card-body overflow">		   
<table id="export" class="text-nowrap">
  <tr>
    <td>/ip hotspot user</td>
  </tr>
<?php
for ($i=1; $i<$TotalReg; $i++){
	$userdetails =	$getuser[$i];
	$uid = $userdetails['.id'];
	$userver = $userdetails['server'];
	$uname = $userdetails['name'];
	$upass = $userdetails['password'];
	$uprofile = $userdetails['profile'];
	$uuptime = formatDTM($userdetails['uptime']);
  $ubyteso = formatBytes($userdetails['bytes-out'],2);
  if($ubyteso == 0){$ubyteso = "";}else{$ubyteso = $ubyteso;}
	$ucomment = $userdetails['comment'];
  $udisabled = $userdetails['disabled'];
  $utimelimit = $userdetails['limit-uptime'];
  $udatalimit = $userdetails['limit-bytes-out'];

  if($utimelimit == ""){$timelimit= "";}else{$timelimit = 'limit-uptime="'.$utimelimit.'"';}
  if($udatalimit == ""){$datalimit= "";}else{$datalimit = 'limit-bytes-out="'.$udatalimit.'"';}
  if($ucomment == ""){$comment = "";}else{$comment = 'comment="'.$ucomment.'"';}

	echo '
  <tr>
    <td>add name="'.$uname.'" password="'.$upass.'" profile="'.$uprofile.'" '.$comment.' '.$timelimit.' '.$datalimit.'</td>
  </tr>
	';
	}
?>

</table>
</div>
</div>
</div>
</div>
<script>
      function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;
        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});
        // Download link
        downloadLink = document.createElement("a");
        // File name
        downloadLink.download = filename;
        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);
        // Hide download link
        downloadLink.style.display = "none";
        // Add the link to DOM
        document.body.appendChild(downloadLink);
        // Click download link
        downloadLink.click();
        }
        
        function exportTableToCSV(filename) {
          var csv = [];
          var rows = document.querySelectorAll("#export tr");
          
         for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
         for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);
        csv.push(row.join(","));
        }
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
        }
</script>
	
	
