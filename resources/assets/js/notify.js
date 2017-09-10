/**
 * Available use cases:
 *
 * notify.error("Error text")
 * notify.error("Title", "Error text")
 * notify.error({title: "Title", text: "Error text"})
 * notify.error({text: "Error text"})
 *
 * The same can be replaced in any of the above examples:
 * notify.error -> notify.success
 */

import 'pnotify/dist/pnotify.css';
import 'pnotify/dist/pnotify.brighttheme.css';
import 'pnotify/dist/pnotify.buttons.css';
import 'pnotify/dist/pnotify.buttons';

import PNotify from 'pnotify';

export default {

  success: function success() {
    let {title = __('Success'), text} = extractParams(...arguments);
    new PNotify({
      title: title,
      text: text,
      type: 'success',
      buttons: {
        closer: true,
        sticker: false //ugly
      }
    });
  },

  error: function () {
    let {title = __("Error"), text} = extractParams(...arguments);
    new PNotify({
      title: title,
      text: text,
      type: 'error',
      buttons: {
        closer: true,
        sticker: false //ugly
      }
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