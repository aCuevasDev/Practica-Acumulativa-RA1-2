<?php
$duration = 0;

// $ERR_MESSAGE = "La duración de la canción debe ser superior a 0";
$DURATION_0 = "Sin duración";
$DURATION_240 = "Hasta cuatro minutos";
$DURATION_ABOVE_240 = "Más de cuatro
minutos";


if ($duration === 0) {
    echo $DURATION_0;
} else if ($duration > 0 && $duration <= 240) {
    echo $DURATION_240;
} else if ($duration > 240) {
    echo $DURATION_ABOVE_240;
}
