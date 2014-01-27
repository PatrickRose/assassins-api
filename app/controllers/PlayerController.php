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
          'message' => "You haven't created a player yet",
          'user' => Auth::user()->toArray()
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

  public function create() {
    return View::make('players.create');
  }

  public function save() {
    $user = new User;
    $user->email = Input::get('email');
    $user->password = Hash::make(Input::get('password'));
    if ($user->save()) {
      return Redirect::to('createUser')->with('msg', "User created!");
    }
    return Redirect::to('createUser')->with('msg', "User not created!");

  }


}


?>
