<?php

class MessagesController extends BaseController {

  public function index() {
    return View::make('messages.index', array('games' => Game::where('started', true)->get()));
  }

  public function forGame($gameID) {
    return View::make('messages.game',
                      array('messages' => ApiMessage::where('game_id', $gameID)->where('reciever', 0)->get()));
  }

  public function save($gameID) {
    $message = new ApiMessage;
    $message->game_id = $gameID;
    $message->message = Input::get('message');
    $message->sender = 0;
    $message->reciever = Input::get('reciever');
    if($message->save()) {
      return Redirect::to('messages/' . $gameID)->with(array('msg' => 'Did it!'));
    } else {
      return Redirect::to('messages/' . $gameID)->with(array('msg' => 'Didn\'t it!'));
    }
  }

}

?>
