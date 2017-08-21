<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Model\Job;
use App\Share\ShareList;
use App\Share\ShareListJob;
use Illuminate\Http\Request;

class JobController extends Controller {

  public function showJobPage(Request $request) {

    /** @var Company $company */
    $company = $request->company;

    $job = Job::approved()->find($request->route('id'));

    //$search = new Search_Engine_Jobs($this->curr_user);
    //$job = $search
    //  ->set_id($this->request->param('job_id'))
    //  ->find()
    //  ->get_result();

    if (!$job || !$job->exists) {
      abort(404, __('Вакансия не найдена'));
    }

    //$page_meta = $job->page_meta();

    return view('company.page.job', [
      'title'   => $job->title,
      'job'     => $job,
      'company' => $company,
      'share'   => $this->getShare($job),
    ]);
    //$layout = new Layout_Company_Job($job, $page);
    //$this->template->page_meta = $page_meta;
    //$this->main_js = '/js/company/job.js';
  }

  private function getShare(Job $job) {
    return new ShareListJob($job);
  }

}