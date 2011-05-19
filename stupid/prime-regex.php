<?php
#perl -e'$|++;(1 x$_)!~/^1?$|^(11+?)\1+$/&&print"$_ "while ++$_'
while($s.=' ')if(!preg_match('/^1?$|^(11+?)\1+$/',$s))echo strlen($s).' ';
?>
