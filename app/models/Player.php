<?php

class Player extends Eloquent {

  //Player attributes
  // Pseudonym, Real Name, Course and department, Year,
  // allergies, water (dropdown box) and picture

  public static $rules = array(
    'pseudonym'  => 'required',
    'name'       => 'required',
    'course'     => 'required',
    'department' => 'required',
    'year'       => 'required',
    'allergies'  => 'required',
    'water'      => 'required',
    'gameID'     => 'required',
  );

  public function user() {
    return $this->belongsTo('User');
  }

  public function game() {
    return $this->belongsTo('Game');
  }

}

?>
