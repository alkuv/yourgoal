<header class="siteHeader">
<?php $fb_app_id = Yii::app()->params['fb_app_id']; ?>

                <div class="section-wrapper clearfix">

                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/home'); ?>" class="header-logo beta-label">YOUR<span class="yellow">GOAL</span></a>

                    <span class="header-explanation"><?php echo Yum::t("Сервис для достижения целей");?></span>

                    <div class="loginBox">

                        <div class="login-panel">
                            <?php 
                                if(Yii::app()->user->isGuest):
                            ?>
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("/user/login"); ?>" class="login-panel-link"><?php echo Yum::t("Войти");?></a> / 
                                            <?php echo CHtml::link(Yum::t("Регистрация"),
                                                            Yum::module('registration')->registrationUrl, array('class'=>"login-panel-link") );
                                elseif(!Yii::app()->user->isGuest):
                            ?>
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("/goal/dashboard"); //echo Yii::app()->createAbsoluteUrl("/profile/profile/view"); ?>" class="login-panel-link"><?php echo Yum::t("My Account"); ?></a> / 
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("/user/user/logout"); ?>" class="login-panel-link"><?php echo Yum::t("logout"); ?></a>/
<!--                                    <a href="<?php  ?>" class="login-panel-link">DB</a> -->
                            <?php 
                                endif;
                                
                            ?>

                        </div>

                        <div class="socials clearfix">
<?php $baseurl = Yii::app()->request->baseUrl; ?>
<!--                            <a href="" class="social-btn"></a>-->
							<a href="javascript:void(0);" id="login_button1" onclick="VK.Auth.login(authInfo);" class="social-btn vk"></a>
                            <a href="<?php echo Yii::app()->createUrl("user/auth/Google_login") ?>" class="social-btn gg"></a>
                            <a onclick="login('<?php echo $baseurl ?>/index.php/user/auth/facebooklogin'); return false;" href="#" class="social-btn fb"></a>

                            <a href="<?php echo Yii::app()->createUrl("user/auth/twitter") ?>" class="social-btn tw"></a>
                            

                        </div>

                    </div>

                </div>
                <?php    if(isset (Yii::app()->user->id)) {?> 
				<input type="hidden" id="user_login" value="<?php echo Yii::app()->user->id;?>"/>
				<?php } else { ?>
                                <input type="hidden" id="user_login" value="no"/>
                                <?php } ?>
            </header>

<!-- facebook login script ---->

<div id="fb-root"></div><script src="//connect.facebook.net/en_US/all.js"></script><script type="text/javascript">
//<![CDATA[

    window.fbAsyncInit = function() {
        FB.init({
            appId: "<?php echo $fb_app_id; ?>", // App ID
            channelURL: '/channel.html', // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            oauth: true, // enable OAuth 2.0
            xfbml: true  // parse XFBML
        });


        // Checks whether the user is logged in
        FB.getLoginStatus(function(response) {
            if (response.authResponse) {
                // logged in and connected user, someone you know
                // alert('You are connected');
            } else {
                // no user session available, someone you dont know
                // alert('You are disconnected');
            }
        });

        FB.Event.subscribe('auth.authResponseChange', function(response) {
            if (response.authResponse) {
                // the user has just logged in
                // alert('You just logged in facebook from somewhere');
            } else {
                // the user has just logged out
                // alert('You just logged out from faceboook');
            }
        });

        // Other javascript code goes here!

    };

    // logs the user in the application and facebook
    function login(redirection) {
        FB.login(function(response) {
            if (response.authResponse) {
                // user is logged in
                // console.log('Welcome!');
                if (redirection != null && redirection != '') {
                    top.location.href = redirection;
                }
            } else {
                // user could not log in
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'email'});
    }

    // logs the user out of the application and facebook
    function logout(redirection) {
        FB.logout(function(response) {
            // user is logged out
            // redirection if any
            if (redirection != null && redirection != '') {
                top.location.href = redirection;
            }
        });
    }

    // Load the SDK Asynchronously
    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol
                + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
//]]>
</script>

<!--- end script --->
<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
<script language="javascript">
VK.init({
  apiId: 4657192 
});
function authInfo(response) {

  if (response.session) {
    console.log( JSON.stringify(response) );
   // alert('user: '+response.session.mid);
    var userid=response.session.mid;
    var first_name=response.session.user.first_name;
    var last_name=response.session.user.last_name;
//	alert(response.session.user.first_name);
//	alert(response.session.user.last_name);
        window.location = '<?php echo Yii::app()->createAbsoluteUrl("/user/auth/vk"); ?>?userid='+userid+'&first_name='+first_name+'&last_name='+last_name+'';
	
  } else {
    //alert('not auth');
  }
}
VK.Auth.getLoginStatus(authInfo);
VK.UI.button('login_button');
</script>