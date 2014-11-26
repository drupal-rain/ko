<?php

use Drupal\ko\Module\Module;

function ko_module($name) {
  $module = new Module($name);

  return $module;
}
