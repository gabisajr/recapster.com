define('initTiny', ['tinyMCE'], function (tinyMCE) {

  return function (selector) {
    if (!selector) selector = 'textarea.tinymce';
    tinyMCE.init({
      selector: selector,
      mode: "textareas",
      theme: "modern",
      plugins: "link autoresize paste",
      paste_as_text: true,
      height: 150,
      autoresize_bottom_margin: 0,
      autoresize_min_height: 150,
      autoresize_max_height: 500,
      statusbar: false,
      browser_spellcheck: true,
      convert_newlines_to_brs: false,
      force_p_newlines: false,
      menubar: false,
      target_list: false,
      skin: 'lightgray',
      language: 'ru',
      toolbar: "bold,italic,link,bullist,numlist",
      content_css: '/css/tiny-content.css'
    });
  }

});