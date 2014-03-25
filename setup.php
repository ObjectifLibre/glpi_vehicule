<?php

define ("PLUGIN_VEHICULE_VERSION", "0.85+1.0");

include_once(GLPI_ROOT."/inc/includes.php");

// Init the hooks of vehicule
function plugin_init_vehicule() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['vehicule'] = true;

   Plugin::registerClass('PluginVehiculeVehicule');

   $PLUGIN_HOOKS['menu_toadd']['vehicule'] = array('assets' => 'PluginVehiculeVehicule');

}



// Name and Version of the plugin
function plugin_version_vehicule() {
   return array('name'           => 'Vehicule',
                'shortname'      => 'vehicule',
                'version'        => PLUGIN_VEHICULE_VERSION,
                'license'        => 'AGPLv3+',
                'author'         =>'',
                'homepage'       =>'http://',
                'minGlpiVersion' => '0.85'
   );
}



// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_vehicule_check_prerequisites() {
   global $DB;

   if (version_compare(GLPI_VERSION, '0.85', 'lt') || version_compare(GLPI_VERSION, '0.86', 'ge')) {
      echo __('Your GLPI version not compatible, require 0.85', 'vehicule');
      return FALSE;
   }
   return TRUE;
}



function plugin_vehicule_check_config() {
   return TRUE;
}

?>
