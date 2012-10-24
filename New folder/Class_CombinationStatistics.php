<?php
	
	require_once('Class_Combination.php');

	class CombinationStatistics extends Combination {
		public $cRd;
		public $cRf;
		public $cDd;
		public $cDf;
		public $cRd_cRf;
		public $foe; //Factor of elimination

		public function CombinationStatistics($d = NULL) {
			$this->Combination($d);
			$this->populateStats();
			$this->cRd_cRf = $this->cRd_cRf();
			$this->find_foe();
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
		public function cRd_cRf() {
			return $this->cRd.'-'.$this->cRf;
		}
		public function print_cDd() {
			$s = '';
			foreach ($this->cDd as $key => $value) {
				if($value > 0) {
					if($value > 1) {
						$s .= $key.'('.$value.')';
					} else {
						$s .= $key;
					}
				}
			}
			return $s;
		}
		public function print_cDf() {
			$s = '';
			foreach ($this->cDf as $key => $value) {
				if($value > 0) {
					if($value > 1) {
						$s .= $key.'('.$value.')';
					} else {
						$s .= $key;
					}
				}
			}
			return $s;
		}
		public function find_foe(){
			$cRd_cRf = $this->cRd_cRf;
			switch ($cRd_cRf) {
				//12 pairs cRd-Cdf using CRf to eliminate
				case '2211-2211':
				case '21111-2211':
				case '3111-2211':
				case '321-2211':
				case '3111-21111':
				case '321-21111':
				case '2211-3111':
				case '21111-3111':
						$this->foe = $this->print_cDf();
					break;
				case '111111-21111':
				case '222-21111':
				case '411-21111':
				case '3111-3111':
						$cDf = $this->print_cDf();
						$cDf = preg_replace('/[0-9]\([0-9]\)/', '', $cDf);
						$this->foe = $cDf;
					break;
				//8 pairs cRd-Cdf using CRf in part with cRd to eliminate
				case '2211-21111'://???
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$cDf = preg_replace('/[0-9]\([0-9]\)/', '', $cDf);
						$this->foe = $cDd.''.$cDf;
					break;
				case '2211-111111': 
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$this->foe = $cDd.''.$cDf;
					break;
				case '21111-21111': //???
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/[0-9]\([0-9]\)/', '', $cDd);
						$cDf = $this->print_cDf();
						$cDf = preg_replace('/[0-9]\([0-9]\)/', '', $cDf);
						$this->foe = $cDd.''.$cDf;
					break;
				case '21111-111111':
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$this->foe = $cDd.''.$cDf;
					break;
				case '321-111111':
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$this->foe = $cDd.''.$cDf;
					break;
				case '3111-111111':
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$this->foe = $cDd.''.$cDf;
					break;
				case '2211-321':
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDd);
						$cDf = $this->print_cDf();
						$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDf);
						$this->foe = $cDd.''.$cDf;
					break;
				case '21111-321':
						$cDd = $this->print_cDd();
						$cDd = preg_replace('/[0-9]\([0-9]\)/', '', $cDd);
						$cDf = $this->print_cDf();
						$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $cDf);
						$this->foe = $cDd.''.$cDf;
					break;				
				default:
						$this->foe ="DNE";
					break;
			}
		}
	}