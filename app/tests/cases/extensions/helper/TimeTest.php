<?php

namespace app\tests\cases\extensions\helper;
use app\extensions\helper\Time;
use lithium\core\Environment;

class TimeTest extends \lithium\test\Unit {

	public function setUp() {
		$this->time = new Time();
	}

	public function tearDown() {}

	public function testRelative () {
		Environment::set('test', array('locale' => 'en', 'locales' => array('en' => 'English')));
		$t = time();

		// equal
		$expected = 'now';
		$this->assertEqual($expected, $this->time->relative($t, $t));

		// seconds
		$expected = '30 seconds ago';
		$this->assertEqual($expected, $this->time->relative($t - 30, $t));

		// minutes and seconds
		$expected = '30 minutes ago';
		$this->assertEqual($expected, $this->time->relative($t - 1810, $t));

		// hour
		$expected = '1 hour ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600, $t));

		// hours and minutes
		$expected = '2 hours, 10 minutes ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600 - 3600 - 600, $t));

		// days and hours
		$expected = '3 days, 16 hours ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 24 * 3 - 16 * 3600, $t));

		// weeks and days
		$expected = '2 weeks, 6 days ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 20 * 24, $t));

		$t = strtotime('2012-02-28 12:00:00');
		// more than limit
		$expected = 'on 2012-01-24';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 35 * 24, array('now' => $t, 'format' => 'Y-m-d')));

		// more than lowered limit
		$expected = 'on 2012-02-27';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 24 - 10, array('now' => $t, 'format' => 'Y-m-d', 'end' => '+1 day')));

		// months, weeks and days
		$expected = '2 months, 1 week, 6 days ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 24 * (31 * 2 + 7 + 6), array('now' => $t, 'end' => '+1 year')));

		// year, months and days
		$expected = '5 years, 2 months, 6 days ago';
		$this->assertEqual($expected, $this->time->relative($t - 3600 * 24 * (365 * 5 + 31 * 2 + 6 + 1), array('now' => $t, 'end' => '+10 years')));
	}

}

?>