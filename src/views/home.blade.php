<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
      <div class="header">
          <ul>
            <li><a class="active" href="home">Home</a></li>
            <li><a href="logout">Logout</a></li>
          </ul>
      </div>
      <div class="flex-center position-ref full-height">
          <div class="content">
              <div class="title m-b-md">
                  Laravel JWT Starter
              </div>
          </div>
      </div>
    </body>
</html>
