<?php
require_once(__DIR__ . "/services/read-json.php");

function duracionLegible(int $total): string
{
    if ($total <= 0) {
        return "0";
    }

    $minutes = intdiv($total, 60);
    $seconds = $total % 60;
    return str_pad($minutes, 2, '0', STR_PAD_LEFT) . ":" . str_pad($seconds, 2, '0', STR_PAD_LEFT);
}

echo duracionLegible(185);

echo "Duración de otra canción desde la clase Cancion.php: " . ($songs[0]->duracionLegible());
