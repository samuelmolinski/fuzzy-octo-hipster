<?php 

	require_once('LF_Combination.php');
	require_once('Seed_LF.php');
	
	/**
	*  Restrictions for the Lotto Facil System
	*/
	class LF_Restrictions
	{
		public $wC;
		public $recent_2_7config;
		function __construct($wC = null)
		{
			if(!isset($wC)){
				$this->wC = Seed_LF::get_wC();
			} else {
				$this->wC = $wC;
			}		
		}

		static function restrict_N0($C) {
			$accepted0 = array(1,2,3,4);
			if(	in_array($C->d[0]->n, $accepted0)) {
				return true;
			}
			return false;
		}
		static function restrict_N1($C) {
			$accepted1 = array(2,3,4,5,6);
			if(	in_array($C->d[1]->n, $accepted1)) {
				return true;
			}
			return false;
		}
		static function restrict_N14($C) {
			$accepted14 = array(22,23,24,25);
			if(	in_array($C->d[14]->n, $accepted14)) {
				return true;
			}
			return false;
		}

		static function restrict_D_config($C) {
			$min = 4;
			$max = 8;
			$min2 = 2;
			$max2 = 5;

			if(	($C->D_config[0] >= $min) &&
				($C->D_config[1] >= $min) &&
				($C->D_config[0] <= $max) &&
				($C->D_config[1] <= $max) &&
				($C->D_config[2] >= $min2) &&
				($C->D_config[2] <= $max2)){
				return true;
			}
			return false;
		}

		static function restrict_accepted_D_config($C) {
			$accepted = array(array(4,6,5), array(6,4,5), array(5,5,5), array(8,5,2), array(5,8,2), array(7,6,2), array(6,7,2), array(8,4,3),
							  array(4,8,3), array(7,5,3), array(5,7,3), array(6,6,3), array(7,4,4), array(4,7,4), array(6,5,4), array(5,6,4));
			if (in_array($C->D_config, $accepted)) {
				return true;
			}
			return false;
		}

		static function restrict_D_config_limit($C, $prev_C) {
			if ($C->D_config != $prev_C->D_config) {
				return true;
			}
			return false;
		}

		static function restrict_P_I($C){			
			$min = 5;
			$max = 10;
			if(($min <= $C->P_I)&&($C->P_I <= $max)){
				return true;
			}
			return false;
		}

		static function restrict_P_I_limit($C, $prev3_C_list){	
			if((($C->P_I == 5)&&($C->P_I == $prev3_C_list[0]->P_I))||(($C->P_I == 10)&&($C->P_I == $prev3_C_list[0]->P_I))){
				return false;
			}
			if(($C->P_I == $prev3_C_list[0]->P_I)&&($prev3_C_list[0]->P_I == $prev3_C_list[1]->P_I)&&($prev3_C_list[1]->P_I == $prev3_C_list[2]->P_I)){
				return false;
			}
			return true;
		}

		static function restrict_DF1_5($C) {		
			$min = 7;
			$max = 11;
			if(($min <= $C->DF1_5)&&($C->DF1_5 <= $max)){
				return true;
			}
			return false;
		}

		static function restrict_DF1_5_limit($C, $prev3_C_list){	
			if(($C->DF1_5 == 11)&&($C->DF1_5 == $prev3_C_list[0]->DF1_5)){
				return false;
			}	
			if(($C->DF1_5 == 7)&&($C->DF1_5 == $prev3_C_list[0]->DF1_5)){
				return false;
			}
			if((($C->DF1_5 == 8)||($C->DF1_5 == 10))&&($C->DF1_5 == $prev3_C_list[0]->DF1_5)&&($prev3_C_list[0]->DF1_5 == $prev3_C_list[1]->DF1_5)){
				return false;
			}
			return true;
		}

		static function restrict_DF6_0s($C) {
			$min = 0;
			$max = 3;
			if(($min <= $C->DF6_0s)&&($C->DF6_0s <= $max)){
				return true;
			}
			return false;
		}

		static function restrict_DF6_0s_limit($C, $prev4_C_list){	
			if(($C->DF6_0s == 0)){
				$count = 0;
				$limit = 1;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF6_0s == $prev4_C_list[$i]->DF6_0s) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			}
			if(($C->DF6_0s == 3)){
				$count = 0;
				$limit = 1;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF6_0s == $prev4_C_list[$i]->DF6_0s) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			}
			if(($C->DF6_0s == 1)){
				$count = 0;
				$limit = 3;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF6_0s == $prev4_C_list[$i]->DF6_0s) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			}
			if(($C->DF6_0s == 2)){
				$count = 0;
				$limit = 4;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF6_0s == $prev4_C_list[$i]->DF6_0s) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			}
			return true;
		}

		static function restrict_DFx3s($C) {
			$min = 0;
			$max = 2;
			$count = count($C->DFx3s);
			if(($min <= $count)&&($count <= $max)){
				return true;
			}
			return false;
		}

		static function restrict_DFx3s_limit_a($C) {
			$arr = array();
			$limit = 3;
			foreach ($C->DFx3s as $k => $n) {
				if(!isset($arr[$n])) {
					$arr[$n] = 0;
				}
				$arr[$n]++;
			}
			foreach ($arr as $k => $count) {
				if($count >= $limit){
					return false;
				}
			}
			return true;
		}

		/*static function restrict_DFx3s_limit_b($C, $prev3_C_list) {
			$count = 0;
			$limit = 1;
			for ($i=0; $i < $limit; $i++) { 
				if($C->DFx3s == $prev3_C_list[$i]->DFx3s) {
					$count++;
				}
			}
			if($count < $limit){
				return true;
			}
			return false;
		}*/

		static function restrict_DF_unique($C) {
			$min = 2;
			$max = 6;
			$count = count($C->DF_unique);
			if(($min <= $count)&&($count <= $max)){
				return true;
			}
			return false;
		}

		static function restrict_DF_unique_limit($C, $prev3_C_list) {
			
			if($C->DF_unique == 2) {
				$count = 0;
				$limit = 1;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF_unique == $prev3_C_list[$i]->DF_unique) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			} elseif ($C->DF_unique == 6) {
				$count = 0;
				$limit = 1;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF_unique == $prev3_C_list[$i]->DF_unique) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			} else {
				$count = 0;
				$limit = 2;
				for ($i=0; $i < $limit; $i++) { 
					if($C->DF_unique == $prev3_C_list[$i]->DF_unique) {
						$count++;
					}
				}
				if($count < $limit){
					return true;
				}
				return false;
			}
		}

		static function restrict_N_consec($C) {
			$maxCardinaly = 3;
			$maxConsN = 7;
			foreach ($C->N_consec as $key => $value) {
				if($key > $maxConsN) return false;
				//if($value > $maxCardinaly) return false;
				if(($key == 1)&&($value >= 6)) return false;
			}
			return true;
		}

		static function restrict_N_consec_limit($C) {
			if((@$C->N_consec[1] > 5)) {
				return false;
			}
			return true;
		}

		static function restrict_N_consec_config_limit($C, $prev10_C_list) {
			foreach ($prev10_C_list as $k => $C2) {
				if($C->N_consec == $C2->N_consec) {
					//d($C->N_consec == $C2->N_consec);
					return false;
				}
			}
			
			return true;
		}


		static function restrict_Ns_ta($C) {
			$min = 7;
			$max = 11;
			if(($min <= $C->Ns_ta)&&($C->Ns_ta <= $max)){
				return true;
			}
			return false;
		}

		public function restrict_Ns_ta_limit($C, $prev4_C_list){	
			$e1 = $this->N_equal($C, $prev4_C_list[0]);	
			$e2 = $this->N_equal($C, $prev4_C_list[1]);	
			$e3 = $this->N_equal($C, $prev4_C_list[2]);
			$e4 = $this->N_equal($C, $prev4_C_list[3]);

			if((($e1 == 7)||($e1 == 11))&&($C->Ns_ta == $prev4_C_list[0]->Ns_ta)) {
				return false;
			}
			if((($e1 == 8)||($e1 == 9)||($e1 == 10))&&($C->Ns_ta == $prev4_C_list[0]->Ns_ta)&&($C->Ns_ta == $prev4_C_list[1]->Ns_ta)&&($C->Ns_ta == $prev4_C_list[2]->Ns_ta)&&($C->Ns_ta == $prev4_C_list[3]->Ns_ta)) {
				return false;
			}
			return true;
		}

		public function N_equal($C, $C2) {
			$count = 0;
			foreach ($C->d as $k => $N) {
				if(in_array($N, $C2->d)){
					$count++;
				}
			}
			return $count;
		}

		public function N_14_equal($C) {
			foreach ($this->wC as $k => $c) {
				if($this->N_equal($C, $c) < 14){
					return true;
				}
			}			
			return false;
		}
		public function N_X_equal($C, $id = null) {
			$equalN = 0;
			foreach ($this->wC as $k => $c) {
				$temp = 0;
				if($id != $k) {
					$temp = $this->N_equal($C, $c);
				} 
				if($equalN < $temp){
					$equalN = $temp;
				}
			}			
			return $equalN;
		}
		public function restrict_1_2config($C, $prev10_C_list) {
			$C_1 = $C->D_config;
			$C_2 = $C->P_I;

			$arr_N = array(
					array(7,5,3),
					array(5,7,3),
					array(6,5,4),
					array(5,6,4),
					array(7,6,2),
					array(6,7,2),
					array(6,6,3),
				);

			if(in_array($C_2, array(6,7,8))&&in_array($C_1, $arr_N)) {
				$list = array();

				
				for($i=0; $i <10; $i++) {
					$c = $prev10_C_list[$i];
					if(in_array($c->P_I, array(6,7,8))&&in_array($c->D_config, $arr_N)) {
						$list[] = array($c->D_config, $c->P_I);
					}
				}

				if(!in_array(array($C_1,$C_2), $list)) {
					return true;
				}
				return false;
			} else {
				return true;
			}
		}
	}