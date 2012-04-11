<?php
namespace app\extensions\helper;

class Form extends \lithium\template\helper\Form {
	public function formLink ($text, $url, $options) {
		if (empty($options['class'])) {
			$options['class'] = '';
		}
		$options['class'] .= ' linkForm';
		$r = $this->create(null, array('url' => $url));
		$r .= $this->submit($text);
		$r .= $this->end();
		return $this->_render(__METHOD__, 'block', array('content' => $r, 'options' => $options));
	}
}
