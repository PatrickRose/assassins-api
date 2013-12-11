<?php

class Kill extends Eloquent {

    public function game() {
        $this->belongsTo('Games');
    }

}

?>
