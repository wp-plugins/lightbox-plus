jQuery(document).ready(function ($) {
	if (!$('#use_inline').attr('checked')) {
		$('.base_gen').hide();
	}

	if (!$('#use_perpage').attr('checked')) {
		$('.base_blog').hide();
	}

	if ($("#output_htmlv").attr('checked')) {
		$('.htmlv_settings').show();
	}

	if ($('#rel').attr('checked')) {
		$('.grouping_prim').hide();
	}

	if ($("#use_class_method").attr('checked')) {
		$('.primary_class_name').show();
	}

	if ($("#retina_url").attr('checked')) {
		$('.retina_suffix').show();
	}

	if ($("#retina_url_sec").attr('checked')) {
		$('.retina_suffix_sec').show();
	}

	if (!$('#slideshow').attr('checked')) {
		$('.slideshow_prim').hide();
	}

	if ($('#rel_sec').attr('checked')) {
		$('.grouping_sec').hide();
	}

	if (!$('#slideshow_sec').attr('checked')) {
		$('.slideshow_sec').hide();
	}

	$("input[title]").tooltip({
		position: {
			my: "left top",
			at: "right+5 top-5"
		}
	});

	$("select[title]").tooltip({
		position: {
			my: "left top",
			at: "right+5 top-5"
		}
	});

	$(".lbp-help[title]").tooltip({
		position: {
			my: "left top",
			at: "right+5 top-5"
		}
	});

	$('.close-me').each(function () {
		$(this).addClass("closed");
	});

	$('#lbp_message').each(function () {
		$(this).fadeOut(5000);
	});

	$('.postbox h3').click(function () {
		$(this).next('.toggle').slideToggle('fast');
	});

	$("#blbp-tabs").tabs({fx: {height: 'toggle', duration: 'fast'}});
	$("#plbp-tabs").tabs({fx: {height: 'toggle', duration: 'fast'}});
	$("#slbp-tabs").tabs({fx: {height: 'toggle', duration: 'fast'}});
	$("#ilbp-tabs").tabs({fx: {height: 'toggle', duration: 'fast'}});

	$("#use_inline").click(function () {
		if ($("#use_inline").attr("checked")) {
			$(".base_gen").show("fast");
		} else {
			$(".base_gen").hide("fast");
		}
	});

	$("#output_htmlv").click(function () {
		if ($("#output_htmlv").attr('checked')) {
			$(".htmlv_settings").show("fast");
		} else {
			$(".htmlv_settings").hide("fast");
		}
	});

	$("#lbp_setting_detail").click(function () {
		$('#lbp_detail').toggle('fast')
	});

	$("#use_perpage").click(function () {
		if ($("#use_perpage").attr('checked')) {
			$(".base_blog").show("fast");
		} else {
			$(".base_blog").hide("fast");
		}
	});

	$("#rel").click(function () {
		if ($("#rel").attr('checked')) {
			$(".grouping_prim").hide("fast");
		} else {
			$(".grouping_prim").show("fast");
		}
	});

	$("#use_class_method").click(function () {
		if ($("#use_class_method").attr("checked")) {
			$(".primary_class_name").show("fast");
		} else {
			$(".primary_class_name").hide("fast");
		}
	});

	$("#retina_url").click(function () {
		if ($("#retina_url").attr("checked")) {
			$(".retina_suffix").show("fast");
		} else {
			$(".retina_suffix").hide("fast");
		}
	});

	$("#retina_url_sec").click(function () {
		if ($("#retina_url_sec").attr("checked")) {
			$(".retina_suffix_sec").show("fast");
		} else {
			$(".retina_suffix_sec").hide("fast");
		}
	});

	$("#slideshow").click(function () {
		if ($("#slideshow").attr('checked')) {
			$(".slideshow_prim").show("fast");
		} else {
			$(".slideshow_prim").hide("fast");
		}
	});

	$("#rel_sec").click(function () {
		if ($("#rel_sec").attr('checked')) {
			$(".grouping_sec").hide("fast");
		} else {
			$(".grouping_sec").show("fast");
		}
	});

	$("#slideshow_sec").click(function () {
		if ($("#slideshow_sec").attr('checked')) {
			$(".slideshow_sec").show("fast");
		} else {
			$(".slideshow_sec").hide("fast");
		}
	});

	$("#lightboxplus_style").change(function () {
		var style = $(this).attr('value');
		$('#lbp-style-screenshot').find(".lbp-sample-current").hide(0).removeClass('lbp-sample-current').addClass('lbp-sample');
		$('#lbp-style-screenshot').find("#lbp-sample-" + style).show(0).addClass('lbp-sample-current').removeClass('lbp-sample');
	});

	if ($('.fade-notice').length) {
		$(".fade-notice").fadeOut(9000);
	}

	/**
	 * callback handler for save settings base lightbox form submit
	 */
	$("#lightboxplus-settings").submit(function (e) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
			{
				url    : formURL,
				type   : "POST",
				data   : postData,
				success: function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=basic';
				},
				error  : function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=basic-error';
				}
			});
		e.preventDefault(); //STOP default action
		//e.off(); //unbind. To stop multiple form submit this throws an error
	});

	/**
	 * callback handler for save settings primary lightbox form submit
	 */
	$("#lightboxplus-settings-primary").submit(function (e) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
			{
				url    : formURL,
				type   : "POST",
				data   : postData,
				success: function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=primary';
				},
				error  : function () {

					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=primary-error';
				}
			});
		e.preventDefault(); //STOP default action
		//e.off(); //unbind. To stop multiple form submit this throws an error
	});

	/**
	 * callback handler for save settings secondary lightbox form submit
	 */
	$("#lightboxplus-settings-secondary").submit(function (e) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
			{
				url    : formURL,
				type   : "POST",
				data   : postData,
				success: function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=secondary';
				},
				error  : function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=secondary-error';
				}
			});
		e.preventDefault(); //STOP default action
		//e.off(); //unbind. To stop multiple form submit this throws an error
	});

	/**
	 * callback handler for save settings inline lightbox form submit
	 */
	$("#lightboxplus-settings-inline").submit(function (e) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
			{
				url    : formURL,
				type   : "POST",
				data   : postData,
				success: function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=inline';
				},
				error  : function () {
					window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=inline-error';
				}
			});
		e.preventDefault(); //STOP default action
		//e.off(); //unbind. to stop multiple form submit.
	});

	/**
	 * callback handler for save settings reset lightbox form submit
	 */
	$("#lightboxplus-settings-reset").submit(function (e) {
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		var r = confirm("Reset all Lightbox Plus Colorbox settings?");
		if (r == true) {
			$.ajax(
				{
					url    : formURL,
					type   : "POST",
					data   : postData,
					success: function () {
						window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=reset';
					},
					error  : function () {
						window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=reset-error';
					}
				});
		} else {
			window.location.href = "//" + window.location.host + window.location.pathname + '?page=lightboxplus&message=reset-cancel';
		}
		e.preventDefault(); //STOP default action
		//e.off(); //unbind. to stop multiple form submit.
	});
});