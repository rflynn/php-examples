<?php

function strip_nonalpha($str)
{
	return preg_replace('/[^a-zA-ZæøåÆØÅ]+/', '', $str);
}

function test_strip_nonalpha()
{
	$Test = array(
		"" => "",
		"." => "",
		"123x" => "x",
		"a b" => "ab",
		"a_b" => "ab",
		"a,b" => "ab",
		"abcdefghijklmnopqrstuvxyzæøåABCDEFTGIJKLMNOPQRSTUVXYZÆØÅ" => "abcdefghijklmnopqrstuvxyzæøåABCDEFTGIJKLMNOPQRSTUVXYZÆØÅ",
	);
	reset($Test);
	$passcnt = 0;
	while(list($in,$expect) = each($Test))
	{
		$out = strip_nonalpha($in);
		$pass = $out == $expect;
		printf("[%2s] \"%s\" -> \"%s\"%s\n", $pass ? "OK" : "!!", $in, $out, $pass ? "" : "($expect)");
		$passcnt += $pass;
	}
	printf("%d/%d (%.2f%%)\n", $passcnt, count($Test), $passcnt / count($Test) * 100);
	return $passcnt == count($Test);
}

test_strip_nonalpha();

?>
