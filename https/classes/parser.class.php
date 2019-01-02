<?php

class Parser
{
		public static function getBody($str)
		{
			return explode("<body>", $str)[1];
		}
		
		public static function getFood($str)
		{
			preg_match("#<div class=\"text_volby\">(.*?)</div>#s", $str, $matches);
			//return explode("<div class=\"den\">", $str);	
			return $matches;
		}

		public static function parseName($str)
		{
			return preg_replace("~.*<td style=\"width:100%;\" class=\"logjmeno\" colspan=\"2\">(.*?)<\/td>.*~s", "\\1", $str);
		}
	
		public static function parseTimeTable($str, $title = 'Rozvrh na tento týden')
		{
			/* Najde tabulku s rozvrhem */
			return '<div class="box"><div class="border"><h2>'.$title.'</h2>'.preg_replace("~.*cphmain_roundrozvrh_RPC.*?>(.*?)<!--.*~s", "\\1", $str) . '</div></div>';
		}

		public static function parseMarkTable($str)
		{
			/* Najde tabulku se známkama */
			return preg_replace("~.*<table class=\"radekznamky\">(.*?)<\/table>.*~s", "\\1", $str);
		}

		public static function parseReportTable($str)
		{
			/* Najde tabulku se známkama */
			return preg_replace("~.*<table class=\"tablepolo\">(.*?)<\/table>.*~s", "\\1", $str);
		}

		public static function parseReportSubjects($str)
		{
			preg_match_all("~<tr><td class=\"polonazev\">(.*?)<\/td>(.*?)</tr>~s", $str, $matches);
			return $matches;
		}

		public static function parseReportMarks($str)
		{
			preg_match_all("~<td class=\"poloznamka\">([-0-9])?<\/td>~s", $str, $matches);
			return $matches;
		}

		
		public static function splitTable($str)
		{
			/* Rozdělí tabulku se známkama na části s jednotlivými předměty */
			return explode('<div class="nazevprdiv">', $str);

		}
		
		public static function parseAbsenceTable($str)
		{
			/* Najde tabulku s průběžnou absencí */
			$str = preg_replace("~.*cphmain_roundrozvrh_RPC.*?>(.*?)<\/div>.*~s", "\\1", $str);
			$str = str_replace('<img src="images/wAbsent.gif" />','Absence',$str);
			$str = str_replace('<img src="images/wAbOk.gif" />','Omluvená absence',$str);  
			$str = str_replace('<img src="images/wAbMiss.gif" />','Neomluvená absence',$str);
			$str = str_replace('<img src="images/wAbLate.gif" />','Pozdní příchod',$str);
			$str = str_replace('<img src="images/wAbSoon.gif" />','Dřívější odchod',$str);
			$str = str_replace('<img src="images/wAbPrez.gif" />','Prezentace školy',$str);
			return $str;
		}
		
		public static function parseAbsenceTable2($str)
		{
			/* Najde tabulku se zameškaností */
			return preg_replace("~.*<div align=\"center\">(.*?)<\/div>.*~s", "\\1", $str);
		}
		
		public static function parseSubject($str)
		{
			/* Zjistí název předmětu */
			preg_match_all("~>(.*?)<\/a>~s", $str, $subject);
			return $subject[1][0];
		}
		
		public static function parseMarks($str, $subjectIndex)
		{

			//preg_match_all("~váha ([0-9]+)\">~s", $str, $weights); // váhy
			//preg_match_all("~([znamka|dní])\">([XAN0-9-]+)<~s", $str, $marks); // známky
			
			$str = explode("<tr class=\"detznamka\">",$str)[1];
			$str = explode("<tr class=\"typ\">",$str);
			
/*			preg_match_all("~váha ([0-9]+)\">~su", $str[1], $weights); // váhy
			preg_match_all("~(class=\"znnovejsi\" )?(title=\")?([\!ěščřžýáíéĚŠČŘŽÝÁÍÉa-zA-Z0-9\\s-,\.]*?)[\"]?>([\!XAN0-9][-]?)</td>~su", $str[0], $marks); // známky*/

			preg_match_all("~váha ([0-9]+)\">~su", $str[1], $weights); // váhy
			/*preg_match_all("~(class=\"znnovejsi\" )?(title=\")?(.*?)[\"]?>(.*?)</td>~su", $str[0], $marks);*/
			preg_match_all("~<td( class=\"znnovejsi\")?( title=\")?(.*?)[\"]?>(.*?)</td>~su", $str[0], $marks);
			
			$marks_clean = array();
			$i = 0;
			
			foreach($weights[1] as $index => $weight)
			{
				if(isset($_SESSION['hiddenMarks'][$subjectIndex][$i]) && $_SESSION['hiddenMarks'][$subjectIndex][$i] == 1)
				{
					$type = 2;
				}
				elseif($marks[1][$index] == " class=\"znnovejsi\"")
					$type = 1;
				else
					$type = 0;
					
				$marks_clean[] = Array(0=>trim($marks[4][$index],'!'), 1=>$weight, 2=>$type, 3=>$marks[3][$index]);
				$i++;
			}
						
			return $marks_clean; // Array( Array(známka, váha, nová?), ... )
			
		}

}

?>