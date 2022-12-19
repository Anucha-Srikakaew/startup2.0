$.ajax({
    url: "php/ajax_checklogin.php",
    type: "POST",
    dataType: "json",
    data: dataSearch,
    success: function (result) {
        console.log(result)
        // if (result.length != 0 && result.STARTUP_USER_NAME != null && result.STARTUP_USER_NAME == '') {
        //     $('#login').attr('href', "logout.php")
        //     $('#login').text(result.STARTUP_USER_NAME + ' ')
        // } else {
        //     $('#login').attr('href', "login.php?COUNTRY=" + COUNTRY + "&FACTORY=" + FACTORY + "&BIZ=" + BIZ)
        //     $('#login').text('LOGIN')
        // }
    }
})
