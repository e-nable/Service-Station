<?php

require_once('backend.php');

// this not-only starts the session, but will accept the user form submission stuff
start_user_session( $assemblervars);

$render = render( $assemblervars);

// The idea is to invoke the Render method asynchronously so we can cherry pick out the image and be done with it!
echo $render
?>

<?php printHeaderSessionVariables(); ?>



