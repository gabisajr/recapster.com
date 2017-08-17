<footer id="footer" class="page-footer hidden-print">
  <div class="page-footer-top hidden-xs">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="page-footer-desc page-footer-top-block html-text">
            <p><strong>{{ config('app.name') }} - первый в Казахстане современный молодежный job-портал.</strong></p>
            <p>
              Создан специально для того, чтобы талантливые студенты, выпускники и
              молодые специалисты легко и быстро находили интересную стажировку
              или работу в лучших компаниях Казахстана… <a href="/about" class="more blue-gray">{{ __('Подробнее') }}</a>
            </p>
          </div>

        </div>

        <div class="col-lg-5 col-lg-offset-1 hidden-xs">
          <div class="page-footer-top-block links-wrapper">
            <div class="links">
              <div class="links-title">{{ config('app.name') }}</div>
              <ul class="list-unstyled">
                <li><a href="/about">О проекте</a></li>
                <li><a href="https://vk.com/im?media=&sel=-112941564" target="_blank">Связь с нами</a></li>
                <li><a href="/blog">Блог</a></li>
              </ul>
            </div>

            <div class="links">
              <div class="links-title">Работодатель</div>
              <ul class="list-unstyled">
                <li><a href="/employers">Личный кабинет</a></li>
                <li><a href="/add/job">Добавить работу</a></li>
              </ul>
            </div>

            <div class="links">
              <div class="links-title">Сообщество</div>
              <ul class="list-unstyled">
                <li><a href="/guidelines">Правила сообщества</a></li>
                <li><a href="/terms/terms-of-use">Правила использования</a></li>
                <li><a href="/terms/privacy-policy">Политика безопасности</a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="page-footer-bot">
    <div class="container no-pad-xs">
      <div class="page-footer-content">
        <div class="social hover_links">
          {{--todo socials config--}}
          <a href="<?/*=Kohana::$config->load('vk')->get('group_url')*/?>" target="_blank" class="social-vk" title="ВКонтакте"><i class="fa fa-vk"></i></a>
          <a href="<?/*=Kohana::$config->load('facebook')->get('group_url')*/?>" target="_blank" class="social-facebook" title="Facebook"><i class="fa fa-facebook-f"></i></a>
          <a href="<?/*=Kohana::$config->load('instagram')->get('url')*/?>" target="_blank" class="social-instagram" title="Instagram"><i class="fa fa-instagram"></i></a>
          <a href="<?/*=Kohana::$config->load('twitter')->get('url')*/?>" target="_blank" class="social-twitter" title="Twitter"><i class="fa fa-twitter"></i></a>
        </div>

        <span class="copyright pull-left">© <?=date('Y')?>, {{ config('app.name') }}</span>
        <div class="menu" role="menu">
          <a href="/about">{{ __('О нас') }}</a>
          <a href="/blog">{{ __('Блог') }}</a>
          <a href="/rules">{{ __('Правила') }}</a>
        </div>
      </div>
    </div>
  </div>
</footer>