<?php
class Cancion
{
    public $title;
    public $artist;
    public $duration;
    public $volume;
    public $available;

    public function __construct()
    {

    }

    public function populate_cancion($title = '', $artist = '', $duration = 0, $volume = 0, $available = true)
    {
        $this->title = $title;
        $this->artist = $artist;
        $this->duration = $duration;
        $this->volume = $volume;
        $this->available = $available;
    }

    public function dump_variables()
    {
        return array('title' => $this->title, 'artist' => $this->artist, 'duration' => $this->duration, 'volume' => $this->volume, 'available' => $this->available);
    }
}