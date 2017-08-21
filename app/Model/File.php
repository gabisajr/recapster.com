<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_File
 *
 * @property int    id
 * @property string path
 * @property string title
 * @property string format
 */
class Model_File extends ORM {

  public function delete() {

    /** @var ORM $item */

    //remove file
    $path = $this->path;
    if ($path && file_exists(DOCROOT . $path)) {
      unlink(DOCROOT . $path);
    }

    //remove from db
    parent::delete();

  }

}