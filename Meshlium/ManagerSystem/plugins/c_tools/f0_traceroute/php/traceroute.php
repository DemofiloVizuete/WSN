<?php
/*
 *  Copyright (C) 2008 Libelium Comunicaciones Distribuidas S.L.
 *  http://www.libelium.com
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Version 0.1
 *  Author: Octavio Benedí  Joaquin Ruiz
 */
//set_time_limit (20);

if (file_exists("../data/url.php"))
{
    exec("sudo remountrw");

    include_once '../data/url.php';
    // Remove file to allow other use it or to avoid bad use of plugin.
    unlink("../data/url.php");
    //echo "url:".$url."<br>interface:".$interface."<br>";    
    if (strstr($interface,"eth06"))
    {    
	echo '<span style="font-family:monospace; font-weight: 12px;"><b>Launching: </b> traceroute6 '.escapeshellarg($url).' -i eth0</span>';
	flush();
	$fp=popen('traceroute6 '.escapeshellarg($url),"r");
    }
    else
    {   
	echo '<span style="font-family:monospace; font-weight: 12px;"><b>Launching: </b> traceroute '.escapeshellarg($url).' -i '.escapeshellarg($interface).'</span>';
	flush();
	$fp=popen('traceroute '.escapeshellarg($url),"r");
    }
    

    echo "<pre>";
    while (!feof($fp))
    {
        $results = fgets($fp, 256);
        if (strlen($results) == 0) {
           // stop the browser timing out
           echo " ";
           flush();
        }
        else
        {
            echo $results;
            flush();
        }
        // avoid a busy wait
        sleep(1);
    }

    exec("sudo remountro");
    
    echo '</pre><span style="font-family:monospace; font-weight: 12px;"><b>Traceroute finished.</b></span>';
}
?>
