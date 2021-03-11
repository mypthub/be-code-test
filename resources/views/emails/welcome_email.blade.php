<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UMS</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 34px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                   Hi {{$user->name}}
                </div>
                <div>
                    <h4>{{$user->email}}</h4>
                    <h3>Wel-come Here.</h3>
                    <h3>Your organisation register successfully.</h3>
                    <h3>Please confirm organisation details:</h3>
                    <div>
                        <p><label>Organisation Name - </label>{{$organisation->name}}</p>
                        <p><label>Organisation Subscription - </label>
                            {{($organisation->subscribed==1 ? 'Subscribed':'30 Days Trial')}}</p>
                        @if(!$organisation->subscribed)
                        <p><label>Subscription Last Date - </label>{{$organisation->trial_end}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
