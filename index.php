<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = ''; // your client id
$clientSecret = ''; // your client secret
$redirectUri = 'https://messages.google.com/web/';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Redirect to messages page
    header('Location: $redirectUri');
    exit();
} else {
?>
    <div class="container">
        <h3 class="text-center">Login using Google with PHP</h3>
        <div class="panel panel-default">
            <div class="panel-body">
                <form>
                   <!--  <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="pwd" id="pwd" placeholder="Enter Password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" id="login" name="login" value="Login" class="btn btn-success form-control"/>
                    </div> -->
                    <hr>
                    <center><a href="<?php echo $client->createAuthUrl(); ?>"><img src="https://developers.google.com/static/identity/images/branding_guideline_sample_lt_sq_lg.svg" width="256"></a></center>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
</body>
</html>
