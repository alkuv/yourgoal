<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>

<div id="login_button" onclick="VK.Auth.login(authInfo);"></div>

<script language="javascript">
VK.init({
  apiId: 4632986
});
function authInfo(response) {

  if (response.session) {
    alert('user: '+response.session.mid);
      console.log( JSON.stringify(response) );
	alert(response.session.user.first_name);
	alert(response.session.user.last_name);
	window.location = baseURL + '/yourgoal/index.php/goal/dashboard';
	 
  } else {
    alert('not auth');
	VK.UI.button('login_button');
  }
}
VK.Auth.getLoginStatus(authInfo);
VK.UI.button('login_button');
</script>