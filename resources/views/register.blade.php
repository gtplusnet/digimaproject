<!DOCTYPE html>
<html>
    <head>
        <title>Digima Timer</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/login.css ">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


        <div class="container">
            <div class="row vertical-offset-100">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Create Account</h3>
                        </div>
                        
                        @if (count($errors) > 0)
                        <div class="error-container">
                            <div class="alert alert-danger">
                                @foreach ($errors as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                        @endif
                     
                        <div class="panel-body">
                            <form method="post" accept-charset="UTF-8" role="form">
                                <fieldset>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" type="text">
                                    </div> 
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" type="text">
                                    </div> 
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email_address" value="{{ old('email_address') }}"type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" type="text">
                                    </div> 
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" value="{{ old('password') }}" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" value="">
                                    </div>
                                    <input class="btn btn-success btn-block" type="submit" value="Create Account">
                                    <input class="btn btn-default btn-block" onclick="location.href='/login'" type="button" value="&laquo; Back to Login">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>