<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 11.08.2017
 * Time: 18:46
 */

namespace App\Share;


use App\Model\Job;

class ShareListJob extends ShareList {

  public function __construct(Job $job) {

    parent::__construct();

    $this->header = __('Поделиться вакансией');
    $this->share_intents = ['vk', 'facebook', 'twitter', 'mailto', 'print'];
    $this->shareUrl = $job->url();
    $this->title = $job->title;
    $this->description = $job->noHtmlDescription();
    $this->imageUrl = $job->metaImage();
    $this->email = $job->shareEmailParams();
  }

}