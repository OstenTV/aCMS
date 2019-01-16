<?php

if (($_POST['allow']) && (isset($_POST['return'])))
{
	setcookie("allow", true, time() + 315569520);
    header('Location: /?view='.$_POST['return']);
}

?>