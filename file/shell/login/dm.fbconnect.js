$(document).ready(function() {
	$('.fb_login').live('click', fbClick);

});

var fbRedirect = '';
function fbClick() {
	var url = '/login/fbconnect';
	if ($('#remember_me').size() > 0 && $('#remember_me').is(':checked'))
		url += '?' + $('#remember_me').attr('name') + '=on';
	
	if (fbRedirect!=''){
		url += (url.indexOf('?') != -1) ? '&' : '?';
		url += 'redirectTo=' + escape(fbRedirect);
	}
	if (typeof dm_site_alias != 'undefined') {
		url += (url.indexOf('?') != -1) ? '&' : '?';
		url += 'siteAlias=' + dm_site_alias;
	}

	var w = 600;
	var h = 400;
	var left = (screen.width / 2) - (w / 2);
	var top = (screen.height / 2) - (h / 2);
	var targetWin = window.open(url, '',
			'status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='
					+ w + ', height=' + h + ', top=' + top + ', left=' + left);
}