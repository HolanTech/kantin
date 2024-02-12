@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $users }}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i> <!-- Updated icon -->
                    </div>
                    <a href="{{ route('admin.user') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $canteens }}</h3>
                        <p>Canteen</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-utensils"></i> <!-- Updated icon -->
                    </div>
                    <a href="{{ route('admin.canteen') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $sales }}</h3>
                        <p>Transaction</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exchange-alt"></i> <!-- Updated icon -->
                    </div>
                    <a href="{{ route('sales.filter', ['user' => '', 'kantin_id' => '', 'bulan' => '', 'date_start' => now()->format('Y-m-d'), 'date_end' => now()->format('Y-m-d')]) }}"
                        class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $topup }}</h3>
                        <p>Top Up</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i> <!-- Updated icon -->
                    </div>
                    <a href="{{ route('topup.filter', ['user' => '', 'bulan' => '', 'date_start' => now()->format('Y-m-d'), 'date_end' => now()->format('Y-m-d')]) }}"
                        class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daily Transaction</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <div id="chartData" data-transactions="{{ htmlentities(json_encode($dataPerKantin)) }}"></div>
                            {{-- <canvas id="areaChart"></canvas> --}}

                            <canvas id="areaChart"
                                style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Monthly Transaction</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>


@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctxArea = document.getElementById('areaChart').getContext('2d');
            var dataPerKantin = @json($dataPerKantin);
            var currentYear = new Date().getFullYear();
            var currentMonth = new Date().getMonth() + 1; // JavaScript months are 0-based
            var daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
            var labels = [];

            // Generate labels for each day of the month
            for (let day = 1; day <= daysInMonth; day++) {
                labels.push(`${day}-${currentMonth}-${currentYear}`);
            }

            var datasets = [];

            Object.entries(dataPerKantin).forEach(([kantinName, data], index) => {
                // Initialize arrays to hold transactions and income data for each day of the month
                let transactionsData = new Array(daysInMonth).fill(0);
                let incomeData = new Array(daysInMonth).fill(0);

                // Populate the arrays with the actual data
                Object.entries(data.transactions).forEach(([date, value]) => {
                    let day = parseInt(date.split('-')[2], 10) -
                        1; // Convert date string to day of month and adjust for zero-based index
                    transactionsData[day] = value;
                });
                Object.entries(data.income).forEach(([date, value]) => {
                    let day = parseInt(date.split('-')[2], 10) - 1;
                    incomeData[day] = value;
                });

                // Add the dataset for transactions
                datasets.push({
                    label: `${kantinName} - Transactions`,
                    data: transactionsData,
                    borderColor: `hsl(${index * 360 / Object.keys(dataPerKantin).length}, 70%, 50%)`,
                    fill: false,
                });

                // Add the dataset for income
                datasets.push({
                    label: `${kantinName} - Income`,
                    data: incomeData,
                    borderColor: `hsl(${(index * 360 / Object.keys(dataPerKantin).length) + 100}, 70%, 50%)`,
                    fill: false,
                });
            });

            new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var dataPerBulanPerKantin = @json($dataPerBulanPerKantin);
            var labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];
            var datasets = [];

            Object.entries(dataPerBulanPerKantin).forEach(([kantinName, months], index) => {
                var data = [];
                for (var i = 1; i <= 12; i++) {
                    data.push(months[i].total_income);
                }
                datasets.push({
                    label: kantinName,
                    data: data,
                    backgroundColor: `hsl(${index * 360 / Object.keys(dataPerBulanPerKantin).length}, 70%, 70%)`,
                    borderColor: `hsl(${index * 360 / Object.keys(dataPerBulanPerKantin).length}, 70%, 40%)`,
                    borderWidth: 1
                });
            });

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
