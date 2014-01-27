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
    <div>
      @foreach($messages as $message)
	<h2>
	  From: {{ Player::find($message->sender)->pseudonym }}
	</h2>
	<p>
	  {{ $message->message }}
	</p>

	<h2>
	  Respond
	</h2>

	{{ Form::open(
	    array('url' => 'messages/' . $message->game_id)
	  ) }}

	<p>
	  {{ Form::label('message', 'Message:') }}
	  {{ Form::textarea('message') }}
	</p>

	{{ Form::hidden('reciever', $message->sender) }}

	<p>
	  {{ Form::submit() }}
	</p>
	
	{{ Form::close() }}
      @endforeach
    </div>

  </body>
</html>
