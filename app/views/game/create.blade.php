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

    {{ Form::open(array('url' => 'createGame')) }}

    <p>
      {{ Form::label('password', 'Game Password:') }}
      {{ Form::text('password') }}
    </p>

    <p>
      {{ Form::submit() }}
    </p>
    
    {{ Form::close() }}
    
  </body>  
</html>
