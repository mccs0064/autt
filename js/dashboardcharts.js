var DashboardCharts={
    base_url: null,
    drawChart: function(type)
    {
        DashboardCharts.base_url=$("#base_url").text();
        switch(type)
        {
            case 'claims_per_driver':
                DashboardCharts.drawClaimsByDriverChart();
                break;
            case 'claims_per_month':
                DashboardCharts.drawClaimsMonthChart();
                break;
            case 'claims_per_vehicle':
                DashboardCharts.drawClaimsPerVehicle();
                break;
            case 'claims_per_weather':
                DashboardCharts.drawClaimsPerWeather();
                break;
            default:
                break;
        }
    },
    drawClaimsPerWeather: function () {
        DashboardCharts.base_url=$("#base_url").text();
        var weather=$("#claims_per_weather").val();
        var chart_type=$("#chart_type_weather").val();
        var dataRange=$("#date_range_weather").val();
        $.ajax({
            type: 'get',
            data: {weather: weather,chart_type: chart_type,date_range: dataRange},
            url: DashboardCharts.base_url+'/fleetmanager/dashboard/accidentsbyweather',
            success: function(response){

                if(chart_type=='Bar')
                {
                    DashboardCharts.drawWeatherBar(response);
                }
                else if(chart_type=='Pie')
                {
                    DashboardCharts.drawWeatherPie(response);
                }

            }
        });
    },
    drawWeatherPie: function(data){
        data=$.parseJSON(data);
        var chart = c3.generate({
            bindto: '#accidents-per-weather',
            data: {
                columns: data,
                type: 'pie'
            },
            legend: {
                show: false
            },
            grid: {
                y: {
                    show: true
                }
            }
        });
    },
    drawWeatherBar: function (data) {
        data=$.parseJSON(data);
        var chart = c3.generate({
            bindto: '#accidents-per-weather',
            data: {
                columns: data,
                type: 'bar'
            },
            legend: {
                show: false
            },
            grid: {
                y: {
                    show: true
                }
            },
            tooltip: {
                format: {
                    title: function (d) { return "Weather Conditions"; }
                }
            }
        });
    },
    drawClaimsPerVehicle: function()
    {
        DashboardCharts.base_url=$("#base_url").text();
        var vehicle_id=$("#chart_per_vehicle_id").val();
        var dataRange=$("#date_range_vehicle_chart").val();
        $.ajax({
            type: 'get',
            data: {reg: vehicle_id,date_range: dataRange},
            url: DashboardCharts.base_url+'/fleetmanager/dashboard/accidentsbyvehicle',
            success: function(response){
                var data=$.parseJSON(response);
                var chartVehicle = c3.generate({
                    bindto: '#accidents-per-vehicle',
                    data: {
                        columns: data,
                        type: 'bar'
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        y: {
                            show: true
                        }
                    },
                    tooltip: {
                        format: {
                            title: function (d) { return "Vehicles"; }
                        }
                    }
                });
            }
        });
    },
    drawClaimsMonthChart: function(){
        DashboardCharts.base_url=$("#base_url").text();
        var chart_type=$("#chart_type_month_accidents").val();
        var dataRange=$("#date_range_month_chart").val();
        $.ajax({
            type: 'get',
            data: {chart_type: chart_type,date_range: dataRange},
            url: DashboardCharts.base_url+'/fleetmanager/dashboard/accidentspermonth',
            success: function(response){
                if(chart_type=='Bar')
                {
                    DashboardCharts.drawClaimsMonthBarChart(response);
                }
                else
                {
                    DashboardCharts.drawClaimsMonthLineChart(response);
                }
            }
        });
    },
    drawClaimsMonthBarChart: function(data){
        data=$.parseJSON(data);
        console.log(data);
        chartDriver=c3.generate({
            bindto: '#accidents-per-month',
            data: {
                columns: data,
                type: 'bar'
            },
            legend: {
                show: false
            },
            grid: {
                y: {
                    show: true
                }
            },
            axis : {
                x : {
                    tick : {
                        format : "%y/%m"
                    }
                }
            },
            tooltip: {
                format: {
                    title: function (d) { return "Claims"; },
                    value: function (value, ratio, id,index) {
                        var format = id === 'data1' ? d3.format(',') :d3.format();
                        return format(value);
                    },
                    id: function (a) {
                       return 'abc';
                    }
                }
            }
        });
    },
    drawClaimsMonthLineChart: function(data){

        data=$.parseJSON(data);
        console.log(data);
        var chart = c3.generate({
            bindto: '#accidents-per-month',
            data: {
                x: 'x',
                columns: [
                    data[0],
                    data[1]
                ]
            },
            color: {
                pattern: ['#91c84d']
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format:  function (x) {
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];
                            var month=x.getMonth();
                            return monthNames[month]+"-"+x.getFullYear();
                        }
                    }
                }
            },
            grid: {
                y: {
                    show: true
                }
            },
            padding: {
                right: 50
            }

        });
    },
    drawClaimsByDriverChart: function()
    {
        DashboardCharts.base_url=$("#base_url").text();
        var claims_per_driver_driver=$("#claims_per_driver_driver").val();
        var chart_type=$("#claims_per_driver_type").val();
        var dataRange=$("#date_range_driver_chart").val();
        $.ajax({
            type: 'get',
            data: {driver_id: claims_per_driver_driver,chart_type: chart_type,date_range: dataRange},
            url: DashboardCharts.base_url+'/fleetmanager/dashboard/accidents',
            success: function(response){

                    DashboardCharts.drawClaimsByDriverBarChart(response);
            }
        });
    },
    drawClaimsByDriverBarChart: function(data){
        data=$.parseJSON(data);
        chartDriver=c3.generate({
            bindto: '#accidents',
            data: {
                columns: data,
                type: 'bar'
            },
            legend: {
                show: false
            },
            grid: {
                y: {
                    show: true
                }
            },
            tooltip: {
                format: {
                    title: function (d) { return "Accident Claims"; }
                }
            }
        });
    },
    initDriverBarChartDatePicker: function(){
        $("#date_range_driver_chart").dateRangePicker({
            endDate: new Date()
        });

        $("#date_range_driver_chart").bind('datepicker-apply',function(event,obj)
        {
            DashboardCharts.drawChart("claims_per_driver");
        });
    },
    initMonthChartDatePicker: function()
    {
        $("#date_range_month_chart").dateRangePicker({
            endDate: new Date()
        });
        $("#date_range_month_chart").bind('datepicker-apply',function(event,obj)
        {
            DashboardCharts.drawChart("claims_per_month");
        });
    },
    initDateRangeVehicle: function () {
        $("#date_range_vehicle_chart").dateRangePicker({
            endDate: new Date()
        });
        $("#date_range_vehicle_chart").bind('datepicker-apply',function(event,obj)
        {
            DashboardCharts.drawChart("claims_per_vehicle");
        });
    },
    initDateRangeWeather: function () {
        $("#date_range_weather").dateRangePicker({
            endDate: new Date()
        });
        $("#date_range_weather").bind('datepicker-apply',function(event,obj)
        {
            DashboardCharts.drawChart("claims_per_weather");
        });
    }
};