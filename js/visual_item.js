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
console.log(CENTER)
var fileVisual = ''
if (CENTER != null && CENTER != 'null' && CENTER != "") {
    fileVisual = 'visual_model.html'
}else{
    fileVisual = 'visual_line.html'
}

$("#btnBackPage").attr('href', fileVisual + '?COUNTRY=' + COUNTRY + '&FACTORY=' + FACTORY + '&BIZ=' + BIZ + '&CENTER=' + CENTER + '&LINE=' + LINE + '&START_DATE=' + START_DATE + '&END_DATE=' + END_DATE + '&SHIFT=' + SHIFT + '&PERIOD=' + PERIOD + '&TYPE=' + TYPE + '&MODEL=' + MODEL + '&dataFunc=loadDatatableDefault')

var homeProcess = ''
$("#txtSub").attr(
    'href', fileVisual + '?' +
    'COUNTRY=' + COUNTRY +
    '&FACTORY=' + FACTORY +
    '&BIZ=' + BIZ +
    '&CENTER' + CENTER +
    '&LINE=' + LINE +
    '&START_DATE=' + START_DATE +
    '&END_DATE=' + END_DATE +
    '&SHIFT=' + SHIFT +
    '&PERIOD=' + PERIOD +
    '&TYPE=' + TYPE +
    '&MODEL=' + MODEL +
'&dataFunc=loadDatatable'
)

$('#txtMain').text(
    'COUNTRY : ' + COUNTRY +
    ' / FACTORY : ' + FACTORY +
    ' / BIZ : ' + BIZ
)

$('#txtSub').text(
    'LINE : ' + LINE +
    ' / MODEL : ' + MODEL +
    ' / TYPE : ' + TYPE
)
$('#txtProcess').text(
    'PROCESS : ' + PROCESS
)
var processNameArr = []
$.ajax({
    url: "php/ajax_query_visual_item.php",
    type: "POST",
    dataType: "json",
    data: dataSearch,
    success: function (json) {
        console.log(json)
        var tblData = [], carousel_item, table = []
        $.each(json, function (key, value) {
            var idProcess = key.replace(/[$/&!+=.() ]/g, '') + value[0]['ID']
            // '<h4 class="text-center"><b>PROCESS : ' + key + '</b></h4>' +
            processNameArr[idProcess] = key

            carousel_item = '<div class="carousel-item bg-light" id="carousel-item-' + idProcess + '">' +
                '<br>' +
                '<div class="container">' +
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
                console.log(valueTbl)
                var value1 = ''

                if (valueTbl.PICTURE != null && valueTbl.PICTURE != '') {
                    IMG_SRC = '<img width="100%" src="http://43.72.52.206/excel_body/item/photo/' + valueTbl.PICTURE + '" alt="">'
                } else {
                    IMG_SRC = '<img width="60%" src="framework/img/no-image-vector.jpg" alt="">'
                }

                if (valueTbl.SPEC == 'PHOTO') {
                    value1 = '<button onclick="modalImgValue1(this)" type="button" name="' + valueTbl.VALUE1 + '" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">' +
                        '<i class="fa fa-eye" aria-hidden="true"></i>' +
                        '</button>'
                } else {
                    value1 = valueTbl.VALUE1
                }

                var row = [
                    IMG_SRC,
                    valueTbl.ITEM,
                    valueTbl.SPEC_DES,
                    value1,
                    valueTbl.VALUE2,
                    valueTbl.JUDGEMENT,
                ]
                rows.push(row)
            })

            tblData[idProcess].push(rows)
            $('.carousel-inner').append(carousel_item)
            table['table-' + idProcess] = $('#table-' + idProcess).DataTable({
                paging: false,
                searching: false,
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

var myCarousel = document.getElementById('carouselExampleControls')

myCarousel.addEventListener('slid.bs.carousel', function () {
    var show = $("div.carousel-item.active")[0]
    var key = show.id.split("carousel-item-")[1]
    console.log(show)
    console.log(key)
    console.log(processNameArr[key])
    $('#txtProcess').text(
        'PROCESS : ' + processNameArr[key]
    )
})

$("#homeTable").click(function () {
    console.log(homeProcess)
    $('div.active').removeClass('active')
    $('#carousel-item-' + homeProcess).addClass('active')

    $('#txtProcess').text(
        'PROCESS : ' + processNameArr[homeProcess]
    )
})

function modalImgValue1(btn) {
    $("#imgValue1").attr('src', 'http://43.72.52.239/startup_photo_body/photo/' + btn.name)
    $("#exampleModalLabelImg").text(btn.name)
}