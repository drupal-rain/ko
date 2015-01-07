<?php

/**
 * @file Utility related to Drupal module system.
 */

namespace Drupal\ko\Module;

class Module {

  protected $name = '';
  protected $weight = 0;

  /**
   * Constructor.
   */
  function __construct($name) {
    $this->name = $name;
  }

  /**
   * Get the module weight.
   */
  function getWeight() {
    $query = db_select('system', 'sys');
    $query->addField('sys', 'weight');
    $query->condition('name', $this->name);
    $this->weight = $query->execute()->fetchField();

    return $this->weight;
  }

  /**
   * Set the module weight.
   */
  function setWeight($weight) {
    db_query("UPDATE {system} SET weight = :weight WHERE name = :module",
      array(
        ':weight' => $weight,
        ':module' => $this->name,
      )
    );
  }

}
