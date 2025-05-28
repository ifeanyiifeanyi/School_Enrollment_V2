@extends('admin.layouts.adminLayout')

@section('title', 'Admission Portal')

@section('css')
    <!-- Add Animate.css library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Add Chart.js library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />
    <style>
        /* Base visibility settings */
        .card-statistic-1,
        .card,
        .section-header,
        .text-center,
        .mb-4 {
            opacity: 0;
            visibility: hidden;
        }

        /* Make elements visible when animated */
        .animate__animated {
            visibility: visible;
            opacity: 1;
        }

        /* Card Statistics Hover Effects */
        .card-statistic-1 {
            transition: all 0.4s ease-in-out;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(0);
        }

        .card-statistic-1:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Card Icon Hover Effects */
        .card-statistic-1 .card-icon {
            transition: all 0.5s ease;
            border-radius: 50%;
            overflow: hidden;
        }

        .card-statistic-1:hover .card-icon {
            transform: scale(1.1) rotate(10deg);
        }

        /* Card Body Hover Effects */
        .card-statistic-1 .card-wrap {
            transition: all 0.3s ease;
        }

        .card-statistic-1:hover .card-wrap .card-body {
            font-weight: bold;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        /* Regular Cards Hover Effects */
        .card {
            transition: all 0.35s ease;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        /* Progress Bar Setup */
        .progress {
            overflow: visible;
            margin-bottom: 26px;
            height: 4px;
        }

        .progress-bar {
            position: relative;
            border-radius: 10px;
            width: 0 !important;
            transition: width 1.5s ease-in-out !important;
        }

        /* Department/Faculty List hover effect */
        .card .mb-4:hover .mb-1.font-weight-bold {
            color: #6777f0;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        .card .mb-4 .mb-1.font-weight-bold {
            transition: all 0.3s ease;
        }

        /* View Applications Button Animation */
        .view-applications-btn {
            position: relative;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 30px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .view-applications-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #007bff, #6610f2);
            z-index: -1;
            opacity: 0;
            transform: scale(0.5, 0.5);
            transition: all 0.3s ease;
        }

        .view-applications-btn:hover:before {
            opacity: 1;
            transform: scale(1, 1);
        }

        .view-applications-btn:hover {
            color: #fff;
            background-color: #5a67d8 !important;
            box-shadow: 0 10px 20px rgba(90, 103, 216, 0.4);
            transform: translateY(-3px) scale(1.02);
        }

        .view-applications-btn:active {
            transform: translateY(1px);
        }

        /* For the department and faculty items */
        .mb-4 {
            transition: all 0.3s ease;
        }

        .mb-4:hover {
            background-color: rgba(103, 119, 240, 0.05);
            padding: 5px;
            border-radius: 5px;
            transform: translateX(5px);
        }

        /* Enhance the text-small indicators */
        .text-small.font-weight-bold.text-muted {
            transition: all 0.3s ease;
        }

        .mb-4:hover .text-small.font-weight-bold.text-muted {
            color: #6777f0 !important;
        }

        /* Hover effect for section headers */
        .section-header h1 {
            position: relative;
            transition: all 0.3s ease;
        }

        .section-header h1:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 0;
            background-color: #6777f0;
            transition: width 0.3s ease;
        }

        .section-header:hover h1:after {
            width: 50px;
        }

        /* Sparkle effect for the session text */
        .text-muted {
            position: relative;
            transition: all 0.3s ease;
        }

        @keyframes sparkle {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 200% 0%;
            }
        }

        .text-muted:hover {
            background: linear-gradient(90deg, #6777f0, #a3adf9, #6777f0);
            background-size: 200% auto;
            color: transparent !important;
            -webkit-background-clip: text;
            background-clip: text;
            animation: sparkle 2s linear infinite;
        }

        /* Chart container styles */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
            margin-bottom: 20px;
        }

        /* Chart animation keyframes */
        @keyframes growIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Chart element animation */
        .chart-animated {
            animation: growIn 1s ease-out forwards;
        }

        /* Tab styling for chart sections */
        .chart-tabs {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #e4e6fc;
        }

        .chart-tab {
            padding: 10px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            margin-right: 5px;
            font-weight: 600;
        }

        .chart-tab.active {
            border-bottom: 2px solid #6777f0;
            color: #6777f0;
        }

        .chart-tab:hover:not(.active) {
            background-color: rgba(103, 119, 240, 0.05);
            border-bottom: 2px solid #a3adf9;
        }

        /* Filter buttons for chart data */
        .chart-filters {
            display: flex;
            margin-bottom: 15px;
            gap: 8px;
        }

        .chart-filter-btn {
            padding: 5px 12px;
            border-radius: 20px;
            background-color: #f2f2f2;
            border: none;
            transition: all 0.3s ease;
            font-size: 12px;
            cursor: pointer;
        }

        .chart-filter-btn.active {
            background-color: #6777f0;
            color: white;
        }

        .chart-filter-btn:hover:not(.active) {
            background-color: #e4e6fc;
        }
    </style>
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="text-center">
                    <a href="{{ route('admin.student.application') }}"
                        class="mb-3 btn btn-primary btn-lg view-applications-btn">
                        <i class="fas fa-hourglass fa-spin"></i> View Active Applications
                    </a>
                    <p class="text-muted">
                        Academic Session : {{ $academicSession->session ?? '' }}
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Faculties</h4>
                                </div>
                                <div class="card-body">
                                    {{ $facultyCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-school"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Departments</h4>
                                </div>
                                <div class="card-body">
                                    {{ $departmentCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>All Registered Students</h4>
                                </div>
                                <div class="card-body">
                                    {{ $studentCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-hourglass fa-spin"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Active Applications</h4>
                                </div>
                                <div class="card-body">
                                    {{ $activeApplication }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Row for Animated Charts -->
                <div class="row">
                    <!-- Department Applications Chart -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Department Applications</h4>
                                <div class="card-header-action">
                                    <div class="chart-filters">
                                        <button class="chart-filter-btn active" data-period="weekly">Weekly</button>
                                        <button class="chart-filter-btn" data-period="monthly">Monthly</button>
                                        <button class="chart-filter-btn" data-period="yearly">Yearly</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-tabs">
                                    <div class="chart-tab active" data-chart-type="bar">Bar Chart</div>
                                    <div class="chart-tab" data-chart-type="line">Line Chart</div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="departmentBarChart"></canvas>
                                    <canvas id="departmentLineChart" style="display: none;"></canvas>
                                </div>
                                @forelse($departmentData as $data)
                                    <div class="mb-4">
                                        <div class="float-right text-small font-weight-bold text-muted">{{ $data->total }}</div>
                                        <div class="mb-1 font-weight-bold">{{ Str::title($data->department->name) }}</div>
                                        <div class="progress" data-height="3">
                                            <div class="progress-bar" role="progressbar" data-width="{{ $data->percentage }}%"
                                                aria-valuenow="{{ $data->percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Faculty Applications Chart -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Faculty Applications</h4>
                                <div class="card-header-action">
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm active" id="pieChartBtn">Pie Chart</button>
                                        <button class="btn btn-primary btn-sm" id="doughnutChartBtn">Doughnut</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="facultyPieChart"></canvas>
                                    <canvas id="facultyDoughnutChart" style="display: none;"></canvas>
                                </div>
                                @foreach ($facultyData as $data)
                                    <div class="mb-4">
                                        <div class="float-right text-small font-weight-bold text-muted">{{ $data->total }}</div>
                                        <div class="mb-1 font-weight-bold">{{ $data->faculty_name }}</div>
                                        <div class="progress" data-height="3">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                data-width="{{ $data->percentage }}%"
                                                aria-valuenow="{{ $data->percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Payment Methods Chart -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Payment Methods Usage</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="paymentHistogram"></canvas>
                                </div>
                                @foreach ($paymentData as $data)
                                    <div class="mb-4">
                                        <div class="float-right text-small font-weight-bold text-muted">{{ $data->total }}</div>
                                        <div class="mb-1 font-weight-bold">{{ $data->payment_method }}</div>
                                        <div class="progress" data-height="3">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                data-width="{{ $data->percentage }}%"
                                                aria-valuenow="{{ $data->percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Student Demographics Chart -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Student Demographics</h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="demographicsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="demographicsDropdown">
                                            <a class="dropdown-item active" href="#" data-demographics="gender">By Gender</a>
                                            <a class="dropdown-item" href="#" data-demographics="age">By Age Group</a>
                                            <a class="dropdown-item" href="#" data-demographics="location">By Location</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="demographicsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Row for Application Trend -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Application Trends</h4>
                                <div class="card-header-action">
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm active" data-trend="daily">Daily</button>
                                        <button class="btn btn-primary btn-sm" data-trend="weekly">Weekly</button>
                                        <button class="btn btn-primary btn-sm" data-trend="monthly">Monthly</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="applicationTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <!-- Add Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        // Admin Dashboard Animation JavaScript using Animate.css
        document.addEventListener('DOMContentLoaded', function() {
            // On page load animations
            animateOnLoad();

            // Set up scroll animations
            setupScrollAnimations();

            // Animate progress bars when they become visible
            setupProgressBarAnimations();

            // Initialize all charts
            initializeCharts();
        });

        // Animate elements on initial page load
        function animateOnLoad() {
            // Animate section header first
            setTimeout(() => {
                animateElement(document.querySelector('.section-header'), 'animate__fadeIn');
            }, 100);

            // Animate the view applications button
            setTimeout(() => {
                animateElement(document.querySelector('.text-center'), 'animate__zoomIn');
            }, 300);

            // Animate stat cards with staggered delay
            const statCards = document.querySelectorAll('.card-statistic-1');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    animateElement(card, 'animate__fadeInUp');
                }, 500 + (index * 150));
            });
        }

        // Set up intersection observer for scroll animations
        function setupScrollAnimations() {
            // Options for the Intersection Observer
            const options = {
                root: null, // Use the viewport as the root
                rootMargin: '0px',
                threshold: 0.1 // 10% of the element needs to be visible
            };

            // Create an Intersection Observer instance
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Determine the animation type based on position and type
                        let animationClass;

                        if (entry.target.classList.contains('card-statistic-1')) {
                            animationClass = 'animate__fadeInUp';
                        } else if (entry.target.classList.contains('col-lg-6') &&
                            entry.target.getBoundingClientRect().left < window.innerWidth / 2) {
                            animationClass = 'animate__fadeInRight';
                        } else if (entry.target.classList.contains('col-lg-6')) {
                            animationClass = 'animate__fadeInLeft';
                        } else {
                            animationClass = 'animate__fadeIn';
                        }

                        // Apply the animation
                        animateElement(entry.target, animationClass);

                        // Stop observing this element
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            // Observe all main content sections for scroll animations
            const sections = document.querySelectorAll('.card, .col-lg-6, .col-lg-3');
            sections.forEach(section => {
                observer.observe(section);
            });

            // Observe all department/faculty application items
            const items = document.querySelectorAll('.mb-4');
            items.forEach(item => {
                observer.observe(item);
            });
        }

        // Set up animations for progress bars
        function setupProgressBarAnimations() {
            const progressBars = document.querySelectorAll('.progress-bar');

            // Options for the Intersection Observer
            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.2 // 20% of the progress bar needs to be visible
            };

            // Observer for progress bars
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBar = entry.target;
                        const width = progressBar.getAttribute('data-width');

                        // Animate the progress bar width after a small delay
                        setTimeout(() => {
                            progressBar.style.width = width;
                            // Add a pulse animation from Animate.css
                            progressBar.classList.add('animate__animated', 'animate__pulse');
                        }, 300);

                        // Stop observing this progress bar
                        observer.unobserve(progressBar);
                    }
                });
            }, options);

            // Observe all progress bars
            progressBars.forEach(bar => {
                observer.observe(bar);
            });
        }

        // Helper function to animate an element with Animate.css
        function animateElement(element, animationClass) {
            if (element) {
                element.classList.add('animate__animated', animationClass);
            }
        }

        // Initialize all chart visualizations
        function initializeCharts() {
            // Create Department Bar Chart
            createDepartmentBarChart();

            // Create Faculty Pie Chart
            createFacultyPieChart();

            // Create Payment Histogram
            createPaymentHistogram();

            // Create Demographics Chart
            createDemographicsChart();

            // Create Application Trend Chart
            createApplicationTrendChart();

            // Set up chart tab switching
            setupChartTabSwitching();
        }

        // Create Department Bar Chart
        function createDepartmentBarChart() {
            const ctx = document.getElementById('departmentBarChart').getContext('2d');

            // Extract department data from the page
            const departmentData = [];
            const departmentLabels = [];
            const departmentColors = [];

            // Generate random data for demo purposes
            // In production, this would come from your backend
            @foreach($departmentData as $index => $data)
                departmentLabels.push("{{ Str::title($data->department->name) }}");
                departmentData.push({{ $data->total }});
                departmentColors.push(getRandomColor({{ $index }}, 0.7));
            @endforeach

            // Create the chart
            window.departmentBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: departmentLabels,
                    datasets: [{
                        label: 'Number of Applications',
                        data: departmentData,
                        backgroundColor: departmentColors,
                        borderColor: departmentColors.map(color => color.replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    }
                }
            });

            // Create corresponding line chart
            const lineCtx = document.getElementById('departmentLineChart').getContext('2d');
            window.departmentLineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: departmentLabels,
                    datasets: [{
                        label: 'Application Trend',
                        data: departmentData,
                        backgroundColor: 'rgba(103, 119, 240, 0.2)',
                        borderColor: 'rgba(103, 119, 240, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(103, 119, 240, 1)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        // Create Faculty Pie Chart
        function createFacultyPieChart() {
            const ctx = document.getElementById('facultyPieChart').getContext('2d');
            const doughnutCtx = document.getElementById('facultyDoughnutChart').getContext('2d');

            // Extract faculty data
            const facultyData = [];
            const facultyLabels = [];
            const facultyColors = [];

            @foreach($facultyData as $index => $data)
                facultyLabels.push("{{ $data->faculty_name }}");
                facultyData.push({{ $data->total }});
                facultyColors.push(getRandomColor({{ $index + 10 }}, 0.7));
            @endforeach

            // Create pie chart
            window.facultyPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: facultyLabels,
                    datasets: [{
                        data: facultyData,
                        backgroundColor: facultyColors,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutCirc'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            });

            // Create doughnut chart
            window.facultyDoughnutChart = new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: facultyLabels,
                    datasets: [{
                        data: facultyData,
                        backgroundColor: facultyColors,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 70,
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutCirc'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            });

            // Add chart switch event listeners
            document.getElementById('pieChartBtn').addEventListener('click', function() {
                this.classList.add('active');
                document.getElementById('doughnutChartBtn').classList.remove('active');
                document.getElementById('facultyPieChart').style.display = 'block';
                document.getElementById('facultyDoughnutChart').style.display = 'none';
            });

            document.getElementById('doughnutChartBtn').addEventListener('click', function() {
                this.classList.add('active');
                document.getElementById('pieChartBtn').classList.remove('active');
                document.getElementById('facultyPieChart').style.display = 'none';
                document.getElementById('facultyDoughnutChart').style.display = 'block';
            });
        }

        // Create Payment Histogram
        function createPaymentHistogram() {
            const ctx = document.getElementById('paymentHistogram').getContext('2d');

            // Extract payment data
            const paymentData = [];
            const paymentLabels = [];
            const paymentColors = [];

            @foreach($paymentData as $index => $data)
                paymentLabels.push("{{ $data->payment_method }}");
                paymentData.push({{ $data->total }});
                paymentColors.push('rgba(46, 184, 92, ' + (0.5 + ({{ $index }} * 0.1)) + ')');
            @endforeach

            // Create histogram chart
            window.paymentHistogram = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: paymentLabels,
                    datasets: [{
                        label: 'Number of Payments',
                        data: paymentData,
                        backgroundColor: paymentColors,
                        borderColor: paymentColors.map(color => color.replace(/[\d\.]+\)$/, '1)')),
                        borderWidth: 1,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    animation: {
                        duration: 2500,
                        easing: 'easeOutQuart',
                        onProgress: function(animation) {
                            const chartInstance = this.chart;
                            const ctx = chartInstance.ctx;
                            const dataset = chartInstance.data.datasets[0];
                            const meta = chartInstance.controller.getDatasetMeta(0);

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.font = '11px sans-serif';
                            ctx.fillStyle = '#333';

                            meta.data.forEach(function(bar, index) {
                                const data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        }
                    },
                    hover: {
                        animationDuration: 0
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return data.labels[tooltipItem.index] + ': ' +
                                       tooltipItem.yLabel + ' payments';
                            }
                        }
                    }
                }
            });
        }

        // Create Demographics Chart
        function createDemographicsChart() {
            const ctx = document.getElementById('demographicsChart').getContext('2d');

            // Demo data for demographics - in production, this would come from your backend
            const genderData = {
                labels: ['Male', 'Female', 'Other'],
                datasets: [{
                    data: [58, 40, 2],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const ageData = {
                labels: ['18-21', '22-25', '26-30', '31+'],
                datasets: [{
                    data: [45, 35, 15, 5],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const locationData = {
                labels: ['Urban', 'Suburban', 'Rural', 'International'],
                datasets: [{
                    data: [50, 25, 15, 10],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            // Create demographics chart (starting with gender)
            window.demographicsChart = new Chart(ctx, {
                type: 'polarArea',
                data: genderData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scale: {
                        ticks: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            });

            // Set up demographic filter switches
            document.querySelectorAll('[data-demographics]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const type = this.getAttribute('data-demographics');

                    // Remove active class from all options
                    document.querySelectorAll('[data-demographics]').forEach(el => {
                        el.classList.remove('active');
                    });

                    // Add active class to clicked option
                    this.classList.add('active');

                    // Update chart data based on selection
                    if (type === 'gender') {
                        window.demographicsChart.data = genderData;
                    } else if (type === 'age') {
                        window.demographicsChart.data = ageData;
                    } else if (type === 'location') {
                        window.demographicsChart.data = locationData;
                    }

                    // Update chart with animation
                    window.demographicsChart.update({
                        duration: 800,
                        easing: 'easeOutBounce'
                    });
                });
            });
        }

        // Create Application Trend Chart
        function createApplicationTrendChart() {
            const ctx = document.getElementById('applicationTrendChart').getContext('2d');

            // Demo data for application trends - in production, this would come from your backend
            const dailyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            const weeklyLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const dailyData = [12, 19, 15, 17, 14, 8, 5];
            const weeklyData = [65, 80, 90, 75];
            const monthlyData = [50, 65, 85, 120, 160, 190, 210, 180, 120, 90, 75, 60];

            // Create application trend chart (starting with daily)
            window.applicationTrendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: 'Daily Applications',
                        data: dailyData,
                        backgroundColor: 'rgba(103, 119, 240, 0.2)',
                        borderColor: 'rgba(103, 119, 240, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: 'rgba(103, 119, 240, 1)',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });

            // Set up trend period switches
            document.querySelectorAll('[data-trend]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const period = this.getAttribute('data-trend');

                    // Remove active class from all options
                    document.querySelectorAll('[data-trend]').forEach(el => {
                        el.classList.remove('active');
                    });

                    // Add active class to clicked option
                    this.classList.add('active');

                    // Update chart data based on selection
                    if (period === 'daily') {
                        window.applicationTrendChart.data.labels = dailyLabels;
                        window.applicationTrendChart.data.datasets[0].data = dailyData;
                        window.applicationTrendChart.data.datasets[0].label = 'Daily Applications';
                    } else if (period === 'weekly') {
                        window.applicationTrendChart.data.labels = weeklyLabels;
                        window.applicationTrendChart.data.datasets[0].data = weeklyData;
                        window.applicationTrendChart.data.datasets[0].label = 'Weekly Applications';
                    } else if (period === 'monthly') {
                        window.applicationTrendChart.data.labels = monthlyLabels;
                        window.applicationTrendChart.data.datasets[0].data = monthlyData;
                        window.applicationTrendChart.data.datasets[0].label = 'Monthly Applications';
                    }

                    // Update chart with animation
                    window.applicationTrendChart.update({
                        duration: 800,
                        easing: 'easeOutQuart'
                    });
                });
            });
        }

        // Setup chart tab switching
        function setupChartTabSwitching() {
            // Department chart tabs switching
            document.querySelectorAll('.chart-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    document.querySelectorAll('.chart-tab').forEach(t => {
                        t.classList.remove('active');
                    });

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show/hide corresponding chart
                    const chartType = this.getAttribute('data-chart-type');
                    if (chartType === 'bar') {
                        document.getElementById('departmentBarChart').style.display = 'block';
                        document.getElementById('departmentLineChart').style.display = 'none';
                    } else if (chartType === 'line') {
                        document.getElementById('departmentBarChart').style.display = 'none';
                        document.getElementById('departmentLineChart').style.display = 'block';
                    }
                });
            });

            // Chart filter period buttons
            document.querySelectorAll('.chart-filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons in same group
                    this.parentElement.querySelectorAll('.chart-filter-btn').forEach(b => {
                        b.classList.remove('active');
                    });

                    // Add active class to clicked button
                    this.classList.add('active');

                    // In production, this would fetch new data based on period
                    const period = this.getAttribute('data-period');
                    console.log(`Filtering for period: ${period}`);

                    // For demo, we'll just simulate a data update with animation
                    if (window.departmentBarChart) {
                        // Generate some random new data
                        const newData = window.departmentBarChart.data.datasets[0].data.map(() => {
                            return Math.floor(Math.random() * 50) + 10;
                        });

                        // Update the charts
                        window.departmentBarChart.data.datasets[0].data = newData;
                        window.departmentBarChart.update({
                            duration: 800,
                            easing: 'easeOutQuart'
                        });

                        if (window.departmentLineChart) {
                            window.departmentLineChart.data.datasets[0].data = newData;
                            window.departmentLineChart.update({
                                duration: 800,
                                easing: 'easeOutQuart'
                            });
                        }
                    }
                });
            });
        }

        // Helper function to generate random colors
        function getRandomColor(seed, opacity) {
            // Use a deterministic approach based on seed
            const colors = [
                `rgba(103, 119, 240, ${opacity})`,    // Blue-purple
                `rgba(46, 184, 92, ${opacity})`,      // Green
                `rgba(250, 92, 124, ${opacity})`,     // Pink
                `rgba(255, 159, 67, ${opacity})`,     // Orange
                `rgba(54, 163, 247, ${opacity})`,     // Light blue
                `rgba(156, 39, 176, ${opacity})`,     // Purple
                `rgba(233, 30, 99, ${opacity})`,      // Deep pink
                `rgba(0, 150, 136, ${opacity})`,      // Teal
                `rgba(255, 193, 7, ${opacity})`,      // Amber
                `rgba(96, 125, 139, ${opacity})`,     // Blue grey
                `rgba(230, 81, 0, ${opacity})`,       // Deep orange
                `rgba(121, 85, 72, ${opacity})`,      // Brown
                `rgba(76, 175, 80, ${opacity})`,      // Green
                `rgba(63, 81, 181, ${opacity})`,      // Indigo
                `rgba(0, 188, 212, ${opacity})`       // Cyan
            ];

            return colors[seed % colors.length];
        }

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
