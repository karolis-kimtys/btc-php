<!DOCTYPE html>

<html lang="en">

<head>
    <title>Bitcoin Data</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="./moment.min.js"></script>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


    <!-- Insert new row -->
    <script>
    $(document).ready(function() {

        $('#insert').on('click', function() {
            $("#spinner").addClass('visible').removeClass('hidden');
            $("#insert").attr("disabled", "disabled");
            var price = $('#price').val();
            var timestamp = $('#timestamp').val();
            var date = $('#date').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();
            var hour = $('#hour').val();
            var zerohour = $('#zerohour').val();
            if (price == "" || timestamp == "" || date == "" || year == "" || month == "" || day ==
                "" || hour == "" || zerohour == "") {
                alert('Please fill all of the fields!');
                return false;
            }

            $.ajax({
                url: "insert.php",
                type: "POST",
                data: {
                    price: price,
                    timestamp: timestamp,
                    date: date,
                    year: year,
                    month: month,
                    day: day,
                    hour: hour,
                    zerohour: zerohour
                },
                cache: false,
                async: true,
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.statusCode == 200) {
                        $("#insert").removeAttr("disabled");
                        // $('#form').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Data added successfully !');
                        $("#spinner").removeClass('visible').addClass('hidden');
                    } else if (data.statusCode == 201) {
                        alert("Error occured !");
                        $("#spinner").removeClass('visible').addClass('hidden');
                    }

                }
            });
        });
    });
    </script>

    <!-- Get data from MongoDB -->
    <script>
    // let selected_year;
    // let selected_month;
    // let selected_day;
    // let selected_hour;
    // let data;

    // $(document).ready(function() {
    //     $.ajax({
    //         type: "GET",
    //         url: "https://btc-server-app.herokuapp.com/allcharts",
    //         dataType: "json",
    //         data: data,
    //         success: function(data) {
    //             console.log("Data Saved: " + data);

    //         }
    //     });


    // })

    // $(document).ready(function() {
    //     $('.year').on('change', function() {
    //         console.log(this.value);
    //         selected_year = this.value;
    //     });
    // })

    // $(document).ready(function() {
    //     $('.month').on('change', function() {
    //         console.log(this.value);
    //         selected_month = this.value;
    //     });
    // })

    // $(document).ready(function() {
    //     $('.day').on('change', function() {
    //         console.log(this.value);
    //         selected_day = this.value;
    //     });
    // })

    // $(document).ready(function() {
    //     $('.hour').on('change', function() {
    //         console.log(this.value);
    //         selected_hour = this.value;
    //     });
    // })
    </script>


</head>

<body>


    <div class=" container">
        <?php echo '<h1>Bitcoin Data</h1>'; ?>

        <?php
        include 'database.php';

        require 'vendor/autoload.php';

        use Dotenv\Dotenv;

        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        echo '<p>Connected to MySQL successfully</p>';
        ?>

        <?php
        // Make "bitcoin" the current database
        $db_selected = mysqli_select_db($conn, 'bitcoin');
        if (!$db_selected) {
            die('Can\'t use foo : ' . mysqli_error($conn));
        }
        $result = $conn->query('SELECT DATABASE()');
        $row = $result->fetch_row();
        echo "<p>Database '{$row[0]}' selected</p>";
        ?>

        <?php
        $query = mysqli_query($conn, 'SHOW TABLES IN bitcoin');
        $numrows = mysqli_num_rows($query);

        while ($row = mysqli_fetch_array($query)) {
            echo "<p>Table '{$row[0]}'</p>";
        }

        $conn->close();
        ?>
    </div>




    <div class=" container">

        <h5>Insert row into the MySQL table</h5>

        <form action="index.php" method="post" class="inputs" id="form">
            <div class="input_rows">
                <label>Price</label>
                <input type="number" name="price" placeholder="2.99" id="price" value="10141.4" />
            </div>
            <div class=" input_rows">
                <label>Timestamp</label>
                <input type="text" name="timestamp" placeholder="10000000" id="timestamp" value="101010101010" />
            </div>
            <div class="input_rows">
                <label>Date</label>
                <input type="text" name="date" placeholder="2022-12-31 23:59:59" id="date"
                    value="2022-12-31 23:59:59" />
            </div>
            <div class="input_rows">
                <label>Year</label>
                <input type="text" name="year" placeholder="2022" id="year" value="2022" />
            </div>
            <div class="input_rows">
                <label>Month</label>
                <input type="text" name="month" placeholder="12" id="month" value="12" />
            </div>
            <div class="input_rows">
                <label>Day</label>
                <input type="text" name="day" placeholder="31" id="day" value="31" />
            </div>
            <div class="input_rows">
                <label>Hour</label>
                <input type="text" name="hour" placeholder="2359" id="hour" value="2359" />
            </div>
            <div class="input_rows">
                <label>Zero Hour</label>
                <input type="text" name="zerohour" placeholder="2300" id="zerohour" value="2300" />
            </div>
        </form>

        <p class="hidden" id="spinner">Loading...</p>

        <button class="button" id="insert">INSERT ROW</button>

    </div>


    <div class=" container">

        <h5>BTC 10 second charts</h5>


        <!-- <?php
        $api_url = 'https://btc-server-app.herokuapp.com/allcharts';
        $json_data = file_get_contents($api_url);
        $response_data = json_decode($json_data);
        $charts = $response_data;

        $split_data = $response_data;
        $year = [];
        $month = [];
        $day = [];
        $hour = [];

        foreach ($split_data ?? [] as $data) {
            $times = explode(' ', $data->date);
            $dates = explode('-', $times[0]);

            if (in_array($dates[0], $year)) {
                continue;
            } else {
                $year[] = $dates[0];
            }

            if (in_array($dates[1], $month)) {
                continue;
            } else {
                $month[] = $dates[1];
            }

            if (in_array($dates[2], $day)) {
                continue;
            } else {
                $day[] = $dates[2];
            }

            if (in_array($times[1], $hour)) {
                continue;
            } else {
                $hour[] = $times[1];
            }
        }
        ?> -->

        <!-- https://btc-server-app.herokuapp.com/getall/years -->

        <div class="select_chart">

            <div class="container_row"> <select id="year" class='year'>
                    <option value="">Year</option>
                </select>

                <select id="month" class="month">
                    <option value="">Month</option>
                </select>

                <select id="day" class="day">
                    <option value="">Day</option>
                </select>

                <select id="hour" class="hour">
                    <option value="">Hour</option>
                </select>
            </div>


            <div class="container_row">
                <button class="button" id="fetch">Fetch data</button>
                <button class="button" id="download" class="download">Download chart</button>

            </div>


            <div>
                <canvas id="myChart"></canvas>
            </div>






            <table class="table">

                <tr>
                    <th>Price (USD)</th>
                    <th>Date</th>
                </tr>

                <tbody class="table_body">

                </tbody>


            </table>

        </div>


        <div class="charts">

            <script>
            var selected_year = '';
            var selected_month = '';
            var selected_day = '';
            var selected_hour = '';

            var prices = []
            var dates = [];

            const data = {

                labels: dates,
                datasets: [{
                    label: 'Bitcoin Price',
                    backgroundColor: 'rgb(15, 99, 132)',
                    borderColor: 'rgb(25, 99, 132)',
                    data: prices,
                    pointRadius: 1,
                    borderWidth: 1
                }]
            };


            const config = {

                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            display: false
                        }
                    }
                }
            };




            const myChart = new Chart(
                document.getElementById('myChart'),
                config,

            );


            $('#fetch').on('click', function fetch() {

                prices.length = 0;
                dates.length = 0;


                $(".table_body").empty();


                var year = selected_year;
                var month = selected_month;
                var day = selected_day;
                var hour = selected_hour;

                if (year == "" && month == "" && day == "" && hour == "") {
                    alert('Please select dates!');
                    return false;
                }

                var response = ''
                $.ajax({
                    // url: `https://btc-server-app.herokuapp.com/getby/${selected_year}`,

                    // url: `https://btc-server-app.herokuapp.com/getby/${selected_year}${selected_month && "/" + selected_month}`,


                    // url: `https://btc-server-app.herokuapp.com/getby/${selected_year}${selected_month && "/" + selected_month}${selected_day && "/" + selected_day}`,

                    url: `https://btc-server-app.herokuapp.com/getby/${selected_year}${selected_month && "/" + selected_month}${selected_day && "/" + selected_day}${selected_hour && "/" + selected_hour}`,
                    type: "GET",
                    cache: false,
                    async: true,

                    success: function(data) {
                        $.each(data, function(i) {
                            prices.push(data[i].price);
                            dates.push(moment(data[i].date).format(
                                'YYYY-MM-DD h:mm:ss'));

                            $('.table_body').append(
                                "<tr>" +
                                "<td>" + data[i].price + "</td>" +
                                "<td>" + moment(data[i].date).format(
                                    'YYYY-MM-DD h:mm:ss') + "</td>" +
                                "</tr>"
                            );

                        });

                        myChart.update();

                    },

                })
            });


            $('#download').on('click', function() {
                var image = myChart.toBase64Image('image/jpeg', 1);
                var a = document.createElement('a');
                a.href = image;
                a.download = 'chart.png';
                a.click();



            });








            $.ajax({
                url: "https://btc-server-app.herokuapp.com/getall/years",
                type: 'GET',
                success: function(data) {
                    $.each(data, function(i) {
                        $('.year').append("<option value=" + data[i].year + ">" + data[i].year +
                            "</option>");
                    });

                }
            });

            $('.month').attr("hidden", true);
            $('.day').attr("hidden", true);
            $('.hour').attr("hidden", true);


            $('.year').on('change', function() {

                if ($('.year').val() === "") {
                    $('.month').attr("hidden", true);
                    $('.download').attr("hidden", true);
                } else {
                    $('.month').attr("hidden", false);
                    $('.download').attr("hidden", false);
                    selected_year = this.value;
                    $.ajax({
                        url: `https://btc-server-app.herokuapp.com/getall/${this.value}/months`,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(i) {
                                $('.month').append("<option value=" + data[i].month +
                                    ">" +
                                    data[
                                        i].month +
                                    "</option>");
                            });
                        }
                    });
                }
            });

            $('.month').on('change', function() {

                if ($('.month').val() === "") {
                    $('.day').attr("hidden", true);
                } else {
                    $('.day').attr("hidden", false);
                    selected_month = this.value;
                    $.ajax({
                        url: `https://btc-server-app.herokuapp.com/getall/${selected_year}/${this.value}/days`,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(i) {
                                $('.day').append("<option value=" + data[i].day + ">" +
                                    data[
                                        i].day +
                                    "</option>");
                            });
                        }
                    });
                }
            });


            $('.day').on('change', function() {

                if ($('.day').val() === "") {
                    $('.hour').attr("hidden", true);
                } else {
                    $('.hour').attr("hidden", false);
                    selected_day = this.value;
                    $.ajax({
                        url: `https://btc-server-app.herokuapp.com/getall/${selected_year}/${selected_month}/${this.value}/hours`,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(i) {
                                $('.hour').append("<option value=" + data[i].hour +
                                    ">" +
                                    data[
                                        i].hour +
                                    "</option>");
                            });
                        }
                    });
                }
            });

            $('.hour').on('change', function() {
                selected_hour = this.value;

            });
            </script>



            <!-- <?php foreach ($charts ?? [] as $chart) {
                // $get_year = explode('-', $chart->date);
                // $get_year = $get_year[0];
                // print_r($get_year[0]);

                echo "<div class='chart'><img src='{$chart->image->data}' alt='chart' ><p>'{$chart->date}'</p></img></div>";
            } ?> -->
        </div>


    </div>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>


</body>

</html>