<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/daterangepicker.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/momen.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.daterangepicker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/c3/d3.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/c3/c3.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/dashboardcharts.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/c3.css" rel="stylesheet">
<div class="row">
    <div class="col-xs-12 bg-white chart-container">
        <h3 class="chart-heading text-center">Number of accidents claims per driver</h3>
        <div class="row chart-options">
            <div class="col-xs-4 col-xs-offset-1">
                <?php echo CHtml::dropDownList('claims_per_driver_driver',null,CHtml::listData($drivers,'id','full_name'),array('class'=>'form-control','onchange'=>'DashboardCharts.drawChart("claims_per_driver")','prompt'=>'Select All Drivers'));?>
            </div>
            <div class="col-xs-4">
                <input type="text" id="date_range_driver_chart" class="form-control" placeholder="Select Date Range"/>
            </div>
        </div>
        <div id="accidents"></div>
    </div><br/><br/>
    <div class="col-xs-12 bg-white chart-container">
        <h3 class="chart-heading text-center">Number of Accidents claims per month</h3>
        <div class="row chart-options">
            <div class="col-xs-4 col-xs-offset-1">
                <input type="text" id="date_range_month_chart" class="form-control" placeholder="Select Date Range"/>
            </div>
            <div class="col-xs-4">
                <?php echo CHtml::dropDownList('claims_per_month',null,array('Bar'=>'Bar','Line'=>'Line'),array('class'=>'form-control','onchange'=>'DashboardCharts.drawChart("claims_per_month")','id'=>'chart_type_month_accidents'));?>
            </div>

        </div>
        <div id="accidents-per-month"></div>
    </div>
</div>
<br/><br/>
<div class="row">
    <div class="col-xs-12 bg-white chart-container">
        <h3 class="chart-heading page-title text-center">Number of Accidents claims per vehicle</h3>
        <div class="row chart-options">
            <div class="col-xs-4 col-xs-offset-1">
                <?php echo CHtml::dropDownList('claims_per_vehicle',null,CHtml::listData($vehicles,'vehicle_reg','select_option'),array('class'=>'form-control','onchange'=>'DashboardCharts.drawChart("claims_per_vehicle")','prompt'=>'All Vehicles','id'=>'chart_per_vehicle_id'));?>
            </div>
            <div class="col-xs-4">
                <input type="text" id="date_range_vehicle_chart" class="form-control" placeholder="Select Date Range"/>
            </div>
        </div>
        <div id="accidents-per-vehicle"></div>
    </div><br/><br/>
    <div class="col-xs-12 bg-white chart-container">
        <h3 class="chart-heading text-center">Number of each weather condition for claims</h3>
        <div class="row chart-options">
            <div class="col-xs-4 col-xs-offset-1">
                <?php echo CHtml::dropDownList('chart_type_weather',null,array('Bar'=>'Bar','Pie'=>'Pie'),array('class'=>'form-control','onchange'=>'DashboardCharts.drawChart("claims_per_weather")','id'=>'chart_type_weather'));?>
            </div>

                <?php echo CHtml::dropDownList('claims_per_weather',null,array('Foggy'=>'Foggy','Raining'=>'Raining','Dry'=>'Dry','Snow'=>'Snow','Icy'=>'Icy'),array('class'=>'hidden','onchange'=>'DashboardCharts.drawChart("claims_per_weather")','prompt'=>'Select Weather','id'=>'claims_per_weather_name'));?>
            <div class="col-xs-4">
                <input type="text" id="date_range_weather" class="form-control" placeholder="Select Date Range"/>
            </div>

        </div>
        <div id="accidents-per-weather"></div>
    </div>
</div>
<div class="hidden" id="base_url">
    <?php echo Yii::app()->request->getBaseUrl(true);?>
</div>
<script>

    $(document).ready(function(){
        DashboardCharts.drawClaimsByDriverChart();
        DashboardCharts.drawClaimsMonthChart();
        DashboardCharts.drawClaimsPerVehicle();
        DashboardCharts.drawClaimsPerWeather();
        $("#bg-white-container").removeClass('bg-white');
        DashboardCharts.initDriverBarChartDatePicker();
        DashboardCharts.initMonthChartDatePicker();
        DashboardCharts.initDateRangeVehicle();
        DashboardCharts.initDateRangeWeather();

    });
</script>

