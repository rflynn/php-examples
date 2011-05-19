<?php
# ex: set ts=4 et:
# dal#php GoogleGuy
# http://www.srwebstudio.com/applications/uptime/

function sec_to_time2($seconds) {
    $units = array(
        array('week',   60*60*24*7),
        array('day',    60*60*24),
        array('hour',   60*60),
        array('minute', 60),
        array('second', 1)
    );
    $pizza_ = array();
    foreach ($units as $u) {
        list($descr, $div) = $u;
        $n = floor($seconds / $div);
        if ($n || (!$pizza_ && 1 == $div))
            $pizza_[] = sprintf('%d %s%s', $n, $descr, $n == 1 ? '' : 's');
        $seconds -= $n * $div;
    }
    return join(', ', $pizza_);
}

foreach (array(0,1,60,61,60*60,60*60+1,60*60*24.60*60*24+1,9e9) as $sec)
    printf("%d -> %s\n", $sec, sec_to_time2($sec));

/*

0 -> 0 seconds
1 -> 1 second
60 -> 1 minute
61 -> 1 minute, 1 second
3600 -> 1 hour
3601 -> 1 hour, 1 second
127526401 -> 210 weeks, 6 days, 1 second
9000000000 -> 14880 weeks, 6 days, 16 hours

*/

# original
function sec_to_time($seconds) {
    $weeks = floor($seconds / 604800);
    $days = floor($seconds % 604800 / 86400);
    $hours = floor($seconds % 86400 / 3600);
    $minutes = floor($seconds % 3600 / 60);
    $seconds = $seconds % 60;
    return sprintf("%d week(s), %d day(s), %d hour(s), %d minute(s), %d second(s)", $weeks, $days, $hours, $minutes, $seconds);
}

?>
