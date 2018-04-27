<?php
defined('_VALID') or die('Restricted Access!');
//mod random multiserver ftp start
function get_server()
{
 global $conn;
	$sql = "SELECT * FROM servers WHERE status = '1'";
	$sql2 = "SELECT COUNT(server_id) AS total_server FROM servers WHERE status = '1' ORDER BY last_used ASC";
	$rs  = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$servers = $rs->getrows();
		
		$total_serv = $rs->RecordCount();
		$counter = $total_serv-1;
		
		for ( $i = 0; $i < $total_serv; $i++)
		{
		    //echo "This is server : $i <br />";
		    //echo "***********************************************************<br />";
			//echo $servers[$i]['url'];
			//echo "<br /><br />";
			if ($servers[$i]['current_used'] == 1)
			{
              update_server_to_off($servers[$i]['server_id']);//set current server used to 0.
			  if ($i < $counter)
			  {
			    $params = $i+1;
			  }
			  else
			  {
			    $params = 0;
			  }
			 // echo "Param is: ".$params;
			  update_server_to_on($servers[$params]['server_id']);//set next server used to 1.
			  return $servers[$i];
			  //echo "<strong style='color:#FF0000;'>######## This Server Was Currently in Used. ########</strong> </br>";
			  

			}
			
			//echo "<br />***********************************************************<br />";
		
		}

	} else {
		die('Failed to find a active server! Please check your settings!');
	}	
}
function update_server_to_off($server_id)
{
	global $conn;
	$conn->execute("UPDATE servers SET current_used = '0' WHERE server_id = ".$server_id." LIMIT 1");
}
function update_server_to_on($server_id)
{
	global $conn;
	$conn->execute("UPDATE servers SET current_used = '1' WHERE server_id = ".$server_id." LIMIT 1");
}
//mod random multiserver ftp end
function update_server_used($server)
{
	global $conn;
	$conn->execute("UPDATE servers SET current_used = '1' WHERE server_id = ".$server['server_id']." LIMIT 1");
}

function update_server($server)
{
	global $conn;
	$conn->execute("UPDATE servers SET last_used = '".date('Y-m-d h:i:is')."', current_used = '0'
	                WHERE server_id = ".$server['server_id']." LIMIT 1");
}

function upload_video($flv, $iphone, $hd, $ip, $username, $password, $ftp_root)
{
	$conn_id    = ftp_connect($ip);
	$ftp_login  = ftp_login($conn_id, $username, $password);
	if ( !$conn_id or !$ftp_login ) {
        die('Failed to connect to FTP server!');
    }
	ftp_pasv($conn_id, 1);
	if ( !ftp_chdir($conn_id, $ftp_root) ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}		
	if (file_exists($flv)) {
		if ( !ftp_chdir($conn_id, 'flv') ) {
		    die('Failed to change directory to: flv');
		}	
		$filename = basename($flv);
		ftp_delete($conn_id, $filename);
		ftp_put($conn_id, $filename, $flv, FTP_BINARY);
		ftp_site($conn_id, sprintf('CHMOD %u %s', 777, $filename));
		if ( !ftp_chdir($conn_id, '..') ) {
		    die('Failed to change directory to: ' .$ftp_root);
		}		
	}
	if (file_exists($iphone)) {
		if ( !ftp_chdir($conn_id, 'iphone') ) {
		    die('Failed to change directory to: iphone');
		}	
		$filename = basename($iphone);
		ftp_delete($conn_id, $filename);
		ftp_put($conn_id, $filename, $iphone, FTP_BINARY);
		ftp_site($conn_id, sprintf('CHMOD %u %s', 777, $filename));
		if ( !ftp_chdir($conn_id, '..') ) {
		    die('Failed to change directory to: ' .$ftp_root);
		}	
	}
	if (file_exists($hd)) {
		if ( !ftp_chdir($conn_id, 'hd') ) {
		    die('Failed to change directory to: hd');
		}	
		$filename = basename($hd);
		ftp_delete($conn_id, $filename);
		ftp_put($conn_id, $filename, $hd, FTP_BINARY);
		ftp_site($conn_id, sprintf('CHMOD %u %s', 777, $filename));
		if ( !ftp_chdir($conn_id, '..') ) {
		    die('Failed to change directory to: ' .$ftp_root);
		}	
	}
	ftp_close($conn_id);
}


?>
