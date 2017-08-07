<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link href="{{ asset('/css/header.css') }}" rel="stylesheet">
      </head>
      <body>
          @include('layouts.header')
          <h1>Home Page</h1>
          <h5>Home page contents</h5>
      </body>
</html>
