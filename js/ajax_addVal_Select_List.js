// FACTORY
$.ajax({
    url: "php/ajax_item_query_factory.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#FACTORY').empty()
        $('#FACTORY').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#FACTORY').append($('<option>', {
                value: item.FACTORY,
                text: item.FACTORY
            }));
            $('#listFACTORY').append("<option value='" + item.FACTORY + "'>");
        });
    }
})

// BIZ
$.ajax({
    url: "php/ajax_item_query_biz.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#BIZ').empty()
        $('#BIZ').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#BIZ').append($('<option>', {
                value: item.BIZ,
                text: item.BIZ
            }));
            $('#listBIZ').append("<option value='" + item.BIZ + "'>");
        });
    }
})

// LINE
$.ajax({
    url: "php/ajax_item_query_line.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#LINE').empty()
        $('#LINE').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#LINE').append($('<option>', {
                value: item.LINE,
                text: item.LINE
            }));
            $('#listLINE').append("<option value='" + item.LINE + "'>");
        });
    }
})

// TYPE
$.ajax({
    url: "php/ajax_item_query_type.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#TYPE').empty()
        $('#TYPE').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#TYPE').append($('<option>', {
                value: item.TYPE,
                text: item.TYPE
            }));
            $('#listTYPE').append("<option value='" + item.TYPE + "'>");
        });
    }
})

// MODEL
$.ajax({
    url: "php/ajax_item_query_model.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#MODEL').empty()
        $('#MODEL').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#MODEL').append($('<option>', {
                value: item.MODEL,
                text: item.MODEL
            }));
            $('#listMODEL').append("<option value='" + item.MODEL + "'>");
        });
    }
})

// PROCESS
$.ajax({
    url: "php/ajax_item_query_process.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#PROCESS').empty()
        $('#PROCESS').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#PROCESS').append($('<option>', {
                value: item.PROCESS,
                text: item.PROCESS
            }));
            $('#listPROCESS').append("<option value='" + item.PROCESS + "'>");
        });
    }
})

// SPEC
$.ajax({
    url: "php/ajax_item_query_spec.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#SPEC').empty()
        $('#SPEC').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#SPEC').append($('<option>', {
                value: item.SPEC,
                text: item.SPEC
            }));
            $('#listSPEC').append("<option value='" + item.SPEC + "'>");
        });
    }
})

// PERIOD
$.ajax({
    url: "php/ajax_item_query_period.php",
    dataType: "json",
    async: false,
    success: function (json) {
        $('#PERIOD').empty()
        $('#PERIOD').append(
            $('<option>', {
                selected: true,
                text: 'ALL',
                value: ''
            })
        )
        $.each(json, function (i, item) {
            $('#PERIOD').append($('<option>', {
                value: item.PERIOD,
                text: item.PERIOD
            }));
            $('#listPERIOD').append("<option value='" + item.PERIOD + "'>");
        });
    }
})