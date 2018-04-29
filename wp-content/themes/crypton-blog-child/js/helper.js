var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

String.prototype.format = function() {
	var formatted = this;
	for (var i = 0; i < arguments.length; i++) {
	    var regexp = new RegExp('\\{'+i+'\\}', 'gi');
	    formatted = formatted.replace(regexp, arguments[i]);
	}
	return formatted;
};