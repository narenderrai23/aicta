function getChartColorsArray(chartId) {
  if (document.getElementById(chartId) !== null) {
    var colors = document.getElementById(chartId).getAttribute("data-colors");
    colors = JSON.parse(colors);
    return colors.map(function (value) {
      var newValue = value.replace(" ", "");
      if (newValue.indexOf("--") != -1) {
        var color = getComputedStyle(document.documentElement).getPropertyValue(
          newValue
        );
        if (color) return color;
      } else {
        return newValue;
      }
    });
  }
}
function createMiniChart(containerId, data) {
  var barchartColors = getChartColorsArray(containerId);
  var options = {
    series: [{ data }],
    chart: { type: "line", height: 61, sparkline: { enabled: true } },
    colors: barchartColors,
    stroke: { curve: "smooth", width: 2.5 },
    tooltip: {
      fixed: { enabled: false },
      x: { show: false },
      y: { title: { formatter: () => "" } },
      marker: { show: false },
    },
  };

  new ApexCharts(document.querySelector(`#${containerId}`), options).render();
}

function createBarChart(containerId, data, categories) {
  var barchartColors = getChartColorsArray(containerId);
  var options = {
    series: [{ data }],
    chart: {
      toolbar: { show: false },
      height: 350,
      type: "bar",
      events: { click: () => {} },
    },
    plotOptions: { bar: { columnWidth: "70%", distributed: true } },
    dataLabels: { enabled: false },
    legend: { show: false },
    colors: barchartColors,
    xaxis: {
      categories,
      labels: { style: { colors: barchartColors, fontSize: "12px" } },
    },
  };

  new ApexCharts(document.querySelector(`#${containerId}`), options).render();
}

function createGenderChart(containerId, data, categories) {
  var barchartColors = getChartColorsArray(containerId);
  var options = {
    chart: { type: "pie" },
    labels: categories,
    series: data,
    colors: barchartColors,
  };
  new ApexCharts(document.getElementById("genderChart"), options).render();
}

function createSplineAreaChart(containerId, seriesData, categories) {
  var barchartColors = getChartColorsArray(containerId);
  var options = {
    series: seriesData,
    chart: { type: "area" },
    dataLabels: { enabled: false },
    stroke: { curve: "smooth" },
    colors: barchartColors,
    xaxis: {
      categories,
      labels: { style: { colors: barchartColors, fontSize: "12px" } },
    },
  };

  new ApexCharts(document.querySelector(`#${containerId}`), options).render();
}