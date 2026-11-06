<?php
// WHILE Y FOR QUE PIDE EL EJERCICIO, luego lo hago con foreach para el array
// for ($i = 0; $i < 3; $i++)
//     echo "<ul>" . $i + 1 . "</ul>";

// $i = 0;
// while ($i < 3):
//     echo "<ul>" . $i + 1 . "</ul>";
//     $i++;
// endwhile;

$canciones = [
    [
        'id' => 1,
        'title' => 'Bohemian Rhapsody',
        'artist' => 'Queen',
        'category' => 'Rock',
        'duration' => 355,
        'volume' => 80,
        'available' => true,
        'src' => 'bohemian-rhapsody.mp3',
    ],
    [
        'id' => 2,
        'title' => 'Billie Jean',
        'artist' => 'Michael Jackson',
        'category' => 'Pop',
        'duration' => 294,
        'volume' => 75,
        'available' => true,
        'src' => 'billie-jean.mp3',
    ],
    [
        'id' => 3,
        'title' => 'Smells Like Teen Spirit',
        'artist' => 'Nirvana',
        'category' => 'Grunge',
        'duration' => 301,
        'volume' => 90,
        'available' => false,
        'src' => 'smells-like-teen-spirit.mp3',
    ],
    [
        'id' => 4,
        'title' => 'La Macarena',
        'artist' => 'Los del Río',
        'category' => 'Latina',
        'duration' => 240,
        'volume' => 70,
        'available' => true,
        'src' => 'la-macarena.mp3',
    ],
];

if (empty($canciones)) {
    echo "Canciones vacías";
}
?>
<ul>
    <?php foreach ($canciones as $index => $cancion): ?>
        <li> CANCION : <?= $index ?>
            <?= htmlspecialchars($cancion['title'], ENT_QUOTES, 'UTF-8') ?> —
            <?= htmlspecialchars($cancion['artist'], ENT_QUOTES, 'UTF-8') ?> —
            <?= htmlspecialchars((string) $cancion['duration'], ENT_QUOTES, 'UTF-8') ?> s
        </li>
    <?php endforeach; ?>
</ul>