<?php

if (!isset($_COOKIE['loggedUser']) ) { 
    header('Location:auth/login?err=3');
 }

?>