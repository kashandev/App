// /**
//  * Created by Huzaifa on 9/18/15.
//  */

// function GetOutstandingChart() {
// //alert('hi');
//     $.ajax({
//         url: $UrlGetOutstandingChart,
//         dataType: 'json',
//         type: 'post',
//         data: '',
//         beforeSend: function () {
//         },
//         complete: function () {
//         },
//         success: function (json) {
//             if (json) {

//                 Highcharts.chart('container_outstanding',json.data);

//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     });
// }

// function GetRequestChart() {
// //alert('hi');
//     $.ajax({
//         url: $UrlGetRequestChart,
//         dataType: 'json',
//         type: 'post',
//         data: '',
//         beforeSend: function () {
//         },
//         complete: function () {
//         },
//         success: function (json) {
//             if (json) {

//                 Highcharts.chart('container_request',json.data);

//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     });
// }

// function GetExpenseChart() {
// //alert('hi');
//     $.ajax({
//         url: $UrlGetExpenseChart,
//         dataType: 'json',
//         type: 'post',
//         data: '',
//         beforeSend: function () {
//         },
//         complete: function () {
//         },
//         success: function (json) {
//             if (json) {

//                 Highcharts.chart('container_expense',json.data);

//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     });
// }

// function getTopCustomer() {

//     $.ajax({
//         url: $UrlGetCustomer,
//         dataType: 'json',
//         type: 'post',
//         data: '',
//         beforeSend: function () {
//         },
//         complete: function () {
//         },
//         success: function (json) {
//             if (json) {
//                 var result = json.data;
//                 var chart = new CanvasJS.Chart("chartContainer", {
//                     title:{
//                         text: "Top 10 Customer Of The Month"

//                     },
//                     axisX: {

//                         labelAngle: -30,
//                         labelFontSize: 12
//                     },
//                     data: [

//                         {
//                             type: "column",
//                             dataPoints: result
//                         }
//                     ]
//                 });

//                 chart.render();
//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     });
// }
// function getSales() {

//     $.ajax({
//         url: $UrlGetSales,
//         dataType: 'json',
//         type: 'post',
//         data: '',
//         beforeSend: function () {
//         },
//         complete: function () {
//         },
//         success: function (json) {
//             if (json) {
//                 var result = json.data;
//                 var chart = new CanvasJS.Chart("salesContainer", {
//                     title:{
//                         text: "Sales Of The Year"

//                     },
//                     axisX: {

//                         valueFormatString: "MMM",
//                         interval:1,
//                         intervalType: "month"
//                     },
//                     data: [

//                         {
//                             type: "line",
//                             dataPoints: result
//                         }
//                     ]
//                 });

//                 chart.render();
//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     });
// }
// $(document).ready(function() {
// //        x = new Date(2012, 10, 1);
// //        console.log(x);
//     GetOutstandingChart();
//     GetRequestChart();
//     GetExpenseChart();
//     getSales();
// });