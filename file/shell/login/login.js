$(document).ready(function() {
	$('input').focus(function() {
		$(this).css('border', '2px solid #F7AA67');
	});

	$('input').focusout(function() {
		$(this).css('border', '2px solid #E7E9D9');
	});
});
