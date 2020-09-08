@extends('layouts.master')
@section('title','Dashboard')
@section('styles')
    <style>
        tr td {
            padding: 0 !important;
            margin: 0 !important;
        }
        thead th {
            padding: 0 !important;
            margin: 0 !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c8ced3;
            /* text-align: center; */
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <!-- Breadcrumb-->
    <div class="container-fluid">
        <div class="animated fadeIn dashboard">
            <div class="row">
                <div class="card col-sm-6 col-lg-6">
                    <div class="heading mb-3 mt-2">
                        <h4 class="card-title">Expired
                            <a style="text-decoration: none;color: #FFFFFF; float:right" href="{{route('deposit.index', ['status' => [3]])}}" class="btn btn-dark">View All</a></h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0 20px 0 20px;">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>SN</th>
                                    <th>Mature Date</th>
                                    <th>Bank</th>
{{--                                    <th>Amount</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expired_lists as $expired_list)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$expired_list->mature_date_en}}</td>
                                        <td>
                                            <a style="text-decoration: none;color: #0a0e0f" href="{{ route('deposit.edit',$expired_list->id) }}">
                                                {{$expired_list->institute->institution_name}}
                                            </a>
                                        </td>
{{--                                        <td>{{$expired_list->deposit_amount}}</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card col-sm-6 col-lg-6">
                    <div class="heading mb-3 mt-2">
                        <h4 class="card-title">Renew Soon
                            <a style="text-decoration: none;color: #FFFFFF; float:right" href="{{route('deposit.index', ['include_pending' => [1], 'status' => [2], 'next_status' => 'is_null'])}}" class="btn btn-dark">View All</a></h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0 20px 0 20px;">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>SN</th>
                                    <th>Mature Date</th>
                                    <th>Bank</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($renew_soon_lists))
                                @foreach($renew_soon_lists as $renew_soon_list)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$renew_soon_list->mature_date_en}}</td>
                                        <td>
                                            <a style="text-decoration: none;color: #0a0e0f" href="{{ route('deposit.edit',$renew_soon_list->id) }}">
                                                {{$renew_soon_list->institute->institution_name}}
                                            </a>
                                        </td>
{{--                                        <td>{{$renew_soon_list->deposit_amount}}</td>--}}
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-sm-6 col-lg-4">
                    <div class="card text-black-50 bg-gray-400 bg-blue">
                        <div class="card-body pb-0 text-center">
                            <div class="btn-group float-right">
                            </div>
                            <div class="text-value">अनुसुची १ को दफा 6 (Bond)</div>
                            <div class="card-header"> {{-->=25% <br>--}} Total
                                Rs @if(!empty($bondtotal)){{$bondtotal}} {{--<br>  ({{$bondper}} %)--}}@else
                                NA @endif</div>
                        </div>
                        <div class="card-body text-center">
                            <div class="text-value">Due Alert</div>
                            @if(!empty($bonds_alerts))
                                <div><a class="text-black-50 text-uppercase"
                                        href="{{route('bond.alerts')}}">{{$bonds_alerts}} out of {{$bonds_total}} </a>
                                </div>
                                <div class="progress progress-xs my-2">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{$bond_alerts_per}}%" aria-valuenow="{{$bonds_alerts}}"
                                         aria-valuemin="0" aria-valuemax="{{$bonds_total}}"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="card col-sm-6 col-lg-4">
                    <div class="card text-white bg-spotify bg-teal">
                        <div class="card-body pb-0 text-center">
                            <div class="text-value">अनुसुची १ को दफा 6 (2) (Deposit)</div>
                            <div class="card-header">{{--45% <br>--}} Total
                                Rs @if(!empty($deposittotal)){{$deposittotal}}
                                <br> {{--({{$depositper}} %) @else NA--}} @endif</div>
                        </div>
                        <div class="card-body text-center">
                            <div class="text-value">Due Alert</div>
                            @if(!empty($deposits_alerts))
                                <div><a class="text-black-50 text-uppercase"
                                        href="{{route('deposit.index',['status'=>[2], 'next_status' => null])}}">{{$deposits_alerts}} out
                                        of {{$deposits_total}}  </a></div>
                                <div class="progress progress-xs my-2">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{$deposits_alerts_per}}%"
                                         aria-valuenow="{{$deposits_alerts}}" aria-valuemin="0"
                                         aria-valuemax="{{$deposits_total}}"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="card col-sm-6 col-lg-4">
                    <div class="card text-white bg-cyan">
                        <div class="card-body pb-0 text-center">
                            <div class="text-value">अनुसुची 2 को दफा 4 (Share)</div>
                            <div class="card-header">{{--<=30% <br>--}} Total Rs @if(!empty($sharetotal)){{$sharetotal}}
                                {{--<br> ({{$shareper}} %) @else NA--}} @endif</div>
                        </div>
                        <div class="card-body text-center">
                            <div class="text-value" style="visibility: hidden;">Due Alert</div>
                            {{--  <div class="progress progress-xs my-2">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
--}}                            </div>
                    </div>

                </div>
                <!--/.col-->
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="text-value">{{$deposit_stats->sum('total_deposit_amount')}}</div>
                            <div>Deposit Amount</div>
                        </div>
                        <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-12 col-lg-6">
                    <div class="card text-white bg-info">
                        <div class="card-body pb-0">

                            <div class="text-value">{{$deposit_stats->sum('count')}}</div>
                            <div>Number of Deposits</div>
                        </div>
                        <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->

                <!-- /.col-->
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card text-white bg-warning">
                        <div class="card-body pb-0">
                            {{--<div class="text-value">9.823</div>--}}
                            <div>Share Values</div>
                        </div>
                        <div class="chart-wrapper mt-3" style="height:300px;">
                            <canvas class="chart" id="card-chart3" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-12 col-lg-6">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0">
{{--                            <div class="text-value">9.823</div>--}}
                            <div>Bank Average Interest Rates</div>
                        </div>
                        <div class="chart-wrapper mt-3 mx-3" style="height:300px;">
                            <canvas class="chart" id="card-chart4" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Active Deposits</h4>
{{--                            <div class="small text-muted">November 2017</div>--}}
                        </div>

                    </div>
                    <!-- /.row-->
                    <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                        <canvas class="chart" id="main-chart" height="300"></canvas>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Earnings</h4>
{{--                            <div class="small text-muted">November 2017</div>--}}
                        </div>

                    </div>
                    <!-- /.row-->
                    <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                        <canvas class="chart" id="main-chart-2" height="300"></canvas>
                    </div>
                </div>

            </div>
            <!-- /.card-->
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')
@endsection

@section('scripts')
    <script src="{{asset('assets/@coreui/chart/chart.js')}}"></script>
    <script src="{{asset('assets/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.js')}}"></script>

    <script>
        Chart.defaults.global.pointHitDetectionRadius = 1;
        Chart.defaults.global.tooltips.enabled = false;
        Chart.defaults.global.tooltips.mode = 'index';
        Chart.defaults.global.tooltips.position = 'nearest';
        Chart.defaults.global.tooltips.custom = CustomTooltips;
        Chart.defaults.global.tooltips.intersect = true;

        Chart.defaults.global.tooltips.callbacks.labelColor = function (tooltipItem, chart) {
            return {
                backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].borderColor
            };
        }; // eslint-disable-next-line no-unused-vars


        var cardChart1 = new Chart($('#card-chart1'), {
            type: 'line',
            data: {
                labels: [@foreach($nepali_fiscal_year_months as $key=> $month) '{{$month}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Deposit Amount',
                    backgroundColor: getStyle('--primary'),
                    borderColor: 'rgba(255, 255, 225, .55)',
                    data: [@foreach($nepali_fiscal_year_months as $key=> $month) {{$deposit_stats->where('month','=',$key)->first()->total_deposit_amount ?? 0}} @if (!$loop->last), @endif @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: 'transparent',
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            fontSize: 2,
                            fontColor: 'transparent'
                        }
                    }],
                    yAxes: [{
                        display: false,
                       /* ticks: {
                            display: false,
                            min: 1000000,
                            max: 300000000
                        }*/
                    }]
                },
                elements: {
                    line: {
                        borderWidth: 1
                    },
                    point: {
                        radius: 4,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        }); // eslint-disable-next-line no-unused-vars

        var cardChart2 = new Chart($('#card-chart2'), {
            type: 'line',
            data: {
                labels: [@foreach($nepali_fiscal_year_months as $key=> $month) '{{$month}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Deposit Amount',
                    backgroundColor: getStyle('--primary'),
                    borderColor: 'rgba(255,255,255,.55)',
                    data: [@foreach($nepali_fiscal_year_months as $key=> $month) {{$deposit_stats->where('month','=',$key)->first()->count ?? 0}} @if (!$loop->last), @endif @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: 'transparent',
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            fontSize: 2,
                            fontColor: 'transparent'
                        }
                    }],
                    yAxes: [{
                        display: false,
                       /* ticks: {
                            display: false,
                            min: 0,
                            max: 100
                        }*/
                    }]
                },
                elements: {
                    line: {
                        tension: 0.00001,
                        borderWidth: 1
                    },
                    point: {
                        radius: 4,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        }); // eslint-disable-next-line no-unused-vars

        var cardChart3 = new Chart($('#card-chart3'), {
            type: 'line',
            data: {
                labels: [@foreach($investment_institutions as $value) '{{$value->institution_code}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Share Value',
                    backgroundColor: getStyle('--primary'),
                    borderColor: 'rgba(255,255,255,.55)',
                    data: [@foreach($investment_institutions as $value)  {{((($value->purchase_count ?? 0)-($value->sales_count ?? 0)) * ($value->latest_share_price->closing_value ?? 0) )?? 0}} @if (!$loop->last), @endif @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false,
                       /* ticks: {
                            display: false,
                            min: 0,
                            max: 40000000
                        }*/
                    }]
                },
                elements: {
                    line: {
                        borderWidth: 2
                    },
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        }); // eslint-disable-next-line no-unused-vars

        var cardChart4 = new Chart($('#card-chart4'), {
            type: 'line',
            data: {
                labels: [@foreach($institution_stats as $institution) '{{$institution->institution_code}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Average Interest Rate',
                    backgroundColor: getStyle('--danger'),
                    borderColor: 'rgba(255,255,255,.55)',
                    data: [@foreach($institution_stats as $institution) {{$institution->average_interest_rate ?? 0}} @if (!$loop->last), @endif @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false,
                        barPercentage: 0.6
                    }],
                    yAxes: [{
                        display: false,
                    }]
                },
                elements: {
                    line: {
                        borderWidth: 1
                    },
                    point: {
                        radius: 4,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        }); // eslint-disable-next-line no-unused-vars

        var mainChart = new Chart($('#main-chart'), {
            type: 'line',
            data: {
                labels: [@foreach($nepali_fiscal_year_months as $key=> $month) '{{$month}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Deposits',
                    backgroundColor: 'transparent',
                    borderColor: getStyle('--success'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    data: [@foreach($nepali_fiscal_year_months as $key=> $month) {{$deposit_stats->where('month','=',$key)->first()->total_deposit_amount ?? 0}} @if (!$loop->last), @endif @endforeach]
                }, {
                    label: 'Withdraw',
                    backgroundColor: 'transparent',
                    borderColor: getStyle('--danger'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 1,
                    borderDash: [8, 5],
                    data: [@foreach($nepali_fiscal_year_months as $key=> $month) {{$withdraw_stats->where('month','=',$key)->first()->withdrawn_amount ?? 0}} @if (!$loop->last), @endif @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            stepSize: Math.ceil(150000000  / 5),
                            max: 150000000
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3
                    }
                }
            }
        });
        var mainChart = new Chart($('#main-chart-2'), {
            type: 'bar',
            data: {
                labels: [@foreach($institution_stats as $institution) '{{$institution->institution_code}}' @if (!$loop->last), @endif  @endforeach],
                datasets: [{
                    label: 'Estimated Earning',
                    backgroundColor: 'transparent',
                    borderColor: getStyle('--success'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    stack: 'Stack 1',
                    data: [@foreach($institution_stats as $institution) {{$institution->estimated_earning}} @if (!$loop->last), @endif  @endforeach]
                },{
                    label: 'Total Deposit',
                    backgroundColor: hexToRgba(getStyle('--info'), 10),
                    borderColor: getStyle('--info'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    stack: 'Stack 1',

                    data: [@foreach($institution_stats as $institution) {{$institution->deposit_amount}} @if (!$loop->last), @endif  @endforeach]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            /*maxTicksLimit: 5,*/
                          /*  stepSize: Math.ceil(1800000000  / 5),
                            max: 1800000000*/
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3
                    }
                }
            }
        });

    </script>
@endsection
