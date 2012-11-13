<header>
	<div class="container">
		<div class="left">
			<a href="http://w4111a.cs.columbia.edu/~smp2183/"><img id="header-logo" src="img/brewcloud-logo.png" alt="brewcloud logo" /></a>
		</div>
		<div class="right">
			<ul>
				<li><a href="#loginModal" role="button" data-toggle="modal">LOGIN</a></li>
				<li><a href="#registerModal" role="button" data-toggle="modal">REGISTER</a></li>
			</ul>
		</div>
	</div>
</header>

<!-- Login -->
<div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="login.php" method="POST">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h1 id="myModalLabel">Login</h1>
	  </div>
	  <div class="modal-body">
    	<div><input type="text" name="username" placeholder="Username" style="height: 28px;"></input></div>
    	<div><input type="password" name="password" placeholder="Password" style="height: 28px;"></input></div>
	  </div>
	  <div class="modal-footer">
	    <button class="btn btn-warning" type="submit">Login</button>
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
  </form>
</div>

<!-- Register -->
<div id="registerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="register.php" method="POST">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h1 id="myModalLabel">Register</h1>
	  </div>
	  <div class="modal-body">
	  	<div><input type="text" name="firstname" placeholder="First Name (Optional)" style="height: 28px;"></input></div>
	  	<div><input type="text" name="lastname" placeholder="Last Name (Optional)" style="height: 28px;"></input></div>
    	<div><input type="email" name="email" placeholder="Email" style="height: 28px;"></input></div>
    	<div><input type="text" name="username" placeholder="Username" style="height: 28px;"></input></div>
    	<div><input type="password" name="password" placeholder="Password" style="height: 28px;"></input></div>
	  </div>
	  <div class="modal-footer">
	    <button class="btn btn-warning">Register</button>
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</form>
</div>