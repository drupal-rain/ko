<?php

/**
 * @file
 */


namespace Drupal\ko;


class File {

  /**
   * Get the uri of filepath.
   *
   * @todo
   *
   * Use these path to replace the scheme.
   *   - file_public_path, variable_get('file_public_path', conf_path() . '/files')
   *   - file_private_path, variable_get('file_private_path', FALSE)
   *   - file_temporary_path, variable_get('file_temporary_path', file_directory_temp())
   */
  public static function filePathUri($file_path) {

  }

  /**
   * Helper function to load file entity by uri.
   *
   * @param string $uri
   * @return boolean|stdClass
   */
  public static function loadByUri($uri) {
    $fid = db_query('SELECT fid FROM {file_managed} WHERE uri = :uri', array(':uri' => $uri))->fetchField();
    if (!empty($fid)) {
      $file = file_load($fid);
      return $file;
    }
    return FALSE;
  }

  /**
   * Helper function to load file entity by relative path.
   */
  public static function loadByPath($path, $scheme = NULL) {
    return self::loadByURI(self::getUri($path, $scheme));
  }

  /**
   * Helper function to get uri.
   */
  public static function getUri($path, $scheme = NULL) {
    // Check if it's uri already.
    if (file_valid_uri($path)) {
      $uri = $path;
    }
    else {
      $stream_wrapper = $scheme ? $scheme : file_default_scheme();
      $uri = $stream_wrapper . '://' . $path;
      $uri = file_stream_wrapper_uri_normalize($uri);
    }

    return $uri;
  }

  /**
   * Download and save a web file.
   */
  public static function wgetSave($url, $dest = NULL) {
    if (
      valid_url($url)
      && $data = file_get_contents($url)
    ) {
      if ($dest === NULL) {
        $dest = 'public://' . basename($url);
      }
      if ($file = file_save_data($data, $dest)) {
        return $file;
      }
    }

    return FALSE;
  }

  /**
   * Borrow from FileTestCase::createFile().
   */
  public static function createFile($filepath = NULL, $contents = NULL, $scheme = NULL) {
    if (!isset($filepath)) {
      // Prefix with non-latin characters to ensure that all file-related
      // tests work with international filenames.
      $filepath = 'Файл для тестирования ' . $this->randomName();
    }
    if (!isset($scheme)) {
      $scheme = file_default_scheme();
    }
    $filepath = $scheme . '://' . $filepath;

    if (!isset($contents)) {
      $contents = "file_put_contents() doesn't seem to appreciate empty strings so let's put in some data.";
    }

    file_put_contents($filepath, $contents);

    $file = new \stdClass();
    $file->uri = $filepath;
    $file->filename = drupal_basename($file->uri);
    $file->filemime = file_get_mimetype($file->uri);
    $file->uid = 1;
    $file->timestamp = REQUEST_TIME;
    $file->filesize = filesize($file->uri);
    $file->status = 0;

    return file_save($file);
  }

  public static function prepareFile($uri) {
    $file = new \stdClass();
    $file->uri = $uri;
    $file->filename = drupal_basename($file->uri);
    $file->filemime = file_get_mimetype($file->uri);
    $file->uid = 1;
    $file->timestamp = REQUEST_TIME;
    $file->filesize = @filesize($file->uri);
    $file->status = 0;

    return $file;
  }

  /**
   * Prepare a #options array.
   *
   * @doc http://drupal7.api/api/drupal/includes%21file.inc/function/file_get_stream_wrappers/7.x
   *
   * @param $filter STREAM_WRAPPERS_ALL | STREAM_WRAPPERS_WRITE_VISIBLE | and many more
   */
  public static function schemeOptions($filter = STREAM_WRAPPERS_WRITE_VISIBLE) {
    $scheme_options = array();
    foreach (file_get_stream_wrappers($filter) as $scheme => $stream_wrapper) {
      $scheme_options[$scheme] = $stream_wrapper['name'];
    }
    return $scheme_options;
  }

}
