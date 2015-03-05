<?php

/**
 * @file
 */


namespace Drupal\ko;

/**
 * Utility function for PHP Array.
 */
class ArrayHelper {

  public static function insertBeforeKey() {

  }

  public static function insertAfterKey() {

  }

  public static function insertBeforeValue($arr, $val, $replacement) {
    $pos = array_search($val, $arr, TRUE);
    if ($pos !== FALSE) {
      array_splice($arr, $pos, 0, $replacement);
    }
    return $arr;
  }

  public static function insertAfterValue($arr, $val, $replacement) {
    $pos = array_search($val, $arr, TRUE);
    if ($pos !== FALSE) {
      array_splice($arr, $pos + 1, 0, $replacement);
    }
    return $arr;
  }

}
