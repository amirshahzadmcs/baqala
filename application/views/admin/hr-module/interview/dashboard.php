<?php $this->load->view('admin/home/header'); ?>
<style>
    /* ---------- Custom Dashboard Styling ---------- */

    .dashboard-title {
        font-weight: 600;
    }

    /* Timeline container */
    .kpi-timeline {
        display: flex;
        position: relative;
        padding-bottom: 36px;
    }

    /* Dotted horizontal connector */
    .kpi-timeline::after {
        content: "";
        position: absolute;
        bottom: 12px;
        left: 0;
        right: 0;
        border-bottom: 2px dotted #d6d6d6;
        z-index: 1;
    }

    /* KPI block */
    .kpi-step {
        position: relative;
        flex: 1;
        background: #f2994a;
        margin-right: 21px;
        padding: 8px 8px;
        color: #fff;
        min-width: 104px;
        z-index: 2;
    }

    /* Chevron arrow */
    .kpi-step::after {
        content: "";
        position: absolute;
        top: 1px;
        right: -20px;
        border-top: 28px solid transparent;
        border-bottom: 29px solid transparent;
        border-left: 21px solid #f2994a;
    }

    /* .kpi-step:last-child::after {
        display: none;
    } */

    /* Chevron inner cut */
    .kpi-step::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        border-top: 29px solid transparent;
        border-bottom: 29px solid transparent;
        border-left: 22px solid #fff;
    }

    .kpi-step:first-child::before {
        display: none;
    }

    /* KPI text */
    .kpi-content {
        text-align: center;
    }

    .kpi-value {
        font-size: 16px;
        font-weight: 700;
    }

    .kpi-label {
        font-size: 12px;
        opacity: 0.9;
    }

    /* Vertical connector from KPI to timeline */
    .kpi-step .kpi-node::before {
        content: "";
        position: absolute;
        top: -18px;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 18px;
        background: #d6d6d6;
    }

    /* Node on dotted line */
    .kpi-node {
        position: absolute;
        bottom: -28px;
        left: 50%;
        transform: translateX(-50%);
        width: 10px;
        height: 10px;
        background: #f2994a;
        border-radius: 50%;
        z-index: 3;
    }

    .recruitment-dashboard .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .04);
    }

    .recruitment-dashboard .card-title h5 {
        font-size: 14px;
        font-weight: 600;
    }

    .recruitment-dashboard .card {
        /* height: 445px; */
        margin-bottom: 5px;
        /* overflow-y: scroll; */
    }
    /*--- Donut Chart Start ---*/
    .chart-wrapper {
        /* position: relative; */
        height: 180px;
    }

    /*---- Donut Chart End ----*/
    .metric-table td {
        vertical-align: middle;
        padding: 6px;
    }

    /* Row holding bar + value */
    .bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Background track */
    .bar-wrapper {
        flex: 1;
        height: 16px;
        background: #f1f3f5;
        border-radius: 2px;
        overflow: hidden;
    }

    /* Actual bar */
    .bar {
        height: 100%;
        border-radius: 2px;
    }

    .hired-bar {
        background-color: #1f2a56;
    }

    .days-bar {
        background-color: #f2994a;
    }

    /* Value outside */
    .bar-value {
        min-width: 28px;
        text-align: right;
        font-weight: 600;
        font-size: 13px;
        color: #000;
    }

    /*----- Recruitment Funnel & Pipeline ----*/
    .funnel-table td {
        padding: 3px 6px;
        vertical-align: middle;
        border: none;
    }

    .funnel-bar-wrapper {
        flex: 1;
        background: #f1f1f1;
        border-radius: 2px;
        overflow: hidden;
        height: 16px;
    }

    .funnel-bar {
        height: 100%;
        background: linear-gradient(90deg, #1e90ff, #28366e);
        border-radius: 2px;
    }

    .funnel-percent {
        min-width: 38px;
        font-size: 12px;
        font-weight: 600;
        color: #333;
        text-align: right;
    }

    .progress {
        height: 18px;
    }

    .progress-bar {
        font-size: 11px;
        font-weight: 600;
    }

    /* PIPELINE BAR */
    .pipeline-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .pipeline-step {
        text-align: center;
        position: relative;
    }

    /* Circle */
    .pipeline-count {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid currentColor;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin: auto;
        z-index: 2;
    }

    /* Connector line */
    .pipeline-step::after {
        content: "";
        position: absolute;
        top: 34px;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 12px;
        background: currentColor;
    }

    /* Progress bar */
    .pipeline-bar {
        height: 36px;
        margin-top: -10px;
    }

    /* Legend */
    .pipeline-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 2px 6px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        font-size: 12px;
    }

    .legend-box {
        width: 14px;
        height: 8px;
        margin-right: 6px;
        border-radius: 2px;
    }

    /* Colors */
    .step-navy, .bg-navy { color: #1f2a44; background-color: #1f2a44; }
    .step-indigo, .bg-indigo { color: #4c5aa7; background-color: #4c5aa7; }
    .step-orange, .bg-orange { color: #f2994a; background-color: #f2994a; }
    .step-light-orange, .bg-light-orange { color: #f6c28b; background-color: #f6c28b; }
    .step-blue, .bg-blue { color: #007bff; background-color: #007bff; }

    .table th {
        font-size: 12px;
        color: #6c757d;
    }
</style>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Recruitment Dashboard Metrics with Active Pipeline</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Overview of recruitment metrics to track active interview pipeline and status.</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">

                </div>
                <?php if ($this->admin->getInfo()) {
                    $info = explode("--", $this->admin->getInfo());
                    $info_type = $info[0];
                    $msg_data = $info[1];
                    if ($info_type == 1) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong><?php echo $msg_data; ?></strong>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong><?php echo $msg_data; ?></strong>
                        </div>
                <?php }
                }
                $this->admin->removeInfo();  ?>
                <?php if ($this->input->get('msg')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><?php echo $this->input->get('msg'); ?></strong>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="recruitment-dashboard">
                            <!--
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="dashboard-title mb-3">Monthly Metrics (Past 12 months)</h5>
                                </div>
                                <div class="col">
                                    <div class="kpi-timeline">

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">34</div>
                                                <div class="kpi-label">Hired</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">5.6</div>
                                                <div class="kpi-label">Apps Per Hire</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">29</div>
                                                <div class="kpi-label">Days to Hire</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">$500</div>
                                                <div class="kpi-label">Cost Per Hire</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">20</div>
                                                <div class="kpi-label">Open Positions</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                        <div class="kpi-step">
                                            <div class="kpi-content">
                                                <div class="kpi-value">150</div>
                                                <div class="kpi-label">Days in Mkt</div>
                                            </div>
                                            <span class="kpi-node"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="row g-2 mb-4">
                                <!-- Pipeline Efficiency -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom">
                                            <h5>Pipeline Efficiency of Hiring</h5>
                                        </div>
                                        <div class="chart-wrapper text-center">
                                            <canvas id="projectDonut"></canvas>
                                        </div>
                                        <div class="row">
                                            <div class="pipeline-legend mt-2" style="gap: 0px 8px;">
                                                <?php foreach ($chart_labels as $index => $label): ?>
                                                    <?php $color = $statusColors[$row['status']] ?? 'secondary'; ?>
                                                    <div class="legend-item">
                                                        <span class="legend-box" 
                                                            style="
                                                                width:10px;
                                                                height:10px;
                                                                background-color: <?= [
                                                                    '#3F51E5',
                                                                    '#6A7BFF',
                                                                    '#9FA8FF',
                                                                    '#FFD77A',
                                                                    '#FFB300',
                                                                    '#2DE2D6',
                                                                    '#00BFA5',
                                                                    '#66FFF2',
                                                                    '#0e643c'
                                                                ][$index]; ?>;
                                                                display:inline-block;
                                                                margin-right:3px;
                                                                border-radius:50%;
                                                            ">
                                                        </span>
                                                        <span class="legend-text">
                                                            <?= $label ?>
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Monthly Metrics -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom">
                                            <h5>Monthly Metrics</h5>
                                        </div>
                                        <table class="table table-bordered align-middle metric-table" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width:24%;background: #1e90ff;color: #fff;font-size: 12px;padding: 4px;">Month</th>
                                                    <th style="width:38%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;">Hired</th>
                                                    <th style="width:38%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;">Total Applications</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($monthly_metrics)): ?>
                                                    <?php foreach ($monthly_metrics as $row): ?>
                                                        <tr>
                                                            <td style="background:#e6e6fa;color:#000;">
                                                                <?= $row['month_label']; ?>
                                                            </td>

                                                            <!-- Hired -->
                                                            <td>
                                                                <div class="bar-row">
                                                                    <div class="bar-wrapper">
                                                                        <div
                                                                            class="bar hired-bar"
                                                                            style="width:<?= $row['hired_width']; ?>%">
                                                                        </div>
                                                                    </div>
                                                                    <span class="bar-value">
                                                                        <?= (int) $row['hired_count']; ?>
                                                                    </span>
                                                                </div>
                                                            </td>

                                                            <!-- Total Applications -->
                                                            <td>
                                                                <div class="bar-row">
                                                                    <div class="bar-wrapper">
                                                                        <div
                                                                            class="bar days-bar"
                                                                            style="width:<?= $row['total_width']; ?>%">
                                                                        </div>
                                                                    </div>
                                                                    <span class="bar-value">
                                                                        <?= (int) $row['total_applications']; ?>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">
                                                            No data available
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>

                                        </table>

                                    </div>
                                </div>

                                <!-- Recruitment Funnel -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom mb-2">
                                            <h5>Recruitment Funnel</h5>
                                        </div>

                                        <table class="table align-middle funnel-table" style="font-size: 12px;margin-bottom: 0px;">
                                            <tbody>
                                                <?php if (!empty($funnel_data)): ?>
                                                    <?php foreach ($funnel_data as $row): ?>
                                                        <tr>
                                                            <td style="width:35%;">
                                                                <?= htmlspecialchars($row['status']); ?>
                                                            </td>

                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="funnel-bar-wrapper">
                                                                        <div
                                                                            class="funnel-bar"
                                                                            style="width:<?= $row['width']; ?>%">
                                                                        </div>
                                                                    </div>

                                                                    <span class="funnel-percent">
                                                                        <?= $row['percentage']; ?>%
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom">
                                            <h5>Application Sources</h5>
                                        </div>
                                        <table class="table table-bordered align-middle metric-table" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width:20%;background: #1e90ff;color: #fff;font-size: 12px;padding: 4px;">Source</th>
                                                    <th style="width:20%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;"># Hired</th>
                                                    <th style="width:20%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;">% of Hired</th>
                                                    <th style="width:40%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;">Conv Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($application_sources)): ?>
                                                    <?php foreach ($application_sources as $row): ?>
                                                        <tr>
                                                            <td style="background:#e6e6fa;color:#000;">
                                                                <?= $row['emp_no'] ?>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <?= $row['hired_count'] ?>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <?= $row['hire_percentage'] ?>%
                                                            </td>

                                                            <td>
                                                                <div class="bar-row">
                                                                    <div class="bar-wrapper">
                                                                        <div class="bar hired-bar"
                                                                            style="width:<?= $row['conv_width'] ?>%">
                                                                        </div>
                                                                    </div>
                                                                    <span class="bar-value">
                                                                        <?= $row['conversion_rate'] ?>%
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">
                                                            No data available
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>

                                        </table>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom">
                                            <h5>Decline Reasons</h5>
                                        </div>
                                        <table class="table table-bordered align-middle metric-table" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width:25%;background: #1e90ff;color: #fff;font-size: 12px;padding: 4px;">Source</th>
                                                    <th style="width:25%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;"># of Apps</th>
                                                    <th style="width:50%;background: #28366e;color: #fff;font-size: 12px;padding: 4px;text-align: center;"># of Apps</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($decline_reasons['rows'])): ?>

                                                    <?php foreach ($decline_reasons['rows'] as $row): ?>
                                                        <tr>
                                                            <td style="background:#e6e6fa;color:#000;">
                                                                <?= htmlspecialchars($row['reason']) ?>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <?= $row['total_count'] ?>
                                                            </td>

                                                            <td>
                                                                <div class="bar-row">
                                                                    <div class="bar-wrapper">
                                                                        <div class="bar days-bar"
                                                                            style="width:<?= $row['bar_width'] ?>%">
                                                                        </div>
                                                                    </div>
                                                                    <span class="bar-value">
                                                                        <?= $row['percentage'] ?>%
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                    <?php if ($decline_reasons['others']['count'] > 0): ?>
                                                        <tr>
                                                            <td><strong>Outside Top 8</strong></td>
                                                            <td style="text-align:center;">
                                                                <?= $decline_reasons['others']['count'] ?>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <?= $decline_reasons['others']['percentage'] ?>%
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>

                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">
                                                            No declined applications found
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>

                                        </table>
                                    </div>
                                </div>

                                <!-- Active Pipeline -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-title border-bottom mb-2">
                                            <h5>Active Pipeline</h5>
                                        </div>

                                        <?php
                                        $statusColors = [
                                            'Screening'        => 'navy',
                                            'Phone Interview'  => 'indigo',
                                            'Onsite Interview' => 'orange',
                                            'Qiwa Requested'   => 'light-orange',
                                            'Onboarding'       => 'blue',
                                        ];
                                        ?>

                                        <!-- COUNTS (CIRCLES) -->
                                        <div class="pipeline-steps">
                                            <?php foreach ($active_pipeline as $row): ?>
                                                <?php $color = $statusColors[$row['status']] ?? 'secondary'; ?>
                                                <div class="pipeline-step" style="width: <?= $row['percentage'] ?>%">
                                                    <div class="pipeline-count">
                                                        <?= (int) $row['total_count'] ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- PROGRESS BAR -->
                                        <div class="progress pipeline-bar">
                                            <?php foreach ($active_pipeline as $row): ?>
                                                <?php $color = $statusColors[$row['status']] ?? 'secondary'; ?>
                                                <div class="progress-bar bg-<?= $color ?>"
                                                    style="width: <?= $row['percentage'] ?>%">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- LEGEND (NO OVERLAP) -->
                                        <div class="pipeline-legend mt-3">
                                            <?php foreach ($active_pipeline as $row): ?>
                                                <?php $color = $statusColors[$row['status']] ?? 'secondary'; ?>
                                                <div class="legend-item">
                                                    <span class="legend-box bg-<?= $color ?>"></span>
                                                    <span class="legend-text">
                                                        <?= htmlspecialchars($row['status']) ?>
                                                        (<?= (int) $row['total_count'] ?>)
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
    // Dynamic data from PHP
    const chartLabels = <?= json_encode($chart_labels); ?>;
    const chartValues = <?= json_encode($chart_values); ?>;
    const totalCount  = <?= (int) $chart_total; ?>;

    // Colors must match HTML legend
    const chartColors = [
        '#3F51E5',
        '#6A7BFF',
        '#9FA8FF',
        '#FFD77A',
        '#FFB300',
        '#2DE2D6',
        '#00BFA5',
        '#66FFF2',
        '#0e643c',
    ];

    const ctx = document.getElementById('projectDonut');

    const data = {
        labels: chartLabels,
        datasets: [{
            data: chartValues,
            backgroundColor: chartColors,
            borderWidth: 2,
            borderColor: '#fff'
        }]
    };

    // Center total text plugin
    const centerTextPlugin = {
        id: 'centerText',
        afterDraw(chart) {
            const { ctx, chartArea } = chart;
            if (!chartArea) return;

            const centerX = (chartArea.left + chartArea.right) / 2;
            const centerY = (chartArea.top + chartArea.bottom) / 2;

            ctx.save();
            ctx.font = '700 22px Arial';
            ctx.fillStyle = '#444';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(totalCount, centerX, centerY);
            ctx.restore();
        }
    };

    // Create chart
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        plugins: [ChartDataLabels, centerTextPlugin],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    display: false // IMPORTANT: hide default legend
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: '600',
                        size: 14
                    },
                    formatter: value => value > 0 ? value : ''
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw}`
                    }
                }
            }
        }
    });

    // Render status labels below the chart
    const legendContainer = document.getElementById('chartLegend');

    chartLabels.forEach((label, index) => {
        const item = document.createElement('div');
        item.className = 'col-6 d-flex align-items-center mb-2';

        item.innerHTML = `
            <span style="
                width:12px;
                height:12px;
                background-color:${chartColors[index]};
                display:inline-block;
                margin-right:8px;
                border-radius:50%;
            "></span>
            <small>${label}</small>
        `;

        legendContainer.appendChild(item);
    });
</script>

