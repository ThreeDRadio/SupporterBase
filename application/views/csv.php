<?php

$printHeaders = true;
foreach ($members as $member) {
    if ($printHeaders) {
        foreach ($member as $key=>$val) {
            echo '"' . $key. '",';
        }
        echo "\n";
        $printHeaders = false;
    }
    foreach ($member as $key=>$val) {
        if ($key == "expiration_date") {
            echo '"' . strftime('%d/%m/%y', $val) . '",';
        }
        if ($key == "timestamp") {
            echo '"' . strftime('%d/%m/%y', $val) . '",';
        }
        else {
            echo '"' . $val . '",';
        }
    }
    echo "\n";
}
?>
