check_add_image = 0;
var check_add_image; //check snapshot photo //เช็คว่ากดถ่ายรูปหรือยังถ้ายังจะกดเซฟไม่ได้ส่งไปเช็คที่ uploadphoto.php
var iditem; // return iditem
var check_camera;
var CAMERA = "environment";
check = 0; // value to upload photo check 
var imageCapture;

$(document).ready(function () {
    $(canvas).hide();
    $('#snap').on('click', function () {
        $(canvas).show();
        $(video).hide();
    })
    $('#switchcamera').on('click', function () {
        var isClicked = $(this).data("clicked"); //set value to check
        if (isClicked == 0) {
            isClicked = 1;
            user();
            CAMERA = "user"
        } else if (isClicked == 1) {
            isClicked = 0;
            environment();
            CAMERA = "environment"
        }
        $(this).data("clicked", isClicked);
        console.log(isClicked)
    })
    $("tr").click(function () {
        table = $(this).find('table');
        trId = table.prevObject[0].id;
        TrItem = document.getElementById(trId);
    });
})

function show(btn) {
    // alert("jkj");
    check_camera = 1;
    check_add_image = 0;
    var element = btn.value;
    iditem = element;
    console.log(iditem)
    $('.modal').modal({
        backdrop: 'static',
        keyboard: false
    })
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            facingMode: "environment",
            width: { min: 1024, ideal: 4096, max: 4096 },
            height: { min: 576, ideal: 2160, max: 2160 },
        }
    })
        .then(function (stream) {
            window.stream = stream;
            video.srcObject = stream;
        })
    $(canvas).hide();
    $(video).show();

}

function take_snapshot() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    check = 1;
    check_add_image = 1;
    stopVideoOnly();
};

function resetVideoOnly() {
    $(video).show();
    $(canvas).hide();
    check = 0;
    check_add_image = 0;
    console.log(check)
    console.log(check_add_image)
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            facingMode: CAMERA,
            width: { min: 1024, ideal: 4096, max: 4096 },
            height: { min: 576, ideal: 2160, max: 2160 },
        }
    })
        .then(function (stream) {
            window.stream = stream;
            video.srcObject = stream;
        })
}

function saveSnap() {
    if (check == 1 && check_add_image == 1) {
        var imgData = canvas.toDataURL('image/png');
        var itemID = iditem;
        var check_camera = check_add_image;
        // console.log(imgData);
        // console.log(trId)
        $.post("http://43.72.52.51/startup2.0/uploadphoto.php", { image: imgData, itemID: itemID, checkimage: check_camera },
            function (data) {
                // console.log('posted');
                console.log(data);
                $("#imagename" + itemID).text("" + data + ""); //show value to tag p
                $("#nameimage" + itemID).val("" + data + ""); //set value insert to database
                $(TrItem).removeClass().addClass("table-success");// green tr 
                JUDGEMENT = 'PASS';

                console.log(trId)
                $.ajax({
                    url: "config/php/update_input.php",
                    type: "POST",
                    data: {
                        'ID': trId,
                        'VALUE': data,
                        'VALUE_TYPE': 'VALUE1',
                        'JUDGEMENT': JUDGEMENT,
                    },
                    success: function (re) {
                        // alert(re)
                        $(document).ready(function () {
                        })
                    }
                });
            });
        $(document).ready(function () {
            $('.modal').modal('hide');
        })
        check_add_image = 1;
        check = 0;
        stopVideoOnly();
    } else {
        check_add_image = 0;
        console.log(check_add_image);
    }
}

function handleSuccess(stream) {
    window.stream = stream; // make stream available to browser console
    video.srcObject = stream;
}

function stopVideoOnly() {

    const video = document.querySelector('video');

    const mediaStream = video.srcObject;

    const tracks = mediaStream.getTracks();

    tracks[0].stop();
}

function handleError(error) {
    console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
}

function environment() {
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            facingMode: "environment",
            width: { min: 1024, ideal: 4096, max: 4096 },
            height: { min: 576, ideal: 2160, max: 2160 },
        }
    })
        .then(function (stream) {
            window.stream = stream;
            video.srcObject = stream;
        })
}

function user() {
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            facingMode: "user",
            width: { min: 1024, ideal: 4096, max: 4096 },
            height: { min: 576, ideal: 2160, max: 2160 },
        }
    })
        .then(function (stream) {
            window.stream = stream;
            video.srcObject = stream;

        })
}