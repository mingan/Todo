$().ready(function () {
	$AT = $('#AddTask')
	$Desc = $AT.find('#TaskDesc')

	$Desc.focus(function () {
		if (!$Desc.val()) {
			$Desc.origHeight = $Desc.height()
			$Desc.animate({'height' : '10em'})
		}
	}).blur(function () {
		if (!$Desc.val()) {
			$Desc.animate({'height' : $Desc.origHeight})
		}
	})

	$('.complete, .uncomplete').click(function (e) {
		e.preventDefault()

		var $task = $(this).parent().addClass('loading')
		$.getJSON($(this).attr('href') + '.json', null, function (response) {
			$task.removeClass('loading')
			if (response == null || response.data == undefined) {
				alert('Error while saving')
				return
			}


			show = 'uncomplete'
			hide = 'complete'
			completed = response.data.completed

			$task.toggleClass('completed', completed)
			if (!completed) {
				tmp = show
				show = hide
				hide = tmp
			}
			$task
				.find('.' + show)
					.show()
				.end()
				.find('.' + hide)
					.hide()

		})
	})


	$('.edit').click(function (e) {
		e.preventDefault()

		$edit = $(this).hide()
		$task = $edit.parents('.task').addClass('loading')
		$content = $task.find('.content')
		$editor = $('<div>').addClass('editor').insertAfter($content).hide()

		$editor.load($edit.attr('href'), null, function () {
			showEditForm()
		})

		function showEditForm () {
			$content.hide()
			$editor.show()
			$task.removeClass('loading')
			$editor.find('form').submit(function (e) {
				e.preventDefault()

				$task.addClass('loading')
				$.ajax({
					'url' : $(this).attr('action'),
					'data' : $(this).serialize(),
					'type' : 'POST',
					'success' : function (data) {
						if (data instanceof Object) {
							$task.removeClass('loading')
							$content.find('.taskName').text(data.name)
							$content.find('.taskDesc').text(data.desc)
							$content.show()
							$editor.text('')
						} else {
							showEditForm()
						}
					}
				})
			})
		}
	})

	$('div.linkForm').each(function () {
		$t = $(this).css('display', 'inline')

		id = 'LinkForm' + (((1+Math.random())*0x10000000)|0).toString(16)
		form = $t.find('form').attr('id', id).hide()

		link = $('<a>')
			.text(form.find('input[type=submit]').val())
			.attr({'href' : 'javascript:void(0);', 'rel' : id, 'class' : this.className})
			.click(function (e) {
				e.preventDefault()

				$('#' + $(this).attr('rel')).submit()
			})
		$t.append(link)
	})

	$('.task')
		.find('.uncomplete').hide().end()
		.filter('.completed')
			.find('.complete').hide().end()
			.find('.uncomplete').show()
})