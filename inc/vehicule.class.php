<?php

class PluginVehiculeVehicule extends CommonDBTM {

   public $dohistory = TRUE;

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
   static function canUpdate() {
      return true;
   }


   static function canView() {
      return true;
   }

   function defineTabs($options=array()){

      $ong = array();
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('Contract_Item', $ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }


// pour ajouter des colones par défaut à l'install :
// voir install/mysql/plugin_fusioninventory-empty.sql
   
   function getSearchOptions() {

      $tab = array();
      $tab['common'] = "Vehicule";

      $tab[1]['table']     = $this->getTable();
      $tab[1]['field']     = 'name';
      $tab[1]['name']      = __('Name');
      $tab[1]['datatype']  = 'itemlink';

      $tab[2]['table']     = $this->getTable();
      $tab[2]['field']     = 'serial';
      $tab[2]['name']      = __('Serial number');

      return $tab;
   }


   function showForm($id, $options=array()) {

      $this->initForm($id, $options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Name')." :</td>";
      echo "<td align='center'>";
      echo Html::input("name", array("value"=>$this->fields["name"]) );
      echo "</td>";
      echo "<td>".__('Serial number')."&nbsp;:</td>";
      echo "<td align='center'>";
      echo Html::input("serial", array("value"=>$this->fields["serial"]) );
      echo "</td>";
      echo "</tr>";


      $this->showFormButtons($options);

      return TRUE;
   }

}

