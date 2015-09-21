<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>
	<form action="includes/checklogin.php" method="post" id="login_form">
		username <input type="text" name="username" />
	    password <input type="password" name="password" />
        <input type="submit" value="go" />
	</form>
    <hr />
    <form action="includes/register.php" method="post" id="login_form">
		first <input type="text" name="fname" />
	    last <input type="text" name="lname" />
        username <input type="text" name="username" />
	    password <input type="password" name="password" />
        <input type="submit" value="go" />
	</form>
</body>
</html>