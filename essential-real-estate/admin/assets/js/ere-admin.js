(function ($) {
    'use strict';
    $(document).ready(function () {
        $('.tips, .help_tip').tipTip({
            'attribute': 'data-tip',
            'fadeIn': 50,
            'fadeOut': 50,
            'delay': 200
        });
        var css_class_wrap = '.ere-property-select-meta-box-wrap';
        var ajax_url = ere_admin_vars.ajax_url;
        var ere_get_states_by_country = function () {
            var $this = $(".ere-property-country-ajax", css_class_wrap);
            if ($this.length) {
                var selected_country = $this.val();
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: {
                        'action': 'ere_get_states_by_country_ajax',
                        'country': selected_country,
                        'type': 0
                    },
                    beforeSend: function () {
                        $this.parent().children('.ere-loading').remove();
                        $this.parent().append('<span class="ere-loading"><i class="fa fa-spinner fa-spin"></i></span>');
                    },
                    success: function (response) {
                        $(".ere-property-state-ajax", css_class_wrap).html(response);
                        var val_selected = $(".ere-property-state-ajax", css_class_wrap).attr('data-selected');
                        if (val_selected != 'undefined') {
                            $(".ere-property-state-ajax", css_class_wrap).val(val_selected);
                        }
                        $this.parent().children('.ere-loading').remove();
                    },
                    error: function () {
                        $this.parent().children('.ere-loading').remove();
                    },
                    complete: function () {
                        $this.parent().children('.ere-loading').remove();
                    }
                });
            }
        };
        ere_get_states_by_country();

        $(".ere-property-country-ajax", css_class_wrap).on('change', function () {
            ere_get_states_by_country();
        });

        var ere_get_cities_by_state = function () {
            var $this = $(".ere-property-state-ajax", css_class_wrap);
            if ($this.length) {
                var selected_state = $this.val();
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: {
                        'action': 'ere_get_cities_by_state_ajax',
                        'state': selected_state,
                        'type': 0
                    },
                    beforeSend: function () {
                        $this.parent().children('.ere-loading').remove();
                        $this.parent().append('<span class="ere-loading"><i class="fa fa-spinner fa-spin"></i></span>');
                    },
                    success: function (response) {
                        $(".ere-property-city-ajax", css_class_wrap).html(response);
                        var val_selected = $(".ere-property-city-ajax", css_class_wrap).attr('data-selected');
                        if (val_selected != 'undefined') {
                            $(".ere-property-city-ajax", css_class_wrap).val(val_selected);
                        }
                        $this.parent().children('.ere-loading').remove();
                    },
                    error: function () {
                        $this.parent().children('.ere-loading').remove();
                    },
                    complete: function () {
                        $this.parent().children('.ere-loading').remove();
                    }
                });
            }
        };
        ere_get_cities_by_state();

        $(".ere-property-state-ajax", css_class_wrap).on('change', function () {
            ere_get_cities_by_state();
        });

        var ere_get_neighborhoods_by_city = function () {
            var $this = $(".ere-property-city-ajax", css_class_wrap);
            if ($this.length) {
                var selected_city = $this.val();
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: {
                        'action': 'ere_get_neighborhoods_by_city_ajax',
                        'city': selected_city,
                        'type': 0
                    },
                    beforeSend: function () {
                        $this.parent().children('.ere-loading').remove();
                        $this.parent().append('<span class="ere-loading"><i class="fa fa-spinner fa-spin"></i></span>');
                    },
                    success: function (response) {
                        $(".ere-property-neighborhood-ajax", css_class_wrap).html(response);
                        var val_selected = $(".ere-property-neighborhood-ajax", css_class_wrap).attr('data-selected');
                        if (val_selected != 'undefined') {
                            $(".ere-property-neighborhood-ajax", css_class_wrap).val(val_selected);
                        }
                        $this.parent().children('.ere-loading').remove();
                    },
                    error: function () {
                        $this.parent().children('.ere-loading').remove();
                    },
                    complete: function () {
                        $this.parent().children('.ere-loading').remove();
                    }
                });
            }
        };
        ere_get_neighborhoods_by_city();

        $(".ere-property-city-ajax", css_class_wrap).on('change', function () {
            ere_get_neighborhoods_by_city();
        });
    });
})(jQuery);