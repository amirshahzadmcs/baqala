<?php $this->load->view('admin/home/header'); ?>
<style>
	.kpi-wrapper {
		display: flex;
		height: 115px;
		background: #fff;
		font-family: system-ui, -apple-system, "Segoe UI";
	}

	/* COMMON KPI */
	.kpi {
		flex: 1;
		border-left: 1px solid #e3e3e3;
		display: flex;
		flex-direction: column;
		justify-content: center;
		text-align: center;
	}

	.kpi:first-child,
	.kpi:nth-child(2),
	.kpi:nth-child(3) {
		border-left: none;
	}

	.kpi i {
		font-size: 26px;
		color: #111;
		margin-bottom: 4px;
	}

	.kpi-label {
		font-size: 11px;
		letter-spacing: 1px;
		color: #000000;
		text-transform: uppercase;
		font-weight: 600;
	}

	.kpi-number {
		color: #111;
		font-size: 22px;
		font-weight: 700;
	}

	/* HIRED BLOCK */
	.kpi.hired {
		width: 280px;
		flex: none;
		background: #000;
		color: #fff;
		padding: 18px 10px;
		display: flex;
		flex-direction: initial;
	}

	.kpi.hired .hired-employees,
	.kpi.hired .active-employees {
		width: 50%;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	/* Divider */
	.kpi.hired .hired-employees {
		border-right: 1px solid #b9b6b6;
		text-align: center;
		padding-right: 10px;
	}

	.kpi.hired .active-employees {
		text-align: center;
		padding-left: 10px;
	}

	.kpi.hired .kpi-title {
		font-size: 11px;
		letter-spacing: 1px;
		color: #ffffff;
		margin-top: 10px;
		font-weight: 500;
	}

	.kpi.hired .kpi-value {
		font-size: 22px;
		font-weight: 700;
		margin-bottom: 0;
	}

	.kpi.hired .kpi-progress-bar {
		padding: 6px 0px;
	}

	.kpi.hired .kpi-progress-bar .progress {
		height: 20px;
		border-radius: 0px;
	}

	/* MINI CHART */
	.nationality-kpi {
		height: 155px;
		border: 1px solid #ddd;
		margin: 0px 5px;
		padding: 5px 2px;
		width: 130px;
	}

	.nationality-kpi .vbar-wrapper {
		width: 60px;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.nationality-kpi .vbar-track {
		height: 55px;
		width: 35px;
		background: #f1f1f1;
		border-radius: 0px;
		display: flex;
		align-items: flex-end;
		overflow: hidden;
	}

	.nationality-kpi .vbar-fill {
		width: 100%;
		border-radius: 0px;
		transition: height 0.6s ease;
	}

	.nationality-kpi .vbar-fill.saudi {
		background-color: #080808;
	}

	.nationality-kpi .vbar-fill.non-saudi {
		background-color: #4dd0e1;
	}

	.nationality-kpi .percent {
		font-size: 12px;
		font-weight: 600;
		margin-bottom: 6px;
		color: #000;
	}

	.nationality-kpi .label {
		font-size: 12px;
		margin-top: 6px;
		color: #666;
		color: #000000;
		font-weight: 500;
	}

	#genderNumbers {
		font-weight: 600;
		margin: auto 0px;
		line-height: 18px;
	}

	/*---- FUNNEL TABLE ----*/
	.bar-charts-row .card-title h5 {
		font-size: 14px;
		font-weight: 600;
	}

	.funnel-table td {
		padding: 2px 6px;
		vertical-align: middle;
		border: none;
		color: #000;
		font-weight: 500;
	}

	.funnel-bar-wrapper {
		flex: 1;
		background: #f1f1f1;
		border-radius: 0px;
		overflow: hidden;
		height: 14px;
	}

	.funnel-bar {
		height: 100%;
		background: linear-gradient(90deg, #4dd0e1, #1a1a1a);
		border-radius: 0px;
	}

	.funnel-percent {
		min-width: 20px;
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
	#vehicleNumbers {
		font-weight: 600;
		margin: auto 11px;
		line-height: 26px;
		font-size: 18px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>#RWFD Human Resources Dashboard | Overview</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item active">A Comprehensive View of Workforce Operations and Key Indicators</li>
						<!-- <li class="breadcrumb-item active">Human Resources</li> -->
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->
<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="row px-0 kpi-row">
							<div class="kpi-wrapper">

								<!-- HIRED EMPLOYEES -->
								<div class="kpi hired">
									<div class="hired-employees">
										<?php
											$total = $summary->total;
											$active = $summary->active;
											$activePercent = $total ? round(($active/$total)*100) : 0;
										?>
										<div class="kpi-title">HIRED EMPLOYEES</div>
										<div class="kpi-value"><?= number_format($total) ?></div>
									</div>

									<div class="active-employees">
										<div class="kpi-title">ACTIVE - <?= $active ?></div>
										<div class="kpi-progress-bar">
											<div class="progress">
												<div class="progress-bar"
													role="progressbar"
													style="width: <?= $activePercent ?>%;background: #4dd0e1;">
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- ACTIVE EMPLOYEES -->
								<div class="kpi" style="width: 130px;flex: none;color: #fff;display: flex;">
									<div class="d-flex justify-content-center align-items-end gap-0 nationality-kpi">
										<?php
											$natTotal = $nationality->saudi + $nationality->non_saudi;
											$saudiP   = $natTotal ? round(($nationality->saudi/$natTotal)*100) : 0;
											$nonP     = 100 - $saudiP;
										?>
										<div class="vbar-wrapper">
											<div class="percent"><?= $saudiP ?>%</div>
											<div class="vbar-track">
												<div class="vbar-fill saudi" style="height:<?= $saudiP ?>%"></div>
											</div>
											<div class="label">Saudi</div>
										</div>

										<div class="vbar-wrapper">
											<div class="percent"><?= $nonP ?>%</div>
											<div class="vbar-track">
												<div class="vbar-fill non-saudi" style="height:<?= $nonP ?>%"></div>
											</div>
											<div class="label">Non-Saudi</div>
										</div>
									</div>
								</div>

								<div class="kpi" style="flex-direction: inherit;width: 190px;flex: none;">
									<div style="width:100px; margin:auto 10px; position:relative;">
										<canvas id="genderChart"></canvas>
									</div>
									<div id="genderNumbers">
										<div>Male<br><span id="maleCount" style="color:#4caf50;font-size: 20px;font-weight: 700;"></span></div>
										<div>Female<br><span id="femaleCount" style="color:#2f5876;font-size: 20px;font-weight: 700;"></span></div>
									</div>
								</div>

								<!-- TERMINATED -->
								<div class="kpi">
									<i class="mdi mdi-account-clock-outline"></i>
									<div class="kpi-label">Operational Staff</div>
									<div class="kpi-number"><?= $operational_staff->active; ?></div>
								</div>

								<!-- AVG AGE -->
								<div class="kpi">
									<i class="mdi mdi-bike-fast"></i>
									<div class="kpi-label">Bike Riders</div>
									<div class="kpi-number"><?= $vehicle->bike; ?></div>
								</div>

								<!-- AVG AGE -->
								<div class="kpi">
									<i class="mdi mdi-car"></i>
									<div class="kpi-label">Car Drivers</div>
									<div class="kpi-number"><?= $vehicle->car; ?></div>
								</div>

							</div>
							<div style="border: 1px solid #e1e1e1;margin: 13px;width: 97%;"></div>
						</div>

						<div class="row bar-charts-row px-0">
							<div class="col-md-4">
								<div class="card p-2">
									<div class="card-title text-center border-none mb-2">
										<h5>NUMBER OF EMPLOYEES BY DEPARTMENT</h5>
									</div>

									<table class="table align-middle funnel-table" style="font-size: 12px;margin-bottom: 0px;">
										<tbody>
											<?php
												$total_by_department = array_sum(array_column($by_department, 'total'));
											?>

											<?php foreach ($by_department as $row): 
												$percent = $total_by_department
													? round(($row->total / $total_by_department) * 100, 2)
													: 0;
											?>
												<tr>
													<td style="width:48%;"><?= $row->department ?></td>
													<td>
														<div class="d-flex align-items-center gap-2">
															<div class="funnel-bar-wrapper">
																<div class="funnel-bar" style="width:<?= $percent ?>%"></div>
															</div>
															<span class="funnel-percent"><?= $row->total ?></span>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>

									</table>
								</div>
							</div>

							<div class="col-md-4">
								<div class="card p-2">
									<div class="card-title text-center border-none mb-2">
										<h5>NUMBER OF RIDERS BY CITY</h5>
									</div>

									<table class="table align-middle funnel-table" style="font-size: 12px;margin-bottom: 0px;">
										<tbody>
											<?php
											$total_riders_by_city = array_sum(array_column($by_city, 'total'));
											?>

											<?php foreach ($by_city as $row): 
												$percent = $total_riders_by_city 
													? round(($row->total / $total_riders_by_city) * 100, 2) 
													: 0;
											?>
											<tr>
												<td style="width:30%;"><?= $row->city ?></td>
												<td>
													<div class="d-flex align-items-center gap-2">
														<div class="funnel-bar-wrapper">
															<div class="funnel-bar" style="width:<?= $percent ?>%"></div>
														</div>
														<span class="funnel-percent"><?= $row->total ?></span>
													</div>
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>

							<div class="col-md-4">
								<div class="card p-2">
									<div class="card-title text-center border-none mb-2">
										<h5>RIDERS PERCENTAGE (CAR vs BIKE)</h5>
									</div>
									<div class="d-flex justify-content-center align-items-center gap-3">
										<!-- BIKE / CAR KPI -->
										<div class="kpi" style="flex-direction: inherit;flex: none;">
											<div style="width:180px; margin:auto 5px; position:relative;">
												<canvas id="vehicleChart"></canvas>
											</div>
											<div id="vehicleNumbers">
												<div>Bike<br><span id="bikeCount" style="color:#4dd0e1;font-size:20px;"></span></div>
												<div>Car<br><span id="carCount" style="color:#0f0f0f;font-size:20px;"></span></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div> <!-- page content wrapper ends -->
</div> <!-- container fluid ends -->
<?php $this->load->view('admin/home/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function renderDoughnutChart({
    canvasId,
    values,
    colors,
    icons,
    countIds
}) {

    const customPlugin = {
        id: canvasId + '_plugin',
        afterDraw(chart) {
            const { ctx, chartArea: { width, height, left, top } } = chart;
            const cx = left + width / 2;
            const cy = top + height / 2;

            const dataset = chart.data.datasets[0];
            const total = dataset.data.reduce((a, b) => a + b, 0);

            /* ================= CENTER ICONS ================= */
            icons.forEach((icon, i) => {
                const img = new Image();
                img.src = icon;
                img.onload = () => {
                    const offset = icons.length === 1 ? 0 : (i === 0 ? -18 : 18);
                    ctx.drawImage(img, cx + offset - 12, cy - 14, 24, 24);
                };
            });

            /* ================= PERCENT LABELS ================= */
            chart.getDatasetMeta(0).data.forEach((arc, index) => {

                if (!total || dataset.data[index] === 0) return;

                const percentValue = (dataset.data[index] / total) * 100;

                // Hide very small slices
                if (percentValue < 2) return;

                const percent = percentValue.toFixed(0) + '%';

                const angle = (arc.startAngle + arc.endAngle) / 2;
                const r = arc.outerRadius - 8;

                const x = cx + r * Math.cos(angle);
                const y = cy + r * Math.sin(angle);

                ctx.save();
                ctx.font = 'bold 11px system-ui, -apple-system, Segoe UI';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                const paddingX = 6;
                const paddingY = 3;
                const textWidth = ctx.measureText(percent).width;
                const boxWidth = textWidth + paddingX * 2;
                const boxHeight = 14;
                const radius = 4;

                // background bubble
                ctx.fillStyle = '#ffffff';
                ctx.beginPath();
                ctx.moveTo(x - boxWidth / 2 + radius, y - boxHeight / 2);
                ctx.lineTo(x + boxWidth / 2 - radius, y - boxHeight / 2);
                ctx.quadraticCurveTo(
                    x + boxWidth / 2,
                    y - boxHeight / 2,
                    x + boxWidth / 2,
                    y - boxHeight / 2 + radius
                );
                ctx.lineTo(x + boxWidth / 2, y + boxHeight / 2 - radius);
                ctx.quadraticCurveTo(
                    x + boxWidth / 2,
                    y + boxHeight / 2,
                    x + boxWidth / 2 - radius,
                    y + boxHeight / 2
                );
                ctx.lineTo(x - boxWidth / 2 + radius, y + boxHeight / 2);
                ctx.quadraticCurveTo(
                    x - boxWidth / 2,
                    y + boxHeight / 2,
                    x - boxWidth / 2,
                    y + boxHeight / 2 - radius
                );
                ctx.lineTo(x - boxWidth / 2, y - boxHeight / 2 + radius);
                ctx.quadraticCurveTo(
                    x - boxWidth / 2,
                    y - boxHeight / 2,
                    x - boxWidth / 2 + radius,
                    y - boxHeight / 2
                );
                ctx.closePath();
                ctx.fill();

                ctx.fillStyle = '#000';
                ctx.fillText(percent, x, y);
                ctx.restore();
            });
        }
    };

    new Chart(document.getElementById(canvasId), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 0,
                cutout: '65%'
            }]
        },
        plugins: [customPlugin],
        options: {
            responsive: true,
            // IMPORTANT: do NOT force height
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });

    /* ================= COUNTS ================= */
    countIds.forEach((id, i) => {
        const el = document.getElementById(id);
        if (el) el.innerText = values[i] ?? 0;
    });
}
</script>

<script>
/* ================= GENDER ================= */
const genderData = <?= json_encode([
    (int)$gender->male,
    (int)$gender->female
]) ?>;

renderDoughnutChart({
    canvasId: 'genderChart',
    values: genderData,
    colors: ['#4caf50', '#2f5876'],
    icons: [
        'admin_assets/icons/male-icon.png',
        'admin_assets/icons/female-icon.png'
    ],
    countIds: ['maleCount', 'femaleCount']
});

/* ================= BIKE / CAR ================= */
renderDoughnutChart({
    canvasId: 'vehicleChart',
    values: [
        <?= (int)$vehicle->bike ?>,
        <?= (int)$vehicle->car ?>
    ],
    colors: ['#4dd0e1', '#0f0f0f'],
    icons: [
        'admin_assets/icons/car-icon.png',
        'admin_assets/icons/bike-icon.png',
    ],
    countIds: ['bikeCount', 'carCount']
});
</script>


