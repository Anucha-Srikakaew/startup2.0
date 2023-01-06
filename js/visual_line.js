var table = $('#example').DataTable({
    // paging: false,
    searching: false,
    "footerCallback": function (row, data, start, end, display) {
        var api = this.api(), data;
        // converting to interger to find total
        var intVal = function (i) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '') * 1 :
                typeof i === 'number' ?
                    i : 0;
        };

        var passTotal = api
            .column(2)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var failTotal = api
            .column(3)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var blankTotal = api
            .column(4)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalTotal = api
            .column(5)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // // Update footer by showing the total with the reference of the column index 
        $(api.column(0).footer()).html('TOTAL');
        $(api.column(1).footer()).html('--');
        $(api.column(2).footer()).html(passTotal);
        $(api.column(3).footer()).html(failTotal);
        $(api.column(4).footer()).html(blankTotal);
        $(api.column(5).footer()).html(totalTotal);
        $(api.column(6).footer()).html('--');
    },
});
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var COUNTRY = urlParams.get('COUNTRY')
var FACTORY = urlParams.get('FACTORY')
var BIZ = urlParams.get('BIZ')
var CENTER = urlParams.get('CENTER')
var LINE = urlParams.get('LINE')
var START_DATE = urlParams.get('START_DATE')
var END_DATE = urlParams.get('END_DATE')
var SHIFT = urlParams.get('SHIFT')
var PERIOD = urlParams.get('PERIOD')
var dataFunc = urlParams.get('dataFunc')
var TYPE = urlParams.get('TYPE')
var MODEL = urlParams.get('MODEL')
if (FACTORY == 'STTC') {
    var URLIMG = 'http://43.72.52.159/ATTENd/IMG_opt/';
} else {
    var URLIMG = 'http://43.72.228.147/attend/img_opt/';
}
var dataSearch = {
    COUNTRY: COUNTRY,
    FACTORY: FACTORY,
    BIZ: BIZ,
    CENTER: CENTER,
    LINE: LINE,
    START_DATE: START_DATE,
    END_DATE: END_DATE,
    SHIFT: SHIFT,
    PERIOD: PERIOD
},
    STATUS_CONFIRM = []

$('#txtMain').text('COUNTRY : ' + COUNTRY + ' / FACTORY : ' + FACTORY + ' / BIZ : ' + BIZ + '')

$("#btnBACK").click(function () {
    loadDatatableDefault()
})

$("#btnBACK, #btnCONFRIM, #btnDISPOSE, #btnPrint").hide()

if (dataFunc == 'loadDatatable' && TYPE != '' && MODEL != '' && TYPE != null && MODEL != null) {
    loadDatatable(TYPE, MODEL)
} else {
    loadDatatableDefault()
}

function loadDatatableDefault() {
    dataFunc = 'loadDatatableDefault'
    $("#TECHNICIAN, #MFE, #PRODUCTION").slideUp("slow")
    $("#TECHNICIAN, #MFE, #PRODUCTION").empty()
    $("#btnBACK, #btnCONFRIM, #btnDISPOSE, #btnPrint").hide('slow')
    $(table.column(6).header()).text('STATUS')
    $.ajax({
        url: "php/ajax_query_visual_line_people_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (obj) {
            showDataMemberTxT(obj)

            $.ajax({
                url: "php/ajax_query_visual_line_table_default.php",
                type: "POST",
                dataType: "json",
                data: dataSearch,
                success: function (obj) {
                    var TYPE = '', MODEL = '', strClass
                    table.clear().draw();
                    table.column(1).visible(true);
                    $(table.column(0).header()).text('TYPE');
                    $.each(obj, function (key, value) {
                        var row = '';
                        var TYPE = value.TYPE
                        var MODEL = value.MODEL
                        var PASS = +value.PASS
                        var FAIL = +value.FAIL
                        var BLANK = +value.BLANK
                        var TOTAL = +value.TOTAL
                        var MODEL = value.MODEL
                        var STATUS = '';
                        if (FAIL > 0) {
                            STATUS = 'FAIL'
                            strClass = 'text-center table-danger'
                        } else {
                            if (BLANK > 0) {
                                STATUS = 'BLANK'
                                strClass = 'text-center table-warning'
                            } else {
                                STATUS = 'PASS'
                                strClass = 'text-center table-success'
                            }
                        }
                        var row = [
                            '<a href="#" onclick="loadDatatable(this.name, this.id)" name="' + TYPE + '" id="' + MODEL + '"><h5><b class="text-primary">' + TYPE + '</b></h5></a>',
                            MODEL,
                            PASS,
                            FAIL,
                            BLANK,
                            TOTAL,
                            STATUS_CONFIRM[TYPE],
                        ];
                        table.row.add(row).draw().nodes().to$().addClass(strClass);
                    })
                    window.history.pushState(
                        "object or string",
                        "Title",
                        "visual_line.html?" +
                        "COUNTRY=" + COUNTRY +
                        "&FACTORY=" + FACTORY +
                        "&BIZ=" + BIZ +
                        "&CENTER=" + CENTER +
                        "&LINE=" + LINE +
                        "&START_DATE=" + START_DATE +
                        "&END_DATE=" + END_DATE +
                        "&SHIFT=" + SHIFT +
                        "&PERIOD=" + PERIOD +
                        "&TYPE=" + TYPE +
                        "&MODEL=" + MODEL +
                        "&dataFunc=" + dataFunc
                    );
                }
            })
        }
    })
}

function loadDatatable(type, model) {
    dataFunc = 'loadDatatable'
    $("#TECHNICIAN, #MFE, #PRODUCTION").slideUp("slow");
    $("#TECHNICIAN, #MFE, #PRODUCTION").empty()
    $("#btnBACK, #btnCONFRIM, #btnDISPOSE, #btnPrint").hide('slow')
    $.ajax({
        url: "php/ajax_query_visual_line_people_process.php",
        type: "POST",
        dataType: "json",
        data: {
            MAIN: dataSearch,
            TYPE: type,
            MODEL: model
        },
        success: function (obj) {
            showDataMemberTxT(obj)

            var STATUS_CONFIRM_BTN = true
            $.ajax({
                url: "php/ajax_query_visual_line_table_process.php",
                type: "POST",
                dataType: "json",
                data: {
                    MAIN: dataSearch,
                    TYPE: type,
                    MODEL: model
                },
                success: function (obj) {
                    var strClass
                    table.clear().draw()
                    $(table.column(0).header()).text('PROCESS')
                    $(table.column(6).header()).text('PROCESS')
                    table.column(1).visible(false)
                    $.each(obj, function (key, value) {

                        var row = '';
                        var PROCESS = value.PROCESS
                        var MODEL = value.MODEL
                        var PASS = +value.PASS
                        var FAIL = +value.FAIL
                        var BLANK = +value.BLANK
                        var TOTAL = +value.TOTAL
                        var MODEL = value.MODEL
                        var STATUS = '';

                        if (FAIL > 0) {
                            STATUS = 'FAIL'
                            strClass = 'text-center table-danger'
                            STATUS_CONFIRM_BTN = false
                        } else {
                            if (BLANK > 0) {
                                STATUS_CONFIRM_BTN = false
                                STATUS = 'BLANK'
                                strClass = 'text-center table-warning'
                            } else {
                                STATUS = 'PASS'
                                strClass = 'text-center table-success'
                            }
                        }

                        var row = [
                            '<a href="visual_item.html?' +
                            'COUNTRY=' + COUNTRY +
                            '&FACTORY=' + FACTORY +
                            '&BIZ=' + BIZ +
                            '&CENTER=' + CENTER +
                            '&LINE=' + LINE +
                            '&START_DATE=' + START_DATE +
                            '&END_DATE=' + END_DATE +
                            '&SHIFT=' + SHIFT +
                            '&PERIOD=' + PERIOD +
                            '&TYPE=' + type +
                            '&MODEL=' + model +
                            '&PROCESS=' + PROCESS +
                            '&dataFunc=' + dataFunc + '"><h5 class="text-primary">' + PROCESS + '</h5></a>',
                            MODEL,
                            PASS,
                            FAIL,
                            BLANK,
                            TOTAL,
                            STATUS,
                        ]

                        table.row.add(row).draw().nodes().to$().addClass(strClass)
                    })

                    if (STATUS_CONFIRM_BTN == false) {
                        $("#btnCONFRIM").hide()
                    } else {
                        $("#btnCONFRIM").show()
                    }
                }
            })
        }
    })

    window.history.pushState(
        "object or string",
        "Title",
        "visual_line.html?" +
        "COUNTRY=" + COUNTRY +
        "&FACTORY=" + FACTORY +
        "&BIZ=" + BIZ +
        "&CENTER=" + CENTER +
        "&LINE=" + LINE +
        "&START_DATE=" + START_DATE +
        "&END_DATE=" + END_DATE +
        "&SHIFT=" + SHIFT +
        "&PERIOD=" + PERIOD +
        "&TYPE=" + type +
        "&MODEL=" + model +
        "&dataFunc=" + dataFunc
    );
}
function showDataMemberTxT(obj) {

    var TECHNICIAN = '',
        MFE = '',
        PRODUCTION = '',
        strModel = '',
        strType = '',
        top = 0,
        right = 109,
        strClass,
        STATUS
    $.each(obj, function (key, value) {
        if (strModel.search(value.MODEL) == -1) {
            if (key == 0) {
                strModel += value.MODEL
            } else {
                strModel += ', ' + value.MODEL
            }
        }
        if (strType.search(value.TYPE) == -1) {
            if (key == 0) {
                strType += value.TYPE
            } else {
                strType += ', ' + value.TYPE
            }
        }
        CONFIRM1_URL = 'framework/img/avatar.png'
        CONFIRM2_URL = 'framework/img/avatar.png'
        CONFIRM3_URL = 'framework/img/avatar.png'
        STATUS_CONFIRM[value.TYPE] = 'TECHNICIAN'
        if (value.CONFIRM1 != null && value.CONFIRM1 != '') {
            CONFIRM1_URL = URLIMG + value.CONFIRM1 + '.JPG'
            STATUS = 'CONFIRM1'
            if (dataFunc != 'loadDatatable') {
                STATUS_CONFIRM[value.TYPE] = 'SUPERVISOR'
            }
        }
        if (value.CONFIRM2 != null && value.CONFIRM2 != '') {
            CONFIRM2_URL = URLIMG + value.CONFIRM2 + '.JPG'
            STATUS = 'CONFIRM2'
            if (dataFunc != 'loadDatatable') {
                STATUS_CONFIRM[value.TYPE] = 'PRODUCTION'
            }
        }
        if (value.CONFIRM3 != null && value.CONFIRM3 != '') {
            CONFIRM3_URL = URLIMG + value.CONFIRM3 + '.JPG'
            STATUS = 'CONFIRM3'
            if (dataFunc != 'loadDatatable') {
                STATUS_CONFIRM[value.TYPE] = 'COMPLETE'
            }
        }

        var name1 = '<br>',
            tabk1 = '<br>',
            datetime1 = '<br>'
        if (value.NAME_CONFIRM1 != null && value.NAME_CONFIRM1 != '') {
            name1 = value.NAME_CONFIRM1
            tabk1 = value.TAKT1 + ' MIN.'
            datetime1 = value.DATETIME1
        }

        var name2 = '<br>',
            tabk2 = '<br>',
            datetime2 = '<br>'
        if (value.NAME_CONFIRM2 != null && value.NAME_CONFIRM2 != '') {
            name2 = value.NAME_CONFIRM2
            tabk2 = value.TAKT2 + ' MIN.'
            datetime2 = value.DATETIME2
        }

        var name3 = '<br>',
            tabk3 = '<br>',
            datetime3 = '<br>'
        if (value.NAME_CONFIRM3 != null && value.NAME_CONFIRM3 != '') {
            name3 = value.NAME_CONFIRM3
            tabk3 = value.TAKT3 + ' MIN.'
            datetime3 = value.DATETIME3
        }


        if (key == 0) {
            TECHNICIAN += '<div class="col-md-6"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM1_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name1 + '</h6>' +
                '<h6>' + tabk1 + '</h6>' +
                '<h6>' + datetime1 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'

            MFE += '<div class="col-md-6"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM2_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name2 + '</h6>' +
                '<h6>' + tabk2 + ' </h6>' +
                '<h6>' + datetime2 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'

            PRODUCTION += '<div class="col-md-6"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM3_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name3 + '</h6>' +
                '<h6>' + tabk3 + ' </h6>' +
                '<h6>' + datetime3 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'
        } else {
            top = top + 3
            right = right + 3
            strClass = '.img' + key + ' { top: ' + top + 'px; right: ' + right + 'px; }';
            $('style')[0].append(strClass);

            TECHNICIAN += '<div class="col-md-6 absolute img' + key + '"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM1_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name1 + '</h6>' +
                '<h6>' + tabk1 + ' </h6>' +
                '<h6>' + datetime1 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'

            MFE += '<div class="col-md-6 absolute img' + key + '"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM2_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name2 + '</h6>' +
                '<h6>' + tabk2 + ' </h6>' +
                '<h6>' + datetime2 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'

            PRODUCTION += '<div class="col-md-6 absolute img' + key + '"><br>' +
                '<div class="card border-light bg-light shadow-sm">' +
                '<div class="card-body shadow-sm">' +
                '<h5>' + value.TYPE + '</h5>' +
                '<h6>' + value.MODEL + '</h6>' +
                '<img class="rounded-circle" src="' + CONFIRM3_URL + '" height="90px" width="90px" aria-label="For screen readers">' +
                '<h6>' + name3 + '</h6>' +
                '<h6>' + tabk3 + ' </h6>' +
                '<h6>' + datetime3 + '</h6>' +
                '</div>' +
                '</div>' +
                '</div>'
        }
    });
    $("#TECHNICIAN").append(TECHNICIAN)
    $("#MFE").append(MFE)
    $("#PRODUCTION").append(PRODUCTION)
    $("#TECHNICIAN, #MFE, #PRODUCTION").slideDown("slow")
    if (dataFunc == 'loadDatatable') {
        if (STATUS != 'CONFIRM3') {
            $("#btnBACK, #btnCONFRIM, #btnDISPOSE").show('slow')
            $("#btnPrint").hide()
        } else {
            $("#btnBACK, #btnPrint").show('slow')
            $("#btnCONFRIM, #btnDISPOSE").hide()
        }
    }
    $("#txtSub").text('LINE : ' + LINE + ' / MODEL : ' + strModel + ' / TYPE : ' + strType)
}

$('.modal').on('shown.bs.modal', function (e) {
    // do something...
    if (this.id == 'exampleModal1') {
        $('#memberIdDispose').focus()
    }
})

// $('.modal').on('hidden.bs.modal', function(e) {
//     // do something...
//     $("#idConfirm").val('')
// })

// Get the input field
var memberIdDispose = document.getElementById("memberIdDispose");

// Execute a function when the user presses a key on the keyboard
memberIdDispose.addEventListener("keypress", function (event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
        // Cancel the default action, if needed
        dispose()
    }
});

function dispose() {
    var dataDispose = {
        'LINE': LINE,
        'PERIOD': PERIOD,
        'START_DATE': START_DATE,
        'END_DATE': END_DATE,
        'SHIFT': SHIFT,
        'TYPE': TYPE,
        'MODEL': MODEL,
        'MEMBER': $('#memberIdDispose').val()
    }

    $.ajax({
        url: "php/ajax_visual_line_dispose.php",
        type: "POST",
        dataType: "json",
        data: dataDispose,
        success: function (result) {
            console.log(result)
            Swal.fire({
                icon: 'success',
                title: 'Sucess...',
                text: 'Dispose complete',
            }).then(function () {
                
            })
        }
    })

}