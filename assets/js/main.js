/*
	Multiverse by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

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

				function debounce(func, wait) {
					let timeout;
					return function() {
						const context = this;
						const args = arguments;
						clearTimeout(timeout);
						timeout = setTimeout(() => func.apply(context, args), wait);
					};
				}

				$window.on('resize', debounce(function() {
					$body.addClass('is-resizing');
					setTimeout(function() {
						$body.removeClass('is-resizing');
					}, 100);
				}, 250));

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

				var $this = $(this),
					$image = $this.find('.image'), 
					$image_img = $image.children('img');

				// 如果没有图片则返回
				if ($image.length === 0) return;

				// 使用 loading="lazy" 属性实现懒加载
				$image_img
					.attr('loading', 'lazy')
					.css('display', 'block') // 确保图片显示
					.on('load', function() {
						// 图片加载完成后的处理
						$(this).css('opacity', '1');
					});

				// 如果有背景位置数据，设置它
				var position = $image_img.data('position');
				if (position) {
					$image.css('background-position', position);
				}

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
				onPopupClose: function() { 
					isPopupActive = false;
					$body.removeClass('modal-active');
					// 确保移除所有可能阻止滚动的样式
					$('html, body').css({
						'overflow': '',
						'position': '',
						'height': '',
						'width': ''
					});
					// 重置触摸状态
					touchStartX = 0;
					touchEndX = 0;
					isTransitioning = false;
				},
				onPopupOpen: function() { 
					isPopupActive = true;
					$body.addClass('modal-active');
				},
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

// 优化全屏切换功能
const fullscreenAPI = {
	enter: document.documentElement.requestFullscreen ||
		   document.documentElement.mozRequestFullScreen ||
		   document.documentElement.webkitRequestFullScreen ||
		   document.documentElement.msRequestFullscreen,
	exit: document.exitFullscreen ||
		  document.mozCancelFullScreen ||
		  document.webkitCancelFullScreen ||
		  document.msExitFullscreen
};

function toggleFullscreen() {
	const isFullscreen = document.fullscreenElement ||
						document.mozFullScreenElement ||
						document.webkitFullscreenElement ||
						document.msFullscreenElement;
	
	if (!isFullscreen) {
		$("#fullscreen").html("退出全屏");
		fullscreenAPI.enter.call(document.documentElement);
	} else {
		$("#fullscreen").html('<i class="iconfont icon-quanping"></i><use xlink:href="#icon-zmki-ziyuan-copy"></use></svg>');
		fullscreenAPI.exit.call(document);
	}
}

// 简化全屏切换事件监听
$('#fullscreen').on('click', toggleFullscreen);

// 为分页按钮添加动画效果
$(document).ready(function() {
    $('.next-page-btn').hover(
        function() {
            $(this).addClass('btn-hover');
        },
        function() {
            $(this).removeClass('btn-hover');
        }
    );
});

// 添加触摸滑动支持
document.addEventListener('DOMContentLoaded', function() {
    let touchStartX = 0;
    let touchEndX = 0;
    let isTransitioning = false;
    let isPopupActive = false;
    const minSwipeDistance = 50;
    const $main = $('#main');
    const $body = $('body');  // 添加 $body 定义

    console.log('触摸事件初始化完成');

    // 监听弹窗状态
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
        onPopupClose: function() { 
            isPopupActive = false;
            $body.removeClass('modal-active');
            // 确保移除所有可能阻止滚动的样式
            $('html, body').css({
                'overflow': '',
                'position': '',
                'height': '',
                'width': ''
            });
            // 重置触摸状态
            touchStartX = 0;
            touchEndX = 0;
            isTransitioning = false;
        },
        onPopupOpen: function() { 
            isPopupActive = true;
            $body.addClass('modal-active');
        },
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

    // 添加全局触摸事件监听
    document.body.addEventListener('touchstart', function(e) {
        const popup = e.target.closest('.poptrox-popup');
        if (!isPopupActive || !popup) return;
        touchStartX = e.touches[0].clientX;
    }, { passive: true });

    document.body.addEventListener('touchend', function(e) {
        const popup = e.target.closest('.poptrox-popup');
        if (!isPopupActive || !popup) return;
        touchEndX = e.changedTouches[0].clientX;
        handleSwipe(popup);
    }, { passive: true });

    // 添加触摸移动事件监听
    document.body.addEventListener('touchmove', function(e) {
        const popup = e.target.closest('.poptrox-popup');
        if (isPopupActive && popup) {
            e.preventDefault();
        }
    }, { passive: false });

    // 添加图片查看器状态变化监听
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.target.classList.contains('poptrox-popup')) {
                isPopupActive = mutation.target.style.display !== 'none';
            }
        });
    });

    // 开始观察 body 的变化
    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['style', 'class']
    });

    function handleSwipe(popup) {
        if (isTransitioning) return;

        const swipeDistance = touchEndX - touchStartX;
        if (Math.abs(swipeDistance) < minSwipeDistance) return;

        const nav = popup.querySelector('.breadcrumb-nav');
        if (!nav) return;

        const dots = nav.querySelectorAll('.nav-dot');
        const images = JSON.parse(nav.dataset.images);
        const currentIndex = Array.from(dots).findIndex(dot => dot.classList.contains('active'));
        
        // 向左滑动显示下一张，向右滑动显示上一张
        let nextIndex;
        if (swipeDistance > 0) {
            // 向右滑动，显示上一张
            nextIndex = (currentIndex - 1 + images.length) % images.length;
        } else {
            // 向左滑动，显示下一张
            nextIndex = (currentIndex + 1) % images.length;
        }

        const imgWrapper = popup.querySelector('.pic');
        const img = imgWrapper.querySelector('img');
        if (img) {
            isTransitioning = true;
            
            // 添加过渡动画
            img.style.transition = 'opacity 0.3s ease-in-out';
            img.style.opacity = '0';

            // 从当前图片URL中提取后缀
            const currentUrl = img.src;
            const suffixMatch = currentUrl.match(/!.*$/);
            const suffix = suffixMatch ? suffixMatch[0] : '';

            // 等待淡出完成
            setTimeout(() => {
                // 获取新的图片URL，使用相同的后缀
                const newImageUrl = images[nextIndex] + suffix;
                
                // 更新图片元素的src和data-src属性
                img.src = newImageUrl;
                if (img.hasAttribute('data-src')) {
                    img.setAttribute('data-src', newImageUrl);
                }
                // 更新父元素的background-image（如果存在）
                if (imgWrapper.style.backgroundImage) {
                    imgWrapper.style.backgroundImage = `url(${newImageUrl})`;
                }
                
                // 图片加载完成后显示
                img.onload = function() {
                    img.style.opacity = '1';
                    isTransitioning = false;
                };
                
                // 如果图片加载失败，也要重置状态
                img.onerror = function() {
                    isTransitioning = false;
                };
            }, 300);

            // 更新导航点状态
            dots.forEach(dot => dot.classList.remove('active'));
            dots[nextIndex].classList.add('active');
        }
    }
});