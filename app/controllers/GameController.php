<?php

class GameController extends Controller {

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
        $player->gameID = $game->id;
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
            $events = $game->events->orderBy('createdAt', 'desc')->take(5)->get();
            return Response::json(
                array(
                    'error' => false,
                    'events' => $events->toArray()
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
            $target = $player->findTarget()->toArray();
            $target['picture'] = asset($game->id . '/' . $target->id . 'jpg');
            $target = $target->id == $player->id ? false : $target;
            return Response::json(
                array(
                    'error' => false,
                    'game' => $game->toArray(),
                    'target' => $target
                )
            );
        }
        return Response::json(
            array(
                'error' => false,
                'game' => $game->toArray()
            )
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
            $kill = Kill::where('killed', Input::get('player'));
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
            $player = Player::find(Input::get('player'));
            $player->alive = false;
            $player->save();
            return Response::json(
                array(
                    'error' => false,
                    'kill' => $kill->toArray()
                ),
                200
            );
        }
        if (Input::has('kill')) {
            $kill = new Kill();
            $kill->killer = Input::get('killer');
            $kill->killed = Input::get('killed');
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
}

?>
