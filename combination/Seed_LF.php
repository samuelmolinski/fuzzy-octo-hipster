<?php
	
	if(!function_exists('shortenURL')){
		require_once('../m_toolbox/m_toolbox.php');
	}
	require_once('Number.php');
	require_once('LF_Combination.php');

	/**
	* 
	*/
	class Seed_LF
	{
		public $wC; //winning Combination
		
		function __construct()
		{
			
			$this->wC = $this->get_wC();

		}
		static function get_wC($path = Null){
			if(NULL == $path) {
				$path = 'D_LOTFAC.HTM';
			}
	        
	        $megaSc = mLoadXml($path);
	        $megaSc = $megaSc->body->table->xpath('tr');
	        array_shift($megaSc);

	        $wC = array();
	        foreach($megaSc as $k=>$combination) {
	        	$d = array();
	        	for ($i=2; $i < 17; $i++) { 
	        		$d[] = new Number((string)$combination->td[$i]);
	        	}
	            sort($d);
	            $id = (int)$combination->td[0];
	            $wC[$id] = new LF_Combination($d);
	            $count = count($wC);
	            if(isset($wC[$id-1])){
		            $wC[$id]->cal_Ns_ta($wC[$id-1]);
		        }
	        }

			return $wC;
		}
		static function get_wC_raw($path = Null){
			if(NULL == $path) {
				$path = 'D_LOTFAC.HTM';
			}
	        
	        $megaSc = mLoadXml($path);
	        $megaSc = $megaSc->body->table->xpath('tr');
	        array_shift($megaSc);

	        $wC = array();
	        foreach($megaSc as $k=>$combination) {
	        	$d = '';
	        	for ($i=2; $i < 17; $i++) { 
	        		$d .= (string)$combination->td[$i];
	        	}
				$date = (string)$combination->td[1];
		        $wC[] = array( 'date'=>$date, 'combination'=>$d, 'group'=>2);
	        }

			return $wC;
		}

	}