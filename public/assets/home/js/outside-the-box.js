var app = new Vue({
	el: '#app',
	data: {
		
	},
	methods: {
		readAllArticle:function(id) {
			$('.article-content').css({
				'overflow-y': 'scroll'
			});
			$('.read-all-link').hide();
			$('.article-content').css({
				'height': '100%'
			});
		},
		orgInfo:function(id) {
			window.location.href = '/party-member-home/branch-life-inner.html?id=' + id;
		},
	}
});

function goHome() {
	window.location.href = '/party-member-home/index.html';
}

function goBack() {
	window.history.back(-1);
}
