@extends('master')
@section('content')
    <div id="login-form" class="col-md-2 col-md-offset-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Đăng nhập WiVideo</h3>
            </div>


            <div class="col-md-6">
                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                </fb:login-button>
            </div>
            <div class="col-md-6">


                <a
                    href="https://accounts.google.com/o/oauth2/v2/auth?client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri={{ env('GOOGLE_REDIRECT_URI') }}&response_type=code&scope=openid%20email%20profile&access_type=offline">
                    <img src="{{ asset('assets/images/google_ico.png') }}" alt="">
                </a>

            </div>
        </div>
    </div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '1779936936268752',
                cookie: true,
                xfbml: true,
                version: 'v23.0'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script>
        function checkLoginState() {
        FB.getLoginStatus(function(response) {
            // Call to server create session
            console.log(response);
           window.location.href = "http://localhost/wivideo/public/social-login-callback/facebook?token=" + response.authResponse.accessToken;
        });
    }
    </script>
@endsection
