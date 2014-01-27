<?php

class Game extends Eloquent {

  public function events()
  {
    return $this->hasMany('ApiEvent');
  }

  public function players() {
    return $this->hasMany('Player', 'gameID');
  }

  public function finished() {
    if ($this->started) {
      return false;
    }
    if ($this->events->count() > 0) {
      return true;
    }
    return false;
  }
}

?>
