<?php
mysql_connect('localhost','root','root') or die(mysql_error());
mysql_select_db('test') or die(mysql_error());
print_r(list($cnt) = mysql_fetch_row(mysql_query('select count(*) from foo') or die('whoops')));
?>
