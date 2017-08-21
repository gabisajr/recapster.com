String.prototype.rus_about = function () {
  if (!this.length) return false;
  return ['а', 'о', 'и', 'у', 'э'].indexOf(this[0].toLowerCase()) !== -1 ? 'об' : 'о';
};

String.prototype.replaceAll = function (search, replacement) {
  var target = this;
  return target.replace(new RegExp(search, 'g'), replacement);
};

String.prototype.random = function (length) {
  var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');

  if (!length) {
    length = Math.floor(Math.random() * chars.length);
  }

  var str = this;
  for (var i = 0; i < length; i++) {
    str += chars[Math.floor(Math.random() * chars.length)];
  }
  return str;
};