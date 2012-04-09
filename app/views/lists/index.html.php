<h1><?= $t('All lists') ?></h1>
<ul>
	<?php foreach ($lists as $list) { ?>
	<li><?= $this->html->link($list->name, array('action' => 'view', 'id' => $list->id)) ?></li>
	<?php } ?>
</ul>