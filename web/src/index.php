<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Flot Examples</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.flot.selection.js"></script>
 </head>
 <body>
 	<div id="placeholder" style="width:600px;height:300px"></div>
 	<script type="text/javascript">
$(function () {
    var data = [
        {
            label: "Home",
            data: <?php
            
            $aFile = file("/home/pi/python/log");
            print '[';
            foreach($aFile as $item) {
            	if(!empty($item)){
            		$data = explode("|", $item);
            		if(count($data) >=2){
            			print '["'.date('YmdHi',strtotime($data[1])).'", '.$data[0].'],';
            		}
	            }
            }
            print ']';
            ?>
        }
    ];

    var options = {
        series: {
            lines: { show: true },
            points: { show: true }
        },
        legend: { noColumns: 2 },
        xaxis: { tickDecimals: 0 },
        yaxis: { min: 0 },
        selection: { mode: "x" }
    };

    var placeholder = $("#placeholder");

    placeholder.bind("plotselected", function (event, ranges) {
        $("#selection").text(ranges.xaxis.from.toFixed(1) + " to " + ranges.xaxis.to.toFixed(1));

        var zoom = $("#zoom").attr("checked");
        if (zoom)
            plot = $.plot(placeholder, data,
                          $.extend(true, {}, options, {
                              xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to }
                          }));
    });

    placeholder.bind("plotunselected", function (event) {
        $("#selection").text("");
    });
    
    var plot = $.plot(placeholder, data, options);

    $("#clearSelection").click(function () {
        plot.clearSelection();
    });

    $("#setSelection").click(function () {
        plot.setSelection({ xaxis: { from: 1994, to: 1995 } });
    });
});
</script>
 </body>
</html>