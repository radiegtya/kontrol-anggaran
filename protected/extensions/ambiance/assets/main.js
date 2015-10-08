$( function() {
    //flash
    $('#success').click(function () {
        $.ambiance({
            message: "Data berhasil disimpan", 
            title: "Success!",
            type: "success",
            timeout: 5
        });
    });
    $('#error').click(function () {
        $.ambiance({
            message: "Data gagal disimpan", 
            title: "Error!",
            type: "error",
            timeout: 5
        });
    });


});