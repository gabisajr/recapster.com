<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Video
 *
 * @property int              $id
 * @property string            $title
 * @property string           $url
 * @property int               $sort
 * @property string            $date
 * @property string            $vendor
 * @property string            $thumbnail
 * @property string            $vendor_id
 * @property string            $embed_url
 * @property int               $album_id
 * @property Model_Video_Album $album
 */
class Model_Video extends ORM {

  protected $_belongs_to = [
    'album' => [
      'model'       => 'Video_Album',
      'foreign_key' => 'album_id',
    ],
  ];

  public function __get($column) {
    if ($column == 'youtube_id') {
      return $this->get_youtube_id();
    }
    return parent::__get($column);
  }

  private function get_youtube_id() {
    if (empty($this->video_url) || !strlen(trim($this->video_url))) {
      return null;
    }

    parse_str(parse_url($this->video_url, PHP_URL_QUERY), $my_array_of_vars);
    return isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : null;
  }

  public function get($column) {
    if ($column == 'embed_url') {
      if ($this->vendor == 'youtube' && !empty($this->vendor_id)) {
        return 'http://www.youtube.com/embed/' . $this->vendor_id . '?'
        . '&autohide=1' //autohide controls
        . '&showinfo=0' //disabled title & video author info
        . '&iv_load_policy=3' //disabled annotations
        . '&rel=0' //disable relevant videos on end
        . '&autoplay=1';
      } else return null;
    }
    return parent::get($column);
  }
}