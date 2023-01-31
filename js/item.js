const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

var COUNTRY = ''
if (urlParams.get('COUNTRY') != null) {
    COUNTRY = urlParams.get('COUNTRY')
}

var FACTORY = ''
if (urlParams.get('FACTORY') != null) {
    FACTORY = urlParams.get('FACTORY')
}

var BIZ = ''
if (urlParams.get('BIZ') != null) {
    BIZ = urlParams.get('BIZ')
}
var LINE = ''
if (urlParams.get('LINE') != null) {
    LINE = urlParams.get('LINE')
}
var TYPE = ''
if (urlParams.get('TYPE') != null) {
    TYPE = urlParams.get('TYPE')
}
var MODEL = ''
if (urlParams.get('MODEL') != null) {
    MODEL = urlParams.get('MODEL')
}

var PROCESS = ''
if (urlParams.get('PROCESS') != null) {
    PROCESS = urlParams.get('PROCESS')
}
var SPEC = ''
if (urlParams.get('SPEC') != null) {
    SPEC = urlParams.get('SPEC')
}
var PERIOD = ''
if (urlParams.get('PERIOD') != null) {
    PERIOD = urlParams.get('PERIOD')
}

var dataAllTable = []
var table = $('#tableData').DataTable({
    // paging: false,
    // searching: false,
    dom: "Bfrtip",
    buttons: [
        {
            text: '<i class="fas fa-upload"></i>',
            action: function (e, dt, node, config) {
                console.log("upload")
                $("#fileData").click()
            }
        },
        {
            text: '<i class="fas fa-image"></i>',
            action: function (e, dt, node, config) {
                console.log("upload")
                $("#fileDataPicture").click()
            }
        },
        {
            text: '<i class="fas fa-download"></i>',
            action: function (e, dt, node, config) {
                console.log("download")
                window.location.href = 'file/STARTUP_ITEM_TEMPLETE.csv'
            }
        },
        {
            text: '<i class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#exampleModalAdd"></i>',
            action: function (e, dt, node, config) {
                console.log("Add one item.")
            }
        },
        {
            text: '<i class="fas fa-sort"></i>',
            action: function (e, dt, node, config) {
                console.log("sort")
                window.location.href = 'item-sort.html'
            }
        },
        {
            text: '<i class="fas fa-trash"></i>',
            action: function (e, dt, node, config) {
                console.log("delete")
                checkboxes = $('input[name=checkbox]:checked')
                var arrId = []
                for (var i = 0, n = checkboxes.length; i < n; i++) {
                    arrId.push(checkboxes[i].id.replace('check', ''))
                }

                if (arrId.length != 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "php/ajax_item_delete.php",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    ID: arrId
                                },
                                async: false,
                                success: function (json) {
                                    if (json.response == true) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Complete.',
                                            text: json.message,
                                        }).then(function () {
                                            window.location.reload()
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: json.message,
                                        }).then(function () {
                                            window.location.reload()
                                        })
                                    }
                                }
                            })
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select item.',
                    })
                }
            }
        },
    ],
    columns: [
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
        { data: 'PIC' },
        { data: 'ID' }
    ],
    columnDefs: [{
        targets: 0,
        orderable: false,
        className: "nowrap"
    }],
    order: [[3, 'asc']],
    iDisplayLength: 50,
    createdRow: function (row, data, dataIndex) {
        dataAllTable[data.ID] = data
        var checkbox = '<input type="checkbox" name="checkbox" id="check' + data.ID + '">'
        $('td:eq(0)', row).empty()
        $('td:eq(0)', row).append(checkbox)

        var btnPicture = ''
        if (data.PICTURE != '') {
            btnPicture = '<button type="button"'
                + 'class="dt-button"'
                + 'data-bs-toggle="modal"'
                + 'data-bs-target="#exampleModal" onclick="showPicture(this.name)" name="' + data.PICTURE + '">'
                + '<i class="fa fa-eye" aria-hidden="true"></i>'
                + '</button>'
        }

        $('td:eq(6)', row).empty()
        $('td:eq(6)', row).append(btnPicture)

        var btnTools = '<button data-bs-toggle="modal" data-bs-target="#exampleModalEdit" onclick="editData(' + data.ID + ')" class="dt-button btn-warning"><i class="fas fa-edit"></i></button>&nbsp; &nbsp;'
        $('td:eq(13)', row).empty()
        $('td:eq(13)', row).append(btnTools)
    }
});

var dataSearch = {
    FACTORY: FACTORY,
    BIZ: BIZ,
    LINE: LINE,
    TYPE: TYPE,
    MODEL: MODEL,
    PROCESS: PROCESS,
    SPEC: SPEC,
    PERIOD: PERIOD,
}
LoadData(dataSearch)
function LoadData(dataSearch) {
    // $(".se-pre-con").fadeIn()
    $.each(dataSearch, function (key, item) {
        $('#' + key).val(item);
    });

    $.ajax({
        url: "php/ajax_item.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        async: false,
        success: function (json) {
            table.clear().draw()
            table.rows.add(json).draw().nodes().to$().addClass("text-center")
            window.history.pushState("object or string", "Title",
                "item.html?FACTORY=" + dataSearch['FACTORY'] +
                "&BIZ=" + dataSearch['BIZ'] +
                "&LINE=" + dataSearch['LINE'] +
                "&TYPE=" + dataSearch['TYPE'] +
                "&MODEL=" + dataSearch['MODEL'] +
                "&PROCESS=" + dataSearch['PROCESS'] +
                "&SPEC=" + dataSearch['SPEC'] +
                "&PERIOD=" + dataSearch['PERIOD']
            )
        }
    })
}

function showPicture(pictureName) {
    $("#showPicture").attr("src", 'http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' + pictureName)
}

var dataEditBefore = []
function editData(id) {
    $('#editItemId').text(id)
    dataEditBefore = dataAllTable[id]
    $.each(dataAllTable[id], function (key, value) {
        if (key == 'PICTURE') {
            if (value != '' && value != null) {
                $("#imgEdit").attr("src", 'http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' + value)
            } else {
                console.log('sssss')
                $("#imgEdit").attr("src", 'framework/img/http://43.72.52.239/mdc_photo/station_photo/default/none.jpg')
            }
        } else {
            $('#edit' + key).val(value)
        }
    })
}

var addImg = 0
function addItem() {
    console.log(dataAdd)
    dataAdd['COUNTRY'] = STARTUP_EMP_COUNTRY
    dataAdd['FACTORY'] = STARTUP_EMP_FACTORY
    dataAdd['BIZ'] = STARTUP_EMP_BIZ
    dataAdd['PICTURE'] = addImg
    var check_error = ''
    if (dataAdd.LINE == undefined || dataAdd.LINE == '') {
        check_error += ' >LINE< '
    }

    if (dataAdd.TYPE == undefined || dataAdd.TYPE == '') {
        check_error += ' >TYPE< '
    }

    if (dataAdd.PROCESS == undefined || dataAdd.PROCESS == '') {
        check_error += ' >PROCESS< '
    }

    if (dataAdd.SPEC == undefined || dataAdd.SPEC == '') {
        check_error += ' >SPEC< '
    }

    if (dataAdd.ITEM == undefined || dataAdd.ITEM == '') {
        check_error += ' >ITEM< '
    }

    if (dataAdd.SPEC_DES == undefined || dataAdd.SPEC_DES == '') {
        check_error += ' >SPEC_DES< '
    }

    if (check_error == '') {
        $.ajax({
            url: "php/ajax_item_add.php",
            type: 'POST',
            data: dataAdd,
            dataType: "json",
            async: false,
            success: function (json) {
                if (json.response == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Complete.',
                        text: json.message,
                    }).then(function () {
                        if (addImg == 1) {
                            sendImg(json.data.ID)
                        } else {
                            window.location.reload()
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: json.message,
                    }).then(function () {
                        window.location.reload()
                    })
                }
            }
        })
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please input ' + check_error,
        }).then(function () {
            window.location.reload()
        })
    }
}

$('select').change(function () {
    dataSearch[this.id] = this.value
    LoadData(dataSearch)
})

var dataEdit = {}, dataAdd = {}
$('input, textarea').on('change', function (e) {
    // e.type is the type of event fired
    if (this.id.split("edit")[1] != undefined) {
        dataEdit[this.id.split("edit")[1]] = this.value
    } else if (this.id.split("add")[1] != undefined) {
        dataAdd[this.id.split("add")[1]] = this.value
    }
});

function saveEdit() {
    dataEdit['ID'] = dataEditBefore.ID
    let count = Object.keys(dataEdit).length
    console.log(count)
    if (count > 1) {
        $.ajax({
            url: "php/ajax_item_save_edit.php",
            type: 'POST',
            data: dataEdit,
            dataType: "json",
            success: function (json) {
                if (json.response == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Complete.',
                        text: json.message,
                    }).then(function () {
                        window.location.reload()
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: json.message,
                    }).then(function () {
                        window.location.reload()
                    })
                }
            }
        })
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please input new data.',
        }).then(function () {
            window.location.reload()
        })
    }
}

var myModalEl = document.getElementById('exampleModalEdit2')
myModalEl.addEventListener('shown.bs.modal', function (event) {
    // do something...
    var element1 = '', element2 = ''
    $.each(dataEdit, function (key, value) {
        element1 += '<h6 class="card-subtitle mb-2 text-muted">' + key + '</h6><p class="card-text">' + dataEditBefore[key] + '</p><br>'
        element2 += '<h6 class="card-subtitle mb-2 text-muted">' + key + '</h6><p class="card-text">' + value + '</p><br>'
    })
    $('#objShowConfrim1').empty()
    $('#objShowConfrim2').empty()
    $('#objShowConfrim1').append(element1)
    $('#objShowConfrim2').append(element2)
})

$("input[type=checkbox]").change(function () {
    if (this.id == 'checkAll') {
        checkboxes = $('input[name=checkbox]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = $('#checkAll').is(":checked")
        }
    }
})

$("#fileData, #fileDataPicture").change(function () {
    var url = ''
    if (this.id == 'fileDataPicture') {
        url = "php/ajax_item_upload_file_picture.php"
    } else {
        url = "php/ajax_item_upload_file.php"
    }

    var file_data = $("#" + this.id).prop('files')[0];
    var form_data = new FormData();
    form_data.append("excel_file", file_data);
    form_data.append("table", 'item');
    console.log(form_data)

    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (json) {
            if (json.response == true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Complete.',
                    text: json.message,
                }).then(function () {
                    window.location.reload()
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: json.message,
                }).then(function () {
                    window.location.reload()
                })
            }
        }
    });
})
var reader
$("#imgFile").change(function () {
    addImg = 1
    var file = this.files[0];
    reader = new FileReader();
    reader.onloadend = function () {
        $("#imgAdd").attr('src', reader.result)
    }
    reader.readAsDataURL(file);
})

function sendImg(id) {
    var NameImg = id + '.jpg'
    toDataURL($("#imgAdd").attr('src'), function (dataURL) {
        console.log(dataURL)
        $.post("http://43.72.52.239/STARTUP_photo_body/photo_By_item/uploadphoto.php",
            {
                name: NameImg,
                img: dataURL,
            },
            function (data) {
                console.log(data)
                window.location.reload()
            });
    })
}

function toDataURL(src, callback) {
    var image = new Image();
    image.crossOrigin = 'Anonymous';
    image.onload = function () {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        canvas.height = this.naturalHeight;
        canvas.width = this.naturalWidth;
        context.drawImage(this, 0, 0);
        var dataURL = canvas.toDataURL('image/jpeg');
        callback(dataURL);
    };
    image.src = src;
}