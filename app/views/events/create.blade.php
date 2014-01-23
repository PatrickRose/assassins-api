<!doctype html>
<html>
  <head>
    <title>
      Making events
    </title>
  </head>
  <body>
    @if(Session::has('message'))
      <div class='alert'>
	<h2>{{ Session::get('message') }}</h2>
      </div>
    @endif
    <h1> Create Event</h1>

    {{ Form::open(array('url' => 'event')) }}

    <p>
      {{ Form::label('description', 'Event Description:') }}
      {{ Form::text('description') }}
    </p>

    <p>
      {{ Form::label('game_id', 'Game ID:') }}
      {{ Form::text('game_id') }}
    </p>

    <p>
      {{ Form::submit() }}
    </p>
    
    {{ Form::close() }}
    
  </body>  
</html>
