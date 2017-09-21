jQuery(document).ready(function () {
    if (!isDateSupported() || !isTimeSupported()) {
        DateTimeFallback();
    }
});

function isDateSupported() {
    var i = document.createElement("input");
    i.setAttribute("type", "date");
    return i.type !== "text";
}

function isTimeSupported() {
    var i = document.createElement("input");
    i.setAttribute("type", "time");
    return i.type !== "text";
}

function DateTimeFallback() {
    /* Date Time */
    var date_input = jQuery("input[type=date]");
    var time_input = jQuery("input[type=time]");

    //only for not chrome
    date_input.on("change", function () {
        var dom = jQuery(this);
        var val = dom.val();
        if (!checkDateInput(val)) {
            var mes = val + " is not a valid date.\n";
            mes += "Please follow the format YYYY-MM-DD\n(eg. 2017-05-01)";
            alert(mes);
            dom.focus();
        }
    });

    time_input.on("change", function () {
        var dom = jQuery(this);
        var val = dom.val();
        if (!checkTimeInput(val)) {
            var mes = val + " is not a valid time.\n";
            mes += "Please follow the format HH:MM\n(eg. 15:30)";
            alert(mes);
            dom.focus();
        }
    });

    //format  HH:MM
    function checkTimeInput(time) {
        if (time == "") {
            return true;
        }

        try {
            var arr = time.split(":");
            if (arr.length !== 2) {
                return false;
            }

            var h = arr[0];
            var m = arr[1];

            //check length
            if (h.length !== 2
                    || m.length !== 2) {
                return false;
            }

            h = Number(arr[0]);
            m = Number(arr[1]);

            if (isNaN(h) || isNaN(m)) {
                return false;
            }

            //date
            if (h < 0 || h > 23) {
                return false;
            }

            //month
            if (m < 0 || m > 59) {
                return false;
            }

            return true;

        } catch (err) {
            return false;
        }
    }

//format  YYYY-MM-DD
    function checkDateInput(date) {
        if (date == "") {
            return true;
        }

        try {
            var arr = date.split("-");
            if (arr.length !== 3) {
                return false;
            }

            var y = arr[0];
            var m = arr[1];
            var d = arr[2];

            //check length
            if (y.length !== 4
                    || m.length !== 2
                    || d.length !== 2) {
                return false;
            }

            y = Number(arr[0]);
            m = Number(arr[1]);
            d = Number(arr[2]);

            if (isNaN(y) || isNaN(m) || isNaN(d)) {
                return false;
            }

            //date
            if (y < 0 || y > 9999) {
                return false;
            }

            //month
            if (m < 0 || m > 12) {
                return false;
            }

            //day
            if (d < 0 || d > 31) {
                return false;
            }

            return true;

        } catch (err) {
            return false;
        }
    }
}