!function(e){Upfront.Settings&&Upfront.Settings.l10n?Upfront.Settings.l10n.global.views:Upfront.mainData.l10n.global.views;define(["scripts/upfront/upfront-views-editor/mixins","scripts/perfect-scrollbar/perfect-scrollbar"],function(t,n){return Backbone.View.extend(_.extend({},t.Upfront_Scroll_Mixin,{tagName:"li",className:"sidebar-panel",events:{"click .sidebar-panel-title":"on_click","click .sidebar-panel-tab":"show_tab"},get_title:function(){return""},render:function(){var e=this;this.active?this.$el.addClass("active"):this.$el.removeClass("active"),this.$el.html('<h3 class="sidebar-panel-title">'+this.get_title()+'</h3><div class="sidebar-panel-content" />'),this.stop_scroll_propagation(this.$el.find(".sidebar-panel-content")),this.sections&&(e.$el.find(".sidebar-panel-title").after("<ul class='sidebar-panel-tabspane'></ul>"),this.sections.each(function(t){t.render(),e.$el.find(".sidebar-panel-tabspane").append("<li data-target='"+t.cid+"' class='sidebar-panel-tab'>"+t.get_title()+"</li>"),e.$el.find(".sidebar-panel-content").append("<div class='sidebar-tab-content' id='"+t.cid+"'></div>"),e.$el.find(".sidebar-panel-content").find(".sidebar-tab-content").last().html(t.el),n.withDebounceUpdate(e.$el.find(".sidebar-panel-content")[0],!0,"entity:object:refresh",!0)})),this.on_render&&this.on_render(),this.$el.find(".sidebar-panel-tab").first().addClass("active"),this.$el.find(".sidebar-tab-content").first().show()},get_section:function(e){return!!this.sections&&this.sections.find(function(t){return t.get_name()==e})},on_click:function(){e(".sidebar-panel").not(this.$el).removeClass("expanded"),this.$el.addClass("expanded"),e(".sidebar-panel").not(this.$el).find(".sidebar-panel-tabspane").hide(),this.$el.find(".sidebar-panel-tabspane").not(".sidebar-panel-tabspane-hidden").show(),n.withDebounceUpdate(this.$el.find(".sidebar-panel-content")[0],!1,!1,!1)},show_tab:function(t){var n="#"+e(t.target).data("target");this.$el.find(".sidebar-panel-tab").removeClass("active"),e(t.target).addClass("active"),this.$el.find(".sidebar-tab-content").hide(),this.$el.find(n).show()}}))})}(jQuery);