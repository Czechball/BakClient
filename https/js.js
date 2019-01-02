		google.load("visualization", "1", {packages:["corechart"]});
		
		/* 
		 * FUNCTION DRAW CHART
		 * Assists drawing a chart with added mark.
		 */
		 
		function draw_chart() {
				var $avgs_table = $('#avgs_table th');
				var data = google.visualization.arrayToDataTable([
					['Známka', 'Průměr'],
					['1',  parseFloat($avgs_table.eq(0).html())],
					['1-',  parseFloat($avgs_table.eq(1).html())],
					['2',  parseFloat($avgs_table.eq(2).html())],
					['2-',  parseFloat($avgs_table.eq(3).html())],
					['3',  parseFloat($avgs_table.eq(4).html())],
					['3-',  parseFloat($avgs_table.eq(5).html())],
					['4',  parseFloat($avgs_table.eq(6).html())],
					['4-',  parseFloat($avgs_table.eq(7).html())],
					['5',  parseFloat($avgs_table.eq(8).html())]
					]);

				var options = {
					backgroundColor:{
						color: 'none',
						fill: '#ffffff',
					},
					legend: {position: 'none'},
					vAxis: {maxValue: 5, minValue: 1, 
						gridlines: {color: '#eeeeee', count: 5}, 
						minorGridlines: {color: '#aabbee', count: 1},
						textStyle: {fontSize: 11, color: '#777777', fontName: 'Arial'}},
					hAxis: {
						textStyle: {fontSize: 11, color: '#777777', fontName: 'Arial'}
					},
					chartArea: {width: 540, height: 160}
				};


				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				chart.draw(data, options);
		}
		
		function draw_semester_chart() {
				var $avgs_table = $('.vysvedceni');
				
				var temp = [];
				
				var array = [];
				array.push(['Pololetí', 'Průměr']);
				
				$avgs_table.find("tr").each(function()
				{
					i = 0;
					$(this).find("td").each(function()
					{
						val = $(this).html();
						if(val != "-")
						{
							if(typeof temp[i] == "undefined")
							{							
								temp[i] = [parseInt(val), 1];
							}
							else
							{							
								temp[i][0] += parseInt(val);
								temp[i][1] += 1;
							}
						}
						i++;
					});
				});
				
				console.log(temp);
				i = 0;
				for ( var val in temp)
				{
					i++;
					trida = Math.ceil(i/2);
					pololeti = ((i-1)%2)+1;
					array.push([trida + ".V " + pololeti, (temp[val][1] == 0 ? 0 : temp[val][0]/temp[val][1])]);
				}
				
				console.log(array);
			
				
				var data = google.visualization.arrayToDataTable(array);

				var options = {
					backgroundColor:{
						color: 'none',
						fill: 'none'
					},
					legend: {position: 'none'},
					vAxis: {maxValue: 5, minValue: 1, 
						gridlines: {color: '#aaaaaa', count: 5}, 
						minorGridlines: {color: '#cccccc', count: 1},
						textStyle: {fontSize: 11, color: '#777777', fontName: 'Arial'}},
					hAxis: {
						textStyle: {fontSize: 11, color: '#777777', fontName: 'Arial'}
					},
					chartArea: {width: "100%", height: 160}
				};


				var chart = new google.visualization.LineChart(document.getElementById('chart_div_semester'));
				chart.draw(data, options);
		}
		
		function show_modal()
		{
			$("#modal").animate({opacity: 'show'}, 300);
		}

		function hide_modal()
		{
			$("#modal").animate({opacity: 'hide'}, 300);
		}
		
		function frame(file) 
		{	
			show_modal();
			$.get('frames/frame.'+file+'.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}
		
		function frame_login()
		{
			$.post('frames/frame.login.php', $("#loginform").serialize(), function(response) {
				$.get('frames/frame.marks.php', function(response) {
					hide_modal();
					$('#ajaxspace').html(response);
				});
				$.get('frames/frame.nav.php', function(response) {
					hide_modal();
					$('#ajaxspace-menu').html(response);
				});
			});
		}
		
		function frame_timetable()
		{	
			show_modal();
			$.get('frames/frame.timetable.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}
		
		function frame_marks()
		{
			show_modal();
			$.get('frames/frame.marks.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}

		function frame_absence()
		{
			show_modal();
			$.get('frames/frame.absence.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}

		function frame_jidelna()
		{
			show_modal();
			$.get('frames/frame.jidelna.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}

		function frame_addmark(index)
		{
			show_modal();
			$.get('frames/frame.addmark.php?index='+index, $("#markform").serialize(),function(response) {
			$.get('frames/frame.details.php?index='+index, function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
			});
		}
		
		function frame_hidemark(index, markIndex)
		{
			show_modal();
			$.get('frames/frame.hidemark.php?index='+index+'&markIndex='+markIndex, function(response) {
			if(index == 0)
			$.get('frames/frame.marks.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
			else
			$.get('frames/frame.details.php?index='+index, function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
			});
		}
		
		function frame_delmark(index, markIndex )
		{
			show_modal();
			$.get('frames/frame.delmark.php?index='+index+'&markIndex='+markIndex,function(response) {
			if(index == 0)
			$.get('frames/frame.marks.php', function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
			else
			$.get('frames/frame.details.php?index='+index, function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
			});
		}


		function frame_averages()
		{
			show_modal();
			$.get('frames/frame.avgs.php', $("#avgsform").serialize(),function(response) {
				hide_modal();
				$('#ajaxaverages').html(response);
				draw_chart();
			});
		}
		
		function frame_details(index)
		{
			show_modal();
			$.get('frames/frame.details.php?index='+index, function(response) {
				hide_modal();
				$('#ajaxspace').html(response);
			});
		}


		
		function frame_logout()
		{
			show_modal();
			$.post('frames/frame.logout.php', function(response) {
				$.get('frames/frame.loginbox.php', function(response) {
					hide_modal();
					$('#ajaxspace').html(response);
					$('#ajaxspace-menu').html('');
				});
			});
		}

		
		function frame_logout_kick()
		{
			show_modal();
			$.post('frames/frame.logout.php', function(response) {
				$.get('frames/frame.loginbox.php?wrong', function(response) {
					hide_modal();
					$('#ajaxspace').html(response);
					$('#ajaxspace-menu').html('');
				});
			});
		}
		
		$(document).ready(function(){
			$(document).on("click","#moznosti",function()
			{
				$("#modal").animate({opacity: "show"}, 500);
				$(".moznostibox").animate({height: "show", opacity: "show"}, 200);
			});
			
			$(document).on("click", ".closelink", function() {
				$("#modal").animate({opacity: "hide"}, 500);
				$(".moznostibox").animate({height: "hide", opacity: "hide"}, 200);
				$(".znamkabox").animate({height: "hide", opacity: "hide"}, 200);
			});
			
			$(document).mouseup(function (e)
			{
				var container = $("#modal");
				if (container.has(e.target).length === 0)
				{
					$("#modal").animate({opacity: "hide"}, 500);
					$(".moznostibox").animate({height: "hide", opacity: "hide"}, 200);
					$(".znamkabox").animate({height: "hide", opacity: "hide"}, 200);
				}
			});
			
			$(document).on("click",".markgroup",function()
			{
				$t = $(this);
				
				html = "<h2>"  + $t.find("span.mark").html() + " <span style='color: #999999'>" + $t.find('span.weight').html() + "</span></h2>";
				
				if($t.hasClass("nova"))
				{
					html += "<p>Toto je <strong style='color:red'>nová</strong> známka (podle bakalářů, nevím, podle čeho to počítají)</p>";
				}
				if($t.hasClass("skryta"))
				{
					html += "<p>Známka je <strong style='color: #888888'>skrytá</strong> a nezapočítává se do průměru.</p>";
				}
				if($t.hasClass("blue"))
				{
					html += "<p>Tato známka byla <strong style='color: #559911;'>přidána</strong> pro orientační výpočet průměru.</p>";
				}

				if($t.hasClass("skryta"))
				{
					html += "<br>";
					html += '<center><a href="#" class="closelink" onclick="frame_hidemark('+$t.data('subject')+', '+$t.data('mark')+')" id="save">Odkrýt známku</a> <a href="#" class="closelink" id="close">Zavřít okno</a></center>';
				}
				else if($t.hasClass("blue"))
				{
					html += "<br>";
					html += '<center><a href="#" class="closelink" onclick="frame_delmark('+$t.data('subject')+', '+$t.data('mark')+')" id="save">Odstranit známku</a> <a href="#" class="closelink" id="close">Zavřít okno</a></center>';
				}
				else
				{
					html += "<br>";
					html += '<center><a href="#" class="closelink" onclick="frame_hidemark('+$t.data('subject')+', '+$t.data('mark')+')" id="save">Skrýt známku</a> <a href="#" class="closelink" id="close">Zavřít okno</a></center>';
				}
						
				$("#modal").animate({opacity: "show"}, 500);
				$(".znamkabox").html(html).animate({height: "show", opacity: "show"}, 200);
			});

		});