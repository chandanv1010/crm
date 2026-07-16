<?php if(isset($check) && $check == true){ ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Cơ cấu tỉ lệ các khoản chi
                    </h5>
                </div>
                <div class="ibox-content">
                    <div id="canvas-holder">
                        <canvas id="donut_payment" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý lợi nhuận Công ty Năm <?php echo date('Y') ?></h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="periodic_in_year" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý tiền mặt Công ty</h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="barChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Doanh Thu / Chi Phí
                    </h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="lineChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Doanh thu Hosting/Website
                    </h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="hosting" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Khách hàng theo vùng
                    </h5>
                </div>
                <div class="ibox-content">
                    <div id="canvas-holder">
                        <canvas id="chart-area" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="public/backend/js/plugins/chartJs/Chart.min.js"></script>
<script src="public/backend/js/plugins/flot/jquery.flot.js"></script>
<script type="text/javascript">
    <?php
        $bsae64_line = base64_encode(json_encode($periodicList));
        $bac = base64_encode(json_encode($mien_bac));
        $nam = base64_encode(json_encode($mien_nam));
    ?>
    let json_line = JSON.parse(atob("<?php echo $bsae64_line ?>"));
    let bac = JSON.parse(atob("<?php echo $bac ?>"));
    let nam = JSON.parse(atob("<?php echo $nam ?>"));


    var barOptions = {
		tooltips: {
		  callbacks: {
				label: function(tooltipItem, data) {
					var value = tooltipItem.yLabel;
					value = value.toString();
					value = value.split(/(?=(?:...)*$)/);
					value = value.join('.');
					return value;
				}
		  } // end callbacks:
		}, //end tooltips
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true,
					userCallback: function(value, index, values) {
						// Convert the number to a string and splite the string every 3 charaters from the end
						value = value.toString();
						value = value.split(/(?=(?:...)*$)/);
						value = value.join('.');
						return value;
					}
				}
			}],
			xAxes: [{
				ticks: {
				}
			}]
		}
	};

    var barData = {
        labels: json_line,
        datasets: [
            {
                label: "Chi nhánh Miền Nam",
                backgroundColor: '#f00000',
                backgroundColor: 'rgba(255,99,132,0.7)',
                borderColor: "rgba(255,99,132,0.7)",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                data: nam
            },
            {
                label: "Chi nhánh Miền Bắc",
                backgroundColor: 'rgba(54,162,235,0.7)',
                borderColor: "rgba(54,162,235,0.7)",
                pointBackgroundColor: "rgba(54,162,235,1)",
                pointBorderColor: "#fff",
                data: bac
            }
        ]
    };

    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

    <?php
        $periodic_in_year_title = base64_encode(json_encode($periodic_in_year['list']));
        $periodic_in_year_total = base64_encode(json_encode($periodic_in_year['total']));
    ?>
    let periodic_in_year_title = JSON.parse(atob("<?php echo $periodic_in_year_title ?>"));
    let periodic_in_year_total = JSON.parse(atob("<?php echo $periodic_in_year_total ?>"));

    var colors = []
    for(i = 0; i < periodic_in_year_total.length; i++){
        var color;
        if(periodic_in_year_total[i] > 0){
            color = 'rgba(54,162,235,0.7)';
        }else{
            color = 'rgba(255,99,132,0.7)';
        }
       colors[i] = color;
    }

    var barOptions_1 = {
        legend: {
        display: false
   },
		tooltips: {
		  callbacks: {
				label: function(tooltipItem, data) {
					var value = tooltipItem.yLabel;
					value = value.toString();
					value = value.split(/(?=(?:...)*$)/);
					value = value.join('.');
					return value;
				}
		  } // end callbacks:
		}, //end tooltips
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true,
					userCallback: function(value, index, values) {
						// Convert the number to a string and splite the string every 3 charaters from the end
						value = value.toString();
						value = value.split(/(?=(?:...)*$)/);
						value = value.join('.');
						return value;
					}
				}
			}],
			xAxes: [{
				ticks: {
				}
			}]
		}
	};

     var barData = {
        labels: periodic_in_year_title,
        datasets: [
            {
                label: "Lợi nhuận",
                backgroundColor: colors,
                borderColor: "rgba(54,162,235,0.7)",
                pointBackgroundColor: "rgba(54,162,235,1)",
                pointBorderColor: "#fff",
                data: periodic_in_year_total
            }
        ]
    };

    var ctx2 = document.getElementById("periodic_in_year").getContext("2d");

    var chartProfit = new Chart(ctx2, {type: 'bar', data: barData, options:barOptions_1});




    // Line chart
    <?php $money_end = base64_encode(json_encode($money_end)) ?>
    <?php $money_pay = base64_encode(json_encode($money_pay)) ?>
    let json_line_data = JSON.parse(atob("<?php echo $money_end ?>"));
    let money_pay = JSON.parse(atob("<?php echo $money_pay ?>"));
    var lineData = {
        labels: json_line,
        datasets: [
            {
                label: "Thu",
                backgroundColor: 'transparent',
                borderColor: "rgba(54,162,235,0.7)",
                pointBackgroundColor: "rgba(54,162,235,1)",
                pointBorderColor: "#fff",
                data: json_line_data
            },{
                label: "Chi",
                backgroundColor: 'transparent',
                borderColor: "rgba(255,99,132,0.7)",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                data: money_pay
            }
        ]
    };

    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options: barOptions});

<?php
    $hosting = base64_encode(json_encode($hosting));
    $website = base64_encode(json_encode($website));

 ?>
    let hosting = JSON.parse(atob("<?php echo $hosting ?>"));
    let website = JSON.parse(atob("<?php echo $website ?>"));
    var lineData = {
        labels: json_line,
        datasets: [
            {
                label: "Doanh thu Hosting",
                backgroundColor: 'transparent',
                borderColor: "rgba(54,162,235,0.7)",
                pointBackgroundColor: "rgba(54,162,235,1)",
                pointBorderColor: "#fff",
                data: hosting
            },{
                label: "Doanh thu Website",
                backgroundColor: 'transparent',
                borderColor: "rgba(255,99,132,0.7)",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                data: website
            }
        ]
    };


    var ctx = document.getElementById("hosting").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:barOptions});




    //
 <?php
    $city_name = base64_encode(json_encode($customer['title']));
    $city_number = base64_encode(json_encode($customer['number']));

 ?>
    let city_name = JSON.parse(atob("<?php echo $city_name ?>"));
    let city_number = JSON.parse(atob("<?php echo $city_number ?>"));

    var data_pie = {
        datasets: [{
            data: city_number,
            backgroundColor: ["rgb(54, 162, 235)","rgb(255, 99, 132)","rgb(255, 205, 86)"],
        }],
        labels: city_name
    };



    var ctx = document.getElementById("chart-area");
    new Chart(ctx, {type: 'doughnut', data: data_pie});



    
</script>


<!-- ==================================================== Cơ cấu các khoản chi  ========================================================== -->
<?php
    $pay_name = [];
    $pay_total = [];
    if(isset($sum_pay['data']) && is_array($sum_pay['data']) && count($sum_pay['data'])){
        foreach ($sum_pay['data'] as $key => $value) {
            $percent = round($value['pay']/$sum_pay['sum'] *100, 2);
            $pay_name[] = $value['title'];
            $pay_total[] = $percent;
        }
    }
    $pay_name = base64_encode(json_encode($pay_name));
    $pay_total = base64_encode(json_encode($pay_total));
 ?>
<script>
    var donut_option = {
        legend: {
            display: false
       }
    };

    let pay_name = JSON.parse(atob("<?php echo $pay_name ?>"));
    let pay_total = JSON.parse(atob("<?php echo $pay_total ?>"));
    let color_pay = ['#6767ff','#ff6384','#ffcd56','#36a2eb','#1cc09f','#ff9a30','#30ff30','#ffff30','#ff30ff','#ff6666','#6767ff','#fecf9a','#fe98fe'];
    var data_pie = {
        datasets: [{
            data: pay_total,
            backgroundColor: color_pay,
        }],
        labels: pay_name
    };

    var ctx = document.getElementById("donut_payment");
    new Chart(ctx, {type: 'doughnut', data: data_pie, options:donut_option});
</script>
<?php } ?>