!function(){define(["scripts/upfront/upfront-views-editor/presets/button/collection"],function(t){return function(t){var n=function(){var t=_.debounce(e,100);button_presets_collection.on("add remove edit",t)},e=function(){var t={action:"upfront_update_button_presets",button_presets:button_presets_collection.toJSON()};Upfront.Util.post(t).error(function(){return notifier.addMessage(l10n.button_presets_save_fail)})};n()}})}();