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
			$params['data'] = $self::invokeMethod('_separateNameAndDesc', array($params['data']));

			$result = $chain->next($self, $params, $chain);

			$self::invokeMethod('_updateListModified', array($params));

			return $result;
		});
	}

	public static function _updateListModified ($params) {
		if (!empty($params['data']['list_id'])) {
			$listId = $params['data']['list_id'];
		} else {
			$listId = $params['entity']->list_id;
		}
		$list = Lists::find('first', array('conditions' => array('id' => $listId)));
		return $list->save();
	}

	public static function _separateNameAndDesc ($data) {
		if (isset($data['name']) || !isset($data['desc'])) {
			return $data;
		}

		$text = explode("\n", $data['desc']);

		$data['name'] = trim(array_shift($text));
		$data['desc'] = implode("\n", $text);

		return $data;
	}

	public function mergeFields ($entity) {
		if (!empty($entity->name) && !empty($entity->desc)) {
			$entity->desc = trim($entity->name . "\n" . $entity->desc, "\n");
		} else {
			$entity->desc = $entity->name;
		}

		return $entity;
	}
}

?>