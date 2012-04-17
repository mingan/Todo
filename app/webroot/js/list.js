$().ready(function () {
	a = function ($) {
		$AT = $('#AddTask')
		$Desc = $AT.find('#TaskDesc')
		$Submit = $AT.find('input[type=submit]')

		$Desc.focus(function () {
			if (!$Desc.val()) {
				$Submit.show()
			}
		}).blur(function () {
			if (!$Desc.val()) {
				$Submit.hide()
			}
		})
		$Submit.hide()

		$AT.submit(function (e) {
			e.preventDefault()
			$.ajax({
				'url' : $(this).attr('action'),
				'data' : $(this).serialize(),
				'type' : 'POST',
				'success' : function (data) {
					$Desc.removeClass('loading').removeAttr('disabled').val('')
					$Submit.removeAttr('disabled')

					$d = $(data)
					lis = $('#ListTasks li')
					if (!lis.length) {
						$('#ListTasks').html($d)
					} else {
						li = lis.filter(':not(.completed):last')
						if (!li.length) {
							li = lis.first().before($d)
						} else {
							li.after($d)
						}
					}
					initLinks($d.filter('li'))
				}
			})
			$Desc.attr('disabled', 'disabled').addClass('loading')
			$Submit.attr('disabled', 'disabled')
		})
	}
	a($)

	function initLinks (lis) {
		lis.find('.complete, .uncomplete').click(function (e) {
			e.preventDefault()

			var $task = $(this).parent().addClass('loading')
			$.getJSON($(this).attr('href') + '.json', null, function (response) {
				$task.removeClass('loading')
				if (response == null || response.Task == undefined) {
					alert('Error while saving')
					return
				}

				$('body').css('position', 'relative')
				offset = $task.offset()
				target = $('#ListTasks .task:not(.completed):last')
				next = target.next()
				if (next.length) {
					target = next
				}
				if (!target.length) {
					target = $('#ListTasks .task:first')
				}

				if (target.attr('data-task_id') != $task.attr('data-task_id')) {
					$task = $task.detach()
					target.before($task)
					$task.show()
				}

				show = 'uncomplete'
				hide = 'complete'
				completed = response.Task.completed
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


		lis.find('.edit').click(function (e) {
			e.preventDefault()

			var $edit = $(this).hide()
			var $task = $edit.parents('.task').addClass('loading')
			var $content = $task.find('.content')
			var $editor = $('<div>').addClass('editor').insertAfter($content).hide()

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
								$content.find('.taskName').text(data.Task.name)
								$content.find('.taskDesc').text(data.Task.desc)
								$content.show()
								$editor.text('')
								$edit.show()
							} else {
								showEditForm()
							}
						}
					})
				})
			}
		})

		lis.find('div.linkForm').each(function () {
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

		lis.find('.delete form').submit(function (e) {
			e.preventDefault()

			$task = $(this).parents('.task').addClass('loading')
			$.ajax({
				'url' : $(this).attr('action'),
				'data' : $(this).serialize(),
				'type' : 'POST',
				'success' : function (data) {
					if (data.deleted) {
						$task.slideUp(1000, function () {
							$(this).remove()
						})
					}
				},
				'complete' : function () {
					$task.removeClass('loading')
				}
			})
		})

		lis
			.find('.uncomplete').hide().end()
			.filter('.completed')
				.find('.complete').hide().end()
				.find('.uncomplete').show()
	}

	initLinks($('#ListTasks li'))

})