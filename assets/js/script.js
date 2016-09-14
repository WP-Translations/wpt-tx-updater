jQuery(document).ready(function($) {

	$(".wptxu-update-tx").live( "click", function(e) {
		e.preventDefault();

		project = $(this).attr('data-project');
		$("#wptxu-adminbar-response-" + project).empty();
		$("#wptxu-post-response-" + project).empty();

		$.ajax({
			type: "POST",
			url: wptxu_ajax.ajaxurl,
			data: {
				'action': 'wptxu_update_translation',
				'project': project,
				'nonce': wptxu_ajax.wptxu_nonce,
			},
			beforeSend: function() {
				$("#wptxu-adminbar-response-" + project).append("<li class='check-api'><span class='wptxu-spin dashicons dashicons-update'></span>&nbsp;" + wptxu_ajax.ajax_loading.ajax_loading + '</li>').slideDown('slow');
				$('#wptxu-spinner-post').addClass('is-active');
			},
			success: function(response) {
				$('.check-api').remove();
				$('#wptxu-spinner-post').removeClass('is-active');
				$("#wptxu-adminbar-response-" + project).append(response).slideDown("slow");
				$("#wptxu-post-response-" + project).append(response).slideDown("slow");
			}
		});

	});

	$('#wptxu_license_activate').live( "click", function(e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: wptxu_ajax.ajaxurl,
			data: {
				'action': 'wptxu_activate_license',
				'wptxu_nonce': wptxu_ajax.wptxu_nonce,
			},
			beforeSend: function(reponse) {
				$('#wptxu-spinner-key').addClass('is-active');
			},
			success: function(response) {
				$('#wptxu-spinner-key').removeClass('is-active');
				$('#wptxu-key-response').html(response);
			},
			fail: function() {
				$('h1').after('<div class="wptxu-error"><p>' + wptxu_ajax.ajax_fail.ajax_fail + '</p></div>');
			}

		});

	});

	$('#wptxu_license_deactivate').live( "click", function(e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: wptxu_ajax.ajaxurl,
			data: {
				'action': 'wptxu_deactivate_license',
				'wptxu_nonce': wptxu_ajax.wptxu_nonce,
			},
			beforeSend: function(reponse) {
				$('#wptxu-spinner-key').addClass('is-active');
			},
			success: function(response) {
				$('#wptxu-spinner-key').removeClass('is-active');
				$('#wptxu-key-response').html(response);
				$('#wptxu-sl-key').val('');
				$('h1').after('<div class="updated notice is-dismissible"><p>' + wptxu_ajax.license_deactivate.license_deactivate + '</p></div>');
			},
			fail: function() {
				$('h1').after('<div class="wptxu-error"><p>' + wptxu_ajax.ajax_fail.ajax_fail + '</p></div>');
			}
		});

	});

});
