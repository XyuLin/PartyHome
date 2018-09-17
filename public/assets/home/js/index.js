var app = new Vue({
	el: '#app',
	data: {
		images: [
			'plugins/broadcast/images/1.jpg',
			'plugins/broadcast/images/2.jpg',
			'plugins/broadcast/images/3.jpg',
			'plugins/broadcast/images/4.jpg',
			'plugins/broadcast/images/5.jpg'
		],
		btImages: [
			{
				image:'img/index/1.png',
				link:'/party-member-home/affairs-to-guide.html'
			},
			{
				image:'img/index/2.png',
				link:'/party-member-home/group-org.html'
			},
			{
				image:'img/index/3.png',
				link:'/party-member-home/outside-the-box.html'
			},
			{
				image:'img/index/4.png',
				link:'/party-member-home/newest-dyn.html'
			},
			{
				image:'img/index/5.png',
				link:'/party-member-home/patrol-of-window.html'
			},
			{
				image:'img/index/6.png',
				link:'/party-member-home/branch-life.html'
			},
			{
				image:'img/index/7.png',
				link:'/party-member-home/special-column.html'
			}
		]
	},
	methods: {

	}
});
/**
 * 初始化轮播组件
 */
$(function () {
	Carousel.init($("#carousel-image,#carousel-button"));
	$("#carousel-image,#carousel-button").init();
	var ids = ['#carousel-image', '#carousel-button'];
	for (var i = 0; i < 2; i++) {
		var x_orgin = 0;
		var x_now = 0;
		var isTouch = false;
		//触摸事件触发
		if (i == 0) {
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
		} else if (i == 1) {
			document.querySelector('#carousel-button').addEventListener('touchstart', function (ev) {
				x_origin = ev.touches[0].clientX;
				$(this).bind('touchmove', function (ev) {
					isTouch = true;
					x_now = ev.originalEvent.touches[0].clientX;
				});
			});
			document.querySelector('#carousel-button').addEventListener('touchend', function () {
				if (isTouch) {
					if (x_now - x_origin < 0) {
						$('#carousel-button').find('.poster-next-btn').click();
					} else {
						$('#carousel-button').find('.poster-prev-btn').click();
					}
				}
				isTouch = false;
			});
		}
	}
});
