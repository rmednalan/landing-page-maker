!function(t){var e=Upfront.Settings&&Upfront.Settings.l10n?Upfront.Settings.l10n.global.views:Upfront.mainData.l10n.global.views;define(["scripts/upfront/upfront-views-editor/sidebar/sidebar-panel","scripts/upfront/upfront-views-editor/sidebar/sidebar-panel-settings-section-typography","scripts/upfront/upfront-views-editor/sidebar/sidebar-panel-settings-section-colors"],function(t,n,i){return t.extend({className:"sidebar-panel sidebar-panel-settings",initialize:function(){this.active=!0,this.global_option=!0,this.sections=_([new n({model:this.model}),new i({model:this.model})])},get_title:function(){return e.theme_settings},on_render:function(){Upfront.plugins.call("do-action-after-sidebar-settings-render",{settingsEl:this.$el})}})})}(jQuery);