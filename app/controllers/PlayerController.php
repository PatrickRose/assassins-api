<?php

class PlayerController extends BaseController {

  public function login() {
    $email = Input::get('email');
    $password = Input::get('password');
    if (Auth::attempt(array('email' => $email,
                            'password' => $password))) {
      $player = Auth::user()->player;
      if(isset($player)) {
        return Response::json(
          array(
            'error' => false,
            'player' => $player->toArray(),
          ),
          200
        );
      }
      return Response::json(
        array(
          'error' => true,
          'problem' => "You haven't created a player yet",
        ),
        200
      );
    }
    return Response::json(
      array(
        'error' => true,
        'problem' => "Failed to log in. Check your password?"
      ),
      403
    );
  }

}

?>
