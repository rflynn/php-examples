<?php

function gol($s="GOL!", $ret=0){ $t = $s[0].preg_replace('/([AEIOU])/', str_repeat('\1', rand(20,30)), strtoupper(substr($s, 1)), 1); if ($ret) return $t; else echo $t; }
function sparta_($s="this is sparta!", $ret=0){ $t = preg_replace('/([AEIOUY\d])((?>[^AEIOUY\d]*))$/', str_repeat('\1', rand(10,20)).'\2', strtoupper(trim($s)), 1); $u = preg_replace('/\s+/', '. ', $t);  if ($ret) return $u; else echo $u; }

function sparta($s="this is sparta!", $ret=0){ $n = rand(10,20); $s = strtoupper(trim($s)); $t = preg_replace('/([AEIOUY\d])((?>[^AEIOUY\d]*))$/', str_repeat('\1', $n).'\2', $s, 1); if (strlen($t) == strlen($s)) $t = substr($s, 0, -1) . str_repeat(substr($s,-1),$n); $u = preg_replace('/\s+/', '. ', $t); if ($ret) return $u; else echo $u; }

gol();
sparta("lol wut");
sparta("x");

?>
