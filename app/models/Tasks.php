<?php

namespace app\models;
use app\models\Lists;

class Tasks extends \li3_behaviors\extensions\Model {

    protected $_actsAs = array(
        'Dateable' => array(
			'autoIndex' => false,
			'updated' => array('field' => 'modified', 'auto' => true, 'format' => \DateTime::ISO8601),
		)
    );

	public $validates = array();

	public static function __init() {
		parent::__init();

		Tasks::applyFilter('save', function ($self, $params, $chain) {
			$result = $chain->next($self, $params, $chain);

			if (!empty($params['data']['list_id'])) {
				$listId = $params['data']['list_id'];
			} else {
				$listId = $params['entity']->list_id;
			}
			$list = Lists::find('first', array('conditions' => array('id' => $listId)));
			$list->save();

			return $result;
		});
	}
}

?>