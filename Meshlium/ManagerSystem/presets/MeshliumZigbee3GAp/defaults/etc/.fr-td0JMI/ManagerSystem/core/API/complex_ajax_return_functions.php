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
 *  Author: Octavio Benedí  
 */
$response_array=Array();
$response_iterator=0;
function response_additem($type,$value,$id="")
{
    global $response_array;
    global $response_iterator;
    $response_array['item'][$response_iterator]['type']=$type;
    $response_array['item'][$response_iterator]['value']=$value;
    if(!empty($id))
    {
        $response_array['item'][$response_iterator]['id']=$id;
    }
    $response_iterator++;
}
function response_return()
{
    global $response_array;
    echo json_encode($response_array);
}
?>