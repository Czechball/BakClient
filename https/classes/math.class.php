<?php
class Math
{
		public function Mark_to_decimal($mark)
		{
			/* Pøevede známku s mínusem na desetinné èíslo */
			if(is_numeric($mark)) return $mark;
			else return intval($mark[0])+0.5;
		}
		
		public function Get_average($marks_clean, $marks_clean_added = Array())
		{
		
			/* Vzorec pro vypocet: (znamka*vaha + znamka*vaha + ...) / SUM(váhy) */
			$delenec = 0;
			$delitel = 0;
			foreach($marks_clean as $mark){
				if($mark[0] != 'N' && $mark[0] != 'A' && $mark[0] != 'X' && $mark[0] != '?' && $mark[2] != 2)
				{
					$delenec += $this->Mark_to_decimal($mark[0]) * $mark[1];
					$delitel += $mark[1];
				}
			}
			if(!empty($marks_clean_added))
			{
				foreach($marks_clean_added as $mark)
				{
					$delenec += $this->Mark_to_decimal($mark[0]) * $mark[1];
					$delitel += $mark[1];
				}
			}
			
			$this->soucetznamek = $delenec;
			$this->soucetvah = $delitel;
			
			if($delitel > 0) $podil = $delenec / $delitel;
			else $podil = '';
			return $podil;
		}
		
		public function Get_average_with($mark, $weight, $round = 2)
		{
			/* Spoèítá prùmìr s další známkou */
			return sprintf("%01.".$round."f", round(($this->soucetznamek + $mark * $weight) / ($this->soucetvah + $weight), $round));
		}

		public function Get_needed_weight($mark, $result, $format = true){

			/* Vzorec pro vypocet: vaha = (vysledek * soucet vah - soucet znamek) / (znamka - vysledek) */	
			$weight = ($result * $this->soucetvah - $this->soucetznamek) / ($mark - $result);
			if($format == false) return $weight;
			else return ($this->Is_decimal($weight) ? '<abbr title="'.$weight.'">' . round($weight, 1) . '</abbr>' : $weight);
			
		}
		
		private function Is_decimal( $val )
		{
			/* Zjistí, zda je èíslo desetinné */
			return is_numeric( $val ) && floor( $val ) != $val;
		}

		public function Half_floor($average){
			/* Zaokrouhlí dolù na nerozhodný prùmìr */
			if($average == 1.5) return 1.5;
			elseif($average == 2.5 || $average == 3.5 || $average == 4.5) return $average-1;			
			else return floor($average - 0.5) + 0.5;
		}

		public function Half_ceil($average){
			/* Zaokrouhlí nahoru na nerozhodný prùmìr */
			if($average == 4.5) return 4.5;
			elseif($average == 1.5 || $average == 2.5 || $average == 3.5) return $average+1;			
			else return ceil($average + 0.5) - 0.5;
		}


		public function makeHex($num)
		{
			return str_pad(dechex($num), 2, "0", STR_PAD_LEFT);
		}
		
		public function makeBGColor($colorName, $intensity)
		{
			$color = round(pow(round($intensity*6),1.10));
			$max = hexdec("ff");
			
			if($color > $max)
			{
				$color = $max;
			}
			
			if($colorName == "red") return "#".$this->makeHex($max).$this->makeHex($color).$this->makeHex($color);
			elseif($colorName == "green") return "#".$this->makeHex($color).$this->makeHex($max).$this->makeHex($color);
			else return "#000000";
		}
		
		public function makeColor($colorName, $intensity)
		{
			$color = round(pow(round($intensity*2),1.10));
			$max = hexdec("66");
			
			if($color > $max)
			{
				$color = $max;
			}
			
			if($colorName == "red") return "#".$this->makeHex($max).$this->makeHex($color).$this->makeHex($color);
			elseif($colorName == "green") return "#".$this->makeHex($color).$this->makeHex($max).$this->makeHex($color);
			else return "#000000";
		}
}


?>