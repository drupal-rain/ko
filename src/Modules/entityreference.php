<?php

namespace Drupal\ko\Modules;

class entityreference {

  public static function fieldItems2Entities($field, $items) {
    return self::items2Entities($field['settings']['target_type'], $items);
  }

  public static function items2Entities($entity_type, $items) {
    $entities = array();
    foreach ($items as $item) {
      $entities[] = entity_load_single($entity_type, $item['target_id']);
    }

    return $entities;
  }

  public static function fieldItems2EntityWrappers($field, $items) {
    return self::items2EntityWrappers($field['settings']['target_type'], $items);
  }

  public static function items2EntityWrappers($entity_type, $items) {
    $entity_wrappers = array();
    foreach ($items as $item) {
      $entity_wrappers[] = entity_metadata_wrapper($entity_type, $item['target_id']);
    }

    return $entity_wrappers;
  }

}
