var table = $('#example').DataTable({
    paging: false,
    searching: false,
    createdRow: function (row, data, dataIndex) {
        // console.log(row)

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
}

$('#txtMain').text('COUNTRY : ' + COUNTRY + ' / FACTORY : ' + FACTORY + ' / BIZ : ' + BIZ + '')

var TECHNICIAN = '',
    MFE = '',
    PRODUCTION = ''
$.ajax({
    url: "php/ajax_query_visual_line_people_data.php",
    type: "POST",
    dataType: "json",
    data: dataSearch,
    success: function (obj) {
        var strModel = '', strType = '', objShow = '', top = 0, right = 25, strClass

        // $('style')[0].append('.imgMain123456 {position: relative;}');

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

            if (key == 0) {
                TECHNICIAN += '<div class="col-md-6"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM1 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM1 + '</h6>' +
                    '<h6>' + value.TAKT1 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME1 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'

                MFE += '<div class="col-md-6"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM2 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM2 + '</h6>' +
                    '<h6>' + value.TAKT2 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME2 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'

                PRODUCTION += '<div class="col-md-6"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM3 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM3 + '</h6>' +
                    '<h6>' + value.TAKT3 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME3 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
            } else {
                top = top + 3
                right = right + 3
                strClass = '.img' + key + ' { top: ' + top + 'px; right: ' + right + '%; }';
                $('style')[0].append(strClass);

                TECHNICIAN += '<div class="col-md-6 absolute img' + key + '"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM1 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM1 + '</h6>' +
                    '<h6>' + value.TAKT1 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME1 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'

                MFE += '<div class="col-md-6 absolute img' + key + '"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM2 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM2 + '</h6>' +
                    '<h6>' + value.TAKT2 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME2 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'

                PRODUCTION += '<div class="col-md-6 absolute img' + key + '"><br>' +
                    '<div class="card border-light bg-light shadow-sm">' +
                    '<div class="card-body shadow-sm">' +
                    '<h5>' + value.TYPE + '</h5>' +
                    '<h6>' + value.MODEL + '</h6>' +
                    '<img src="http://43.72.52.159/ATTENd/IMG_opt/' + value.CONFIRM3 + '.JPG"' +
                    'width="50%"' +
                    'aria-label="For screen readers">' +
                    '<h6>' + value.NAME_CONFIRM3 + '</h6>' +
                    '<h6>' + value.TAKT3 + ' MIN.</h6>' +
                    '<h6>' + value.DATETIME3 + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
            }
        });

        $("#TECHNICIAN").empty()
        $("#MFE").empty()
        $("#PRODUCTION").empty()
        $("#TECHNICIAN").append(TECHNICIAN)
        $("#MFE").append(MFE)
        $("#PRODUCTION").append(PRODUCTION)
        $("#txtSub").text('LINE : ' + LINE + ' / MODEL : ' + strModel + ': / TYPE : ' + strType)
        loadDatatableDefault()
    }
})

function loadDatatableDefault() {
    $.ajax({
        url: "php/ajax_query_visual_line_table_default.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (obj) {
            console.log(obj)
            $.each(obj, function (key, value) {
                console.log(value)
            })
            // $(table.column(0).header()).text('TYPE');
            // table.rows.add(obj).draw().nodes().to$().addClass("text-center");
        }
    })
}