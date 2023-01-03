const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var COUNTRY = urlParams.get('COUNTRY'), FACTORY = urlParams.get('FACTORY')
    , BIZ = urlParams.get('BIZ')
    , CENTER = urlParams.get('CENTER')
    , LINE = urlParams.get('LINE')
    , START_DATE = urlParams.get('START_DATE')
    , END_DATE = urlParams.get('END_DATE')
    , SHIFT = urlParams.get('SHIFT')
    , PERIOD = urlParams.get('PERIOD')
    , dataFunc = urlParams.get('dataFunc')
    , TYPE = urlParams.get('TYPE')
    , MODEL = urlParams.get('MODEL')
    , PROCESS = urlParams.get('PROCESS')

var dataSearch = {
    COUNTRY: COUNTRY,
    FACTORY: FACTORY,
    BIZ: BIZ,
    CENTER: CENTER,
    LINE: LINE,
    TYPE: TYPE,
    MODEL: MODEL,
    PROCESS: PROCESS,
    START_DATE: START_DATE,
    END_DATE: END_DATE,
    SHIFT: SHIFT,
    PERIOD: PERIOD
}
var homeProcess = ''

$("#VISUAL_URL").attr('href', document.referrer)

$.ajax({
    url: "php/ajax_query_visual_item.php",
    type: "POST",
    dataType: "json",
    data: dataSearch,
    success: function (json) {
        var tblData = [], carousel_item, table = []
        $.each(json, function (key, value) {
            var idProcess = key.replace(/[$/&!+=. ]/g, '') + value[0]['ID']

            carousel_item = '<div class="carousel-item bg-light" id="carousel-item-' + idProcess + '">' +
                '<br><br>' +
                '<div class="container">' +
                '<h4 class="text-center"><b>PROCESS : ' + key + '</b></h4>' +
                '<br>' +
                '<div class="table-responsive">' +
                '<table id="table-' + idProcess + '" class="table table-hover table-bordered" style="width:100%">' +
                '<thead class="table-dark text-light">' +
                '<tr>' +
                '<th class="text-center" width="15%">PICTURE</th>' +
                '<th class="text-center" width="25%">ITEM</th>' +
                '<th class="text-center" width="15%">SPEC</th>' +
                '<th class="text-center" width="15%">INITIAL VALUE</th>' +
                '<th class="text-center" width="15%">ADJUST VALUE</th>' +
                '<th class="text-center" width="15%">JUDGEMENT</th>' +
                '</tr>' +
                '</thead>' +
                '</table>' +
                '</div>' +
                '<br>' +
                '</div>' +
                '</div>'

            tblData[idProcess] = []
            var rows = []
            $.each(value, function (keyTbl, valueTbl) {
                var row = [
                    'PICTURE',
                    valueTbl.ITEM,
                    valueTbl.SPEC_DES,
                    valueTbl.VALUE1,
                    valueTbl.VALUE2,
                    valueTbl.JUDGEMENT,
                ]
                rows.push(row)
            })

            tblData[idProcess].push(rows)
            $('.carousel-inner').append(carousel_item)
            table['table-' + idProcess] = $('#table-' + idProcess).DataTable({
                paging: false,
                createdRow: function (row, data, dataIndex) {
                    // console.log(row)
                    // .addClass()

                    // console.log($('td:eq(6)', row).text())
                    var strClass = '';
                    var strStatus = $('td:eq(5)', row).text()
                    if (strStatus == 'FAIL') {
                        strClass = 'border-light table-danger text-center'
                    } else if (strStatus == 'BLANK') {
                        strClass = 'border-light table-warning text-center'
                    } else if (strStatus == 'PASS') {
                        strClass = 'border-light table-success text-center'
                    }
                    $(row).addClass(strClass)

                    // $('td:eq(1)', row).css('font-weight', 'bold');
                    // $('td:eq(2)', row).css('font-weight', 'bold');
                    // $('td:eq(5)', row).css('font-weight', 'bold');
                    // $('td:eq(6)', row).css('font-weight', 'bold');

                    // if ((typeof data[6]) == 'string') {
                    //     $('td:eq(6)', row).attr('colspan', 2);
                    //     $('td:eq(5)', row).css('display', 'none');
                    // }

                    // if ((typeof data[2]) == 'string') {
                    //     $('td:eq(2)', row).attr('colspan', 2);
                    //     $('td:eq(1)', row).css('display', 'none');
                    // }
                }
            })
            table['table-' + idProcess].rows.add(rows).draw().nodes().to$().addClass('strClass');

            if (idProcess == PROCESS.replace(/[$/&!+=. ]/g, '') + value[0]['ID']) {
                homeProcess = PROCESS.replace(/[$/&!+=. ]/g, '') + value[0]['ID']
                $('#carousel-item-' + homeProcess).addClass('active')
            }
        })
    }
})

$("#homeTable").click(function () {
    console.log(homeProcess)
    $('div.active').removeClass('active')
    $('#carousel-item-' + homeProcess).addClass('active')
})