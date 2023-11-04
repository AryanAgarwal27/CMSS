<?/// sum_graph_complete_abandon.php

function sum_graph_calls_buys($_day, $_month, $_year, $_queue, $_source, $_store)
{
global $text_graphics_sum_graph_calls_buys;
global $text_graphics_Hours;
global $text_graphics_Days;
global $text_graphics_Months;
global $text_graphics_overall_buys;
global $text_graphics_complete_calls;
global $text_graphics_Calls;
global $text_graphics_Buys;
global $db_con;
global $db_con_asterisk;

$complete_calls=0;
$overall_buys=0;
$without_consults=0;
$with_consults=0;

/// Initialize Chart
# Create Column3D chart Object 
$FC = new FusionCharts("MSArea2D","500","400"); 
# set the relative path of the swf file
$FC->setSWFPath("charts/");

/// Year Month or Day Selected
$count=24; /// Day
($_day==0)?$count=31:''; /// Month
($_day==0 && $_month==0 )?$count=12:''; /// Year

for($date=1;$date<=$count;$date++)
{
	$month=date('m',mktime(0,0,0,$_month,$date,$_year));
	if($month-$_month==0 || $count==12)
	{
		switch ($count)
		{
			case '24': // Day
				$from_date=$to_date=date('Y-m-d', mktime(0,0,0,$_month,$_day,$_year));
				$from_time=date('H:i:s', mktime($date-1,0,0,$_month,$_day,$_year));
				$to_time=date('H:i:s', mktime($date-1,59,59,$_month,$_day,$_year));
				$from_time_graph=date('H:i', mktime($date-1,0,0,$_month,$_day,$_year));
				$FC->addCategory($from_time_graph);
$strParam="rotateNames=1;yaxisname=$text_graphics_Calls/$text_graphics_Buys;numdivlines=9;divLineColor=CCCCCC;divLineAlpha=80;decimalPrecision=0;showAlternateHGridColor=1;AlternateHGridAlpha=30;AlternateHGridColor=CCCCCC;caption=$text_graphics_sum_graph_calls_buys $text_graphics_Hours;animation=0";
				break;
			case '31': //Month
				$from_date=$to_date=date('Y-m-d', mktime(0,0,0,$_month,$date,$_year));
				$from_time='00:00:00';
				$to_time='23:59:59';
				$FC->addCategory($from_date);
$strParam="rotateNames=1;yaxisname=$text_graphics_Calls/$text_graphics_Buys;numdivlines=9;divLineColor=CCCCCC;divLineAlpha=80;decimalPrecision=0;showAlternateHGridColor=1;AlternateHGridAlpha=30;AlternateHGridColor=CCCCCC;caption=$text_graphics_sum_graph_calls_buys $text_graphics_Days;animation=0";
				break;
			case '12': //Year
				$from_date=date('Y-m-d', mktime(0,0,0,$date,1,$_year));
				$to_date=date('Y-m-d', mktime(0,0,0,$date+1,0,$_year));
				$from_time='00:00:00';
				$to_time='23:59:59';
				$from_time_graph=date('F', mktime(0,0,0,$date,1,$_year));
				$FC->addCategory($from_time_graph);
$strParam="rotateNames=1;yaxisname=$text_graphics_Calls/$text_graphics_Buys;numdivlines=9;divLineColor=CCCCCC;divLineAlpha=80;decimalPrecision=0;showAlternateHGridColor=1;AlternateHGridAlpha=30;AlternateHGridColor=CCCCCC;caption=$text_graphics_sum_graph_calls_buys $text_graphics_Months;animation=0";
				break;
		}

		/// BUYS
		$query_buys="SELECT id FROM Orders.Orders WHERE store LIKE '$_store' AND source LIKE '$_source' AND state='complete' AND Orders.Orders.order_time >= '$from_date $from_time' AND Orders.Orders.order_time <= '$to_date $to_time'";
		$buys=mysql_num_rows(mysql_query($query_buys, $db_con));

		/// COMPLETE calls
		$query_connect="SELECT FROM_UNIXTIME(TIME) FROM  asterisk.queue_log WHERE (event =  'CONNECT') AND (queuename LIKE 'queue_$_queue') AND (FROM_UNIXTIME( TIME ) >= '$from_date $from_time') AND (FROM_UNIXTIME( TIME ) <= '$to_date $to_time')";
		$complete_calls=mysql_num_rows(mysql_query($query_connect, $db_con_asterisk));

		$FC_dataset_1[$date]=$complete_calls;
		$FC_dataset_2[$date]=$buys;
		$days++;
	}
}

# Set chart attributes
global $bgcolor;
$strParam.=";bgcolor=$bgcolor";
$FC->setChartParams($strParam);

$FC->setParamDelimiter("\n");
$FC->addDataset("$text_graphics_complete_calls", "color=e5124d\nshowValues=0\nareaAlpha=55\nshowAreaBorder=1\nareaBorderThickness=2\nareaBorderColor=FF0000");
for($i=1;$i<=$days;$i++)
{
		$FC->addChartData($FC_dataset_1[$i]);
}
$FC->addDataset("$text_graphics_overall_buys", "color=12e565\nshowValues=0\nareaAlpha=55\nshowAreaBorder=1\nareaBorderThickness=2\nareaBorderColor=006600");
for($i=1;$i<=$days;$i++)
{
		$FC->addChartData($FC_dataset_2[$i]);
}

$FC->renderChart();
}
?>
