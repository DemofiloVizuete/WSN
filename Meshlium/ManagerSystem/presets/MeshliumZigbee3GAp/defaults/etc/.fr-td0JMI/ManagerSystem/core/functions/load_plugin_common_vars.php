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
if (!empty($_GET))
{
    // Check for section or plugin that must be shown.
    // Strip non allowed characters.
    $section=preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['section']);
    if (!empty($section))
    {
        $base_section=$base_dir.'plugins/'.$section.'/';
        $plugin=preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['plugin']);
        if($section=="z_help")
        {
            //$_GET['plugin'] == "about";
            $plugin = "about";
            //header('Location: index.php?section=z_help&plugin=about');
        }
        if (!empty($plugin)) // Plugin is defined
        {
            // Check if the plugin exists and if so, show it.
            $base_plugin=$base_section.$plugin.'/';
            $url_plugin='plugins/'.$section.'/'.$plugin.'/';
            $API_core='core/API/';
        }
    }
}
elseif (!empty($_POST))
{
    // Check for section or plugin that must be shown.
    // Strip non allowed characters.
    $section=preg_replace("/[^a-zA-Z0-9_]/", "", $_POST['section']);
    if (!empty($section))
    {
        $base_section=$base_dir.'plugins/'.$section.'/';
        $plugin=preg_replace("/[^a-zA-Z0-9_]/", "", $_POST['plugin']);
        if (!empty($plugin)) // Plugin is defined
        {
            // Check if the plugin exists and if so, show it.
            $base_plugin=$base_section.$plugin.'/';
            $url_plugin='plugins/'.$section.'/'.$plugin.'/';
            $API_core='core/API/';
        }
    }
}
else
{
    // This should load index page.
    $initial_index_page=true;
}
?>