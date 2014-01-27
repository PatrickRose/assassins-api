<?php

class GameController extends Controller {

  public function messageAdmin() {
    $game = Game::find(Input::get('gameID'));
    if (!$game) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game not found"
        ),
        400
      );
    }
    $message = new ApiMessage;
    $message->reciever = Input::has('reciever') ? Input::get('reciever') : 0;
    $message->sender = Input::get('sender');
    $message->game_id = Input::get('gameID');
    $message->message = Input::get('message');
    if ($message->save()) {
      return Response::json(
        array(
          'error' => false,
          'message' => $message->toArray()
        ),
        200
      );
    } else {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Couldn't save to database"
        ),
        400
      );
    }
  }

  public function showGameInfo($game) {
    return View::make('game.gameInfo')->with('game', $game);
  }

  public function joinGame() {
    $game = Game::find(Input::get('gameID'));
    if (!$game) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game not found"
        ),
        400
      );
    }
    if (Input::get('gamePassword') != $game->password) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game password is incorrect"
        ),
        401
      );
    }
    if ($game->started) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game has already started",
        ),
        400
      );
    }
    $player = new Player();
    //Player attributes
    // Pseudonym, Real Name, Course and department, Year,
    // allergies, water (dropdown box) and picture
    $player->name = Input::get('name');
    $player->pseudonym = Input::get('pseudonym');
    $player->course = Input::get('course');
    $player->department = Input::get('department');
    $player->year = Input::get('year');
    $player->allergies = Input::get('allergies');
    $player->water = Input::get('water');
    $player->address = Input::get('address');
    $player->gameID = $game->id;
    $player->alive = true;
    $player->user_id = Input::get('userID');

    $validator = Validator::make($player->toArray(), $player::$rules);
    if ($validator->fails()) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Validation did not pass",
          'errors' => $validator->messages()->toArray()
        ),
        400
      );
    }
    if (Input::hasFile('photo')) {
      if ($player->save()) {
        $file = Input::file('photo');
        $destination = 'public/' . $game->id;
        $filename = $player->id . '.jpg';
        $file->move($destination, $filename);
        return Response::json(
          array(
            'error' => false,
            'player' => $player->toArray()
          ),
          200
        );
      }
    }
    else {
      return Response::json(
        array(
          'error' => true,
          'problem' => "You didn't upload a picture"
        ),
        400
      );
    }
    return Response::json(
      array(
        'error' => true,
        'problem' => 'Your details could not be saved'
      ),
      400
    );
  }

  public function getEvents() {
    $game = Game::find(Input::get('gameID'));
    if (!$game) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game not found"
        ),
        400
      );
    }
    if ($game->started) {
      $events = DB::table('events')->where('game_id', '=', Input::get('gameID'))->orderBy('created_at', 'desc')->take(10)->get();
      return Response::json(
        array(
          'error' => false,
          'events' => $events
        ),
        200
      );
    }
    return Response::json(
      array(
        'error' => true,
        'problem' => "Game not yet started"
      )
    );

  }

  public function getGameInfo() {
    $game = Game::find(Input::get('gameID'));
    if (!$game) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game not found"
        ),
        400
      );
    }
    $finished = $game->finished();
    if ($game->started) {
      $player = Player::find(Input::get('player'));
      if (!$player) {
        return Response::json(
          array(
            'error' => true,
            'problem' => "Couldn't find you"
          )
        );
      }
      if ($player->alive) {
        $kills = Kill::where('gameID', $game->id)->where('killee', $player->id)->get();
        foreach($kills as $kill) {
          $kill->pseudonym = Player::find($kill['killer'])->pseudonym;
        }
        $target = $player->findTarget()->toArray();
        $target['picture'] = asset('public/' . $game->id . '/' . $target['id'] . '.jpg');
        if ($target['id'] == $player->id) {
          $game->started = false;
          $game->save();
        }
        $messages = ApiMessage::where('game_id', $game->id)->where('reciever', $player->id)->where('read', 0)->get();
        foreach($messages as $message) {
          $message->read = true;
          $message->save();
        }
        $events = DB::table('events')->where('game_id', '=', Input::get('gameID'))->orderBy('created_at', 'desc')->take(10)->get();
        $game = $game->toArray();
        $game['finished'] = $finished;
        return Response::json(
          array(
            'error' => false,
            'game' => $game,
            'target' => $target,
            'kill' => $kills->toArray(),
            'events' => $events,
            'player' => $player->toArray(),
            'messages' => $messages->toArray()
          ),
          200
        );
      }
      $game = $game->toArray();
      $game['finished'] = $finished;
      return Response::json(
        array(
          'error' => false,
          'game' => $game,
          'player' => $player->toArray(),
          'target' => false,
        ),
        200
      );
    }
    $game = $game->toArray();
    $game['finished'] = $finished;
    return Response::json(
      array(
        'error' => false,
        'game' => $game
      ),
      200
    );
  }

  public function submitReport() {
    $game = Game::find(Input::get('gameID'));
    if (!$game) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Game not found"
        ),
        404
      );
    }
    if (Input::has('death')) {
      $kill = Kill::where('killee', Input::get('player'))->where('killer', Input::get('killer'))->where('gameID', $game->id)->get()->first();
      if (!$kill) {
        return Response::json(
          array(
            'error' => true,
            'problem' => "Kill report not found"
          ),
          404
        );
      }
      $kill->confirmed = true;
      $kill->save();
      $killed = Player::find(Input::get('player'));
      $killed->alive = false;
      $killed->save();
      $killer = Player::find($kill->killer);
      $event = new ApiEvent;
      $event->game_id = $game->id;
      $event->description = $killer->pseudonym . " killed " . $killed->pseudonym . ": " . $kill->description;
      $event->save();
      return Response::json(
        array(
          'error' => false,
          'kill' => $kill->toArray()
        ),
        200
      );
    }
    if (Input::has('delete')) {
      $kill = Kill::where('killee', Input::get('player'))->where('killer', Input::get('killer'))->where('gameID', $game->id)->get()->first();
      if (!$kill->delete()) {
        return Response::json(
          array(
            'error' => true,
            'problem' => 'Failed to delete kill'
          ),
          400
        );
      }
      $message = new ApiMessage;
      $message->game_id = $game->id;
      $message->reciever = Input::get('killer');
      $player = Player::find(Input::get('player'));
      $message->message = "KILL REPORT DENIED. " . $player->pseudonym . " disagreed that they were dead";
      $message->save();
      return Response::json(
        array(
          'error' => false,
          'message' => $message->toArray()
        ),
        200
      );
    }
    if (Input::has('kill')) {
      $kill = new Kill();
      $kill->killer = Input::get('killer');
      $kill->killee = Input::get('killed');
      $kill->description = Input::get('description');
      $kill->gameID = $game->id;
      $kill->confirmed = false;
      if ($kill->save()) {
        return Response::json(
          array(
            'error' => false,
            'kill' => $kill->toArray()
          ),
          200
        );
      }
      return Response::json(
        array(
          'error' => true,
          'problem' => "Couldn't save to database"
        ),
        200
      );
    }
    return Response::json(
      array(
        'error' => true,
        'problem' => "Didn't specify if it was a kill or death report"
      ),
      400
    );
  }

  public function getAll() {
    $games = Game::all();
    return Response::json(
      array(
        'error' => false,
        'games' => $games->toArray()
      ),
      200
    );

  }

  public function startGame($game) {
    if ($game->started) {
      return Response::json(
        array(
          'error' => true,
          'problem' => 'This game has already started',
          'game' => $game->toArray(),
          'players' => $game->players->toArray()
        ),
        400);
    }
    if ($game->players()->count() < 2) {
      return Response::json(
        array(
          'error' => true,
          'problem' => 'Game too small',
          'game' => $game->toArray(),
        ),
        400);
    }
    $players = $game->players;
    $ids = array();
    foreach($players as $player) {
      $ids[] = $player->id;
    }
    shuffle($ids);
    $circleID = 1;
    foreach($ids as $id) {
      $player = Player::find($id);
      $player->circleID = $circleID;
      $circleID = $circleID + 1;
      if (!$player->save()) {
        return Response::json(
          array(
            'error' => true,
            'problem' => "Couldn't save player",
            'player' => $player->toArray()
          ),
          200
        );
      }
    }
    $game->started = true;
    $game->save();
    return Response::json(
      array(
        'error' => false,
        'game' => $game->toArray(),
        'players' => $game->players->toArray()
      ),
      200
    );
  }

  public function leaveGame() {
    $user = User::find(Input::get('userID'));
    if (!$user) {
      return Response::json(
        array(
          'error' => true,
          'problem' => "Couldn't find you"
        ),
        404);
    }
    if($user->player->delete()) {
      return Response::json(
        array(
          'error' => false,
          'message' => "Removed you from the game!"
        ),
        200);
    }
    return Response::json(
      array(
        'error' => true,
        'problem' => "Couldn't delete players"
      ),
      400);


  }

  public function create() {
    return View::make('game.create');
  }

  public function save() {
    $game = new Game;
    $game->password = Input::get('password');
    if($game->save()) {
      return Redirect::to('createGame')->with(array('msg' => 'Did it!'));
    } else {
      return Redirect::to('createGame')->with(array('msg' => 'Didn\'t it!'));
    }

  }

}

?>
