jQuery(document).ready(function () {

    /* If there are required actions, add an icon with the number of required actions in the About dignified page -> Actions required tab */
    var dignified_nr_actions_required = dignifiedWelcomeScreenObject.nr_actions_required;

    if ((typeof dignified_nr_actions_required !== 'undefined') && (dignified_nr_actions_required != '0')) {
        jQuery('li.dignified-w-red-tab a').append('<span class="dignified-actions-count">' + dignified_nr_actions_required + '</span>');
    }


    /* Dismiss required actions */
    jQuery(".dignified-required-action-button").click(function () {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type      : "GET",
            data      : { action: 'dignified_dismiss_required_action', id: id, todo: action },
            dataType  : "html",
            url       : dignifiedWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.dignified-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + dignifiedWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success   : function (data) {
                location.reload();
                jQuery("#temp_load").remove();
                /* Remove loading gif */
            },
            error     : function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });
    
    /* Dismiss recommended plugins */
    jQuery(".dignified-recommended-plugin-button").click(function () {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type      : "GET",
            data      : { action: 'dignified_dismiss_recommended_plugins', id: id, todo: action },
            dataType  : "html",
            url       : dignifiedWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.dignified-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + dignifiedWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success   : function (data) {
                location.reload();
                jQuery("#temp_load").remove();
                /* Remove loading gif */
            },
            error     : function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });


    // Add automatic frontpage
    jQuery('#set_page_automatic').click(function(evt){
        evt.preventDefault();
        var parent = jQuery(this).parent().parent();
        var container = jQuery(this).parent().parent().parent();

        jQuery.ajax({
            type: "GET",
            data: {action: 'dignified_set_frontpage' },
            dataType: "html",
            url: dignifiedWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                parent.append('<div id="temp_load" style="text-align:center"><img src="' + dignifiedWelcomeScreenObject.template_directory + '/inc/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                location.reload();
                jQuery("#temp_load").remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

});
