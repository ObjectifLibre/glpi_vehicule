<?php

class PluginVehiculeVehicule extends CommonDBTM {

   // Should return the localized name of the type
   static function getTypeName($nb = 0) {
      return 'Vehicule';
   }

   static function getMenuName() {
      return __('Vehicule plugin');
   }

   static function canCreate() {
      return true;
   }


   static function canView() {
      return true;
   }

   
   function getSearchOptions() {

      $tab = array();
      $tab['common'] = "Header Needed";

      $tab[1]['table']     = 'glpi_plugin_example_examples';
      $tab[1]['field']     = 'name';
      $tab[1]['name']      = __('Name');

      $tab[2]['table']     = 'glpi_plugin_example_dropdowns';
      $tab[2]['field']     = 'name';
      $tab[2]['name']      = __('Dropdown');

      $tab[3]['table']     = 'glpi_plugin_example_examples';
      $tab[3]['field']     = 'serial';
      $tab[3]['name']      = __('Serial number');
      $tab[3]['usehaving'] = true;
      $tab[3]['searchtype'] = 'equals';

      $tab[30]['table']     = 'glpi_plugin_example_examples';
      $tab[30]['field']     = 'id';
      $tab[30]['name']      = __('ID');

      return $tab;
   }

   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if (!$withtemplate) {
         switch ($item->getType()) {
            case 'Profile' :
               if ($item->getField('central')) {
                  return __('Example', 'example');
               }
               break;

            case 'Phone' :
               if ($_SESSION['glpishow_count_on_tabs']) {
                  return self::createTabEntry(__('Example', 'example'),
                                              countElementsInTable($this->getTable()));
               }
               return __('Example', 'example');

            case 'ComputerDisk' :
            case 'Supplier' :
               return array(1 => __("Test PLugin", 'example'),
                            2 => __("Test PLugin 2", 'example'));

            case 'Computer' :
            case 'Central' :
            case 'Preference':
            case 'Notification':
               return array(1 => __("Test PLugin", 'example'));

         }
      }
      return '';
   }

   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      switch ($item->getType()) {
         case 'Phone' :
            _e("Plugin Example on Phone", 'example');
            break;

         case 'Central' :
            _e("Plugin central action", 'example');
            break;

         case 'Preference' :
            // Complete form display
            $data = plugin_version_example();

            echo "<form action='Where to post form'>";
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='3'>".$data['name']." - ".$data['version'];
            echo "</th></tr>";

            echo "<tr class='tab_bg_1'><td>Name of the pref</td>";
            echo "<td>Input to set the pref</td>";

            echo "<td><input class='submit' type='submit' name='submit' value='submit'></td>";
            echo "</tr>";

            echo "</table>";
            echo "</form>";
            break;

         case 'Notification' :
            _e("Plugin mailing action", 'example');
            break;

         case 'ComputerDisk' :
         case 'Supplier' :
            if ($tabnum==1) {
               _e('First tab of Plugin example', 'example');
            } else {
               _e('Second tab of Plugin example', 'example');
            }
            break;

         default :
            //TRANS: %1$s is a class name, %2$d is an item ID
            printf(__('Plugin example CLASS=%1$s id=%2$d', 'example'), $item->getType(), $item->getField('id'));
            break;
      }
      return true;
   }


}

