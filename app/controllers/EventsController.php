<?php

class EventsController extends BaseController {

  public function create() {
    return View::make('events.create');
  }

  public function save() {
    $event = new ApiEvent;
    $event->description = Input::get('description');
    $event->game_id = Input::get('game_id');
    if ($event->save()) {
      return Redirect::to('event/create')->with('message', 'Made it');
    }
    else {
      return Redirect::to('event/create')->with('message', "Couldn't make it");
    }
  }

}

?>
