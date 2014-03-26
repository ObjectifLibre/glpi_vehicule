<?php

include ('../../../inc/includes.php');

Html::header("plugin vehicule titre", $_SERVER['PHP_SELF'],"assets","pluginvehiculevehicule","vehicule");

Session::checkRight("plugin_vehicule_vehicule", READ);

Search::show('PluginVehiculeVehicule');

Html::footer();
?>

