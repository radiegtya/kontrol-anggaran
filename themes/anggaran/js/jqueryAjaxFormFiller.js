function setValue() {
    var url = '<?php echo Yii::app()->createAbsoluteUrl("realization/setValue"); ?>';
    var up = $('#up').val();
    $.ajax({
        url: url,
        dataType: "json",
        data: {
            up: up,
        },
        success: function (result) {
            $('#receiver').val(result.receiver);
        }

    })
}
function setInformation() {
    var url = '<?php echo Yii::app()->createAbsoluteUrl("realization/setInformation"); ?>';
    var package = $('#package').val();
    $.ajax({
        url: url,
        dataType: "json",
        data: {
            package: package,
        },
        success: function (information) {
            $('#package_limit').val(information.package_limit);
            $('#package_realization').val(information.package_realization);
            $('#package_rest_money').val(information.package_rest_money);
            $('#package_up_limit').val(information.package_up_limit);
            $('#package_up_realization').val(information.package_up_realization);
            $('#package_up_rest_money').val(information.package_up_rest_money);
        }

    })
}
$(function () {
    $('#up').change(function () {
        if ($(this).val() == "LS") {
            $('.nrk').show();
            $('.nrs').show();
            $('.package_limit').hide();
            $('.package_realization').hide();
            $('.package_rest_money').hide();
            $('.package_up_limit').hide();
            $('.package_up_realization').hide();
            $('.package_up_rest_money').hide();
            document.getElementById("package_limit").value = 0;
            document.getElementById("package_realization").value = 0;
            document.getElementById("package_rest_money").value = 0;
            document.getElementById("package_up_limit").value = 0;
            document.getElementById("package_up_realization").value = 0;
            document.getElementById("package_up_rest_money").value = 0;
        } else {
            $('.nrk').hide();
            $('.nrs').hide();
            $('.package_limit').hide();
            $('.package_realization').hide();
            $('.package_rest_money').hide();
            $('.package_up_limit').hide();
            $('.package_up_realization').hide();
            $('.package_up_rest_money').hide();
            document.getElementById("package_limit").value = 0;
            document.getElementById("package_realization").value = 0;
            document.getElementById("package_rest_money").value = 0;
            document.getElementById("package_up_limit").value = 0;
            document.getElementById("package_up_realization").value = 0;
            document.getElementById("package_up_rest_money").value = 0;
        }
        setValue();
    });
});
$(function () {
    $('#package').change(function () {
        if ($(this).val() != '0' && $('#up').val() == "LS") {
            $('.package_limit').show();
            $('.package_realization').show();
            $('.package_rest_money').show();
            $('.package_up_limit').hide();
            $('.package_up_realization').hide();
            $('.package_up_rest_money').hide();
            setInformation();
        } else if ($(this).val() != '0' && $('#up').val() == "UP") {
            $('.package_limit').show();
            $('.package_realization').show();
            $('.package_rest_money').show();
            $('.package_up_limit').show();
            $('.package_up_realization').show();
            $('.package_up_rest_money').show();
            setInformation();
        } else if ($(this).val() == '0') {
            $('.package_limit').hide();
            $('.package_realization').hide();
            $('.package_rest_money').hide();
            $('.package_up_limit').hide();
            $('.package_up_realization').hide();
            $('.package_up_rest_money').hide();
        }
        setValue();
    });
});