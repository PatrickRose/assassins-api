<?php

class GameController extends Controller {

    public function joinGame() {
        $game = Game::find(Input::get('gameID'));
        if (!$game) {
            return App::error(404, "Game not found");
        }
        if (Input::get('gamePassword') != $game->password) {
            return App::error(401, "Game password is incorrect");
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
        // Pictures could be strange, ignore for now
        if ($player->save()) {
            return Response::json(
                array(
                    'error' => false,
                    'player' => $player->toArray()
                ),
                200
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

}

?>
