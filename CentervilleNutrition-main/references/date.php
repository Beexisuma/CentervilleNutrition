<?php

$time = str_split(getTime());
$day = getdate()["wday"];
$currentHour = getdate()["hours"];
$dayData = $dataClass->searchData("hours","ID",$day);

$_SESSION['isOpen'] = false;

if($dayData["isOpen"] == 1)
{
    $am_pm = $time[4];
    if($time[4] == "a" || $time[5] == "a")
    {
        if($currentHour >= $dayData["Open"] && $time[1] != 2)
        {
            $_SESSION['isOpen'] = true;
        }
    }
    else
    {
        if($currentHour < $dayData["Close"]+12)
        {
            $_SESSION['isOpen'] = true;
        }
    }
}

?>