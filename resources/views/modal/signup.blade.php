<div id="signup-modal" class="signup-modal">
  <div class="container-fluid">
    <div class="row signup-modal-row">
      <div class="col-sm-6 col">
        <img src="{{ asset('images/employee.jpg') }}" class="signup-modal-img">
        <a href="/signup" class="btn btn-primary">{{ __("I'm an applicant") }}</a>
      </div>
      <div class="col-sm-6 col">
        <img src="{{ asset('images/employer.jpg') }}" class="signup-modal-img">
        <a href="/signup?employer=1" class="btn btn-primary">{{ __("I'm an employer") }}</a>
      </div>
    </div>
  </div>
</div>