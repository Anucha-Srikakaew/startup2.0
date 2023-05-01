const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var COUNTRY = urlParams.get('COUNTRY')
var FACTORY = urlParams.get('FACTORY')
var BIZ = urlParams.get('BIZ')
var PERIOD = urlParams.get('PERIOD')
var LINE, TYPE

if (COUNTRY == null || COUNTRY == 'null' || COUNTRY == '') {
    COUNTRY = STARTUP_EMP_COUNTRY
}

if (FACTORY == null || FACTORY == 'null' || FACTORY == '') {
    FACTORY = STARTUP_EMP_FACTORY
}

if (BIZ == null || BIZ == 'null' || BIZ == '') {
    BIZ = STARTUP_EMP_BIZ
}

if (PERIOD == null || PERIOD == 'null' || PERIOD == '') {
    PERIOD = 'DAY'
}

var TARGET1
    , TARGET2
    , TARGET3
    , START_TIME_SHIFT_DAY
    , START_TIME_SHIFT_NIGHT
    , TARGET_TIME_SHIFT_DAY
    , TARGET_TIME_SHIFT_NIGHT
    , SHIFT_DATE
    , SHIFT

$("#MainStartup").text('COUNTRY: ' + COUNTRY + ' /FACTORY: ' + FACTORY + ' /BIZ: ' + BIZ)
// $("#MainStartup").text('COUNTRY: ' + COUNTRY + ' /FACTORY: ' + FACTORY + ' /BIZ: ' + BIZ + ' /SHIFT DATE: 2023-01-04')


$('input[type=radio]').change(function () {
    $("#SubStartup").empty()

    $('#LINE').empty()
    $('#LINE').append(
        $('<option>', {
            selected: true,
            disabled: true,
            text: 'LINE'
        })
    );

    $('#TYPE').empty()
    $('#TYPE').append(
        $('<option>', {
            selected: true,
            disabled: true,
            text: 'TYPE'
        })
    );

    $('#MODEL').empty()
    $('#MODEL').append(
        $('<option>', {
            selected: true,
            disabled: true,
            text: 'MODEL'
        })
    );

    if (this.value == 'SHIFT') {
        $('#SHIFT').show()
    } else if (this.value == 'DAY') {
        $('#SHIFT').hide()
    } else if (this.value == 'WEEK') {
        $('#SHIFT').hide()
    }
    PERIOD = this.value
    lineName()
})

$('#btnradio2').change()

$('select').change(function () {
    if (this.id == 'LINE') {
        LINE = this.value
        typeName(this.value)
    } else if (this.id == 'TYPE') {
        TYPE = this.value
        modelName(LINE, TYPE)
    }
})

function lineName() {
    $.ajax({
        url: "php/ajax_startup_c_data.php",
        type: "POST",
        dataType: "json",
        data: {
            'SEARCH': 'LINE',
            'PERIOD': PERIOD,
            'COUNTRY': COUNTRY,
            'FACTORY': FACTORY,
            'BIZ': BIZ,
        },
        success: function (result) {
            $.each(result.data, function (key, value) {
                $('#LINE').append(
                    $('<option>', {
                        value: value.LINE,
                        text: value.LINE
                    })
                );
            })
        }
    })
}

function typeName(LINE) {
    $.ajax({
        url: "php/ajax_target.php",
        type: "POST",
        dataType: "json",
        data: {
            'COUNTRY': COUNTRY,
            'FACTORY': FACTORY,
            'BIZ': BIZ,
            'LINE': LINE
        },
        success: function (result) {
            SHIFT_DATE = result.SHIFT_DATE

            if (FACTORY == 'STTB') {
                var SHIFT_DATE_SHOW = new Date(SHIFT_DATE);
                SHIFT_DATE_SHOW.setDate(SHIFT_DATE_SHOW.getDate() - 1);
                SHIFT_DATE_SHOW = formatDate(SHIFT_DATE_SHOW)
                SHIFT_DATE = SHIFT_DATE_SHOW
            }

            var SHIFT_DATE_SHOW = SHIFT_DATE

            if (PERIOD == 'DAY') {
                var SHIFT_DATE_SHOW = new Date(SHIFT_DATE);
                SHIFT_DATE_SHOW.setDate(SHIFT_DATE_SHOW.getDate() + 1);
                SHIFT_DATE_SHOW = formatDate(SHIFT_DATE_SHOW)
            } else {
                var SHIFT_DATE_SHOW = SHIFT_DATE;
            }

            var today = new Date();
            if (today.getHours() >= 8 && today.getHours() <= 20) {
                SHIFT = 'DAY'
                SHIFT_SHOW = 'NIGHT'
            } else {
                SHIFT = 'NIGHT'
                SHIFT_SHOW = 'DAY'
            }

            currentDate = new Date(SHIFT_DATE);
            startDate = new Date(currentDate.getFullYear(), 0, 1);
            var days = Math.floor((currentDate - startDate) / (24 * 60 * 60 * 1000));
            var weekNumber = Math.ceil(days / 7);

            // Display the calculated result
            if (PERIOD == 'SHIFT') {
                $("#SubStartup").text(
                    '** STARTUP FOR SHIFT DATE: ' + SHIFT_DATE_SHOW +
                    ' / SHIFT: ' + SHIFT_SHOW + ' **'
                )
            } else if (PERIOD == 'DAY') {
                $("#SubStartup").text(
                    '** STARTUP FOR SHIFT DATE: ' + SHIFT_DATE_SHOW + ' **'
                )
            } else if (PERIOD == 'WEEK') {
                $("#SubStartup").text(
                    '** STARTUP FOR WEEK: ' + SHIFT_DATE.split('-')[0] + '-W' + weekNumber + ' **'
                )
            }

            WEEK = SHIFT_DATE.split('-')[0] + '-W' + weekNumber
        }
    })

    $.ajax({
        url: "php/ajax_startup_c_data.php",
        type: "POST",
        dataType: "json",
        data: {
            'SEARCH': 'TYPE',
            'PERIOD': PERIOD,
            'LINE': LINE,
            'COUNTRY': COUNTRY,
            'FACTORY': FACTORY,
            'BIZ': BIZ,
        },
        success: function (result) {
            // console.log(result)
            $('#TYPE').empty()
            $('#TYPE').append(
                $('<option>', {
                    selected: true,
                    disabled: true,
                    text: 'TYPE'
                })
            );

            $('#MODEL').empty()
            $('#MODEL').append(
                $('<option>', {
                    selected: true,
                    disabled: true,
                    text: 'MODEL'
                })
            );

            $.each(result.data, function (key, value) {
                $('#TYPE').append(
                    $('<option>', {
                        value: value.TYPE,
                        text: value.TYPE
                    })
                );
            })
        }
    })
}

function modelName(LINE, TYPE) {
    $.ajax({
        url: "php/ajax_startup_c_data.php",
        type: "POST",
        dataType: "json",
        data: {
            'SEARCH': 'MODEL',
            'PERIOD': PERIOD,
            'LINE': LINE,
            'TYPE': TYPE,
            'COUNTRY': COUNTRY,
            'FACTORY': FACTORY,
            'BIZ': BIZ,
        },
        success: function (result) {
            console.log(result)

            $('#MODEL').empty()
            $('#MODEL').append(
                $('<option>', {
                    selected: true,
                    disabled: true,
                    text: 'MODEL'
                })
            );

            $.each(result.data, function (key, value) {
                $('#MODEL').append(
                    $('<option>', {
                        value: value.MODEL,
                        text: value.MODEL
                    })
                );
            })
        }
    })
}

function noProduction() {
    if (LINE != '' && LINE != undefined) {
        $.ajax({
            url: "php/ajax_startup_c_no_pro.php",
            type: "POST",
            dataType: "json",
            data: {
                'PERIOD': PERIOD,
                'LINE': LINE,
                'COUNTRY': COUNTRY,
                'FACTORY': FACTORY,
                'BIZ': BIZ,
                'STARTUP_EMP_ID': STARTUP_EMP_ID,
                'SHIFT_DATE': SHIFT_DATE,
                'SHIFT': SHIFT
            },
            success: function (result) {
                console.log(result)
            }
        })
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please input line name.',
        }).then(function () {
            lineName()
        })
    }
}

function startupCheck() {
    console.log(STARTUP_EMP_ID)
    if (STARTUP_EMP_ID != '' && STARTUP_EMP_ID != undefined) {
        if (LINE != '' && LINE != undefined) {
            if (TYPE != '' && TYPE != undefined) {
                if ($('#MODEL').val() != '' && $('#MODEL').val() != undefined) {
                    $.ajax({
                        url: "php/ajax_startup_start.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'PERIOD': PERIOD,
                            'LINE': LINE,
                            'TYPE': TYPE,
                            'MODEL': $('#MODEL').val(),
                            'COUNTRY': COUNTRY,
                            'FACTORY': FACTORY,
                            'BIZ': BIZ,
                            'STARTUP_EMP_ID': STARTUP_EMP_ID,
                            'SHIFT_DATE': SHIFT_DATE,
                            'SHIFT': SHIFT,
                            'WEEK': WEEK,
                        },
                        success: function (result) {
                            console.log(result)
                            if (result.response == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucess...',
                                    text: 'Go to startup check.',
                                }).then(function () {
                                    START_DATE = result.data.START_DATE
                                    END_DATE = result.data.END_DATE
                                    SHIFT = result.data.SHIFT
                                    window.location.href = 'startup.html?' +
                                        'COUNTRY=' + COUNTRY +
                                        '&FACTORY=' + FACTORY +
                                        '&BIZ=' + BIZ +
                                        '&PERIOD=' + PERIOD +
                                        '&START_DATE=' + START_DATE +
                                        '&END_DATE=' + END_DATE +
                                        '&SHIFT=' + SHIFT +
                                        '&LINE=' + LINE +
                                        '&TYPE=' + TYPE +
                                        '&MODEL=' + $('#MODEL').val()
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'System error.',
                                })
                            }
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Oops...',
                        text: 'Please select model name.',
                    })
                }
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Please select type.',
                })
            }
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Please select line name.',
            })
        }
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please login.',
        }).then(function () {
            window.location.href = "login.html"
        })
    }
}