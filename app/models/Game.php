<?php

class Game extends Eloquent {

    public function events()
    {
        return $this->hasMany('Event');
    }
}

?>
