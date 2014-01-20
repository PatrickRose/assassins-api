<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Laravel PHP Framework</title>
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    </head>
    <body>

        <div class='container'>

            <div class='row'>
		<p></p>
		<p></p>

                {{ Bootstrapper\Carousel::create(array(
                      array (
                          'image' => "http://farm4.staticflickr.com/3832/11552763145_013d6d2da2.jpg",
                          "label" => "sdf",
                          "caption" => ""
		      ),
                      array (
                          'image' => "http://farm6.staticflickr.com/5506/11550256893_8e3ed6a5f9.jpg",
                          "label" => "asdlfkasmdlfk",
                          "caption" => ""
		      )
                  ))->prev('<span class="glyphicon glyphicon-chevron-left"></span>')->next('<span class="glyphicon glyphicon-chevron-right"></span>') }}

            </div>

        </div>

    </body>
</html>
