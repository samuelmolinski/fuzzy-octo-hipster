<?php
	
	class Performance {
		public $timers;

		public function Performance() {
			$timers = array();
		}

		public function start_timer($id = 0) {
			$time = microtime();

			$this->timers[$id] = array('start'=>$time, 'end'=> '', 'total'=>'');
		}

		public function end_timer($id = 0) {
			$time = microtime();

			$this->timers[$id]['end'] = $time;
			$total = $this->microtimeDiff($this->timers[$id]['end'], $this->timers[$id]['start']);
			$this->timers[$id]['total'] = $total;
		}

		public function microtimeDiff($microtime1,$microtime2) {
			$microtime1 = explode(' ', $microtime1);
			$decimal1 = (float)$microtime1[0];
			$int1 = (float)$microtime1[1];

			$microtime2 = explode(' ', $microtime2);
			$decimal2 = (float)$microtime2[0];
			$int2 = (float)$microtime2[1];

			$int = $int1-$int2;
			$decimal = $decimal1 - $decimal2;
			return $int+$decimal;
		}

		public function timeToReadable($time) {
			$y = 30758400;
			$d = 86400;
			$h = 3600;
			$m = 60;
			$readable['y'] = (integer)($time / $y);
			$readable['d'] = (integer)(($time % $y) / $d);
			$readable['h'] = (integer)(($time % $d) / $h);
			$readable['m'] = (integer)(($time % $h) / $m);
			$readable['s'] = $time - $readable['m']*$m - $readable['h']*$h - $readable['d']*$d -$readable['y']*$y;
			return $readable;
		}
	}