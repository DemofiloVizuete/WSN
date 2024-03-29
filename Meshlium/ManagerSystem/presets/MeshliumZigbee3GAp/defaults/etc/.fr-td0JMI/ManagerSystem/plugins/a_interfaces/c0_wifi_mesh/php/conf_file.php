<?php
/*
 *  Copyright (C) 2009 Libelium Comunicaciones Distribuidas S.L.
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
 *  Author: Daniel Larraz <d.larraz [at] libelium [dot] com>
 */

function load_conf_file ($filepath)
/* ------------------------------------------------------------------------ */
{ 
    if ( file_exists ($filepath) )
    {
        return parse_ini_file ($filepath, true);
    }
    else
    {
        return array();
    }
}
/* ------------------------------------------------------------------------ */

function save_conf_file ($filepath, $data)
/* ------------------------------------------------------------------------ */
{
    $fp = fopen ($filepath, "w");

    foreach ($data as $section => $confs)
    {
        fwrite ($fp, "[".$section."]\n\n");
        foreach ($confs as $key => $value)
        {
            if ( is_array($value) ) {
                foreach ($value as $v)
                {
                    fwrite ($fp, $key."[] = \"".$v."\"\n");
                }
            } else {
                fwrite ($fp, $key." = \"".$value."\"\n");
            }
            
        }
        fwrite ($fp, "\n");
    }

    fclose ($fp);
}
/* ------------------------------------------------------------------------ */

?>
