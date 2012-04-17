WebFontConfig = {
	google: { families: [ 'Signika:300:latin,latin-ext' ] }
};
(function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);
})();

$().ready(function () {
	$Descs = $('textarea.taskDesc')
	$Descs.focus(function () {
		$Desc = $(this)
		if (!$Desc.val()) {
			$Desc.attr('data-orig_height', $Desc.height())
			$Desc.animate({'height' : '10em'})
		}
	}).blur(function () {
		$Desc = $(this)
		if (!$Desc.val()) {
			$Desc.animate({'height' : $Desc.attr('data-orig_height')})
		}
	})
})