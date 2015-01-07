<?php

/**
 * @file
 */


namespace Drupal\ko;


class Field {

  /**
   * Add field to entity bundle.
   */
  public static function addField($field_type, $entity_type, $bundle, $field_name, $field_label = '') {
    $field_type_info = field_info_field_types($field_type);
    // Field Base
    $base = field_info_field($field_name);
    if (!$base) {
      field_create_field(array(
        'field_name' => $field_name,
        'type'       => $field_type,
      ));
    }
    // Field Instance
    $instance = field_info_instance($entity_type, $field_name, $bundle);
    if (!$instance) {
      field_create_instance(array(
        'field_name'  => $field_name,
        'entity_type' => $entity_type,
        'bundle'      => $bundle,
        'label'       => drupal_strlen($field_label) > 0 ? $field_label : ucfirst($field_name),
        'widget'      => array(
          'type' => $field_type_info['default_widget'],
        ),
        'display'     => array(
          'default' => array(
            'type' => $field_type_info['default_formatter'],
          ),
        ),
      ));
    }
  }

  /**
   * Check if entity bundle has a specific field.
   */
  public static function hasField($field_name, $entity_type, $bundle) {
    $field = field_info_field($field_name);
    if ($field && isset($field['bundles'][$entity_type])) {
      if (in_array($bundle, $field['bundles'][$entity_type])) {
        return TRUE;
      }
    }

    return FALSE;
  }

  public static function hasFieldType($field_type, $entity_type, $bundle) {

  }

}
