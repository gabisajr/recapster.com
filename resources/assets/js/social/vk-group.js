define(['VK'], function (VK) {

  var group_id = document.getElementById('vk-group').dataset.groupId;
  if (group_id) {
    VK.Widgets.Group("vk-group", {
      redesign: 1,
      mode: 3,
      width: "280.5",
      height: "400",
      color1: 'FFFFFF',
      color2: '000000',
      color3: '5E81A8'
    }, group_id);
  }

});