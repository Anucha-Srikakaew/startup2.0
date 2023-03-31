const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var dataSearchUrl = {
    'COUNTRY': urlParams.get('COUNTRY'),
    'FACTORY': urlParams.get('FACTORY'),
    'BIZ': urlParams.get('BIZ'),
    'PERIOD': urlParams.get('PERIOD'),
    'START_DATE': urlParams.get('START_DATE'),
    'END_DATE': urlParams.get('END_DATE'),
    'SHIFT': urlParams.get('SHIFT'),
    'LINE': urlParams.get('LINE'),
    'TYPE': urlParams.get('TYPE'),
    'MODEL': urlParams.get('MODEL')
}
$("#btnBackPage").attr('href', 'startup_c.html?COUNTRY=' + dataSearchUrl.COUNTRY
    + '&FACTORY=' + dataSearchUrl.FACTORY
    + '&BIZ=' + dataSearchUrl.BIZ
    + '&PERIOD=' + dataSearchUrl.PERIOD)

if (dataSearchUrl.LINE == null || dataSearchUrl.MODEL == null || dataSearchUrl.TYPE == null) {
    window.location.href = 'startup_c.html?COUNTRY=' + dataSearchUrl.COUNTRY + '&FACTORY=' + dataSearchUrl.FACTORY + '&BIZ=' + dataSearchUrl.BIZ + '&PERIOD=' + dataSearchUrl.PERIOD + '';
}

$("#txtMain").text(
    'COUNTRY: ' + dataSearchUrl.COUNTRY +
    ' /FACTORY: ' + dataSearchUrl.FACTORY +
    ' /BIZ: ' + dataSearchUrl.BIZ
)
$("#txtSub1").text(
    'LINE: ' + dataSearchUrl.LINE +
    ' /TYPE: ' + dataSearchUrl.TYPE +
    ' /MODEL: ' + dataSearchUrl.MODEL
)

var txtSub2 = ''
if (dataSearchUrl.PERIOD == 'SHIFT') {
    txtSub2 += 'PERIOD: ' + dataSearchUrl.PERIOD
    txtSub2 += ' /SHIFT DATE: ' + dataSearchUrl.START_DATE
    txtSub2 += ' /SHIFT: ' + dataSearchUrl.SHIFT
} else if (dataSearchUrl.PERIOD == 'DAY') {
    txtSub2 += 'PERIOD: ' + dataSearchUrl.PERIOD
    txtSub2 += ' /SHIFT DATE: ' + dataSearchUrl.START_DATE
} else if (dataSearchUrl.PERIOD == 'WEEK') {
    DAY = dataSearchUrl.START_DATE
    currentDate = new Date(DAY);
    startDate = new Date(currentDate.getFullYear(), 0, 1);
    var days = Math.floor((currentDate - startDate) / (24 * 60 * 60 * 1000));
    var weekNumber = Math.ceil(days / 7);
    var year = DAY.split('-')[0]
    var month = DAY.split('-')[1]
    WEEK = year + "-W" + weekNumber

    txtSub2 += 'PERIOD: ' + dataSearchUrl.PERIOD
    txtSub2 += ' /WEEK: ' + WEEK
}

$("#txtSub2").text(txtSub2)

var table = $('#example').DataTable({
    paging: false,
    searching: false,
    columnDefs: [
        {
            orderable: false,
            targets: [0, 1, 2, 3, 4]
        }
    ],
});

var timeId = ''
var specArr = []
$.ajax({
    url: "php/ajax_query_startup.php",
    type: "POST",
    dataType: "json",
    data: dataSearchUrl,
    success: function (result) {
        // start success
        console.log(result)
        if (result.length != 0) {
            table.clear().draw();
            $.each(result, function (key, value) {
                var picture, input = '', cls = 'text-center ', valueInput = ''

                if (value.PICTURE == '') {
                    picture = '<img width="60%" src="framework/img/http://43.72.52.239/mdc_photo/station_photo/default/none.jpg" alt="">'
                } else {
                    picture = '<img width="60%" src="http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' + value.PICTURE + '" alt="">'
                }

                if (value.SPEC == '') {
                    console.log(value)
                }

                if (value.SPEC == 'OK' || value.SPEC == 'NG' || value.SPEC == 'JUDGEMENT') {
                    input = '<select name="VALUE1" id="' + value.ID + '" class="form-select">' +
                        '<option value="OK">OK</option>' +
                        '<option value="NG">NG</option>' +
                        '</select>'
                } else if (value.SPEC == 'TEXT') {
                    input = '<input type="text" class="form-control" name="VALUE1" id="' + value.ID + '">'
                } else if (value.SPEC == 'PHOTO') {
                    if (value.VALUE1 == '') {
                        valueInput = '<i class="fa fa-camera"></i>'
                    } else {
                        valueInput = value.VALUE1
                    }

                    input = '<button id="' + value.ID + '" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#exampleModal">' + valueInput + '</button>';
                } else if (value.SPEC == 'DATE') {
                    input = '<input type="date" class="form-control" name="VALUE1" id="' + value.ID + '">'
                } else if (value.SPEC == 'VALUE') {
                    input = '<input type="number" step="any" class="form-control" name="VALUE1" id="' + value.ID + '">'
                } else if (value.SPEC == '') {
                    input = '<b class="text-warning">SPEC BLANK (ITEM ID : ' + value.ID + ').</b>'
                }

                if (value.JUDGEMENT == 'FAIL') {
                    cls += 'border-light table-danger'
                } else if (value.JUDGEMENT == 'PASS') {
                    cls += 'border-light table-success'
                }

                table.row.add([
                    value.PROCESS,
                    picture,
                    value.ITEM,
                    value.SPEC_DES,
                    input
                ]).node().id = 'tr' + value.ID
                table.draw(true)
                $('#tr' + value.ID).addClass(cls)

                $('#' + value.ID).val(value.VALUE1)

                specArr[value.ID] = {
                    'MIN': value.MIN,
                    'MAX': value.MAX,
                    'SPEC_DES': value.SPEC_DES,
                    'SPEC': value.SPEC,
                }
            })

            $('input,select').on('keyup change', function (e) {
                setElement(this)
            });
        } else {
            window.location.href = "startup_c.html"
        }

        // end success
    }
})

var id = '', value = '', type = '', judgment = ''
function setElement(elem) {
    id = elem.id
    value = elem.value
    type = elem.type

    if (value != '') {
        if (type == 'number') {
            value = parseFloat(value)
            console.log(parseFloat(specArr[id].MIN))
            console.log(parseFloat(specArr[id].MAX))
            console.log(value)
            if (value >= parseFloat(specArr[id].MIN) && value <= parseFloat(specArr[id].MAX)) {
                judgment = 'PASS'
            } else {
                judgment = 'FAIL'
            }
        } else if (type == 'text') {
            judgment = 'PASS'
        } else if (type == 'date') {
            if (value >= specArr[id].MIN && value <= specArr[id].MAX) {
                judgment = 'PASS'
            } else {
                judgment = 'FAIL'
            }
        } else if (type == 'select-one') {
            if (value >= 'OK' || value == specArr[id].SPEC) {
                judgment = 'PASS'
            } else {
                judgment = 'FAIL'
            }
        }
    } else {
        judgment = 'BLANK'
    }

    updateInput(id, 'VALUE1', value, judgment)
}

function updateInput(id, column, value, judgment) {
    dataUpdate = {
        'id': id,
        'column': column,
        'value': value,
        'judgment': judgment,
        'timeId': timeId
    }

    console.log(dataUpdate)

    $.ajax({
        url: "php/ajax_startup_update_input.php",
        type: "POST",
        dataType: "json",
        data: dataUpdate,
        success: function (result) {
            // start success
            console.log(result)

            // judgment tr table color
            $('#tr' + id).removeClass()
            if (judgment == 'PASS') {
                $('#tr' + id).addClass('text-center border-light table-success')
            } else if (judgment == 'FAIL') {
                $('#tr' + id).addClass('text-center border-light table-danger')
            } else {
                $('#tr' + id).addClass('text-center')
            }

            $("#cloasModelCamera").click()
            // end success
        }
    })
}

// ######## camera ########
$(canvas).hide();
var myModalEl = document.getElementById('exampleModal')
myModalEl.addEventListener('shown.bs.modal', function (event) {
    console.log('modal show')
    id = event.relatedTarget.id
    if ($('i', event.relatedTarget).length == 0) {
        var imgName = event.relatedTarget.textContent || event.relatedTarget.innerText;
        putBIGimage('http://43.72.52.239/STARTUP_photo_body/photo/' + imgName)
    } else {
        openCamera()
    }
})

myModalEl.addEventListener('hidden.bs.modal', function (event) {
    console.log('modal hide')
    // console.log(id)
    var video = document.querySelector('video')
    var mediaStream = video.srcObject
    if (mediaStream != null) {
        var tracks = mediaStream.getTracks()
        tracks[0].stop()
    }
})

function openCamera() {
    $(canvas).hide()
    $(video).show()
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            facingMode: "environment",
            width: 640,
            height: 480,
        }
    }).then(function (stream) {
        window.stream = stream
        video.srcObject = stream
    }).catch(function (err) {
        console.log(err.name + " : " + err.message);
        console.log('Error.')
        Swal.fire({
            icon: 'error',
            title: err.message,
            text: 'ไม่สามารถเข้าถึงกล้องของคุณได้.',
            footer: '<a href="manual.php">Go to manual!</a>'
        }).then(function () {
            window.location.reload()
        })
    });
}

function snap() {
    $(canvas).show()
    $(video).hide()

    canvas.width = video.videoWidth
    canvas.height = video.videoHeight
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height)
}

var BIGimage;
function putBIGimage(imgName) {
    $(canvas).show()
    $(video).hide()
    BIGimage = document.createElement("IMG")
    BIGimage.src = imgName
    BIGimage.onload = waitBIGimage
    BIGimage.onerror = console.error
}

function waitBIGimage() {
    canvas.width = 640
    canvas.height = 480
    var ctx = canvas.getContext('2d')
    ctx.drawImage(this, 0, 0)
    // document.body.appendChild(BIGimage)
}

function saveSnap() {
    var imgData = canvas.toDataURL('image/png');
    $.post("http://43.72.52.239/STARTUP_photo_body/uploadphoto.php",
        {
            image: imgData,
            itemID: id,
            checkimage: 1
        },
        function (data) {
            $('button#' + id).text(data)
            updateInput(id, 'VALUE1', data, 'PASS')
        });
}