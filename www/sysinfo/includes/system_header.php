<?php
//
// phpSysInfo - A PHP System Information Script
// http://phpsysinfo.sourceforge.net/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// $Id: system_header.php,v 1.2 2005/10/20 16:53:42 julio234 Exp $


// our text direction (for hebrew)
if (!$text_dir) {
    $text_dir = 'ltr';
}

// timestamp
$timestamp = strftime ("%b %d %Y %H:%M:%S", time());

if (file_exists("sysinfo/templates/$template/$template.css")) {
    echo '    <link rel="STYLESHEET" type="text/css" href="sysinfo/templates/';
    echo $template . '/' . $template;
    echo ".css\">";
}
?>