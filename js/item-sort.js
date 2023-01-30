const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

var COUNTRY = ''
if (urlParams.get('COUNTRY') != null) {
    COUNTRY = urlParams.get('COUNTRY')
} else {
    COUNTRY = 'TH'
}

var FACTORY = ''
if (urlParams.get('FACTORY') != null) {
    FACTORY = urlParams.get('FACTORY')
} else {
    FACTORY = 'FACTORY'
}

var BIZ = ''
if (urlParams.get('BIZ') != null) {
    BIZ = urlParams.get('BIZ')
} else {
    BIZ = 'BIZ'
}
var LINE = ''
if (urlParams.get('LINE') != null) {
    LINE = urlParams.get('LINE')
} else {
    LINE = 'LINE'
}
var TYPE = ''
if (urlParams.get('TYPE') != null) {
    TYPE = urlParams.get('TYPE')
} else {
    TYPE = 'TYPE'
}
var MODEL = ''
if (urlParams.get('MODEL') != null) {
    MODEL = urlParams.get('MODEL')
} else {
    MODEL = 'MODEL'
}

var dataSearch = {
    COUNTRY: COUNTRY,
    FACTORY: FACTORY,
    BIZ: BIZ,
    LINE: LINE,
    TYPE: TYPE,
    MODEL: MODEL,
    SEARCH: ''
}
console.log(dataSearch)


$('select').change(function () {
    dataSearch[this.id] = this.value
    console.log(dataSearch)

    if (this.id == 'FACTORY') {
        BIZName(dataSearch)
    } else if (this.id == 'BIZ') {
        LINEName(dataSearch)
    } else if (this.id == 'LINE') {
        TYPEName(dataSearch)
    } else if (this.id == 'TYPE') {
        MODELName(dataSearch)
    } else if (this.id == 'MODEL') {
        LoadData(dataSearch)
    }

    window.history.pushState("object or string", "Title",
        "item-sort.html?FACTORY=" + dataSearch.FACTORY +
        "&BIZ=" + dataSearch.BIZ +
        "&LINE=" + dataSearch.LINE +
        "&TYPE=" + dataSearch.TYPE +
        "&MODEL=" + dataSearch.MODEL
    )
})
FACTORYName(dataSearch)
function FACTORYName(dataSearch) {
    dataSearch.SEARCH = 'FACTORY'
    $.ajax({
        url: "php/ajax_sort_item_c_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            $('#FACTORY').empty()
            $('#FACTORY').append(
                $('<option>', {
                    value: '',
                    text: 'FACTORY'
                })
            );
            
            $.each(result.data, function (key, value) {
                $('#FACTORY').append(
                    $('<option>', {
                        value: value.FACTORY,
                        text: value.FACTORY
                    })
                );
            })
            $('#FACTORY').val(FACTORY)
            BIZName(dataSearch)
        }
    })
}


function BIZName(dataSearch) {
    dataSearch.SEARCH = 'BIZ'
    $.ajax({
        url: "php/ajax_sort_item_c_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            $('#BIZ').empty()
            $('#BIZ').append(
                $('<option>', {
                    value: '',
                    text: 'BIZ'
                })
            );
            $.each(result.data, function (key, value) {
                $('#BIZ').append(
                    $('<option>', {
                        value: value.BIZ,
                        text: value.BIZ
                    })
                );
            })
            $('#BIZ').val(BIZ)
            LINEName(dataSearch)
        }
    })
}

function LINEName(dataSearch) {
    dataSearch.SEARCH = 'LINE'
    $.ajax({
        url: "php/ajax_sort_item_c_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            $('#LINE').empty()
            $('#LINE').append(
                $('<option>', {
                    value: '',
                    text: 'LINE'
                })
            );
            $.each(result.data, function (key, value) {
                $('#LINE').append(
                    $('<option>', {
                        value: value.LINE,
                        text: value.LINE
                    })
                );
            })
            $('#LINE').val(LINE)
            TYPEName(dataSearch)
        }
    })
}

function TYPEName(dataSearch) {
    dataSearch.SEARCH = 'TYPE'
    $.ajax({
        url: "php/ajax_sort_item_c_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            $('#TYPE').empty()
            $('#TYPE').append(
                $('<option>', {
                    value: '',
                    text: 'TYPE'
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
            $('#TYPE').val(TYPE)
            MODELName(dataSearch)
        }
    })
}

function MODELName(dataSearch) {
    dataSearch.SEARCH = 'MODEL'
    $.ajax({
        url: "php/ajax_sort_item_c_data.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        success: function (result) {
            $('#MODEL').empty()
            $('#MODEL').append(
                $('<option>', {
                    value: '',
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
            $('#MODEL').val(MODEL)
        }
    })
}

var editor; // use a global for the submit and return data rendering in the examples
editor = new $.fn.dataTable.Editor({
    ajax: {
        url: 'php/ajax_item_update_sort.php',
        type: "POST",
        dataType: "json",
        data: dataSearch
    },
    table: '#example',
    fields: [
        {
            label: 'DT_RowId',
            name: 'DT_RowId'
        },
        {
            label: 'ID',
            name: 'ID'
        },
        {
            label: 'LINE',
            name: 'LINE'
        },
        {
            label: 'TYPE',
            name: 'TYPE'
        },
        {
            label: 'DRAWING',
            name: 'DRAWING'
        },
        {
            label: 'MODEL',
            name: 'MODEL'
        },
        {
            label: 'PROCESS',
            name: 'PROCESS'
        },
        {
            label: 'PICTURE',
            name: 'PICTURE'
        },
        {
            label: 'ITEM',
            name: 'ITEM'
        },
        {
            label: 'SPEC_DES',
            name: 'SPEC_DES'
        },
        {
            label: 'MIN',
            name: 'MIN'
        },
        {
            label: 'MAX',
            name: 'MAX'
        },
        {
            label: 'SPEC',
            name: 'SPEC'
        },
        {
            label: 'PIC',
            name: 'PIC'
        }
    ]
});
var dataAllTable = []
var table = $('#example').DataTable({
    dom: 'Bfrtip',
    "searching": false,
    paging: false,
    ajax: {
        url: 'php/ajax_query_item-sort.php',
        type: "POST",
        dataType: "json",
        data: dataSearch
    },
    columns: [
        { data: 'DT_RowId' },
        { data: 'ID' },
        { data: 'LINE' },
        { data: 'TYPE' },
        { data: 'DRAWING' },
        { data: 'MODEL' },
        { data: 'PROCESS' },
        { data: 'PICTURE' },
        { data: 'ITEM' },
        { data: 'SPEC_DES' },
        { data: 'MIN' },
        { data: 'MAX' },
        { data: 'SPEC' },
        { data: 'PIC' }
    ],
    columnDefs: [
        {
            orderable: false,
            targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }
    ],
    rowReorder: {
        dataSrc: 'ID',
        editor: editor
    },
    createdRow: function (row, data, dataIndex) {
        dataAllTable[data.ID] = data

        var btnPicture = ''
        if (data.PICTURE != '') {
            btnPicture = '<button type="button"'
                + 'class="dt-button"'
                + 'data-bs-toggle="modal"'
                + 'data-bs-target="#exampleModal" onclick="showPicture(this.name)" name="' + data.PICTURE + '">'
                + '<i class="fa fa-eye" aria-hidden="true"></i>'
                + '</button>'
        }

        $('td:eq(7)', row).empty()
        $('td:eq(7)', row).append(btnPicture)
    }
});

editor.on('initEdit', function () {
    // Disable for edit (re-ordering is performed by click and drag)
    editor.field('ID').disable();
});

// LoadData(dataSearch)
function LoadData(dataSearch) {
    $.ajax({
        url: "php/ajax_query_item-sort.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        async: false,
        success: function (json) {
            console.log(json.data)
            table.clear().draw()
            table.rows.add(json.data).draw().nodes().to$().addClass("text-center")

            window.history.pushState("object or string", "Title",
                "item-sort.html?FACTORY=" + dataSearch['FACTORY'] +
                "&BIZ=" + dataSearch['BIZ'] +
                "&LINE=" + dataSearch['LINE'] +
                "&TYPE=" + dataSearch['TYPE'] +
                "&MODEL=" + dataSearch['MODEL']
            )
        }
    })
}

function showPicture(pictureName) {
    $("#showPicture").attr("src", 'http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' + pictureName)
}
