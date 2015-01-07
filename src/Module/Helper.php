<?php

namespace Drupal\ko\Module;
use Drupal\ko\Module\Module;

class Helper {

  /**
   * Set the weight of the module behind the target.
   */
  public static function setWeightAfter($module_name, $module_target_name) {
    $module = new Module($module_name);
    $module_target = new Module($module_target_name);
    $module->setWeight($module_target->getWeight() + 1);
  }

}
