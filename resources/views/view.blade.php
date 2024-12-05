<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>view</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col min-h-[100vh]">
    <header class="bg-slate-800">
        <div class="max-w-7xl mx-auto">
            <div class="py-6">
                <p class="text-white text-2xl">計測データ観測アプリ</p>
            </div>
        </div>
    </header>
    <div class="mx-auto">
         <div class="py-4">
            <form action="{{ route('user.profile', ['datecount' => $datecount, 'timewidth' => $timewidth]) }}" method="post">
                @csrf
                <p class="text-black text-xl">{{$date}}　
                    @if ($timewidth=="day")
                    @php
                    $todate = $totime/24;
                    @endphp
                    0時から
                    <input type="number" min="0" value="{{$todate}}" class="w-12 border border-neutral-400" name="totime">
                    日間　　
                    @else
                    <input type="number" min="0" max="23" value="{{$fromtime}}" class="w-12 border border-neutral-400" name="fromtime">
                    時から
                    <input type="number" min="0" value="{{$totime}}" class="w-12 border border-neutral-400" name="totime">
                    時間　　
                    @endif
                    
                    <button class="mt-1 p-1 bg-indigo-700 text-white" name="update" type="submit">更新</button>
                    @if ($timewidth == "hour")
                    <button class="mt-1 p-1 bg-emerald-600 text-white" name="day" type="submit">日単位に切り替え</button>
                    @else
                    <button class="mt-1 p-1 bg-emerald-600 text-white" name="hour" type="submit">時間単位に切り替え</button>
                    @endif
                </p>
            </form>
        </div>
    </div>

    <div style="width: 60%" class="mx-auto flex">
        <canvas id="chart"></canvas>
        <button id="reset" class="p-1 h-8 whitespace-nowrap bg-orange-500 text-white" onclick="reset()">reset zoom</button>
        <script>
            function reset() {
                chart.resetZoom();
            }
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.0.0/chartjs-plugin-zoom.min.js"></script>
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),         
                datasets: [       
                {
                    label: 'CO2_lifting [ppm]',
                    data: @json($CO2_lifting),
                    backgroundColor: 'rgba(192, 75, 75, 1)',
                    borderColor: 'rgba(192, 75, 75, 1)',
                    borderWidth: 2,
                    radius: 1,
                    pointHoverRadius: 5,
                    hitRadius: 50,
                    yAxisID: 'y_CO2',
                },
                {
                    label: 'CO2_bottom [ppm]',
                    data: @json($CO2_bottom),
                    backgroundColor: 'rgba(75, 192, 75, 1)',
                    borderColor: 'rgba(75, 192, 75, 1)',
                    borderWidth: 2,
                    radius: 1,
                    pointHoverRadius: 5,
                    hitRadius: 50,
                    yAxisID: 'y_CO2',
                },
                {
                    label: 'CO2_top [ppm]',
                    data: @json($CO2_top),
                    backgroundColor: 'rgba(75, 75, 192, 1)',
                    borderColor: 'rgba(75, 75, 192, 1)',
                    borderWidth: 2,
                    radius: 1,
                    pointHoverRadius: 5,
                    hitRadius: 50,
                    yAxisID: 'y_CO2',
                },
                {
                    label: 'height [mm]',
                    data: @json($height),
                    backgroundColor: 'rgba(150, 150, 150, 1)',
                    borderColor: 'rgba(150, 150, 150, 1)',
                    borderWidth: 2,
                    radius: 1,
                    pointHoverRadius: 5,
                    hitRadius: 50,
                    yAxisID: 'y_height',
                },]
            },
            options: {
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(250, 250, 250, 1)',
                        titleColor: 'black',
                        bodyColor: 'black',
                    },
                    zoom: {
                        zoom: {
                        wheel: {
                            enabled: true,
                        },
                        drag: {
                            enabled: true,
                            backgroundColor: 'rgba(100,200,200,0.3)'
                        },
                        pinch: {
                            enabled: true,
                        },
                        mode: 'x',
                        }
                    }
                },
                datasets: {
                    point: {
                        pointStyle: 'cross',
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        display: true,
                        time: {
                            parser: 'YYYY-MM-DD HH:mm:ss.SSSSSS',
                            displayFormats: {
                                'millisecond': 'H:mm:ss.S',
                                'second': 'H:mm:ss',
                                'minute': 'H:mm:ss',
                                'hour': 'H:mm:ss',
                                'day': 'MMM D'
                            },
                            tooltipFormat: 'YYYY/MM/DD HH:mm:ss',
                        },
                        title: {
                            display: true,
                            text: 'time',
                            font: {
                                size: 15,
                                lineHeight: 1.2,
                            },
                        }
                    },
                    y_height: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
				            drawOnChartArea: false, 
			            },
                        title: {
                            display: true,
                            text: 'Height [mm]',
                            font: {
                                size: 15,
                                lineHeight: 1.2,
                            },
                        }
                    },
                    y_CO2: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'CO2 concentration [ppm]',
                            font: {
                                size: 15,
                                lineHeight: 1.2,
                            },
                        }
                    }
                }
            }
        });
    </script>
    <div class="mx-auto">
        <form action="{{ route('user.profile', ['datecount' => $datecount, 'timewidth' => $timewidth, 'fromtime'=>$fromtime, 'totime'=>$totime]) }}" method="post">
        @csrf
            <div class="px-4 sm:px-6 text-xl">
                <button class="p-1 bg-rose-800 text-white" name="onemonth_before" type="submit">1ヵ月戻る</button>
                <button class="p-1 bg-rose-600 text-white" name="oneweek_before" type="submit">1週間戻る</button>
                <button class="p-1 bg-rose-400 text-white" name="oneday_before" type="submit">1日戻る</button>
                <button class="p-1 bg-sky-400 text-white" name="oneday_after" type="submit">1日進む</button>
                <button class="p-1 bg-sky-600 text-white" name="oneweek_after" type="submit">1週間進む</button>
                <button class="p-1 bg-sky-800 text-white" name="onemonth_after" type="submit">1ヵ月進む</button>
            </div>
        </form>
    </div>
</body>
</html>