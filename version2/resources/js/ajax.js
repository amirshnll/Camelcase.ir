jQuery(document).ready(function(a){var e=parseInt(cryout_ajax_more.page_number_next),o=parseInt(cryout_ajax_more.page_number_max),r=cryout_ajax_more.page_link_model;e<=o&&(a(cryout_ajax_more.content_css_selector).append('<div id="cryout_ajax_more_trigger"><span>{loadmore}</span></div>'.replace("{loadmore}",cryout_ajax_more.load_more_str)),a(cryout_ajax_more.pagination_css_selector).remove()),a("#cryout_ajax_more_trigger").click(function(){if(a(this).addClass("cryout_click_loading"),e<=o){var t=r.replace(/9999999/,e);a("<div>").load(t+" .post",function(){$data=a(this).find("article.post"),$data.each(function(){a(this).css("opacity","0").appendTo("#content-masonry")}),1==cryout_theme_settings.masonry&&1!=cryout_theme_settings.magazine?($data.each(function(){a(this).css("opacity","0").appendTo("#content-masonry")}),a("#content-masonry").imagesLoaded(function(){1==cryout_theme_settings.fitvids?a("#content-masonry").fitVids().masonry("appended",$data):a("#content-masonry").masonry("appended",$data),cryout_theme_settings.articleanimation&&animateScroll($data),a("#cryout_ajax_more_trigger").removeClass("cryout_click_loading")})):($data.each(function(){a(this).css({opacity:"1",transform:"none","-webkit-transform":"none"}).appendTo("#content-masonry")}),1==cryout_theme_settings.fitvids&&a(this).fitVids(),cryout_theme_settings.articleanimation&&animateScroll($data),a("#cryout_ajax_more_trigger").removeClass("cryout_click_loading")),o<++e&&a("#cryout_ajax_more_trigger").remove()})}return!1})});