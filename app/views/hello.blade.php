<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
  </head>
  <body>

    <h1>
      Admin Panel
    </h1>

    <ul>
      <li>
        {{ link_to('createUser', 'Create a User') }}
      </li>
      <li>
        {{ link_to('event/create', "Create an event") }}
      </li>
      <li>
        {{ link_to('messages', "Create/View a message") }}
      </li>
      <li>
	{{ link_to('games/create', "Create a game") }}
      </li>
    </ul>

    <ul>
      @foreach(Game::all() as $game)
      <li>
        <ul>
          <li>
            {{ link_to('game/' . $game->id, "Game info!") }}
          </li>
          @if(!$game->started)
            @if(!$game->finished())
              <li>
		{{ link_to('start/' . $game->id, "Start game!") }}
              </li>
            @endif
          @endif
        </ul>
      </li>
      @endforeach
    </ul>

  </body>
</html>
