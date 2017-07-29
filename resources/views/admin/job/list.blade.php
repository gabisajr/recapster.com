@php
  //todo stop here
  /**
   * @var Model_Job[] $jobs
   * @var boolean     $company_col
   */
@endphp
<div class="table-responsive">
  <table class="table table-hover" id="jobs-list">
    <thead>
    <tr>
      <th><samp>id</samp></th>
      <th>{{ __('Заголовок') }}</th>
      <th>{{ __('Должность') }}</th>
      @if ($company_col)
        <th>{{ __('Компания') }}</th>
      @endif
      <th>{{ __('Тип отклика') }}</th>
      <th>{{ __('Город(а)') }}</th>
      <th>{{ __('Статус') }}</th>
      <th>{{ __('Добавлена') }}</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($jobs as $job)
      <tr data-id="{{ $job->id }}">

        <!--<editor-fold desc="id">-->
        <td><samp>{{ $job->id }}</samp></td>
        <!--</editor-fold>-->

        <!--<editor-fold desc="заголовок">-->
        <td>
          <a class="title" href="{{ route('admin.job.edit', $job) }}">{{ str_limit($job->title, 50) }}</a>
          @if ($job->hot)
            <img src="{{ asset('/images/hot-vacancy.svg') }}" alt='hot'>
          @endif
        </td>
        <!--</editor-fold>-->

        <td class="small">
          @if ($job->position)
            {{ $job->position->title }} <i class="fa fa-check text-success"></i>
          @else
            <em class="text-muted"><i class="fa fa-warning"></i> {{ __('нет привязки') }}</em>
          @endif
        </td>

        <!--<editor-fold desc="компания">-->
        @if($company_col)
          <td>
            <a href="{{ route('admin.company.edit', $job->company) }}">{{ str_limit($job->company->title) }}</a>
          </td>
      @endif
      <!--</editor-fold>-->

        <!--<editor-fold desc="тип отклика">-->
        <td class="small">
          @if($job->apply_type == 'contacts')
            Контакты {{--todo html tooltip--}}
          @elseif($job->apply_type == 'external')
            <a href='{{ $job->external_url }}' target='_blank'>{{ __('Внешняя ссылка') }} <i class='fa fa-external-link'></i></a>
          @elseif($job->apply_type == 'internal')
            {{ __('Внутренняя') }}
          @endif
        </td>
        <!--</editor-fold>-->

        <!--<editor-fold desc="города">-->
        <td class="small">
          @php $cities = $job->cities()->get(); //todo load jobs with cities @endphp


          @if ($count = count($cities))

            @if ($count == 1)
              {{ $cities->first()->title_regard_to_me() }}
            @else
              {{ cities_count($count) }} {{--todo html tooltip with ciris --}}
            @endif

          @else
            <em class="text-muted">({{ __('не указано') }})</em>
          @endif

        </td>
        <!--</editor-fold>-->

        <!--<editor-fold desc="статус">-->
        <td>{{ status($job->status) }}</td>
        <!--</editor-fold>-->

        <!--<editor-fold desc="добавлена">-->
        <td class="small">
          <samp>
            {{ date('d.m.Y (H:i)', strtotime($job->created_at)) }} <br>
            @if ($job->user)
              {{ $job->user->name }}
            @else
              <em class='text-muted'>({{ __('нет пользователя') }})</em>
            @endif
          </samp>
        </td>
        <!--</editor-fold>-->

        <!--<editor-fold desc="кнопочки">-->
        <td class="text-nowrap">
          <a href="{{ route('admin.job.edit', $job) }}" class="text-muted" title="{{ __('Правка') }}"><i class="fa fa-fw fa-pencil"></i></a>
          <button class="btn btn-sm btn-secondary" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
        </td>
        <!--</editor-fold>-->
      </tr>
    @endforeach
    </tbody>
  </table>
</div>