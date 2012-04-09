$().ready(function () {
	$AT = $('#AddTask')
	$Desc = $AT.find('#Desc').hide()

	$AT.find('#Name').focus(function () {
		$Desc.slideDown()
	})
})