
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
    <script src="//durov.at/js/openapi_sample.js"></script>
  </head>
  <body>
    <div id="vk_api_transport"></div>
    <script type="text/javascript">
      window.vkAsyncInit = function() {
        VK.Auth.getLoginStatus(function(response) {
          if (response.session) {
               console.log( JSON.stringify(response) );
         window.location = baseURL + '/index.php/goal/dashboard';
          } else {
            VK.UI.button('vk_login');
          }
        });
		
        VK.Observer.subscribe('auth.login', function(response) { 
            console.log( JSON.stringify(response) );
          window.location = baseURL + '/yourgoal/index.php/goal/dashboard';
        });
		
        VK.Observer.subscribe('auth.logout', function() {
          //console.log('logout');
        });
        VK.Observer.subscribe('auth.statusChange', function(response) {
          //console.log('statusChange');
        });
        VK.Observer.subscribe('auth.sessionChange', function(r) {
          //console.log('sessionChange');
        });

        VK.init({
          apiId: 4657192,
          nameTransportPath: '/xd_receiver.html'
        });
        VK.UI.button('vk_login');
      };
      setTimeout(function() {
        var el = document.createElement('script');
        el.type = 'text/javascript';
        el.src = '//vk.com/js/api/openapi.js?3';
        el.async = true;
        document.getElementById('vk_api_transport').appendChild(el);
      }, 0);
    </script>
    <div id="openapi_header">
      <div id="openapi_title">External Site Example<p style="margin:3px 0px 0px; font-size: 11px; color:#CDD9E4">Using VK <span style="color:#FFF">Open API</span></p></div>
      <div style="clear:both;"></div>
    </div>
    <div id="openapi_login_wrap">
      <div style="margin: 5px 0pt 20px; font-weight: normal; text-align: justify;" class="dld">This page demonstrates an example of a site that was created using <b>VK Open API</b>. If you are registered on <b>VK</b> then when clicking on the <b>VK Log In</b> button, you will be automatically authorized on this site.</div>
      <div id="vk_login" style="margin: 0 auto 20px auto;" onclick="doLogin();"></div>
    </div>
  </body>
</html>