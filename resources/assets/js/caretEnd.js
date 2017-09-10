import $ from 'jquery';

export default function caretEnd() {
  let $input = $(this)
    , val = $input.val();
  $input.val('');
  $input.val(val);
}