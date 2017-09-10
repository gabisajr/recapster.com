import {template} from 'lodash';

let tmpl = template(`<option value=""><%=empty%></option>
<% items.forEach(function(item) { %>
<option value="<%=item.id%>"><%=item.title%></option>
<% }); %>`);


export default function buildSelectOptions(items) {
  return tmpl({
    empty: __('Not selected'),
    items: items
  });
}