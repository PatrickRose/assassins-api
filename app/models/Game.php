<?php

class Game extends Eloquent {

  public function events()
  {
    return $this->hasMany('Event');
  }

  public function players() {
    return $this->hasMany('Player', 'gameID');
  }
}

?>
