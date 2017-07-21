!function(t){var e=Upfront.Settings&&Upfront.Settings.l10n?Upfront.Settings.l10n.global.views:Upfront.mainData.l10n.global.views;define(["scripts/upfront/inline-panels/inline-panels","scripts/upfront/upfront-views-editor/region/region-panel-add"],function(i,o){return i.Panels.extend({className:"upfront-inline-panels upfront-region-panels upfront-ui",initialize:function(){this.model.get("container"),this.model.get("name");this.listenTo(this.model.collection,"add",this.render),this.listenTo(this.model.collection,"remove",this.render),this.listenTo(this.model.get("properties"),"change",this.render),this.listenTo(this.model.get("properties"),"add",this.render),this.listenTo(this.model.get("properties"),"remove",this.render),this.listenTo(Upfront.Events,"entity:region:activated",this.on_region_active),this.listenTo(Upfront.Events,"entity:region:deactivated",this.on_region_deactive),this.add_panel_top=new o({model:this.model,to:"top"}),this.add_panel_bottom=new o({model:this.model,to:"bottom"}),this.model.is_main()&&this.model.get("allow_sidebar")&&(this.add_panel_left=new o({model:this.model,to:"left"}),this.add_panel_right=new o({model:this.model,to:"right"}))},panels:function(){var t=_([]),e=this.model.collection;if(_.isUndefined(e))return this._panels=t,t;var i=e.index_container(this.model,["shadow","lightbox"]),o=(e.total_container(["shadow","lightbox"]),0==i),n="full"==this.model.get("type");if(this.model.is_main()){var s=this.model.get_sub_regions();n&&o||t.push(this.add_panel_top),this.model.get("allow_sidebar")&&(s.left===!1&&t.push(this.add_panel_left),s.right===!1&&t.push(this.add_panel_right)),t.push(this.add_panel_bottom)}return this._panels=t,t},on_render:function(){this.update_pos()},on_scroll:function(t){var e=t.data;e.update_pos()},on_region_active:function(e){if(e.model==this.model){var i=t(Upfront.Settings.LayoutEditor.Selectors.main);i.hasClass("upfront-region-editing")&&(this.on_active(),this.listenToOnce(Upfront.Events,"sidebar:toggle:done",this.update_pos),t(window).on("scroll",this,this.on_scroll))}},on_region_deactive:function(){t(window).off("scroll",this,this.on_scroll)},update_pos:function(){var e=t(Upfront.Settings.LayoutEditor.Selectors.main),i=this.$el.closest(".upfront-region-container"),o=this.$el.closest(".upfront-region"),n=i.find(".upfront-region-side-top"),s=i.find(".upfront-region-side-bottom");if((e.hasClass("upfront-region-editing")||e.hasClass("upfront-region-fixed-editing")||e.hasClass("upfront-region-lightbox-editing"))&&i.hasClass("upfront-region-container-active")){var l=this,d=o.offset(),r=d.top,a=r+o.outerHeight(),p=n.length?n.outerHeight():0,f=s.length?s.outerHeight():0,g=t(window).height(),h=t(document).scrollTop(),_=h+g-f,c=e.offset().top+p;this.add_responsive_items(),this._panels.each(function(e){var i=e.$el.offset();if("top"==e.position_v&&h>r-c&&h<a-c)"fixed"!=e.$el.css("position")&&e.$el.css({position:"fixed",top:c,left:i.left,right:"auto"});else if("bottom"==e.position_v&&a>_&&r<_)"fixed"!=e.$el.css("position")&&e.$el.css({position:"fixed",bottom:f,left:i.left,right:"auto"});else if("center"==e.position_v&&(h>r-c||a>_)){var o=h>r-c?c:r-h,n=a>_?0:_-a,s="left"==e.position_h?i.left:"auto",l="right"==e.position_h?t(window).width()-i.left-e.$el.width():"auto";"fixed"!=e.$el.css("position")?e.$el.css({position:"fixed",top:o,bottom:n,left:s,right:l}):e.$el.css({top:o,bottom:n})}else e.$el.css({position:"",top:"",bottom:"",left:"",right:""})}),setTimeout(function(){l.update_padding()},300)}},update_padding:function(){var t={},e=this.$el.closest(".upfront-region");this.model.get("properties").each(function(e){t[e.get("name")]=e.get("value")});var i,o,n=("undefined"!=typeof Upfront.Settings.LayoutEditor.Theme.breakpoints?Upfront.Settings.LayoutEditor.Theme.breakpoints:[],"undefined"!=typeof Upfront.Settings.LayoutEditor.CurrentBreakpoint?Upfront.Settings.LayoutEditor.CurrentBreakpoint:"desktop"),s="default"===n?n:n.id,l="undefined"!=typeof t.breakpoint&&"undefined"!=typeof t.breakpoint[s]&&t.breakpoint[s];i="undefined"!=typeof l.top_bg_padding_num?l.top_bg_padding_num:"undefined"!=typeof t.top_bg_padding_num&&t.top_bg_padding_num,o="undefined"!=typeof l.bottom_bg_padding_num?l.bottom_bg_padding_num:"undefined"!=typeof t.bottom_bg_padding_num&&t.bottom_bg_padding_num,e.css({"padding-top":!1===i?"":i+"px","padding-bottom":!1===o?"":o+"px"})},add_responsive_items:function(){var i=this,o=i.$el.parents(".upfront-region"),n=i.model.get_sub_regions(),s=t('<span class="open-responsive-item-controls"></span>'),l=t('<div class="responsive-item-controls">'+e.add_region+"</div>"),d=t('<div class="responsive-item-control responsive-add-region-top">'+e.above+"</div>"),r=t('<div class="responsive-item-control responsive-add-region-bottom">'+e.below+"</div>"),a=t('<div class="responsive-item-control responsive-add-region-left">'+e.left_sidebar+"</div>"),p=t('<div class="responsive-item-control responsive-add-region-right">'+e.right_sidebar+"</div>");0===o.find(".open-responsive-item-controls").length&&(s.click(function(){o.toggleClass("controls-visible")}),o.append(s)),d.click(function(){i.add_panel_top.$el.find(".upfront-icon").trigger("click"),o.toggleClass("controls-visible")}),l.append(d),r.click(function(){i.add_panel_bottom.$el.find(".upfront-icon").trigger("click"),o.toggleClass("controls-visible")}),l.append(r),i.model.is_main()&&this.model.get("allow_sidebar")&&(n.left===!1&&(a.click(function(){i.add_panel_left.$el.find(".upfront-icon").trigger("click"),o.toggleClass("controls-visible")}),l.append(a)),n.right===!1&&(p.click(function(){i.add_panel_right.$el.find(".upfront-icon").trigger("click"),o.toggleClass("controls-visible")}),l.append(p))),o.find(".responsive-item-controls").remove(),o.append(l)},remove:function(){this.add_panel_top.remove(),this.add_panel_bottom.remove(),this.edit_panel=!1,this.delete_panel=!1,this.add_panel_top=!1,this.add_panel_bottom=!1,this.model.is_main()&&this.model.get("allow_sidebar")&&(this.add_panel_left.remove(),this.add_panel_right.remove(),this.add_panel_left=!1,this.add_panel_right=!1),t(window).off("scroll",this,this.on_scroll),Backbone.View.prototype.remove.call(this)}})})}(jQuery);