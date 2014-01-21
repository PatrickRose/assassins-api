<?php

class ApiEvent extends Eloquent {

  protected $table = 'events';

  public function game() {
    $this->belongsTo('Games');
  }

}

?>
