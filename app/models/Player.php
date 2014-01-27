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
    'address'    => 'required',
    'user_id'    => 'required'
  );

  public function user() {
    return $this->belongsTo('User');
  }

  public function game() {
    return $this->belongsTo('Game', 'gameID');
  }

  public function findTarget() {
    $target = Player::where('circleID', '=', $this->circleID + 1)->where('gameID', '=', $this->gameID)->first();
    if ($target) {
      return $target->alive ? $target : $target->findTarget();
    }
    $target = Player::where('circleID', '=', 1)->where('gameID', '=', $this->gameID)->first();
    return $target->alive ? $target : $target->findTarget();
  }

}

?>
