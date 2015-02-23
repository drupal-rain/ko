<?php

namespace Drupal\ko;

class Debug {

  public static function watchdog($variable, $title = 'Debug') {
    watchdog($title, t('<pre>@print_r</pre>', array('@print_r' => print_r($variable, TRUE))));
  }

}
