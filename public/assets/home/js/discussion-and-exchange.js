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
		}
	}
});

function goHome() {
	window.location.href = '/party-member-home/index.html';
}

function goBack() {
	window.history.back(-1);
}
