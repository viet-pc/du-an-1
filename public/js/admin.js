$(document).ready(function () {
    const data = [];
    let table_product = $('.table_product')
    let chart_product = $('#product')
    table_product.hide();

    function Ajax(handleData) {
        $.ajax({
            async: true,
            url: './analytics/products',
            type: 'GET',
            dataType: "json",
            success: function (result) {
                handleData(result)
            }
        })
    }

    Ajax(function (output) {
        output.forEach((element, index) => {
            data[index] = [element.CategoryName, element.quantity];
        });
        drawChart(data)
        // insertTable(output)
    });
    let product_bottom_table = $('.product-bottom-table');
    click(product_bottom_table,chart_product,table_product);
    // let check = true;
    // product_bottom_table.click(() => {
    //     if (check) {
    //         product_bottom_table.text('Xem biểu đồ');
    //         chart_product.hide();
    //         table_product.show();
    //     } else {
    //         product_bottom_table.text('Xem bảng dữ liệu');
    //         chart_product.show();
    //         table_product.hide();
    //     }
    //     check = !check;
    // })

    function insertTable(data) {
        let html;
        data.forEach((item, index) => {
            html += `<tr>
                 <td>${index}</td>
                 <td>${item.CategoryName}</td>
                 <td>${item.quantity}</td>
                 <td>${item.maxPrice}</td>
                 <td>${item.avgPrice}</td>
                 <td>${item.minPrice}</td>
            </tr>`;
        })
        html = ` <table
                            id="table"
                            class="table table-striped table-bordered first"
                        >
                            <thead style="background-color: var(--cyan)">
                            <tr>
                                <th>#</th>
                                <th>Danh mục</th>
                                <th>Số lượng</th>
                                <th>Giá cao nhất</th>
                                <th>Giá trung bình</th>
                                <th>Giá thấp nhất</th>
                            </tr>
                            </thead>
                            <tbody >` + html + ` </tbody>
                        </table>
`
        // table_product.html(html)
    }

    function drawChart(data) {
        var chart = c3.generate({
            bindto: "#product",
            color: {pattern: ["#5969ff", "#ff407b", "#25d5f2", "#ffc750"]},
            data: {
                // iris data from R
                columns: data,
                type: "pie",
            },
        });

        setTimeout(function () {
            chart.load({});
        }, 1500);

        setTimeout(function () {
            chart.unload({
                ids: "data1",
            });
            chart.unload({
                ids: "data2",
            });
        }, 2500);
    }

    function drawChartTotalMoney(label, data) {
        // console.log({label, data})
        let total_money_chart_div = $('#total-money-chart-div')
        total_money_chart_div.empty();
        let canvas = `<canvas id="total-money-chart"></canvas>`;
        total_money_chart_div.html(canvas);
        let ctx = document.getElementById("total-money-chart").getContext("2d");
        let myChart = new Chart(ctx, {
            type: "line",

            data: {
                labels: label,
                datasets: [
                    {
                        label: "Tổng tiền",
                        data: data,
                        backgroundColor: "rgba(89, 105, 255,.8)",
                        borderColor: "rgba(89, 105, 255,1)",
                        borderWidth: 2,
                    },
                    // ,
                    // {
                    //   label: "Aged Receiables",
                    //   data: [1000, 1500, 2500, 3500, 2500],
                    //   backgroundColor: "rgba(255, 64, 123,.8)",
                    //   borderColor: "rgba(255, 64, 123,1)",
                    //   borderWidth: 2,
                    // },
                ],
            },
            options: {
                legend: {
                    display: true,

                    position: "bottom",

                    labels: {
                        fontColor: "#71748d",
                        fontFamily: "Circular Std Book",
                        fontSize: 14,
                    },
                },

                scales: {
                    xAxes: [
                        {
                            ticks: {
                                fontSize: 14,
                                fontFamily: "Circular Std Book",
                                fontColor: "#71748d",
                            },
                        },
                    ],
                    yAxes: [
                        {
                            ticks: {
                                fontSize: 14,
                                fontFamily: "Circular Std Book",
                                fontColor: "#71748d",
                            },
                        },
                    ],
                },
            },
        });
    }

    Date.prototype.getWeekNumber = function () {
        var d = new Date(
            Date.UTC(this.getFullYear(), this.getMonth(), this.getDate())
        );
        var dayNum = d.getUTCDay() || 7;
        d.setUTCDate(d.getUTCDate() + 4 - dayNum);
        var yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        return Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
    };
    $(function () {

        let daysAgo = moment().startOf('hour').add(-30, 'day');
        let now = moment().startOf('hour');
        let type = 'day';
        now = now.format("YYYY-MM-DD")
        daysAgo = daysAgo.format("YYYY-MM-DD")
        // console.log(now);
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour').add(-30, 'day'),
            endDate: moment().startOf('hour'),
            maxDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            type = $('#type-chart').val();console.log(start)
            handleAjaxTotalMoney(moment(end,'YYYY-MM-DD').format('YYYY-MM-DD') ,moment(start,'YYYY-MM-DD').format('YYYY-MM-DD'), type);
            // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
        let inputDate = $('input[name="datetimes"]').data('daterangepicker')
        $('#type-chart').change(function (e) {
            let start = moment(inputDate.startDate,'YYYY-MM-DD').format('YYYY-MM-DD')
            let end = moment(inputDate.endDate,'YYYY-MM-DD').format('YYYY-MM-DD')
            let type = $('#type-chart').val();
            handleAjaxTotalMoney(end, start, type);
        })


        // console.log(daysAgo.format("YYYY/MM/DD"))

        // console.log(now)
        function AjaxTotalMoney(handleData, daysAgo, now) {
            $.ajax({
                async: true,
                url: './analytics/totalMoney/' + now + '/' + daysAgo,
                type: 'GET',
                dataType: "json",
                success: function (result) {
                    handleData(result)
                }
            })
        }

        let handleAjaxTotalMoney = (now, daysAgo, type) => {
            AjaxTotalMoney(function (output) {
                // console.log(output)
                let data = {labels: [], data: []};
                const labels = [];

                let duration = moment.duration(moment(now,"YYYY-MM-DD").diff(daysAgo));
                let days = Math.abs(duration.asDays());
                // console.log(days)

                // console.log(moment(now, 'YYYY/MM/DD').format("W"))
                // console.log(type)
                for (let i = days; i >= 0; i--) {

                    let day = moment(now,"YYYY-MM-DD").subtract(i, 'days');
                    let number = Math.abs(i - days);
                    let check = true;
                    let dayTrue;

                    for (let j = 0; j < output.length; j++) {
                        if (output[j].ShipDate.indexOf(day.format('-MM-DD')) !== -1) {
                            check = false;
                            dayTrue = output[j];
                            break;
                        } else {
                            check = true;
                        }
                        // console.log([output[0].ShipDate,day.format('-MM-DD')])
                    }
                    if (type === 'day') {
                        data.labels[number] = day.format('DD/MM/YYYY');
                    } else if (type === 'week') {
                        data.labels[number] = moment(day, 'YYYY/MM/DD').format("W")
                        console.log(moment(day, 'YYYY/MM/DD').format("W"))
                    } else {
                        data.labels[number] = moment(day, 'YYYY/MM/DD').format("M")
                    }

                    if (check) {
                        data.data[number] = 0;
                    } else {
                        data.data[number] = dayTrue.total;
                    }

                }
                // console.log(data);
                if (type === 'week' || type === 'month') {
                    let newLabel;
                    let newData = [];
                    let totalMoney = 0;
                    newLabel = data.labels.filter(function (item, pos) {
                        return data.labels.indexOf(item) === pos;
                    })
                    // console.log(newLabel)
                    for (let i = 0; i < data.labels.length; i++) {
                        if (data.labels[i] === data.labels[i + 1]) {
                            totalMoney += data.data[i] + data.data[i + 1];
                        } else {
                            newData.push(totalMoney);
                            totalMoney = 0;
                        }
                    }
                    data.labels = newLabel;
                    data.data = newData;
                }
                drawChartTotalMoney(data.labels, data.data);
            }, now, daysAgo)
        };
        // console.log(data)
        handleAjaxTotalMoney(now,daysAgo, type);
    });
    $(function () {
        function Ajax(handleData) {
            $.ajax({
                async: true,
                url: './analytics/inventory',
                type: 'GET',
                dataType: "json",
                success: function (result) {
                    handleData(result)
                }
            })
        }

        Ajax(function (output) {
            let data = {labels : [],sold: [], stock: []}

            output['1'].forEach(function (item1,index){
                data.labels[index] = item1.CategoryName;
                data.stock[index] = item1.Quantity;
                for(let i = 0; i < output['0'].length; i++){
                    if (item1.CategoryName === output['0'][i].CategoryName){
                        data.sold[index] = output['0'][i].Quantity

                        break;
                    }else {
                        data.sold[index] = 0;
                    }
                }
            })
            insertChartSold(data.labels,data.sold,data.stock)
            // drawChart(data)
            // insertTable(output)
        });
        function insertChartSold(labels,sold,stock) {
            let ctx = document.getElementById("ct-chart-inventory").getContext("2d");
            let myChart = new Chart(ctx, {
                type: "bar",

                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Đã bán',
                        data: sold,
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(191,3,47)',
                        pointBackgroundColor: 'rgb(255, 99, 132)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(255, 99, 132)',
                    }, {
                        label: 'Tồn kho',
                        data: stock,
                        fill: true,
                        backgroundColor: 'rgba(13,125,205,0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        pointBackgroundColor: 'rgb(54, 162, 235)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(54, 162, 235)'
                    }]
                }
            });
        }
        function AjaxVariantSoldStock(handleData) {
            $.ajax({
                async: true,
                url: './analytics/variantSoldStock',
                type: 'GET',
                dataType: "json",
                success: function (result) {
                    handleData(result)
                }
            })
        }

        AjaxVariantSoldStock(function (output) {
            // console.log(output);
            let data = {labels : [],sold: [], stock: []}

            output['1'].forEach(function (item1,index){
                data.labels[index] = item1.VariantName;
                data.stock[index] = item1.Quantity;
                for(let i = 0; i < output['0'].length; i++){
                    if (item1.VariantName === output['0'][i].VariantName){
                        data.sold[index] = output['0'][i].Quantity
                        break;
                    }else {
                        data.sold[index] = 0;
                    }
                }
            })

            // insertTableSold(data.labels,data.sold,data.stock)
            // drawChart(data)
            // insertTable(output)
        });
        function insertTableSold(labels,sold,stock) {
            let html;
            labels.forEach((item, index) => {
                html += `<tr>
                 <td>${index}</td>
                 <td>${item}</td>
                 <td>${stock[index]}</td>
                 <td>${sold[index]}</td>

            </tr>`;
            })
            html = `<div class="table-responsive"> <table
                            id="test-table"
                            class="table table-striped table-bordered first"
                        >
                            <thead style="background-color: var(--cyan)">
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Tồn kho</th>
                                <th>Đã bán</th>
                            </tr>
                            </thead>
                            <tbody >` + html + ` </tbody>
                        </table></div>
`

        }
        let chartSold = $('#ct-chart-inventory');
        let  TableSold = $('.table_product_variant');
        TableSold.hide();
        let inventory_bottom_table = $('.inventory-bottom-table');
        click(inventory_bottom_table,chartSold,TableSold);
    })
    function click(product_bottom_table,chart_product,table_product) {
        let check = true;
        product_bottom_table.click(() => {
            if (check) {
                product_bottom_table.text('Xem biểu đồ');
                chart_product.hide();
                table_product.show();
            } else {
                product_bottom_table.text('Xem bảng dữ liệu');
                chart_product.show();
                table_product.hide();
            }
            check = !check;
        })
    }
});

