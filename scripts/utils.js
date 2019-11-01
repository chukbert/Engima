function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this,
      args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

const chunk = (array, chunk_size) =>
  Array(Math.ceil(array.length / chunk_size))
    .fill()
    .map((_, index) => index * chunk_size)
    .map(begin => array.slice(begin, begin + chunk_size));
