$(function () {
  "use strict";

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  //Mixed Product

  var mixProductCanvas = document.getElementById("mix-product-canvas");

  var mixProductChart = new Chart(mixProductCanvas, {
    type: "bar",
    data: {
      datasets: [
        {
          label: "มูลค่า",
          data: [42559, 211605, 107983, 92118, 14572],
          type: "line",
          lineTension: 0,
          fill: false,
          borderColor: "orange",
          backgroundColor: "transparent",
          pointBorderColor: "orange",
          pointBackgroundColor: "rgba(255,150,0,0.5)",
          pointRadius: 5,
          pointHoverRadius: 10,
          pointHitRadius: 30,
          pointBorderWidth: 2,
          pointStyle: "rectRounded",
        },
        {
          label: "ผลผลิต",
          data: [6538, 114054, 87868, 41368, 2253],
          backgroundColor: "green",
        },
      ],
      labels: ["ปศุสัตว์", "ผัก", "พืซไร่", "ไม้ผล", "อื่นๆ"],
    },
    options: {
      legend: false,
      maintainAspectRatio: false,
      responsive: true,
    },
  });

  // Custom Chart
  var monthProductCanvas = document.getElementById("month-product-canvas");

  var monthProductData = {
    type: "bar",
    labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค."],
    datasets: [
      {
        label: "ผลผลิตพืซผัก",
        data: [190000, 120000, 150000, 180000, 60000, 80000, 60000],
        lineTension: 0,
        fill: false,
        borderColor: "orange",
        backgroundColor: "transparent",
        borderDash: [5, 5],
        pointBorderColor: "orange",
        pointBackgroundColor: "rgba(255,150,0,0.5)",
        pointRadius: 5,
        pointHoverRadius: 10,
        pointHitRadius: 30,
        pointBorderWidth: 2,
        pointStyle: "rectRounded",
      },
      {
        type: "bar",
        label: "ผลผลิต",
        data: [14000, 10000, 12000, 16000, 7000, 8000, 9000],
        backgroundColor: "green",
      },
    ],
  };

  var monthProductOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: true,
      position: "top",
      labels: {
        boxWidth: 80,
        fontColor: "black",
      },
    },
  };

  var monthProductCompare = new Chart(monthProductCanvas, {
    type: "line",
    data: monthProductData,
    options: monthProductOptions,
  });
});
