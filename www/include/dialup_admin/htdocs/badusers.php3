<?php
require('../../../../conf/dialup_admin/conf/config.php3');
require('../lib/functions.php3');
?>
<html>
<?php

if (is_file("../lib/sql/drivers/$config[sql_type]/functions.php3"))
	include_once("../lib/sql/drivers/$config[sql_type]/functions.php3");
else{
	echo <<<EOM
<title>Unauthorized Service Usage History for $login</title>
<meta http-equiv="Content-Type" content="text/html; charset=$config[general_charset]">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
<b>Could not include SQL library functions. Aborting</b>
</body>
</html>
EOM;
	exit();
}

$now = time();
$now_str = ($now_str != '') ? "$now_str" : date($config[sql_date_format],$now + 86400);
$prev_str = ($prev_str != '') ? "$prev_str" : "0001-01-01 00:00:00";

$now_str = da_sql_escape_string($now_str);
$prev_str = da_sql_escape_string($prev_str);

$num = 0;
$pagesize = ($pagesize) ? $pagesize : 10;
if (!is_numeric($pagesize) && $pagesize != 'all')
	$pagesize = 10;
$limit = ($pagesize == 'all') ? '' : "LIMIT $pagesize";
$selected[$pagesize] = 'selected';
$login = ($login != '') ? $login : 'anyone';
$usercheck = ($login == 'anyone') ? "LIKE '%'" : "= '$login'";
$order = ($order != '') ? $order : $config[general_accounting_info_order];
if ($order != 'desc' && $order != 'asc')
	$order = 'desc';
$selected[$order] = 'selected';

echo <<<EOM
<head>
<title>Unauthorized Service Usage History for $login</title>
<meta http-equiv="Content-Type" content="text/html; charset=$config[general_charset]">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
 
EOM;

if ($login != 'anyone'){
	echo <<<EOM
<table border=0 width=400 cellpadding=0 cellspacing=2>
EOM;

include("../html/user_toolbar.html.php3");

print <<<EOM
</table>
EOM;
}

if ($do_delete == 1 && ($row_id != 0 && is_numeric($row_id))){
$link = @da_sql_connect($config);
if ($link){
	$search = @da_sql_query($link,$config,
	"SELECT id,admin FROM $config[sql_badusers_table]
	WHERE id = '$row_id';");
	if ($search){
		$row = @da_sql_fetch_array($search,$config);
		if ($row[id] == $row_id){
			$admin = "$row[admin]";
			if (($admin != '-' && $HTTP_SERVER_VARS["PHP_AUTH_USER"] == $admin) || $admin == '-'){
				$sql_servers = array();
				if ($config[sql_extra_servers] != '')
					$sql_servers = explode(' ',$config[sql_extra_servers]);
				$sql_servers[] = $config[sql_server];
				foreach ($sql_servers as $server){
					$link2 = @da_sql_host_connect($server,$config);
					if ($link2){
						$r = da_sql_query($link2,$config,
						"DELETE FROM $config[sql_badusers_table]
						WHERE id = '$row_id';");
						if (!$r)
							echo "<b>SQL Error:" . da_sql_error($link2,$config) . "</b><br>\n";
						@da_sql_close($link2,$config);
					}
					else
						echo "<b>SQL Error: Could not connect to SQL database: $server</b><br>\n";
				}
			}
		}
	}
	else
		echo "<b>Database query failed: " . da_sql_error($link,$config) . "</b><br>\n";
	@da_sql_close($link,$config);
}
else
	echo "<b>Could not connect to SQL database</b><br>\n";
}

echo <<<EOM
<br><br>
<table border=0 width=740 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=55%></td>
<td bgcolor="888888" width=45%>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">Unauthorized Service Usage History for $login</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
<b>$prev_str</b> up to <b>$now_str</b>
<form action="badusers.php3" method="get" name="master">
<input type=hidden name=do_delete value=0>
<input type=hidden name=row_id value=0>
EOM;
?>

<p>
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr bgcolor="#e6e6e6">
	<th>#</th><th>user</th><th>date</th><th>admin</th><th>reason</th><th>administrator action</th>
	</tr>

<?php
$auth_user = $HTTP_SERVER_VARS["PHP_AUTH_USER"];
if ($config[general_restrict_badusers_access] == 'yes'){
	$auth_user = da_sql_escape_string($auth_user);
	$extra_query = "AND admin == '$auth_user'";
}
$link = @da_sql_pconnect($config);
if ($link){
	$search = @da_sql_query($link,$config,
	"SELECT * FROM $config[sql_badusers_table]
	WHERE UserName $usercheck $extra_query AND Date <= '$now_str'
	AND Date >= '$prev_str' ORDER BY Date $order $limit;");
	if ($search){
		while( $row = @da_sql_fetch_array($search,$config) ){
			$num++;
			$id = $row[id];
			$user = "$row[userName]";
			$date = "$row[date]";
			$reason = "$row[reason]";
			$admin = "$row[admin]";
			if ($admin == $auth_user || $admin == '-')
	$action = "<td><input type=submit class=button value=\"Delete\" OnClick=\"this.form.do_delete.value=1;this.form.row_id.value=$id\"></td>";
			else
				$action = "<td>-</td>";
			if ($admin == '')
				$admin = '-';
			if ($reason == '')
				$reason = '-';
			echo <<<EOM
			<tr align=center>
				<td>$num</td>
				<td><a href="user_admin.php3?login=$user" title="Edit user $user">$user</a></td>
				<td>$date</td>
				<td>$admin</td>
				<td>$reason</td>
				$action
			</tr>
EOM;
		}
	}
	else
		echo "<b>Database query failed: " . da_sql_error($link,$config) . "</b><br>\n";
}
else
	echo "<b>Could not connect to SQL database</b><br>\n";
echo <<<EOM
	</table>
<tr><td>
<hr>
<tr><td align="center">
	<table border=0>
		<tr><td colspan=6></td>
			<td rowspan=3 valign="bottom">
				<small>
				the <b>from</b> date matches any login after the 00:00 that day,
				and the <b>to</b> date any login before the 23:59 that day.
				the default values shown are the <b>current week</b>.
			</td>
		</tr>
		<tr valign="bottom">
			<td><small><b>user</td><td><small><b>from date</td><td><small><b>to date</td><td><small><b>pagesize</td><td><b>order</td>
&nbsp;</td>
	<tr valign="middle"><td>
<input type="text" name="login" size="11" value="$login"></td>
<td><input type="text" name="prev_str" size="11" value="$prev_str"></td>
<td><input type="text" name="now_str" size="11" value="$now_str"></td>
<td><select name="pagesize">
<option $selected[5] value="5" >05
<option $selected[10] value="10">10
<option $selected[15] value="15">15
<option $selected[20] value="20">20
<option $selected[40] value="40">40
<option $selected[80] value="80">80
<option $selected[all] value="all">all
</select>
</td>
<td><select name="order">
<option $selected[asc] value="asc">older first
<option $selected[desc] value="desc">recent first
</select>
</td>
EOM;
?>

<td><input type="submit" class=button value="show"></td></tr>
</table></td></tr></form>
</table>
</tr>
</table>
</body>
</html>
