define(
    [
        'jquery',
        'mousetrap',
        'Magento_Ui/js/modal/modal',
        'ko',
        'uiComponent',
        'collapsible'
    ],
    function ($, Mousetrap, modal, ko, Component) {

        (function(Mousetrap) {
            var _globalCallbacks = {};
            var _originalStopCallback = Mousetrap.prototype.stopCallback;

            Mousetrap.prototype.stopCallback = function(e, element, combo, sequence) {
                var self = this;

                if (self.paused) {
                    return true;
                }

                /** Customisation for applying filters automatically **/
                if (combo == 'enter' && jQuery(element).parents('div[data-part="filter-form"]').length) {
                    jQuery(element).trigger('blur');
                    return false;
                }

                if (_globalCallbacks[combo] || _globalCallbacks[sequence]) {
                    return false;
                }

                return _originalStopCallback.call(self, e, element, combo);
            };

            Mousetrap.init();
        }) (Mousetrap);

        return Component.extend({
            defaults: {
                template: 'Brabs_AdminShortcuts/adminshortcuts'
            },

            next: ko.observable(),
            previous: ko.observable(),
            shortcuts: ko.observable(),

            initialize: function (config) {
                var self = this;
                this.next(config.next);
                this.previous(config.previous);
                this.shortcuts(config.shortcuts);
                this._super();

                config.shortcuts.forEach(function(val) {
                    Mousetrap.bind(val['shortcut'],
                        function()
                        {
                            self.execShortcut(val['id'], val['params']);
                        });
                });

                /* Open keyboard shortcut modal info window */
                Mousetrap.bind('?', function() { self.openModal(); });

                /* Open Filters */
                Mousetrap.bind('/', function() {
                    jQuery("button[data-action='grid-filter-expand']").click();
                    return false;
                });

                /* Apply filter on enter */
                Mousetrap.bind('enter', function() {
                    jQuery('button[data-action="grid-filter-apply"]').click();
                });

                /* Pagination on grids */
                /* Previous */
                Mousetrap.bind(config.previous, function() {
                    jQuery('.admin__data-grid-pager').find('button.action-previous').click();
                });
                /* Next */
                Mousetrap.bind(config.next, function() {
                    jQuery('.admin__data-grid-pager').find('button.action-next').click();
                });

                /* Global Search */
                Mousetrap.bind('shift+f', function() {
                    jQuery('.search-global-label').click();
                    return false;
                });
            },

            format: function (short) {
                short = short.replace(/ /gm, "-----");
                short = short.replace( /([a-zA-Z0-9]+)/gm, "<span class='key'>$1</span>");
                short = short.replace(/-----/gm, " then ");
                short = short.replace(/\+/gm, " + ");
                return short;
            },

            openModal: function() {

                this.modal = jQuery('#brabs-admin-shortcuts-modal').modal({
                    modalClass: 'modal-system-messages ui-popup-message',
                    type: 'popup',
                    buttons: []
                });

                jQuery("#brabs-admin-shortcuts-modal").removeClass("hidden");

                this.modal.modal('openModal');

            },

            execShortcut: function(cssClass, params) {
                var href = jQuery("li[data-ui-id='" + cssClass + "'] a").attr("href");
                if (href) {
                    window.setLocation(href.replace(/\/$/, "") + "/" + params.replace(/^\//, ""));
                } else {
                    alert("Shortcut not available");
                }
            }
        });
    }
);