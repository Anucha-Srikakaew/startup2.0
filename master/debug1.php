<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <link rel="stylesheet" href="framework/vendor/bootstrap/css/w3.css">

    <link rel="stylesheet" href="framework/css/jquery-ui.css">
    <script src="framework/js/jquery-1.12.4.js"></script>
    <script src="framework/js/jquery-ui.js"></script>
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/angular.min.js"></script>
    <script src="framework/vendor/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="framework/css/style_startup_c.css">

    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");
    if (empty($_GET)) {
        header("Location: login.php");
    } else {
        $MEMBER_ID = $_GET['MEMBER_ID'];

        $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        if (empty($objResult)) {
            header("Location: login.php");
        } else {
            $MEMBER_ID = $objResult['MEMBER_ID'];
            $BIZ = $objResult['BIZ'];
            $TYPE = $objResult['TYPE'];
            if ($TYPE != "TECH") {
                header("Location: login.php");
            }
        }
    }

    $DATE = date("Y-m-d");
    $now = date("H");
    if ($now >= 8 && $now < 20) {
        $SHIFT = 'DAY';
    } else {
        $SHIFT = 'NIGHT';
        if ($now >= 0 && $now < 8) {
            $DATE = date("Y-m-d", strtotime("-1 days", strtotime($DATE)));
        } else if ($now >= 20 && $now <= 23) {
            $DATE = date("Y-m-d");
        }
    }

    if ($SHIFT == 'DAY') {
        $SHIFT = 'NIGHT';
    } else {
        $SHIFT = 'DAY';
    }

    ?>

    <script>
        $(document).ready(function() {
            $('#TYPE').append("<option selected disabled value=''>TYPE</option>");
            $('#MODEL').append("<option selected disabled value=''>MODEL</option>");

            var LINE;
            PERIOD = 'SHIFT';
            $.ajax({
                type: 'post', // the method (could be GET btw)
                url: 'model.php', // The file where my php code is
                data: {
                    'PERIOD': PERIOD
                },
                success: function(data) { // in case of success get the output, i named data
                    // console.log(data)
                    $('#LINE').empty();
                    $('#LINE').append('<option selected disabled value="">LINE</option>');
                    var LINE = JSON.parse(data);
                    $.each(LINE, function(index, value) {
                        // console.log('<option value="' + value + '">' + value + '</option>');
                        $('#LINE').append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            })

            $("select.TYPE").change(function() {
                var TYPE = $(this).children("option:selected").val();
                console.log($(this).val());
                $('#MODEL').append("");
                var BIZ = '<?php echo $BIZ; ?>';
                var LINE_CHECK = LINE;
                $('#MODEL').append('');
                console.log(LINE_CHECK)
                $.ajax({
                    type: 'POST',
                    url: 'model.php',
                    data: {
                        BIZ: BIZ,
                        LINE: LINE_CHECK,
                        TYPE: TYPE,
                        'PERIOD': PERIOD
                    },
                    success: function(data) {
                        var MODEL = JSON.parse(data);
                        $('#MODEL').append("<option selected disabled value=''>MODEL</option>");
                        $.each(MODEL, function(index, value) {
                            // console.log(value)
                            var ModelValue = value.replace(" ", "%%");
                            $('#MODEL').append("<option value='" + ModelValue + "'>" + value + "</option>");
                        });
                    }


                });
                $('#MODEL').empty();
            });
            $('select.LINE').change(function() {
                console.log(PERIOD)
                LINE = $(this).children("option:selected").val();
                $('#TYPE').empty();
                $('#TYPE').append("<option selected disabled value=''>TYPE</option>");

                $.ajax({
                    type: 'post', // the method (could be GET btw)
                    url: 'model.php', // The file where my php code is
                    data: {
                        'LINE': LINE, // all variables i want to pass. In this case, only one.
                        'PERIOD': PERIOD
                    },
                    success: function(data) { // in case of success get the output, i named data
                        console.log(data)
                        var MODEL = JSON.parse(data);
                        $.each(MODEL, function(index, value) {
                            // console.log('<option value="' + value + '">' + value + '</option>');
                            $('#TYPE').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                })
            });

            var shift = this.value;
            var text = document.getElementById("shift_date_show").value;
            var shift_date = new Date(text);
            date = toJSONLocal(shift_date);
            var time = new Date().toLocaleString('th-TH', {
                hour: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            })
            DATE = date;
            $("#SHIFT").change(function() {
                $("#shift_show").html(this.value);
                $("#shift_date_show").html(date);
                $("#shift_date_show").val(date);
                if (shift == 'DAY') {
                    shift_date.setDate(shift_date.getDate() - 1);
                    date = toJSONLocal(shift_date);
                    $("#shift_date").val(date);
                } else if (shift == 'NIGHT' && time >= 0 && time < 8) {
                    shift_date.setDate(shift_date.getDate() - 1);
                    date = toJSONLocal(shift_date);
                    $("#shift_date").val(date);
                } else {
                    $("#shift_date").val(date);
                }
            })

            $("#1").click(function() {
                PERIOD = this.value;
                $.ajax({
                    type: 'post', // the method (could be GET btw)
                    url: 'model.php', // The file where my php code is
                    data: {
                        'PERIOD': PERIOD
                    },
                    success: function(data) { // in case of success get the output, i named data
                        // console.log(data)
                        $('#LINE').empty();
                        $('#LINE').append('<option selected disabled value="">LINE</option>');
                        $('#TYPE').empty();
                        $('#TYPE').append('<option selected disabled value="">TYPE</option>');
                        $('#MODEL').empty();
                        $('#MODEL').append('<option selected disabled value="">MODEL</option>');
                        var LINE = JSON.parse(data);
                        $.each(LINE, function(index, value) {
                            // console.log('<option value="' + value + '">' + value + '</option>');
                            $('#LINE').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                })
                check();
            })

            $("#2").click(function() {
                PERIOD = this.value;
                console.log(PERIOD)
                $.ajax({
                    type: 'post', // the method (could be GET btw)
                    url: 'model.php', // The file where my php code is
                    data: {
                        'PERIOD': PERIOD
                    },
                    success: function(data) { // in case of success get the output, i named data
                        // console.log(data)
                        $('#LINE').empty();
                        $('#LINE').append('<option selected disabled value="">LINE</option>');
                        $('#TYPE').empty();
                        $('#TYPE').append('<option selected disabled value="">TYPE</option>');
                        $('#MODEL').empty();
                        $('#MODEL').append('<option selected disabled value="">MODEL</option>');
                        var LINE = JSON.parse(data);
                        $.each(LINE, function(index, value) {
                            // console.log('<option value="' + value + '">' + value + '</option>');
                            $('#LINE').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                })
                check()
            })

            $("#3").click(function() {
                PERIOD = this.value;
                console.log(PERIOD)
                $.ajax({
                    type: 'post', // the method (could be GET btw)
                    url: 'model.php', // The file where my php code is
                    data: {
                        'PERIOD': PERIOD
                    },
                    success: function(data) { // in case of success get the output, i named data
                        console.log(data)
                        $('#LINE').empty();
                        $('#LINE').append('<option selected disabled value="">LINE</option>');
                        $('#TYPE').empty();
                        $('#TYPE').append('<option selected disabled value="">TYPE</option>');
                        $('#MODEL').empty();
                        $('#MODEL').append('<option selected disabled value="">MODEL</option>');
                        var LINE = JSON.parse(data);
                        $.each(LINE, function(index, value) {
                            // console.log('<option value="' + value + '">' + value + '</option>');
                            $('#LINE').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                })
                check()
            })
        });

        function check() {
            if (PERIOD == 'SHIFT') {
                $("#SHIFT").show();
            } else {
                // console.log(DATE)
                // $("#PERIOD_DATE").val(DATE)
                $("#SHIFT").hide();
            }
        }

        function toJSONLocal(date) {
            var local = new Date(date);
            local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        }

        function urlencode(str) {
            str = (str + '').toString();
            return encodeURIComponent(str).replace(/%20/g, '+');
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.52/startup2.0/">HOME <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a id="nav-startup" class="nav-link" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ; ?>">STARTUP</a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0 ">
                <a id="back1" class="nav-link " style="color:white;" href="http://43.72.52.51/startup2.0/login.php">BACK</a>
            </div>
        </div>
    </nav>
    <!-- Main -->
    <section id="main">
        <form name="form" method="POST" action="debug2.php">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p>
                    <p class="lead">STARTUP FOR DATE : <input type="date" id="shift_date_show" name="shift_date_show" value="<?php echo $DATE ?>"></p>
                    <br><br>
                </div>
            </div>

            <script language="javascript">
                function fncSubmit() {
                    if (!$('#LINE').val()) {
                        alert('Please enter LINE');
                        return false;
                    }
                    if (!$('#TYPE').val()) {
                        alert('Please enter TYPE');
                        return false;
                    }
                    if (!$('#MODEL').val()) {
                        alert('Please enter MODEL');
                        return false;
                    } else {
                        document.form.submit();
                    }
                }

                function NoProduction() {
                    if (!$('#LINE').val()) {
                        alert('Please enter LINE');
                        return false;
                    }
                    // if (!$('#TYPE').val()) {
                    //     alert('Please enter TYPE');
                    //     return false;
                    // } 
                    else {
                        // console.log(PERIOD)
                        var LINE = $('#LINE').val();
                        var LINE_TYPE = $('#TYPE').val();

                        if (LINE_TYPE == null) {
                            LINE_TYPE = 'ALL TYPE';
                        }

                        var MEMBER_ID = '<?php echo $MEMBER_ID; ?>';
                        var SHIFT = $('#SHIFT').val();
                        var SHIFT_DATE = $('#shift_date_show').val();

                        $.ajax({
                            type: 'post', // the method (could be GET btw)
                            url: 'model.php', // The file where my php code is
                            data: {
                                'LINE_CENTER': LINE.trim()
                            },
                            success: function(data) { // in case of success get the output, i named data
                                console.log(data)
                                console.log(SHIFT)
                                if (data == 'CENTER' && !$('#MODEL').val()) {
                                    alert('This ' + LINE + 'is center please enter TYPE and MODEL');
                                    return false;
                                } else {
                                    var MODEL = $('#MODEL').val();
                                    if (MODEL == '' || MODEL == null) {
                                        MODEL = 'NO PRODUCTION';
                                    }
                                    window.location.href = "startup_record.php?SHIFT=" + SHIFT + "&SHIFT_DATE=" + SHIFT_DATE + "&MEMBER_ID=" + MEMBER_ID + "&LINE=" + LINE + "&LINE_TYPE=" + LINE_TYPE + "&MODEL=NO PRODUCTION&PERIOD=" + PERIOD + "&LINE_CENTER=" + data + "&MODEL=" + MODEL + "";
                                }
                            }
                        })
                    }
                }
            </script>

            <div class="row text-center">
                <div class="col-sm-4 mx-auto">

                    <div id="debt-amount-slider">
                        <input checked type="radio" name="PERIOD" id="1" value="SHIFT" required>
                        <label for="1" data-debt-amount="SHIFT"></label>
                        <input type="radio" name="PERIOD" id="2" value="DAY" required>
                        <label for="2" data-debt-amount="DAILY"></label>
                        <input type="radio" name="PERIOD" id="3" value="WEEK" required>
                        <label for="3" data-debt-amount="WEEKLY"></label>
                        <div id="debt-amount-pos"></div>
                    </div><br><br>

                    <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">

                    <select name="LINE" id="LINE" class="LINE text-center">
                        <option selected disabled>LINE</option>
                    </select>

                    <select name="TYPE" id="TYPE" class="TYPE text-center">
                        <option selected disabled>TYPE</option>
                    </select>

                    <select name="MODEL" id='MODEL' class="text-center"></select>

                    <?php
                    if ($now >= 8 and $now < 20) {
                        $night = 'selected';
                        $day = '';
                    } else if ($now >= 20 and $now <= 23) {
                        $day = 'selected';
                        $night = '';
                    } else {
                        $day = 'selected';
                        $night = '';
                    }
                    ?>
                    <select name="SHIFT" id='SHIFT' class="text-center">
                        <option value="DAY" <?php echo $day ?>>SHIFT DAY</option>
                        <option value="NIGHT" <?php echo $night ?>>SHIFT NIGHT</option>
                    </select>
                    <input type="hidden" id="shift_date" name="shift_date">
                    <!-- <input type="hidden" id="PERIOD_DATE" name="PERIOD_DATE"> -->
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div class="col-lg-12 mx-auto text-center">
                <input class="btn btn-dark" type="submit" id="submit" value="STARTUP" onclick="JavaScript:return fncSubmit();">
            </div>
        </form>


        <div class="col-lg-12 mx-auto text-center">
            <input class="btn" type="submit" id="submit" value="NO PRODUCTION" onclick="JavaScript:return NoProduction();">
        </div>

    </section>

</body>

</html>