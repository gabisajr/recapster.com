<?php

namespace App\Share;

use Illuminate\Support\Collection;

class ShareList {

  protected $header;
  protected $share_intents = [];
  protected $shareUrl;
  protected $title;
  protected $description;
  protected $imageUrl;
  protected $emailSubject;
  protected $emailText;

  public function __construct() {

    $appName = config('app.name');

    //default values
    $this->share_intents = [];
    $this->shareUrl = config('app.url');
    $this->title = $appName;
    $this->description = config('app.desc');
    $this->imageUrl = null; //todo share img
    $this->emailSubject = __("Интересный сайт");
    $this->emailText = __("Текст Email-сообщения");

  }

  public function __toString() {

    $items = new Collection();
    foreach ($this->share_intents as $intent) {
      $items->put($intent, $this->{$intent}());
    }

    return view('share.list', [
      'header' => $this->header,
      'items'  => $items,
    ])->render();
  }

  //<editor-fold desc="Share renders">
  protected function vk() {
    $text = __('Поделиться ВКонтакте');
    return "<a class='share-list-item vk' href='https://vk.com/share.php?url={$this->shareUrl}' target='_blank'>{$text}</a>";
  }

  protected function facebook() {

    $app_id = config('facebook.client_id');
    $url = "https://www.facebook.com/dialog/share?" . join('&', [
        "app_id={$app_id}",
        "display=popup",
        "href={$this->shareUrl}",
        "redirect_uri={$this->shareUrl}",
      ]);

    $text = __('Поделиться на Facebook');
    $html = "<a class='share-list-item facebook' href='{$url}'>{$text}</a>";

    return $html;
  }

  protected function twitter() {

    $url = "https://twitter.com/intent/tweet?" . join('&', [
        "text=" . htmlentities($this->title),
        "url=" . htmlentities($this->shareUrl),
      ]);

    $text = __('Твитнуть');
    $html = "<a class='share-list-item twitter twitter-popup' id='twitter-job-share' href='{$url}'>{$text}</a>";

    return $html;

  }

  protected function mailto() {
    $url = "mailto:" . join('&', [
        "subject={$this->emailSubject}",
        "body={$this->emailText}",
      ]);
    $text = __('Отправить по Email');
    $html = "<a class='share-list-item mail' target='_blank' href='{$url}'>{$text}</a>";
    return $html;
  }

  protected function print() {
    $text = __('Распечатать страницу');
    $html = "<div class='share-list-item print'>{$text}</div>";
    return $html;
  }

}