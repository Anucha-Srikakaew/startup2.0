const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var COUNTRY = urlParams.get('COUNTRY')
var FACTORY = urlParams.get('FACTORY')
var BIZ = urlParams.get('BIZ')
var PERIOD = urlParams.get('PERIOD')
var SHIFT_DATE = urlParams.get('SHIFT_DATE')
var SHIFT = urlParams.get('SHIFT')
var DAY = urlParams.get('DAY')
var WEEK = urlParams.get('WEEK')


if (COUNTRY == '' || COUNTRY == null) {
    COUNTRY = 'TH'
}

if (FACTORY == '' || FACTORY == null) {
    FACTORY = 'STTC'
}

if (BIZ == '' || BIZ == null) {
    BIZ = 'IM'
}

if (PERIOD == '' || PERIOD == null) {
    PERIOD = 'SHIFT'
}

if (SHIFT_DATE == '' || SHIFT_DATE == null) {
    SHIFT_DATE = formatDate()
}

if (SHIFT == '' || SHIFT == null) {
    SHIFT = 'DAY'
}

if (DAY == '' || DAY == null) {
    DAY = formatDate()
}

if (WEEK == '' || WEEK == null) {
    currentDate = new Date();
    startDate = new Date(currentDate.getFullYear(), 0, 1);
    var days = Math.floor((currentDate - startDate) / (24 * 60 * 60 * 1000));
    var weekNumber = Math.ceil(days / 7);
    var year = DAY.split('-')[0]
    var month = DAY.split('-')[1]
    WEEK = year + "-W" + weekNumber
}

$("#boxShift").hide()
$("#boxDaily").hide()
$("#boxWeekly").hide()

var dataSearch = {
    'COUNTRY': COUNTRY,
    'FACTORY': FACTORY,
    'BIZ': BIZ,
    'PERIOD': PERIOD,
    'SHIFT_DATE': SHIFT_DATE,
    'SHIFT': SHIFT,
    'DAY': DAY,
    'WEEK': WEEK
}

if (dataSearch.PERIOD == "SHIFT") {
    $("#boxShift").show()
} else if (dataSearch.PERIOD == "DAY") {
    $("#boxDaily").show()
} else if (dataSearch.PERIOD == "WEEK") {
    $("#boxWeekly").show()
}

var table = $('#example').DataTable({
    paging: false,
    searching: false,
    createdRow: function (row, data, dataIndex) {
        $('td:eq(1)', row).css('font-weight', 'bold');
        $('td:eq(2)', row).css('font-weight', 'bold');
        $('td:eq(5)', row).css('font-weight', 'bold');
        $('td:eq(6)', row).css('font-weight', 'bold');
        if ((typeof data[6]) == 'string') {
            $('td:eq(4)', row).addClass('table-active')
            $('td:eq(5)', row).addClass('table-active')
            $('td:eq(6)', row).addClass('table-active')
            $('td:eq(7)', row).addClass('table-active')
            $('td:eq(6)', row).attr('colspan', 2);
            $('td:eq(5)', row).css('display', 'none');
        }
        if ((typeof data[2]) == 'string') {
            $('td:eq(0)', row).addClass('table-active')
            $('td:eq(1)', row).addClass('table-active')
            $('td:eq(2)', row).addClass('table-active')
            $('td:eq(3)', row).addClass('table-active')
            $('td:eq(2)', row).attr('colspan', 2);
            $('td:eq(1)', row).css('display', 'none');
        }
    }
});

$('#First, input, select').change(function () {
    if (this.type == 'radio') {
        dataSearch.PERIOD = this.value
        if (this.value == "SHIFT") {
            $("#boxShift").show('slow')
            $("#boxDaily").hide()
            $("#boxWeekly").hide()
        } else if (this.value == "DAY") {
            $("#boxShift").hide()
            $("#boxDaily").show('slow')
            $("#boxWeekly").hide()
        } else if (this.value == "WEEK") {
            $("#boxShift").hide()
            $("#boxDaily").hide()
            $("#boxWeekly").show('slow')
        }
    }
    dataSearch[this.id] = this.value
    $("#partPeriod" + dataSearch.PERIOD).attr('checked', 'checked')
    $("#SHIFT_DATE").val(dataSearch.SHIFT_DATE)
    $("#SHIFT").val(dataSearch.SHIFT)
    $("#DAY").val(dataSearch.DAY)
    $("#WEEK").val(dataSearch.WEEK)
    LoadData(dataSearch)
})

$("#First").change()

function LoadData(dataSearch) {
    $(".se-pre-con").fadeIn()
    $.ajax({
        url: "php/ajax_query_visual.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            console.log(result)

            table.clear().draw();
            table.rows.add(result).draw().nodes().to$().addClass("text-center");

            window.history.pushState("object or string", "Title",
                "visual.html?COUNTRY=" + dataSearch.COUNTRY +
                "&FACTORY=" + dataSearch.FACTORY +
                "&BIZ=" + dataSearch.BIZ +
                "&PERIOD=" + dataSearch.PERIOD +
                "&SHIFT_DATE=" + dataSearch.SHIFT_DATE +
                "&SHIFT=" + dataSearch.SHIFT +
                "&DAY=" + dataSearch.DAY +
                "&WEEK=" + dataSearch.WEEK
            )
            $(".se-pre-con").fadeOut()
        }
    })
}