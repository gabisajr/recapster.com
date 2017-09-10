/**
 * Доступные форматы вызова:
 *
 * notify.error("Текст ошибки")
 * notify.error("Заголовок", "Текст ошибки")
 * notify.error({title: "Заголовок", text: "Текст ошибки"})
 * notify.error({text: "Текст ошибки", title: "Заголовок"})
 * notify.error({text: "Текст ошибки"})
 *
 * таже можно в любом из выше приведенных примеров заменить:
 * notify.error -> notify.success
 */

import 'pnotify/dist/pnotify.css';
import 'pnotify/dist/pnotify.brighttheme.css';
import PNotify from 'pnotify';

export default {

  success: function success() {
    let {title = __('Success'), text} = extractParams(...arguments);
    new PNotify({
      title: title,
      text: text,
      type: 'success',
      closer: '<i class="fa fa-times"></i>'
    });
  },

  error: function () {
    let {title = __("Error"), text} = extractParams(...arguments);
    new PNotify({
      title: title,
      text: text,
      type: 'error'
    });
  }

};

/** different formats resolver */
function extractParams() {

  let title, text;

  let first = arguments[0];

  // notify.error({title: 'notify title', text: 'notify text'});
  if (typeof first === 'object') {
    ({title, text} = first);
  } else if (typeof first === 'string') {

    // notify.error('notify title', 'notify text');
    if (arguments.length > 1) {
      title = arguments[0];
      text = arguments[1];
    } else {

      // notify.error('only text');
      text = first
    }

  } else {
    throw 'invalid notify params';
  }

  return {
    title: title,
    text: text
  }
}