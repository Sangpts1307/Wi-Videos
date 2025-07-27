@extends('master')
@section('content')
<div id="login-form" class="col-md-2 col-md-offset-5">
    <div class="row">
        <div class="col-md-12">
            <h3>Đăng nhập WiVideo</h3>
        </div>
        <div class="col-md-6 fb-button-wrapper">
            <!-- <fb:login-button 
            scope="public_profile,email"
            onlogin="checkLoginState();" id="btn_facebook_login">
            </fb:login-button> -->

            <fb:login-button 
                scope="public_profile,email" 
                onlogin="checkLoginState();" 
                id="btn_facebook_login"
                size="large"
                layout="default"
                button-type="login_with"
                use-continue-as="false">
            </fb:login-button>

            <!-- <img src="assets/images/facebook.png" alt=""> -->
        </div>
        <div class="col-md-6">
            <a
                href="https://accounts.google.com/o/oauth2/v2/auth?client_id={{ env('GOOGLE_CLIENT_ID') }}&redirect_uri={{ env('GOOGLE_REDIRECT_URI') }}&response_type=code&scope=openid%20email%20profile&access_type=offline">
                <img src="{{  asset('assets/images/google_ico.png') }}" alt="">
            </a>
        </div>
    </div>
</div>

<!-- Script trong đăng nhập bằng facebook -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1734841980470643',
      cookie     : true,
      xfbml      : true,
      version    : 'v23.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            // Call to server create session
            window.location.href = "http://localhost/wivideo/public/social-login-callback/facebook?token=" + response.authResponse.accessToken;
        });
    }
</script>

<style>
/* Bọc fb button lại để dễ xử lý */
.fb-button-wrapper {
    margin-top: 30px;
    padding-right: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

/* Ép chiều rộng và chiều cao iframe render bởi Facebook */
.fb-button-wrapper iframe {
    transform: scale(1.6); 
    transform-origin: top left;
}


</style>
@endsection