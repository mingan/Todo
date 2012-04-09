<?php
namespace app\extensions\helper;
use lithium\g11n\Message;

class Time extends \lithium\template\Helper {

	public function utc ($date) {
		return date('c', $this->fromString($date));
	}

	/**
	 *
	 *
	 * Based on CakePHP TimeHelper::timeAgoInWords()
	 *
	 * @param array $date
	 * @param type $to
	 * @return type
	 */
	public function relative ($date, $options = array()) {
		extract(Message::aliases());
		if (!is_array($options)) {
			$options = array(
				'now' => $options
			);
		}
		$options += array(
			'now' => time(),
			'end' => '+1 month',
			'format' => $t('d_fmt')
		);
		extract($options);

		$now = $this->fromString($now);
		$inSeconds = $this->fromString($date);


		$format = $t('d_fmt');

		$diff = $now - $inSeconds;

		if ($diff == 0) {
			return $t('now');
		}

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $now));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $inSeconds));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $inSeconds);

				$days = ($daysInPastMonth - $past['d']) + $future['d'];

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $now - $inSeconds;

		if ($diff > abs($this->fromString($end)- time())) {
			$relativeDate = $t('on {:time}', array('time' => date($format, $inSeconds)));
		} else {

			if ($years > 0) {
				// years and months and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . $tn('year', 'years', $years);
				$relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . $tn('month', 'months', $months) : '';
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . $tn('week', 'weeks', $weeks) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . $tn('day', 'days', $days) : '';
			} elseif (abs($months) > 0) {
				// months, weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . $tn('month', 'months', $months);
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . $tn('week', 'weeks', $weeks) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . $tn('day', 'days', $days) : '';
			} elseif (abs($weeks) > 0) {
				// weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . $tn('week', 'weeks', $weeks);
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . $tn('day', 'days', $days) : '';
			} elseif (abs($days) > 0) {
				// days and hours
				$relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . $tn('day', 'days', $days);
				$relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . $tn('hour', 'hours', $hours) : '';
			} elseif (abs($hours) > 0) {
				// hours and minutes
				$relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . $tn('hour', 'hours', $hours);
				$relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . $tn('minute', 'minutes', $minutes) : '';
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . $tn('minute', 'minutes', $minutes);
			} else {
				// seconds only
				$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . $tn('second', 'seconds', $seconds);
			}

			$relativeDate = $t('{:time} ago', array('time' => $relativeDate));
		}
		return $relativeDate;
	}

/**
 * Returns a UNIX timestamp, given either a UNIX timestamp or a valid strtotime() date string.
 *
 * @param string $dateString Datetime string
 * @param integer $userOffset User's offset from GMT (in hours)
 * @return string Parsed timestamp
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#formatting
 */
	public function fromString($dateString, $userOffset = null) {
		if (empty($dateString)) {
			return false;
		}
		if (is_integer($dateString) || is_numeric($dateString)) {
			$date = intval($dateString);
		} else {
			$date = strtotime($dateString);
		}
		if ($userOffset !== null) {
			return $this->convert($date, $userOffset);
		}
		if ($date === -1) {
			return false;
		}
		return $date;
	}
}