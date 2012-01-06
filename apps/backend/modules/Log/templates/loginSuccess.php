<h1>Sign In</h1>
<hr/>
<br/>
Please enter your E-mail and Password to access your account.
<br/><br/>

<?php include_component('Generic', 'form', array
      (
        'form'          => $form,
        'action_uri'    => '@log_login',
        'styles_folder' => 'log',
        'submit'        => 'Sign In',
        'with_title'    => false
      ))
?>
