/*
	Multiverse by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

jQuery.event.special.touchstart = {
	setup: function( _, ns, handle ) {
		this.addEventListener("touchstart", handle, { passive: true });
	}
};
jQuery.event.special.touchmove = {
	setup: function( _, ns, handle ) {
		this.addEventListener("touchmove", handle, { passive: true });
	}
};

(function($) {

	var	$window = $(window),
		$body = $('body'),
		$wrapper = $('#wrapper');

	// Breakpoints.
		breakpoints({
			xlarge:  [ '1281px',  '1680px' ],
			large:   [ '981px',   '1280px' ],
			medium:  [ '737px',   '980px'  ],
			small:   [ '481px',   '736px'  ],
			xsmall:  [ null,      '480px'  ]
		});

	// Hack: Enable IE workarounds.
		if (browser.name == 'ie')
			$body.addClass('ie');

	// Touch?
		if (browser.mobile)
			$body.addClass('touch');

	// Transitions supported?
		if (browser.canUse('transition')) {

			// Play initial animations on page load.
				$window.on('load', function() {
					window.setTimeout(function() {
						$body.removeClass('is-preload');
					}, 100);
				});

			// Prevent transitions/animations on resize.
				var resizeTimeout;

				$window.on('resize', function() {

					window.clearTimeout(resizeTimeout);

					$body.addClass('is-resizing');

					resizeTimeout = window.setTimeout(function() {
						$body.removeClass('is-resizing');
					}, 100);

				});

		}

	// Scroll back to top.
		$window.scrollTop(0);

	// Panels.
		var $panels = $('.panel');

		$panels.each(function() {

			var $this = $(this),
				$toggles = $('[href="#' + $this.attr('id') + '"]'),
				$closer = $('<div class="closer" />').appendTo($this);

			// Closer.
				$closer
					.on('click', function(event) {
						$this.trigger('---hide');
					});

			// Events.
				$this
					.on('click', function(event) {
						event.stopPropagation();
					})
					.on('---toggle', function() {

						if ($this.hasClass('active'))
							$this.triggerHandler('---hide');
						else
							$this.triggerHandler('---show');

					})
					.on('---show', function() {

						// Hide other content.
							if ($body.hasClass('content-active'))
								$panels.trigger('---hide');

						// Activate content, toggles.
							$this.addClass('active');
							$toggles.addClass('active');

						// Activate body.
							$body.addClass('content-active');

					})
					.on('---hide', function() {

						// Deactivate content, toggles.
							$this.removeClass('active');
							$toggles.removeClass('active');

						// Deactivate body.
							$body.removeClass('content-active');

					});

			// Toggles.
				$toggles
					.removeAttr('href')
					.css('cursor', 'pointer')
					.on('click', function(event) {

						event.preventDefault();
						event.stopPropagation();

						$this.trigger('---toggle');

					});

		});

		// Global events.
			$body
				.on('click', function(event) {

					if ($body.hasClass('content-active')) {

						event.preventDefault();
						event.stopPropagation();

						$panels.trigger('---hide');

					}

				});

			$window
				.on('keyup', function(event) {

					if (event.keyCode == 27
					&&	$body.hasClass('content-active')) {

						event.preventDefault();
						event.stopPropagation();

						$panels.trigger('---hide');

					}

				});

	// Header.
		var $header = $('#header');

		// Links.
			$header.find('a').each(function() {

				var $this = $(this),
					href = $this.attr('href');

				// Internal link? Skip.
					if (!href
					||	href.charAt(0) == '#')
						return;

				// Redirect on click.
					$this
						.removeAttr('href')
						.css('cursor', 'pointer')
						.on('click', function(event) {

							event.preventDefault();
							event.stopPropagation();

							window.location.href = href;

						});

			});

	// Footer.
		var $footer = $('#footer');

		// Copyright.
		// This basically just moves the copyright line to the end of the *last* sibling of its current parent
		// when the "medium" breakpoint activates, and moves it back when it deactivates.
			$footer.find('.copyright').each(function() {

				var $this = $(this),
					$parent = $this.parent(),
					$lastParent = $parent.parent().children().last();

				breakpoints.on('<=medium', function() {
					$this.appendTo($lastParent);
				});

				breakpoints.on('>medium', function() {
					$this.appendTo($parent);
				});

			});

	// Main.
		var $main = $('#main');

		// Thumbs.
			$main.children('.thumb').each(function() {

				var	$this = $(this),
					$image = $this.find('.image'), $image_img = $image.children('img'),
					x;

				// No image? Bail.
					if ($image.length == 0)
						// return;

				// Image.
				// This sets the background of the "image" <span> to the image pointed to by its child
				// <img> (which is then hidden). Gives us way more flexibility.

					// Set background.
						// $image.css('background-image', 'url(' + $image_img.attr('src') + ')');

					// Set background position.
						// if (x = $image_img.data('position'))
						// 	$image.css('background-position', x);

					// Hide original img.
						$image_img.hide();

			});

		// Poptrox.
			$main.poptrox({
				baseZIndex: 20000,
				caption: function($a) {

					var s = '';

					$a.nextAll().each(function() {
						s += this.outerHTML;
					});

					return s;

				},
				fadeSpeed: 300,
				onPopupClose: function() { $body.removeClass('modal-active'); },
				onPopupOpen: function() { $body.addClass('modal-active'); },
				overlayOpacity: 0,
				popupCloserText: '',
				popupHeight: 150,
				popupLoaderText: '',
				popupSpeed: 300,
				popupWidth: 150,
				selector: '.thumb > a.image',
				usePopupCaption: true,
				usePopupCloser: true,
				usePopupDefaultStyling: false,
				usePopupForceClose: true,
				usePopupLoader: true,
				usePopupNav: true,
				windowMargin: 50
			});

			// Hack: Set margins to 0 when 'xsmall' activates.
				breakpoints.on('<=xsmall', function() {
					$main[0]._poptrox.windowMargin = 0;
				});

				breakpoints.on('>xsmall', function() {
					$main[0]._poptrox.windowMargin = 50;
				});

})(jQuery);


//控制全屏
function enterfullscreen() { //进入全屏
    $("#fullscreen").html("退出全屏");
    var docElm = document.documentElement;
    //W3C
    if(docElm.requestFullscreen) {
        docElm.requestFullscreen();
    }
    //FireFox
    else if(docElm.mozRequestFullScreen) {
        docElm.mozRequestFullScreen();
    }
    //Chrome等
    else if(docElm.webkitRequestFullScreen) {
        docElm.webkitRequestFullScreen();
    }
    //IE11
    else if(elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
    }
}

function exitfullscreen() { //退出全屏
    $("#fullscreen").html('<i class="iconfont icon-quanping"></i><use xlink:href="#icon-zmki-ziyuan-copy"></use></svg>');
    if(document.exitFullscreen) {
        document.exitFullscreen();
    } else if(document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if(document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
    } else if(document.msExitFullscreen) {
        document.msExitFullscreen();
    }
}

var a = 0;
$('#fullscreen').on('click', function() {
    a++;
    a % 2 == 1 ? enterfullscreen() : exitfullscreen();
})

$(function() {
	var loading = false;
	var $loadMore = $('#load-more');
	var currentPage = 1;
	var $main = $('#main');
	var totalPages = parseInt($loadMore.data('total-pages')); // 获取总页数
	
	var scrollHandler = function() {
		// 如果正在加载或者没有更多内容,则不执行
		if(loading) return;
		
		// 如果已经到达最后一页,则移除加载更多标记并返回
		if(currentPage >= totalPages) {
			$loadMore.remove();
			return;
		}
		
		// 检查是否滚动到底部
		if($(window).scrollTop() + $(window).height() > $loadMore.offset().top - 100) {
			loading = true;
			currentPage++;
			
			// 发起 AJAX 请求加载下一页
			$.ajax({
				url: window.location.pathname,
				type: 'GET',
				data: {
					page: currentPage
				},
				success: function(response) {
					// 解析返回的 HTML
					var $res = $(response);
					var $newPosts = $res.find('.thumb.img-area');
					
					// 如果没有新文章了,则移除加载更多标记
					if($newPosts.length === 0) {
						$loadMore.remove();
						return;
					}
					
					// 将新文章插入到容器中
					$newPosts.insertBefore($loadMore);
					
					// 重新初始化新加载文章的图片懒加载
					checkImgs();
					
					// 重新初始化 Poptrox
					$main.poptrox({
						baseZIndex: 20000,
						caption: function($a) {
							var s = '';
							$a.nextAll().each(function() {
								s += this.outerHTML;
							});
							return s;
						},
						fadeSpeed: 300,
						onPopupClose: function() { $body.removeClass('modal-active'); },
						onPopupOpen: function() { $body.addClass('modal-active'); },
						overlayOpacity: 0,
						popupCloserText: '',
						popupHeight: 150,
						popupLoaderText: '',
						popupSpeed: 300,
						popupWidth: 150,
						selector: '.thumb > a.image',
						usePopupCaption: true,
						usePopupCloser: true,
						usePopupDefaultStyling: false,
						usePopupForceClose: true,
						usePopupLoader: true,
						usePopupNav: true,
						windowMargin: 50
					});
					
					loading = false;
				},
				error: function() {
					loading = false;
				}
			});
		}
	};
	
	// 使用 passive 选项添加滚动事件监听器
	window.addEventListener('scroll', scrollHandler, { passive: true });
});