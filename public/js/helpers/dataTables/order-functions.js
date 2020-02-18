$(function () {
	// любые числа с примесью очищает до числа
	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"reportNumeric-pre": function (a) {
			let x = (a == "-") ? 0 : a.replace(/[^\d,.]/, "");
			return parseFloat(x);
		},

		"reportNumeric-asc": function (a, b) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"reportNumeric-desc": function (a, b) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	});

	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"reportWeek-pre": function (a) {
			let x = (a == "-") ? 0 : a.replace(/^[^\d]*(\d{2}).(\d{2}).(\d{4})[^$]*/, "$3-$2-$1");

			return new Date(x);
		},

		"reportNumeric-asc": function (a, b) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"reportNumeric-desc": function (a, b) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	});
});