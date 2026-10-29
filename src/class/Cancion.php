<?php
class Cancion
{
    public $id; //json
    public $name; //json
    public $author; //json
    public $category;
    public $duration; //json
    public $file; //json

    public $volume;
    public $available;

    public $picture; //json

    // Either false or the json string
    public function __construct($json = false)
    {
        if ($json)
            $this->set(json_decode($json, true));
    }

    // public function __construct()
    // {
    // }

    public function populate_cancion($id, $title = '', $artist = '', $duration = 0, $volume = 0, $available = true)
    {
        $this->id = $id;
        $this->name = $title;
        $this->author = $artist;
        $this->duration = $duration;
        $this->volume = $volume;
        $this->available = $available;
    }

    public function get_associative_array() : array
    {
        return array('id' => $this->id, 'title' => $this->name, 'artist' => $this->author, 'category' => $this->category, 'duration' => $this->duration, 'volume' => $this->volume, 'available' => $this->available, 'src' => $this->file);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            // if (is_array($value)) {
            //     $sub = new Cancion();
            //     $sub->set($value);
            //     $value = $sub;
            // }
            $this->{$key} = $value;
        }
    }

    public function duracionLegible(): string
    {
        if ($this->duration <= 0) {
            return "00:00";
        }

        $minutes = intdiv($this->duration, 60);
        $seconds = $this->duration % 60;
        return str_pad($minutes, 2, '0', STR_PAD_LEFT) . ":" . str_pad($seconds, 2, '0', STR_PAD_LEFT);
    }

}

