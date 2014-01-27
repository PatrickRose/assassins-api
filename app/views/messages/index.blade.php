<!doctype html>
<html>
  <head>
    <title>
      Messages
    </title>
  </head>
  <body>
    @if(Session::has('msg'))
      <div class='alert'>
	<h2>{{ Session::get('msg') }}</h2>
      </div>
    @endif
    <h1>All Messages</h1>

    <ul>
      @foreach($games as $game)
	<li>
	  {{ link_to('messages/' . $game->id,
		     'Messages for game ' .  $game->id) }}
	</li>
      @endforeach
    </ul>
    
  </body>  
</html>
