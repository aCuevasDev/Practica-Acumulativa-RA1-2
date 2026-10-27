<?php

for ($i = 0; $i < 3; $i++)
    echo "<ul>" . $i + 1 . "</ul>";

$i = 0;
while ($i < 3):
    echo "<ul>" . $i + 1 . "</ul>";
    $i++;
endwhile;