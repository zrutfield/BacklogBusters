<?php
class Game
{
    public $gameName = 'Game';
    private $steamID = '-1';
    public $timeToBeat = -1;
    public $timeOfSitting = -1.0;
    
    public $timePlayed = -1;

    function __construct($name, $id, $toBeat, $sitting, $played)
    {
        $this->gameName = $name;
        $this->steamID = $id;
        $this->timeToBeat = $toBeat;
        $this->timeOfSitting = $sitting;
        $this->timePlayed = $played;
    }
}
