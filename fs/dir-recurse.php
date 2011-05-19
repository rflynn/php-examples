<?php
function dir_recurse($path, $level=0){
	$d = opendir($path);
	while (($f = readdir($d))) {
		if ($f != '.' && $f != '..') {
			printf("%s`%s\n", str_repeat(" ", $level), $f);
			if (is_dir("$path/$f"))
				dir_recurse("$path/$f", $level+1);
		}
	}
	closedir($d);
}
dir_recurse("/tmp");
?>
