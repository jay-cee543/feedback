<?php
// Sample data (replace this with data fetched from a database)
$data = [
    ["date" => "2023-01-01", "count" => 5],
    ["date" => "2023-01-02", "count" => 8],
    ["date" => "2023-01-03", "count" => 12],
    ["date" => "2023-01-04", "count" => 7],
    ["date" => "2023-01-05", "count" => 10],
    ["date" => "2023-01-06", "count" => 15],
    ["date" => "2023-01-07", "count" => 9],
    ["date" => "2023-01-08", "count" => 11],
    ["date" => "2023-01-09", "count" => 14],
    ["date" => "2023-01-10", "count" => 18],
    ["date" => "2023-01-11", "count" => 13],
    ["date" => "2023-01-12", "count" => 16],
];

// Convert data for JavaScript
$dates = array_column($data, "date");
$counts = array_column($data, "count");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Volume Trends</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }
        .chart-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="chart-container">
    <h2>Feedback Volume Trends</h2>

    <div class="chart-controls">
        <select id="chartType" onchange="updateChartType()">
            <option value="line">Line Chart</option>
            <option value="bar">Bar Chart</option>
        </select>
    </div>

    <canvas id="feedbackChart"></canvas>
</div>

<script>
    const chartData = {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: "Feedback Count",
            data: <?php echo json_encode($counts); ?>,
            borderColor: "#3b82f6",
            backgroundColor: "rgba(59, 130, 246, 0.5)",
            borderWidth: 2
        }]
    };

    const config = {
        type: "line",
        data: chartData,
        options: {
            responsive: true,
            scales: {
                x: { 
                    title: { display: true, text: "Date" } 
                },
                y: { 
                    beginAtZero: true,
                    title: { display: true, text: "Count" }
                }
            }
        }
    };

    let feedbackChart = new Chart(document.getElementById("feedbackChart"), config);

    function updateChartType() {
        const selectedType = document.getElementById("chartType").value;
        feedbackChart.destroy();
        feedbackChart = new Chart(document.getElementById("feedbackChart"), {
            ...config,
            type: selectedType
        });
    }
</script>

</body>
</html>
