<!DOCTYPE html>

<html lang="en">

<head>
    <title>Bitcoin Data</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

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
                url: "save.php",
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



    <!-- 
    <div class=" container">

        <h5>Insert row into the MySQL table</h5>

        <form action="index.php" method="post" class="inputs" id="form">
            <div class="input_rows">
                <label>Price</label>
                <input type="number" name="price" placeholder="2.99" id="price" />
            </div>
            <div class="input_rows">
                <label>Timestamp</label>
                <input type="text" name="timestamp" placeholder="10000000" id="timestamp" />
            </div>
            <div class="input_rows">
                <label>Date</label>
                <input type="text" name="date" placeholder="2022-12-31 23:59:59" id="date" />
            </div>
            <div class="input_rows">
                <label>Year</label>
                <input type="text" name="year" placeholder="2022" id="year" />
            </div>
            <div class="input_rows">
                <label>Month</label>
                <input type="text" name="month" placeholder="12" id="month" />
            </div>
            <div class="input_rows">
                <label>Day</label>
                <input type="text" name="day" placeholder="31" id="day" />
            </div>
            <div class="input_rows">
                <label>Hour</label>
                <input type="text" name="hour" placeholder="2359" id="hour" />
            </div>
            <div class="input_rows">
                <label>Zero Hour</label>
                <input type="text" name="zerohour" placeholder="2300" id="zerohour" />
            </div>
        </form>

        <p class="hidden" id="spinner">Loading...</p>

        <button class="button" id="insert">INSERT ROW</button>

    </div> -->


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
            <select id="year" class='year'>
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


        <div class="charts">

            <script>
            $.ajax({
                url: "https://btc-server-app.herokuapp.com/getall/years",
                type: 'GET',
                success: function(data) {
                    console.log("Fetch years", data)
                    $.each(data, function(i) {
                        $('#year').append("<option value=" + data[i].year + ">" + data[i].year +
                            "</option>");
                    });

                }
            });


            $('.year').on('change', function() {

                selected_year = this.value;

                $.ajax({
                    url: `https://btc-server-app.herokuapp.com/getall/${this.value}/months`,
                    type: 'GET',
                    success: function(data) {
                        console.log("Fetch months", selected_year)
                        var year = data;
                        $.each(year, function(i) {
                            $('#year').append("<option value=" + year[i].year + ">" + year[
                                    i].year +
                                "</option>");
                        });

                    }
                });
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

    <!-- 

    <div class=" container">

        <h5>Table data</h5>

        <table>

            <tr>
                <th>ID</th>
                <th>Price (USD)</th>
                <th>Date</th>
            </tr>

            <tr>
                <?php
                include 'database.php';
                /* get first n rows*/
                $n = 100;

                $sql = "SELECT * FROM data LIMIT $n";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                        <td>' .
                            $row['id'] .
                            '</td>
                        <td>' .
                            $row['price'] .
                            '</td>
                        <td>' .
                            $row['date'] .
                            '</td>
                        </tr>';
                    }
                } else {
                    echo '0 results';
                }

// $conn->close();
?>
            </tr>

        </table>
    </div> -->










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>


</body>

</html>