<!doctype html>
<html>
  <head>
    <title>
      Making Players
    </title>
  </head>
  <body>
    @if(Session::has('msg'))
      <div class='alert'>
	<h2>{{ Session::get('msg') }}</h2>
      </div>
    @endif
    <h1> Create Event</h1>

    {{ Form::open(array('url' => 'createUser')) }}

    <p>
      {{ Form::label('email', 'Email:') }}
      {{ Form::text('email') }}
    </p>

    <p>
      {{ Form::label('password', 'Password:') }}
      {{ Form::password('password') }}
    </p>

    <p>
      {{ Form::submit() }}
    </p>
    
    {{ Form::close() }}
    
  </body>  
</html>
