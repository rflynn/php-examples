<?php

foreach (array('-1 week', '-1 month', '-6 months') as $x)
	printf("%s -> %s\n", $x, date('Y-m-d', strtotime($x)));

?>
