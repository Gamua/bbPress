<p class="login">Welcome, Guest | 
<?php
printf(
	__( '<a href="%1$s">Login</a> | <a href="%2$s">Register</a>' ),
	bb_get_uri( 'bb-login.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_USER_FORMS ),
	bb_get_uri( 'register.php', null, BB_URI_CONTEXT_A_HREF + BB_URI_CONTEXT_BB_USER_FORMS )
);
?>
</p>