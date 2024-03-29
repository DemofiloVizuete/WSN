<?php
/*
 * Copyright (C) 2008 Libelium Comunicaciones Distribuidas S.L.
 *
 * This file is part of Meshlium Manager System.
 * Meshlium Manager System will be released as free software; until then you cannot redistribute it
 * without express permission by libelium. 
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 *
 * Version 0.1.0 
 * Author: Octavio Benedí Sánchez  
 */
function parse_dhcp_server()
{
	$return = array();
	$filepath='/etc/dnsmasq.more.conf';
	// if file exists we parse actual values.
	if (file_exists($filepath))
	{
		$ini = file( $filepath );
		foreach( $ini as $line ){
			// with trim just take out unwanted characters
	        $line = trim( $line );
	        // if first character is a # we know is a comment and pass through
			if ( $line == '' || $line{0} == '#' )
			{
				continue;
			}
			$values= explode( ',', $line,4); // here we will have the 4 values of each line.
			$values[0]=trim($values[0]);
            $tmp_info=explode('=',$values[0]);
			if ($tmp_info[0]=='dhcp-range')
			{
				$return[$tmp_info[1]]['start']=$values[1];
				$return[$tmp_info[1]]['end']=$values[2];
				$return[$tmp_info[1]]['expiration']=substr($values[3],0,-1);
			}
		}
	}
    //echo "<pre>".print_r($return,true)."</pre>";
	return $return;
}
?>