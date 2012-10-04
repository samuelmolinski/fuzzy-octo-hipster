<?php
	
	require_once('Class_Combination.php');

	class CombinationStatistics extends Combination {
		public $cRd;
		public $cRf;
		public $cDd;
		public $cDf;

		public function CombinationStatistics() {
			//init
		}

		public function populateStats(){
			$this->find_cRd();
			$this->find_cRf();
		}

		public function find_cRd() {
			$this->find_cDd();
			$cDd = $this->cDd;
			rsort($cDd);
			$cRd = '';
			foreach ($cDd as $k => $v) {
				if($v != 0){
					$cRd .=	 $v;
				}
			}
			$this->cRd = $cRd;
		}

		public function find_cRf() {
			$this->find_cDf();
			$cDf = $this->cDf;

			rsort($cDf);
			$cRf = '';
			foreach ($cDf as $k => $v) {
				if($v != 0){
					$cRf .=	 $v;
				}
			}
			$this->cRf = $cRf;
		}

		public function find_RcRf() {
			$this->find_cDf();
			$cDf = $this->cDf;
			$cRf = '';
			foreach ($cDf as $k => $v) {
				if($v != 0){
					if($v>1){
						$cRf .=	 $k."($v)";
					} else { 
						$cRf .=	 $k;
					}
				}
			}
			$this->cRf = $cRf;
		}

		public function find_cDd() {
			$d = $this->d;
			$cDd = array(0,0,0,0,0,0);
			foreach ($d as $k => $v) {
				switch($v) {
					case ((1 <= $v)&&($v <=10)):
						$cDd[0]++;
						break;
					case ((11 <= $v)&&($v <=20)):
						$cDd[1]++;
						break;
					case ((21 <= $v)&&($v <=30)):
						$cDd[2]++;
						break;
					case ((31 <= $v)&&($v <=40)):
						$cDd[3]++;
						break;
					case ((41 <= $v)&&($v <=50)):
						$cDd[4]++;
						break;
					case ((51 <= $v)&&($v <=60)):
						$cDd[5]++;
						break;
				}
			}
			$this->cDd = $cDd;
		}
		public function find_cDf() {
			$d = $this->d;
			$cDf = array(0,0,0,0,0,0,0,0,0,0);
			foreach ($d as $k => $v) {
				$Df = $v[1];
				$cDf[$Df]++;
			}
			$this->cDf = $cDf;
		}
	}