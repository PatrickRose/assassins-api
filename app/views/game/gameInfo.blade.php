<!doctype html>
<html>
  <head>
    <title>
      Game Info
    </title>
  </head>
  <body>
    @if(Session::has('msg'))
      <div class='alert'>
        <h2>{{ Session::get('msg') }}</h2>
      </div>
    @endif
    <h1>Game Info</h1>

    @foreach($game->players as $player)
      <h3>{{ $player->pseudonym }} ({{ $player->name }})</h3>
      <ul>
        @foreach($player->toArray() as $key => $value)
          <li>{{ $key }} : {{ $value }}</li>
        @endforeach
      </ul>
    @endforeach

  </body>
</html>
