/* JQuery to create the alt tags */
jQuery(document).ready(function ($) {
	$("img").each(function () {
		if (($(this).attr('alt').length == 0) || ($(this).attr('alt') == null)) {
			var alt = "";
			var src = $('img').attr('src'); /* full path of image */
			var splits = src.split('/');      /* path sections broken down */
			var name = splits[splits.length - 1]; /* 'filename.jpg' */
			var alt = name.split('.')[0];  /* 'filename' */

			if ((alt.length > 0) && (alt != null)) {
				//alt;
			} else if ((name.length > 0) && (name != null)) {
				alt = name;
			} else {
				var d = new Date();
				var date = d.getFullYear() + "/" + (d.getMonth() + 1) + "/" + d.getDate();
				var num = Math.floor((Math.random() * 1000) + 1);
				alt = date + " - " + num
			}
			$(this).attr('alt', alt);
		}
	}); // .each
}); //.ready