<?php
function cowsay($str,$M=40){$W=strlen($str);if($W>$M)$W=$M;$str=wordwrap($str,$W,"\n",1);$L=explode("\n",$str);for($i=0;$i<count($L);$i++)$L[$i]="| ".$L[$i].str_repeat(" ",$W-strlen($L[$i]))." |";echo "^__^  
                  {$L[0]}\n    ____(oo)   {$L[1]}\n  /(    (__) --{$L[2]}\n *  ||--||     {$L[3]}\n";}
cowsay($argv[1]);
?>
