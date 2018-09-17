var app = new Vue({
	el: '#app',
	data: {

	},
	methods: {
		redAllArticle: function () {
			$('.article-content').css({
				'overflow-y': 'scroll'
			});
			$('.read-all-link').hide();
			$('.article-content').css({
				'height': '75%'
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
