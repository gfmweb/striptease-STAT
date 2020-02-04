$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': _token
		}
	});

	$('.btn-destroy').on('click', function () {
		if (!confirm('Вы действительно хотите удалить это?')) {
			return false;
		}
		$.ajax({
			url: this.href,
			method: 'delete'
		}).always(function (response) {
			location.assign(response);
		});

		return false;
	});
});