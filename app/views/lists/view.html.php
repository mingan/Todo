<header>
	<h1><?= $list->name ?></h1>
	<h2 class="timestamp"><?= $t('Last updated'); ?>
		<time datetime="<?php echo $this->time->utc($list->modified); ?>"><?= $this->time->relative($list->modified) ?></time>
	</h2>
</header>
<ul id="ListTasks">
<?php
foreach ($list->tasks as $task) {
	echo $this->_render('element', '../tasks/view', array('task' => $task));
}
?>
</ul>
<div id="NewTask">
	<h2><?=$t('New task')?></h2>
	<?php echo $this->_render('element', '../tasks/add', array('listId' => $list->id)) ?>
</div>

<?=$this->html->script('list', array('inline' => false))?>