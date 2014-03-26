<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginVehiculeProfile extends Profile {


   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
      if ($item->getID() > 0
              && $item->fields['interface'] == 'central') {
         return self::createTabEntry('Vehicule');
      }
   }



   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
      if ($item->getID() > 0) {
         $pvProfile = new self();
         $pvProfile->showForm($item->getID());
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

      echo "<div class='firstbloc'>";
      if (($canedit = Session::haveRightsOr(self::$rightname, array(CREATE, UPDATE, PURGE)))
          && $openform) {
         $profile = new Profile();
         echo "<form method='post' action='".$profile->getFormURL()."'>";
      }

      $profile = new Profile();
      $profile->getFromDB($profiles_id);

      $rights = $this->getRightsGeneral();
      $profile->displayRightsChoiceMatrix($rights, array('canedit'       => $canedit,
                                                      'default_class' => 'tab_bg_2',
                                                      'title'         => __('General', 'vehicule')));
      if ($canedit
          && $closeform) {
         echo "<div class='center'>";
         echo "<input type='hidden' name='id' value='".$profiles_id."'>";
         echo "<input type='submit' name='update' value=\""._sx('button', 'Save')."\" class='submit'>";
         echo "</div>\n";
         Html::closeForm();
      }
      echo "</div>";

      $this->showLegend();
   }



   /**
    * Init profiles
    *
    **/
   static function initProfile() {
      $pfProfile = new self();
      $profile = new Profile();

      $a_rights = $pfProfile->getRightsGeneral();
      foreach ($a_rights as $data) {
         if (countElementsInTable("glpi_profilerights", "`name` = '".$data['field']."'") == 0) {
            ProfileRight::addProfileRights(array($data['field']));
            $_SESSION['glpiactiveprofile'][$data['field']] = 0;
         }
      }
      // Add all rights to current profile of the user
      if (
         isset($_SESSION['glpiactiveprofile'])
         and isset($_SESSION['glpiactiveprofile']['id'])
      ) {
         $dataprofile = array();
         $dataprofile['id'] = $_SESSION['glpiactiveprofile']['id'];
         $profile->getFromDB($_SESSION['glpiactiveprofile']['id']);
         foreach ($a_rights as $info) {
            if (is_array($info) && ((!empty($info['itemtype'])) || (!empty($info['rights'])))
                && (!empty($info['label'])) && (!empty($info['field']))) {

               if (isset($info['rights'])) {
                  $rights = $info['rights'];
               } else {
                  $rights = $profile->getRightsFor($info['itemtype']);
               }

               foreach ($rights as $right => $label) {
                  $dataprofile['_'.$info['field']][$right] = 1;
               }
            }
         }
         $profile->update($dataprofile);
      }
   }



   static function uninstallProfile() {
      $pvProfile = new self();
      $a_rights = $pvProfile->getRightsGeneral();
      foreach ($a_rights as $data) {
         ProfileRight::deleteProfileRights(array($data['field']));
      }
   }



   function getRightsGeneral() {
      $rights = array(
          array('rights'    => CommonDBTM::getRights(),
                'label'     => __('Vehicule', 'vehicule'),
                'field'     => 'plugin_vehicule_vehicule'),
      );
      return $rights;
   }
}

?>
