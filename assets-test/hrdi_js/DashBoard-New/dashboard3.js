$(function () {
  "use strict",
    new Chart(document.getElementById("market-canvas"), {
      type: "bar",
      data: {
        labels: [
          "ตลาดข้อตกลง",
          "ตลาดโครงการหลวง",
          "ตลาดท้องถิ่น",
          "ตลาดอุทยานหลวงราชพฤกษ์",
        ],
        datasets: [
          {
            label: "มูลค่าปีก่อน",
            backgroundColor: "#3e95cd",
            data: [5830000, 8000000, 6000000, 120000],
          },
          {
            label: "มูลค่าปีปัจจุบัน",
            backgroundColor: "#8e5ea2",
            data: [4000000, 8120000, 6500000, 120000],
          },
        ],
      },
      options: {
        title: {
          display: true,
          //   text: "Population growth (millions)",
        },
      },
    });

  new Chart(document.getElementById("market-average-canvas"), {
    type: "line",
    data: {
      labels: [
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
      ],
      datasets: [
        {
          data: [15, 7, 20, 16, 25, 10, 25, 17, 35, 0, 10],
          label: "ราคาขาย",
          borderColor: "#3e95cd",
          fill: false,
        },
        {
          data: [10, 12, 13, 10, 15, 14, 15, 14, 17, 0, 6],
          label: "เฉลี่ยต่ำสุด",
          borderColor: "#8e5ea2",
          fill: false,
        },
        {
          data: [16, 15, 16, 15, 21, 19, 20, 20, 23, 25, 18],
          label: "เฉลี่ยสูงสุด",
          borderColor: "#3cba9f",
          fill: false,
        },
      ],
    },
    options: {
      title: {
        display: true,
      },
    },
  });

  // Custom Chart
  var monthProductCanvas = document.getElementById("product-trend-canvas");

  var monthProductData = {
    type: "bar",
    labels: [
      "พ.ศ.2555",
      "พ.ศ.2556",
      "พ.ศ.2557",
      "พ.ศ.2558",
      "พ.ศ.2559",
      "พ.ศ.2560",
      "พ.ศ.2561",
      "พ.ศ.2562",
      "พ.ศ.2563",
      "พ.ศ.2564",
    ],
    datasets: [
      {
        label: "ผลผลิตพืซผัก",
        data: [16.6, 13.22, 12.69, 13.41, 13.94, 14.34, 15.27, 14.54, 16.0],
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
        label: "ผลผลิตพืซผัก",
        data: [null, null, 13.0, 12.5, 13.3, 14.0, 14.64, 15.0, 15.0, 15.83],
        lineTension: 0,
        fill: false,
        borderColor: "green",
        backgroundColor: "transparent",
        borderDash: [5, 5],
        pointBorderColor: "green",
        pointBackgroundColor: "rgba(11,156,49,1)",
        pointRadius: 5,
        pointHoverRadius: 10,
        pointHitRadius: 30,
        pointBorderWidth: 2,
        pointStyle: "rectRounded",
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

  // more product

  // Custom Chart
  var monthProductCanvas = document.getElementById("more-product-canvas");

  var moreProductData = {
    type: "bar",
    labels: [
      "ต.ค.",
      "พ.ย.",
      "ธ.ค.",
      "ม.ค.",
      "ก.พ.",
      "มี.ค.",
      "เม.ย.",
      "พ.ค.",
      "ก.ค.",
      "ส.ค.",
      "ก.ย.",
    ],
    datasets: [
      {
        label: "ปริมาณ",
        data: [600, 400, 300, 500, 400, 700, 1000, 1100, 900, 700, 800],
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
        label: "ราคาเฉลี่ยจาก การส่งมอบ",
        data: [900, 400, 700, 750, 800, 900],
        lineTension: 0,
        fill: false,
        borderColor: "green",
        backgroundColor: "transparent",
        borderDash: [5, 5],
        pointBorderColor: "green",
        pointBackgroundColor: "rgba(11,156,49,1)",
        pointRadius: 5,
        pointHoverRadius: 10,
        pointHitRadius: 30,
        pointBorderWidth: 2,
        pointStyle: "rectRounded",
      },
    ],
  };

  var moreProductOptions = {
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

  var moreProductCompare = new Chart(monthProductCanvas, {
    type: "line",
    data: moreProductData,
    options: moreProductOptions,
  });
});
