var app = new Vue({
	el: '#app',
	data: {

	},
	methods: {
		readAllNotice: function () {
			$('.notice .article-content').css({
				'overflow-y': 'scroll'
			});
			$('.notice .read-all-link').hide();
			$('.notice .article-content').css({
				'height': '100%'
			});
		},
		readAllAnnouncement: function () {
			$('.announcement .article-content').css({
				'overflow-y': 'scroll'
			});
			$('.announcement .read-all-link').hide();
			$('.announcement .article-content').css({
				'height': '100%'
			});
		},
		readAllPublicity: function () {
			$('.publicity .article-content').css({
				'overflow-y': 'scroll'
			});
			$('.publicity .read-all-link').hide();
			$('.publicity .article-content').css({
				'height': '100%'
			});
		}
	}
});

$(function () {
	$("div.class-btn-group img").click(function () {
		var img = $(this);
		if (!$(this).hasClass('scale-img')) {
			var index = $.inArray(img[0], $('div.class-btn-group img'));
			$(this).addClass('scale-img');
			$(this).siblings().removeClass('scale-img');
			$("div.container").find("div.main-content").removeClass('active');
			$("div.container").find("div.main-content").eq(index).addClass('active');
		}
	});
});


function goHome() {
	window.location.href = '/party-member-home/index.html';
}

function goBack() {
	window.history.back(-1);
}
