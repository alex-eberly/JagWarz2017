function AnimateScroll(id) {
	var position = $('#'+id).position();
	$('body,html').animate({
		scrollTop: position.top
	}, 800);
}
function s4() {
  return Math.floor((1 + Math.random()) * 0x10000)
             .toString(16)
             .substring(1);
};
function guid() {
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
         s4() + '-' + s4() + s4() + s4();
}