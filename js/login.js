
$("#login").click(function () {
    username = $("#username").val()
    password = $("#password").val()

    if (username != '') {
        if (password != '') {
            $(".se-pre-con").fadeIn()
            $.ajax({
                url: "php/ajax_checklogin.php",
                type: "POST",
                dataType: "json",
                data: {
                    'username': username,
                    'password': password,
                },
                success: function (result) {
                    console.log(result)
                    $(".se-pre-con").fadeOut()

                    if (result.STARTUP_EMP_ID == '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please check your member.',
                        })
                    } else {
                        if (result.STARTUP_EMP_TYPE == 'TECH') {
                            window.location.href = 'startup_c.html?COUNTRY=' + result.STARTUP_EMP_COUNTRY + '&FACTORY=' + result.STARTUP_EMP_FACTORY + '&BIZ=' + result.STARTUP_EMP_BIZ + '&PERIOD=' + PERIODmain + ''
                        } else if (result.STARTUP_EMP_TYPE == 'PIC') {
                            window.location.href = 'visual.html?' + result.STARTUP_EMP_COUNTRY + '&FACTORY=' + result.STARTUP_EMP_FACTORY + '&BIZ=' + result.STARTUP_EMP_BIZ
                        } else {
                            window.location.href = 'visual.html?' + result.STARTUP_EMP_COUNTRY + '&FACTORY=' + result.STARTUP_EMP_FACTORY + '&BIZ=' + result.STARTUP_EMP_BIZ
                        }
                    }
                }
            })
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Please input user password',
            }).then(function () {
                $("#password").focus()
            })
        }
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please input user id',
        }).then(function () {
            $("#username").focus()
        })
    }
})
