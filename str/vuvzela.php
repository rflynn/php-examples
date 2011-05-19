<?php
function c(){return "bvz"[rand(0,2)];}
echo join('',array_map(c, range(1,200)));
?>
