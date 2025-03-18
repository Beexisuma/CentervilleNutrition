<?php


// Initalize info on today
$ampm = date("a");
$day = ucfirst(date("l"));
$currentHour = date("G");
$dayData = $dataClass->searchData("hours","Day",$day);


// Assume the store is closed
$_SESSION['isOpen'] = false;


if($dayData["isOpen"] == 1)
{
    // Determines if it is am or pm
    if($ampm == "am")
    {
        // If the hour is equal to or greater than the time that the store opens or the store is open always when it is am, the store is open
        if($currentHour >= $dayData["Open"] || 12 == $dayData["Open"])
        {
            $_SESSION['isOpen'] = true;
        }
    }
    else
    {
        // If the hour (adjusted since it is on a 24 hour scale) is before the store close and the store doesn't close at 12pm (meaning it will never be open and pm), the store is open
        if($currentHour-12 < $dayData["Close"] && $dayData["Close"] != 12)
        {
            $_SESSION['isOpen'] = true;
        }
    }
}




// Code to determine next opening time if store is closed
if(!$_SESSION['isOpen'])
{
    // If the store opens today and it is still am, set the hour and day the store will open next using today's data
    if($dayData["isOpen"] && $ampm == "am")
    {
        $nextOpenDay = $day;
        $nextOpenHour = $dayData["Open"] . ":00am";
    }
    else
    {
        // Set dayID to the next day keeping it between 0-6
        $dayID = $dayData["ID"] + 1;
        if($dayID == 7)
        {
            $dayID = 0;
        }


        // Collects the next day's data
        $nextDayData = $dataClass->searchData("hours","ID",$dayID);


        // Loops until an day that store is open is found
        $Closed = true;
        while($Closed)
        {
            // If the data says it is open, exit the loop
            if($nextDayData["isOpen"])
            {
                $Closed = false;
            }
            // If the data says it is closed that day, set dayID to the next day keeping it between 0-6 and collects the next days data
            else
            {
                $dayID++;
                if($dayID == 7)
                {
                    $dayID = 0;
                }
               
                $nextDayData = $dataClass->searchData("hours","ID", $dayID);
            }
        }


        // Using data from the day that is open, set the hour and day the store will open next
        $nextOpenDay = $nextDayData["Day"];
        $nextOpenHour = $nextDayData["Open"] . ":00am";
    }
}


?>


