<?php
class Cancion
{
    public $id;
    public $title;
    public $artist;
    public $category;
    public $duration;
    public $src;

    public $volume;
    public $available;


    public function __construct()
    {

    }

    public function populate_cancion($id, $title = '', $artist = '', $duration = 0, $volume = 0, $available = true)
    {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->duration = $duration;
        $this->volume = $volume;
        $this->available = $available;
    }

    public function get_associative_array()
    {
        return array('id' => $this->id, 'title' => $this->title, 'artist' => $this->artist, 'category' => $this->category, 'duration' => $this->duration, 'volume' => $this->volume, 'available' => $this->available, 'src' => $this->src);
    }
}