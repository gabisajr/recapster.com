@php
  /**
   * @var string                         $caption     заголовок таблицы
   * @var \Illuminate\Support\Collection $images      коллекция фотографий
   * @var boolean                        $company_col показать колонку с компанией
   */
@endphp
<div class="table-responsive">
  <table class="table table-hover" id="images-list">
    <thead>
    <tr>
      <th>{{ __('Миниатюра') }}</th>
      <th>{{ __('Подпись') }}</th>
      @if ($company_col)
        <th>{{ __('Компания') }}</th>
      @endif
      <th class="text-center">{{ __('Видимость') }}</th>
      <th>{{ __('Статус') }}</th>
      <th>{{ __('Добавлена') }}</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($images as $image)
      <tr data-id="{{ $image->id }}">
        <td>
          <a href="{{ $image->path }}" target="_blank" title="{{ __('Открыть оригинал') }}">
            <img class="logo" src="{{ $image->fit(50, 50)->path }}" alt="{{ $image->title }}"></a>
        </td>

        <td class="title-cell small">
        <span class="title">
          @if($image->title)
            {{ str_limit($image->title, 50) }}
          @else
            <em>({{ __('без подписи') }})</em>
          @endif
        </span><br>

          @if($image->city)
            <b>{{ $image->city->title }}</b><br>
          @endif


          <a href="{{ $image->path }}" target="_blank">{{ __('Открыть оригинал') }}</a>
        </td>

        @if ($company_col)
          <td>
            @if ($image->company)
            <a href="{{ $image->company->adminUrl() }}">{{ str_limit($image->company->title, 20) }}</a><br>
            @endif
          </td>
        @endif


        <td class="small text-center">{!! visibility($image) !!}</td>

        <td>
          <samp class="small text-muted">
            <em>
              @if ($image->isPending())
                <span class="text-danger"><i class="fa fa-clock-o"></i> {{ __('В ожидании') }}</span>
              @else
                ({{ status($image->status, 'f') }})
              @endif
            </em>
          </samp>
        </td>

        <td>
          <small><samp>

              {{ date('d.m.Y (H:i)', strtotime($image->created_at)) }} <br>
              @if ($image->user)
                {{ $image->user->name }}
              @else
                <em class='text-muted'>({{ __('нет пользователя') }})</em>
              @endif

            </samp></small>
        </td>
        <td class="text-nowrap">
          <a href="{{ "/admin/image/item/$image->id" }}" class="text-muted" title="{{ __('Правка') }}"><i class="fa fa-fw fa-pencil"></i></a> {{--todo route--}}
          <button class="btn btn-sm btn-secondary" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

{!! $images->links() !!}