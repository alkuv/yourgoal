function subcribe(goalid,listid)
{
   
  var login_id =jQuery("#user_login").val();
  if(login_id=="no")
  {
      var r = confirm("Please Login to Subscribe!");
        if (r == true) 
        {
             window.location.href="";
        }
  }
  else 
  {
  alert("Here we do ajax subscribe");
  }
   
}