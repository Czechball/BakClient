<?php

	class API{

		public $facebook;
		public $user;

		public $count = 0;  // total (mark*weight) SUM
		public $divide = 0; // total weight SUM
		
		const api_key = '869af33632a30586032c9594119c553e';
		const secret  = 'e9fcf9336e09d8798a3925840c30e650';

		const app_name = "Průměry";
		const app_url = "http://apps.facebook.com/prumery/";
		
		const STANDARD = 0;
		const DECIMAL = 1;
		
		/**************************/
		/**** Facebook methods ****/

		public function SetFB($facebook, $user)
		{
			// define FB data into class
			$this->facebook = $facebook;
			$this->user = $user;
		}
		 
		public function userName() 
		{
			$facebook = $this->facebook;
			$user = $this->user;

			$user_details = $facebook->api_client->users_getInfo($user, 'last_name, first_name, profile_url');
			$UserName = $user_details[0]['first_name']." ".$user_details[0]['last_name'];
			return $UserName;    
		}    
    
		public function userProfileURL() 
		{
			$facebook = $this->facebook;
			$user = $this->user;

			$user_details = $facebook->api_client->users_getInfo($user, 'last_name, first_name, profile_url'); 
			$UserProfile = $user_details[0]['profile_url'];
			return $UserProfile; 
		}
		
		/*****************************/
		/**** Application methods ****/

		function FormatMark($mark, $format){
			if($format == self::DECIMAL)		return str_replace('-', '.5', $mark);
			elseif($format == self::STANDARD)	return str_replace('.5', '-', $mark);
		}
		
		/**************************/
		/**** Printout methods ****/
		
		function Heading($heading, $br=1){
			for($i=0; $i<$br; $i++) echo '<br>';
			printf("<h2>%s</h2>",$heading);
		}
		
		function ViewMarks($marks){
			$data = explode(' ', $marks);
			echo '<table>';
			foreach($data as $i=>$mark){
				if($i%4==0)echo '<tr>';
				$mark = explode('x', $mark);
				$this->count = $this->count + ($mark[0]*$mark[1]);
				$this->divide = $this->divide + ($mark[1]);
				echo '<td class="xmark">'.$this->FormatMark($mark[0], self::STANDARD).'<td class="xweight"> s váhou '.$mark[1];
			}
			echo '</table>';
			if($this->divide == 0){
				echo 'Nelze dělit nulou';
				die();
			}
		}

		function ViewAverage(){
			echo '<strong style="font-size: 24px; font-weight: bold;">'.round($this->count/$this->divide, 5).'</strong><br>';				
		}
		
		function ViewChange($marks){
			$data = explode(' ', $marks);
			for($x=1; $x<=5; $x++){
				$MARK = round($this->count/$this->divide);
				if($x != $MARK){
					$count = 0;
					$divide = 0;
					foreach($data as $i=>$mark){
						$mark = explode('x', $mark);
						$count = $count + ($mark[0]*$mark[1]);
						$divide = $divide + ($mark[1]);
					}
				}
				if	  ($MARK<$x)echo 'Aby sis to pokazil na <strong>'.$x.'</strong>, musíš dostat pětku s váhou '.(floor(($this->count-($x-0.5)*$this->divide)/(($x-0.5)-5))+1) . '<br>'; // = 4.5 - 5
				elseif($MARK>$x)echo 'Aby sis to opravil na <strong>'.$x.'</strong>, musíš dostat jedničku s váhou '.(floor(($this->count-($x+0.5)*$this->divide)/(($x+0.5)-1))+1) . '<br>'; // = 1.5 - 1
				elseif(!in_array($MARK, Array("1","5"))) echo '<br>';
			}
		}
		
		function ViewLink(){
			echo '<small style="color: #777777;">http://apps.facebook.com/prumery/?q='.str_replace(" ", "+", $_GET['q'])."</small><br>";
		}
		
		function ViewFuture(){
			echo '<br><table>';
			for($x=1; $x<=5; $x+=0.5){
			$data = explode(' ', $_GET['q']);
			$count = 0;
			$divide = 0;
			foreach($data as $i=>$mark){
				if($i%4==0)echo '<tr>';
				$mark = explode('x', $mark);
				$count = $count + ($mark[0]*$mark[1]);
				$divide = $divide + ($mark[1]);
			}
			if($divide == 0){
				echo 'Nelze dělit nulou';
				die();
			}
			echo '<tr><td style="padding-right: 15px;">'.$this->FormatMark($x, self::STANDARD).'<td><strong>'.sprintf("%.2f", round(($count + ($x*$_GET['future']))/($divide+ $_GET['future']), 2)).'</strong>';
			}
			echo '</table>';
		}
	}
?>