<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
      </head>
      <body>
          <div class="container">
            <div class="title">
              Laravel JWT Starter
            </div>

            {{Form::open (array ('url' => 'logincheck'))}}
            <p> {{Form::email ('email', '', array ('placeholder'=>'Email','maxlength'=>30))}} </p>
            <p> {{Form::password ('password', array('placeholder'=>'Password','maxlength'=>30)) }} </p>
            <p> {{Form::submit ('Submit')}} </p>
            {{Form::close ()}}

            @if ($errors->any ())
              <div class="errors">
                <h2>Errors</h2>
                 @foreach ($errors->all() as $error)
                    <ul>
                      <li>{{ $error }}</li>
                    </ul>
                @endforeach
              </div>
            @endif

            </div>
      </body>
</html>
