var app = new Vue({
	el: '#app',
	data: {
	},
	methods: {
		specialName:function(id) {
			window.location.href = '/party-member-home/branch-life-inner.html?id=' + id;
		},
		specialFocus:function(id) {
			window.location.href = '/party-member-home/branch-life-inner.html?id=' + id;
		},
		moreFocus:function() {
			$('.right-part .right-top-part:nth-child(1)').removeClass('active');
			$('.right-part .right-top-part:nth-child(2)').addClass('active');
		}
	}
});


$(function () {
	
});

function goHome() {
	window.location.href = '/party-member-home/index.html';
}

function goBack() {
	window.history.back(-1);
}