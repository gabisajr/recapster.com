@php
  /**
   * @var \App\Model\Company $company
   * @var boolean            $showIndustries
   */
  if(!isset($showIndustries)) $showIndustries = false;
@endphp
<article class="post company-post search-post" data-url="{{ $company->url() }}">
  <div class="post-inner">
    <div class="post-left">
      <a href="{{ $company->url() }}"><img class="post-logo" src="{{ logo($company, 250) }}" alt="{{ $company->title }}"></a>
    </div>
    <div class="post-right">
      <h2 class="post-title"><a href="{{ $company->url() }}">{{ $company->title }}</a>
        {!! icon_confirmed_company($company) !!}
      </h2>


      <p class="post-info"><?

        $parts = [];

        if ($count = $company->followers_count) {
          $href = $company->section_url('followers');
          $text = followers_count($count);
          $parts[] = "<a href='{$href}'>{$text}</a>";
        }

        //        if ($count = $company->reviews_count) {
        //          $parts[] = reviews_count($count);
        //        }

        echo implode('<span class="separator"></span>', $parts);

        ?>
      </p>


      @if ($showIndustries)
        <p class="help-block"><?

          $links = [];

          /** @var Model_Industry[] $industries */
          $industries = $company->industries->limit(4)->find_all();
          foreach ($industries as $industry) {
            $href = '/search' . URL::query(['type' => 'companies', 'industry' => $industry->id]);
            $links[] = "<a href='{$href}'>{$industry->title}</a>";
          }

          echo implode(', ', $links);

          ?></p>
      @endif

    </div>
  </div>
</article>