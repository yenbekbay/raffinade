/*!
 * jQuery Smooth Scroll Plugin v1.4
 *
 * Date: Mon Apr 25 00:02:30 2011 EDT
 * Requires: jQuery v1.3+
 *
 * Copyright 2010, Karl Swedberg
 * Dual licensed under the MIT and GPL licenses (just like jQuery):
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
*/
(function(c){function k(b){return b.replace(/^\//,"").replace(/(index|default).[a-zA-Z]{3,4}$/,"").replace(/\/$/,"")}var l=k(location.pathname),m=function(b){var d=[],a=false,e=b.dir&&b.dir=="left"?"scrollLeft":"scrollTop";this.each(function(){if(!(this==document||this==window)){var f=c(this);if(f[e]()>0)d.push(this);else{f[e](1);a=f[e]()>0;f[e](0);a&&d.push(this)}}});if(b.el==="first"&&d.length)d=[d.shift()];return d};c.fn.extend({scrollable:function(b){return this.pushStack(m.call(this,{dir:b}))},
firstScrollable:function(b){return this.pushStack(m.call(this,{el:"first",dir:b}))},smoothScroll:function(b){b=b||{};var d=c.extend({},c.fn.smoothScroll.defaults,b);this.die("click.smoothscroll").live("click.smoothscroll",function(a){var e=c(this),f=location.hostname===this.hostname||!this.hostname,g=d.scrollTarget||(k(this.pathname)||l)===l,i=this.hash,h=true;if(!d.scrollTarget&&(!f||!g||!i))h=false;else{f=d.exclude;g=0;for(var j=f.length;h&&g<j;)if(e.is(f[g++]))h=false;f=d.excludeWithin;g=0;for(j=
f.length;h&&g<j;)if(e.closest(f[g++]).length)h=false}if(h){d.scrollTarget=b.scrollTarget||i;d.link=this;a.preventDefault();c.smoothScroll(d)}});return this}});c.smoothScroll=function(b,d){var a,e,f,g=0;e="offset";var i="scrollTop",h={};if(typeof b==="number"){a=c.fn.smoothScroll.defaults;f=b}else{a=c.extend({},c.fn.smoothScroll.defaults,b||{});if(a.scrollElement){e="position";a.scrollElement.css("position")=="static"&&a.scrollElement.css("position","relative")}f=d||c(a.scrollTarget)[e]()&&c(a.scrollTarget)[e]()[a.direction]||
0}a=c.extend({link:null},a);i=a.direction=="left"?"scrollLeft":i;if(a.scrollElement){e=a.scrollElement;g=e[i]()}else e=c("html, body").firstScrollable();h[i]=f+g+a.offset;e.animate(h,{duration:a.speed,easing:a.easing,complete:function(){a.afterScroll&&c.isFunction(a.afterScroll)&&a.afterScroll.call(a.link,a)}})};c.smoothScroll.version="1.4";c.fn.smoothScroll.defaults={exclude:[],excludeWithin:[],offset:0,direction:"top",scrollElement:null,scrollTarget:null,afterScroll:null,easing:"swing",speed:1500}})(jQuery);

jQuery(document).ready(function() {
	jQuery('a.top').smoothScroll();
	jQuery('a.comment-jump').smoothScroll();
	jQuery('a.comments-count').smoothScroll();
});

/**
 * jQuery The Silky Smooth Marquee
 * Copyright, Remy Sharp
 * http://remysharp.com/tag/marquee
*/

(function($){$.fn.marquee=function(klass){var newMarquee=[],last=this.length;function getReset(newDir,marqueeRedux,marqueeState){var behavior=marqueeState.behavior,width=marqueeState.width,dir=marqueeState.dir;var r=0;if(behavior=='alternate'){r=newDir==1?marqueeRedux[marqueeState.widthAxis]-(width*2):width}else if(behavior=='slide'){if(newDir==-1){r=dir==-1?marqueeRedux[marqueeState.widthAxis]:width}else{r=dir==-1?marqueeRedux[marqueeState.widthAxis]-(width*2):0}}else{r=newDir==-1?marqueeRedux[marqueeState.widthAxis]:0}return r}function animateMarquee(){var i=newMarquee.length,marqueeRedux=null,$marqueeRedux=null,marqueeState={},newMarqueeList=[],hitedge=false;while(i--){marqueeRedux=newMarquee[i];$marqueeRedux=$(marqueeRedux);marqueeState=$marqueeRedux.data('marqueeState');if($marqueeRedux.data('paused')!==true){marqueeRedux[marqueeState.axis]+=(marqueeState.scrollamount*marqueeState.dir);hitedge=marqueeState.dir==-1?marqueeRedux[marqueeState.axis]<=getReset(marqueeState.dir*-1,marqueeRedux,marqueeState):marqueeRedux[marqueeState.axis]>=getReset(marqueeState.dir*-1,marqueeRedux,marqueeState);if((marqueeState.behavior=='scroll'&&marqueeState.last==marqueeRedux[marqueeState.axis])||(marqueeState.behavior=='alternate'&&hitedge&&marqueeState.last!=-1)||(marqueeState.behavior=='slide'&&hitedge&&marqueeState.last!=-1)){if(marqueeState.behavior=='alternate'){marqueeState.dir*=-1}marqueeState.last=-1;$marqueeRedux.trigger('stop');marqueeState.loops--;if(marqueeState.loops===0){if(marqueeState.behavior!='slide'){marqueeRedux[marqueeState.axis]=getReset(marqueeState.dir,marqueeRedux,marqueeState)}else{marqueeRedux[marqueeState.axis]=getReset(marqueeState.dir*-1,marqueeRedux,marqueeState)}$marqueeRedux.trigger('end')}else{newMarqueeList.push(marqueeRedux);$marqueeRedux.trigger('start');marqueeRedux[marqueeState.axis]=getReset(marqueeState.dir,marqueeRedux,marqueeState)}}else{newMarqueeList.push(marqueeRedux)}marqueeState.last=marqueeRedux[marqueeState.axis];$marqueeRedux.data('marqueeState',marqueeState)}else{newMarqueeList.push(marqueeRedux)}}newMarquee=newMarqueeList;if(newMarquee.length){setTimeout(animateMarquee,25)}}this.each(function(i){var $marquee=$(this),width=$marquee.attr('width')||$marquee.width(),height=$marquee.attr('height')||$marquee.height(),$marqueeRedux=$marquee.after('<div '+(klass?'class="'+klass+'" ':'')+'style="display: block-inline; width: '+width+'px; height: '+height+'px; overflow: hidden;"><div style="float: left; white-space: nowrap;">'+$marquee.html()+'</div></div>').next(),marqueeRedux=$marqueeRedux.get(0),hitedge=0,direction=($marquee.attr('direction')||'left').toLowerCase(),marqueeState={dir:/down|right/.test(direction)?-1:1,axis:/left|right/.test(direction)?'scrollLeft':'scrollTop',widthAxis:/left|right/.test(direction)?'scrollWidth':'scrollHeight',last:-1,loops:$marquee.attr('loop')||-1,scrollamount:$marquee.attr('scrollamount')||this.scrollAmount||2,behavior:($marquee.attr('behavior')||'scroll').toLowerCase(),width:/left|right/.test(direction)?width:height};if($marquee.attr('loop')==-1&&marqueeState.behavior=='slide'){marqueeState.loops=1}$marquee.remove();if(/left|right/.test(direction)){$marqueeRedux.find('> div').css('padding','0 '+width+'px')}else{$marqueeRedux.find('> div').css('padding',height+'px 0')}$marqueeRedux.bind('stop',function(){$marqueeRedux.data('paused',true)}).bind('pause',function(){$marqueeRedux.data('paused',true)}).bind('start',function(){$marqueeRedux.data('paused',false)}).bind('unpause',function(){$marqueeRedux.data('paused',false)}).data('marqueeState',marqueeState);newMarquee.push(marqueeRedux);marqueeRedux[marqueeState.axis]=getReset(marqueeState.dir,marqueeRedux,marqueeState);$marqueeRedux.trigger('start');if(i+1==last){animateMarquee()}});return $(newMarquee)};$(function(){$('marquee').marquee('pointer').mouseover(function(){$(this).trigger('stop')}).mouseout(function(){$(this).trigger('start')}).mousemove(function(event){if($(this).data('drag')==true){this.scrollLeft=$(this).data('scrollX')+($(this).data('x')-event.clientX)}}).mousedown(function(event){$(this).data('drag',true).data('x',event.clientX).data('scrollX',this.scrollLeft)}).mouseup(function(){$(this).data('drag',false)})})}(jQuery));

jQuery(document).ready(function() {

/** Likes */
function exultic_reload_likes(who) {
	var text = jQuery("#" + who).html();
	var patt= /(\d)+/;

	var num = patt.exec(text);
	num[0]++;
	text = text.replace(patt,num[0]);
	jQuery("#" + who).html('<span>' + text + '</span>');
}

function exultic_like_init() {
	jQuery(".likes-count").click(function() {
		var classes = jQuery(this).attr("class");
		classes = classes.split(" ");

		if(classes[1] == "active") {
			return false;
		}
		var classes = jQuery(this).addClass("active");
		var id = jQuery(this).attr("id");
		id = id.split("like-");
		jQuery.ajax({
		  type: "POST",
		  url: "index.php",
		  data: "likepost=" + id[1],
		  success: exultic_reload_likes("like-" + id[1])
		}); 

		return false;
	});
}

exultic_like_init();

/** Pretty Photo */
$("a[rel^='prettyPhoto']").prettyPhoto({ "overlay_gallery": false, "deeplinking": false, "show_title": false, "social_tools": false });

/** Comments Reply */
$('.comment-reply-link').click(function(){
	$(this).parent().parent().parent().addClass('comment-respond');
	$(this).css('opacity','0').css('visibility','hidden');
});
$('#cancel-comment-reply-link').click(function(){
	$(this).parent().parent().parent().parent().children().removeClass('comment-respond');
	$(this).parent().parent().parent().parent().find('.comment-reply-link').css('opacity','1').css('visibility','visible');
});
	
/** Convert all <video> and <audio> tags to MediaElement.js using jQuery */	
$('video,audio').mediaelementplayer();

/** Enable Superfish menu */	
$('ul.menu').superfish();

$('.soundcloud iframe[height="166"]').addClass('track');
	
});