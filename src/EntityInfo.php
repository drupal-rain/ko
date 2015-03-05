<?php

/**
 * @file
 */


namespace Drupal\ko;


class EntityInfo {

  public static function getLabel($entity_type) {
    $info = entity_get_info($entity_type);

    return $info['label'];
  }

  public static function getViewModes($entity_type) {
    $info = entity_get_info($entity_type);

    return $info['view modes'];
  }

  public static function getViewModesOptions($entity_type) {
    $info = entity_get_info($entity_type);
    $options = array();
    foreach ($info['view modes'] as $mode => $option) {
      $options[$mode] = $option['label'];
    }

    return $options;
  }

}
