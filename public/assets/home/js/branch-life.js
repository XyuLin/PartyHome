var app = new Vue({
	el: '#app',
	data: {
		images: [
			'plugins/broadcast/images/1.jpg',
			'plugins/broadcast/images/2.jpg',
			'plugins/broadcast/images/3.jpg',
			'plugins/broadcast/images/4.jpg',
			'plugins/broadcast/images/5.jpg'
		]
	},
	methods: {
		readAllOrg: function () {
			$('.org .article-content').css({
				'overflow-y': 'scroll'
			});
			$('.org .read-all-link').hide();
			$('.org .article-content').css({
				'height': '100%'
			});
		},
		readAllArticle:function() {
			$('.work .article-content').css({
				'overflow-y': 'scroll'
			});
			$('.work .read-all-link').hide();
			$('.work .article-content').css({
				'height': '100%'
			});
		},
		orgInfo:function(id) {
			window.location.href = '/party-member-home/branch-life-inner.html?id=' + id;
		},
		workDync:function(id) {
			window.location.href = '/party-member-home/branch-life-inner.html?id=' + id;
		}
	}
});

$(function () {
	$("div.class-btn-group img").click(function () {
		var img = $(this);
		if (!img.hasClass('scale-img')) {
			var index = $.inArray(img[0], $('div.class-btn-group img'));
			$(this).addClass('scale-img');
			$(this).siblings().removeClass('scale-img');
			$("div.container").find("div.main-content").removeClass('active');
			$("div.container").find("div.main-content").eq(index).addClass('active');
		}
	});

	/**
	 * 初始化轮播组件
	 */
	Carousel.init($("#carousel-image"));
	$("#carousel-image").init();
	//触摸事件
	var x_orgin = 0;
	var x_now = 0;
	var isTouch = false;
	document.querySelector('#carousel-image').addEventListener('touchstart', function (ev) {
		x_origin = ev.touches[0].clientX;
		$(this).bind('touchmove', function (ev) {
			isTouch = true;
			x_now = ev.originalEvent.touches[0].clientX;
		});
	});
	document.querySelector('#carousel-image').addEventListener('touchend', function () {
		if (isTouch) {
			if (x_now - x_origin < 0) {
				$('#carousel-image').find('.poster-next-btn').click();
			} else {
				$('#carousel-image').find('.poster-prev-btn').click();
			}
		}
		isTouch = false;
	});
});


function goHome() {
	window.location.href = '/party-member-home/index.html';
}

function goBack() {
	window.history.back(-1);
}
