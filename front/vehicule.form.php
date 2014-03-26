<?php


include ('../../../inc/includes.php');

Session::checkRight("plugin_vehicule_vehicule", READ);

if (!isset($_GET["id"])) {
   $_GET["id"] = "";
}

$vehicule = new PluginVehiculeVehicule();

if (isset($_POST["add"])) {
   $vehicule->check(-1, CREATE, $_POST);
   if ($newID = $vehicule->add($_POST)) {
      Event::log($newID, "vehicules", 4, "inventory",
                 sprintf(__('%1$s adds the item %2$s'), $_SESSION["glpiname"], $_POST["name"]));

      if ($_SESSION['glpibackcreated']) {
         Html::redirect($vehicule->getFormURL()."?id=".$newID);
      }
   }
   Html::back();

// delete a vehicule
} else if (isset($_POST["delete"])) {
   $vehicule->check($_POST['id'], DELETE);
   $ok = $vehicule->delete($_POST);
   if ($ok) {
      Event::log($_POST["id"], "vehicules", 4, "inventory",
                 //TRANS: %s is the user login
                 sprintf(__('%s deletes an item'), $_SESSION["glpiname"]));
   }
   $vehicule->redirectToList();

} else if (isset($_POST["restore"])) {
   $vehicule->check($_POST['id'], PURGE);
   if ($vehicule->restore($_POST)) {
      Event::log($_POST["id"],"vehicules", 4, "inventory",
                 //TRANS: %s is the user login
                 sprintf(__('%s restores an item'), $_SESSION["glpiname"]));
   }
   $vehicule->redirectToList();

} else if (isset($_POST["purge"])) {
   $vehicule->check($_POST['id'], PURGE);
   if ($vehicule->delete($_POST,1)) {
      Event::log($_POST["id"], "vehicules", 4, "inventory",
                 //TRANS: %s is the user login
                 sprintf(__('%s purges an item'), $_SESSION["glpiname"]));
   }
   $vehicule->redirectToList();

//update a vehicule
} else if (isset($_POST["update"])) {
   $vehicule->check($_POST['id'], UPDATE);
   $vehicule->update($_POST);
   Event::log($_POST["id"], "vehicules", 4, "inventory",
              //TRANS: %s is the user login
              sprintf(__('%s updates an item'), $_SESSION["glpiname"]));
   Html::back();

} else {//print vehicule information
   Html::header(Computer::GetTypeName(2), $_SERVER['PHP_SELF'], "assets", "vehicule");
   //show vehicule form to add
   $vehicule->display(array('id'           => $_GET["id"]));
   Html::footer();
}


?>
