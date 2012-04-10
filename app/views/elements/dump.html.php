<?php
if ($_SERVER['ENVIRONMENT'] == 'development') {
$rows = \app\extensions\Debugger::dump();
?>
<table class="sqlDump">
	<thead>
		<tr>
			<th>Query</th>
			<th>Time (ms)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($rows as $row) { ?>
		<tr>
			<td><?=$row['query']?></td>
			<td><?=round($row['time'], 3)?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php
}
?>