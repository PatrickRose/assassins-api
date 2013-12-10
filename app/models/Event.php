<?php

class Event extends Eloquent {

    public function game() {
        $this->belongsTo('Games');
    }

}

?>
