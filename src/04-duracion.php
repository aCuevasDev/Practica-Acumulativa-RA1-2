<?php


function getTimeFromDuration($duration)
{
    $minutes = intdiv($duration, 60);
    $seconds = $duration % 60;

    return ["duration" => $duration, "minutes" => $minutes, "seconds" => $seconds];
}

echo var_dump(getTimeFromDuration(185));
