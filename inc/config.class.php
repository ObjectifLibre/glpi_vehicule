<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginVehiculeConfig extends Config {


   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
      if ($item->getID() > 0) {
         return self::createTabEntry('Vehicule');
      }
   }



   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
      if ($item->getID() > 0) {
         $pvConfig = new self();
         $pvConfig->showForm($item->getID());
      }
      return TRUE;
   }



    /**
    * Show profile form
    *
    * @param $items_id integer id of the profile
    * @param $target value url of target
    *
    * @return nothing
    **/
   function showForm($profiles_id=0, $openform=TRUE, $closeform=TRUE) {
      global $CFG_GLPI;

      if (!self::canView()) {
         return false;
      }
      $canedit = Session::haveRight(self::$rightname, UPDATE);
      if ($canedit) {
         echo "<form name='form' action=\"".Toolbox::getItemTypeFormURL('Config')."\" method='post'>";
      }

      $conf = Config::getConfigurationValues('plugin_vehicule');
      echo "<div class='center' id='tabsbody'>";
      echo "<table class='tab_cadre_fixe'>";

      echo "<tr><th colspan='4'>" . __('Vehicule', 'vehicule') . "</th></tr>";
      echo "<tr class='tab_bg_2'>";
      echo "<td>" . __('test') . "</td>";
      echo "<td colspan='3'>";
      Dropdown::showYesNo('test', $conf['test']);
      echo "</td></tr>";

      if ($canedit) {
         echo "<tr class='tab_bg_2'>";
         echo "<td colspan='6' class='center'>";
         echo Html::hidden('config_context', array('value' => 'plugin_vehicule'));
         echo "<input type='submit' name='update' class='submit' value=\""._sx('button', 'Save')."\">";
         echo "</td></tr>";
      }

      echo "</table></div>";
      Html::closeForm();
   }



   /**
    * Init config
    *
    **/
   static function initConfig() {

      Config::setConfigurationValues('plugin_vehicule', array('test' => 1));

   }



   static function uninstallConfig() {
      Config::deleteConfigurationValues('plugin_vehicule', array('test'));
   }
}

?>
