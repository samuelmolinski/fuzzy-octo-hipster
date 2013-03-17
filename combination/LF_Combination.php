<?php
	require_once('Number.php');
	require_once('Combination.php');
	
	/**
	* principal class structure for the lotto facil 
	*/
	class LF_Combination extends Combination
	{
		public $print_id;
		public $D_config;	//cardinality of tens groups
		public $P_I;		//how many even numbers belong to Combination
		public $DF1_5;		//final digits between 1-5
		public $DF6_0s;		//final digits between 6-0 with 2N equal (pair of matching DF between 6-0)
		public $DFx3s;		//final digits with 3N equal
		public $DF_unique;	//final digits that only occur once
		public $N_consec;	//consecative N
		public $Ns_ta;		//cardinality of N that occured in the previous test
		public $config_1_2;
		public $config_1_6;
		public $config_2_7;
		public $config_5_6;
		public $config_6_7;
		public $config_3_4_6_8;
		public $config_a;
		
		public function LF_Combination($d = NULL)
		{	
			$this->Combination($d);
			$this->print_id = $this->print_id();
			$this->cal_D_config();
			$this->cal_P_I();
			$this->cal_DF1_5();
			$this->cal_DF6_0s();
			$this->cal_DFx3s();
			$this->cal_DF_unique();
			$this->cal_N_consec();
			$this->setCongfigs();
		}

		public function setCongfigs() {
			$this->config_1_2 = $this->print_D_config().'|'.$this->print_P_I();
			$this->config_1_6 = $this->print_D_config().'|'.$this->print_DF_unique();
			$this->config_2_7 = $this->print_P_I().'|'.$this->print_N_consec();
			$this->config_5_6 = $this->print_DFx3s().'|'.$this->print_DF_unique();
			$this->config_6_7 = $this->print_DF_unique().'|'.$this->print_N_consec();
			$this->config_3_4_6_8 = $this->print_DF1_5().'|'.$this->print_DF6_0s().'|'.$this->print_DF_unique().'|'.$this->print_Ns_ta();
			$this->config_a = array($this->config_1_2, $this->config_1_6, $this->config_5_6, $this->config_6_7, $this->config_3_4_6_8);
		}

	    public function printHTML_id() {
	        $d = $this->id;
	        $print = '';
	        $count = count($this->d);
	        for ($i=0; $i < $count-1; $i++) { 
	            $print .= "<span class='printHTML_id-$i'>".$this->d[$i]->n.'</span>-';
	        }
	        return $print."<span class='printHTML_id-14'>".$this->d[$count-1]->n.'</span>';
	    }

		public function print_D_config() {
			$tr = '';
			$temp = $this->D_config;
			$tr .= $temp[0];
			array_shift($temp);
			foreach ($temp as $key => $v) {
				$tr .= '-'.$v;
			}
			return $tr;
		}
		public function print_P_I() {
			return $this->P_I.'-'.(15-$this->P_I);
		}
		public function print_DF1_5() {
			return $this->DF1_5;
		}
		public function print_DF6_0s() {
			return $this->DF6_0s;
		}
		public function print_DFx3s() {
			$tr = '';
			$temp = $this->DFx3s;
			if(!empty($temp)){
				$tr .= $temp[0];
				array_shift($temp);
				foreach ($temp as $key => $v) {
					$tr .= ','.$v;
				}
			} else {
				$tr .= '-';
			}
			return $tr;
		}
		public function print_DF_unique() {
			/*$tr = '';
			$temp = $this->DF_unique;
			if(!empty($temp)){
				$tr .= $temp[0];
				array_shift($temp);
				foreach ($temp as $key => $v) {
					$tr .= ','.$v;
				}
			} else {
				$tr .= '-';
			}*/
			return count($this->DF_unique);
		}
		public function print_N_consec() {
			$tr = '';
			$temp = $this->N_consec;
			krsort($temp);
			if(!empty($temp)){
				$first = true;
				foreach ($temp as $key => $v) {
					if($first) {
						$tr .= $key.'x'.$v;
					} else if($key != 1) {
						$tr .= ', '.$key.'x'.$v;
					} else {
						$tr .= ', '.$v;
					}
					$first = false;
				}
				if(!isset($temp[1])) {
					$tr .= ', 0';
				}
			} else {
				$tr .= '-';
			}
			return $tr;
		}
		public function print_Ns_ta() {
			return $this->Ns_ta;
		}

		public function cal_D_config() {
			$config = array(0,0,0);

			foreach ($this->d as $k => $N) {
				$config[$N->D]++;
			}
			$this->D_config = $config;
			return $config;
		}

		public function cal_P_I() {
			$even = 0;
			foreach ($this->d as $k => $N) {
				if(0 == ($N->n%2) ){
					$even++;
				}
			}
			$this->P_I = $even;
			return $even;
		}

		public function cal_DF1_5(){
			$config = 0;		

			foreach ($this->d as $k => $N) {
				if((0 < $N->DF)&&($N->DF <6)) {
					$config++;
				}				
			}
			$this->DF1_5 = $config;
			return $config;
		}

		public function cal_DF6_0s() {			
			$config = array();

			foreach ($this->d as $k => $N) {
				if((0 == $N->DF)||((5 < $N->DF)&&($N->DF <= 9))) {
					@$config[$N->DF]++;
				}
			}
			$c = 0;
			foreach ($config as $k => $v) {
				if($v >=2) {
					$c++;
				}
			}
			$this->DF6_0s = $c;
			return $c;
		}

		public function cal_DFx3s() {			
			$config = array();

			foreach ($this->d as $k => $N) {
				@$config[$N->DF]++;
			}
			foreach ($config as $k => $v) {
				if($v < 3) {
					unset($config[$k]);
				}
			}
			$config = array_keys($config);
			sort($config);
			$this->DFx3s = $config;
			return $config;
		}

		public function cal_DF_unique() {			
			$config = array();

			foreach ($this->d as $k => $N) {
				@$config[$N->DF]++;
			}
			foreach ($config as $k => $v) {
				if($v != 1) {
					unset($config[$k]);
				}
			}
			$config = array_keys($config);
			sort($config);
			$this->DF_unique = $config;
			return $config;
		}
		public function cal_N_consec() {
			$config = array();
			$count = count($this->d);
			$curLen = 1;
			for ($i=0; $i < $count; $i++) { 
				if((($i+1) != $count)&&($this->d[$i]->n == ($this->d[$i+1]->n-1))) {
					$curLen++;
				} else {
					if(!isset($config[$curLen])){
						$config[$curLen] = 0;
					}
					$config[$curLen]++;
					$curLen = 1;
				}
			}
			ksort($config);
			$this->N_consec = $config;
			return $config;
		}

		public function cal_Ns_ta($prev_LF_C) {
			$count = 0;
			foreach ($this->d as $k => $N) {
				if(in_array($N, $prev_LF_C->d)) {
					$count++;
				}
			}
			$this->Ns_ta = $count;
			return $count;
		}


	}