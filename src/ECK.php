<?php

/**
 * @file
 */

namespace Drupal\ko;

class ECK {

  public static function loadEntityTypes($only_types = FALSE) {
    $eck_entity_types = array();
    foreach (\EntityType::loadAll() as $eck_entity_type) {
      if ($only_types) {
        $eck_entity_types[] = $eck_entity_type->name;
      }
      else {
        foreach (\Bundle::loadByEntityType($eck_entity_type) as $eck_bundle) {
          $eck_entity_types[$eck_entity_type->name][] = $eck_bundle->name;
        }
      }
    }

    return $eck_entity_types;
  }

}
