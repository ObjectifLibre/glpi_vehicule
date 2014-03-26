<?PHP

function plugin_vehicule_install() {
   global $DB;

   if (!TableExists("glpi_plugin_vehicule_vehicules")) {
            $query = "CREATE TABLE `glpi_plugin_vehicule_vehicules` (
                  `id` int(11) NOT NULL auto_increment,
                  `entities_id` int(11) NOT NULL DEFAULT '0',
                  `is_recursive` tinyint(1) NOT NULL DEFAULT '1',
                  `name` varchar(255) collate utf8_unicode_ci default NULL,
                  `serial` varchar(255) collate utf8_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

      $DB->query($query) or die("error creating glpi_plugin_vehicule_vehicules ". $DB->error());
   }

   return TRUE;
}



// Uninstall process for plugin : need to return TRUE if succeeded
function plugin_vehicule_uninstall() {
   global $DB;

   if (TableExists("glpi_plugin_vehicule_vehicules")) {
      $query = "DROP TABLE `glpi_plugin_vehicule_vehicules`";
      $DB->query($query) or die("error deleting glpi_plugin_vehicule_vehicules ". $DB->error());
   }
}

?>
