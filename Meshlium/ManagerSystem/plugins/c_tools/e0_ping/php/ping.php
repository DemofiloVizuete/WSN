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
    include_once '../data/url.php';
    // Remove file to allow other use it or to avoid bad use of plugin.
    exec("sudo remountrw", $ret);
    unlink("../data/url.php");

    if (strstr($interface,"eth06"))
    {    
	echo '<span style="font-family:monospace; font-weight: 12px;"><b>Launching: </b> ping6 '.escapeshellarg($url).' -c 10 -I eth0</span>';
	flush();
	$fp=popen('ping6 '.escapeshellarg($url).' -c 10 -I eth0',"r");
    }
    else
    {   
	echo '<span style="font-family:monospace; font-weight: 12px;"><b>Launching: </b> ping '.escapeshellarg($url).' -c 10 -I '.escapeshellarg($interface).'</span>';
	flush();
	$fp=popen('ping '.escapeshellarg($url).' -c 10  -I '.escapeshellarg($interface),"r");
    }
    echo "<pre>";
    while (!feof($fp))
    {
        $results = fgets($fp, 20);
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
        usleep(500);
        //sleep(1);
    }
    exec("sudo remountro", $ret);
    echo '</pre><span style="font-family:monospace; font-weight: 12px;"><b>ping finished.</b></span>';
}
?>
