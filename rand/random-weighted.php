<?php

# return a random element of kv based on their respective weight values
function random_weighted($kv)
{
	$sum = array_sum(array_values($kv));
	$rnd = (mt_rand() / mt_getrandmax()) * $sum;
	foreach ($kv as $k => $v)
	{
		if ($v >= $rnd)
			return $k;
		$rnd -= $v;
	}
	trigger_error('unreachable');
}

$kv = array( 'x' => 5, 'y' => 1);

foreach(range(1,10) as $n)
	echo random_weighted($kv);
echo "\n";

?>
