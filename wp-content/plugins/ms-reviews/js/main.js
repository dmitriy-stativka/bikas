(function ($) {
	const { __, _x, _n, _nx } = wp.i18n;

	var MSInputsObj = new MSInputs();
	var reviewsObj = msweb.plugins.msreviews;
	var csp = reviewsObj._cssPrefix;
	reviewsObj.showNickname = true;
	reviewsObj.showAvatar = true;

	reviewsObj.showLoader = function (DontHideOnClick, target) {
		var div = document.createElement('div');
		div.className = csp + 'preloader';
		if (!DontHideOnClick)
			div.addEventListener('click', reviewsObj.hideLoader);
		var body = document.getElementsByTagName('body');
		if (target) {
			$(div).css('position', 'absolute');
			body = target;
			target.css('position', 'relative');
		}

		$(body).append(div);
		var divH = div.clientHeight;
		var divW = div.clientWidth;
		var loader = document.createElement('img');
		loader.src = reviewsObj._url + "/img/loading.gif";
		var posleft = divW / 2 - 90;
		loader.style.left = Math.floor(posleft) + "px";
		var postop = divH / 2 - 50;
		loader.style.top = Math.floor(postop) + "px";
		$(div).append(loader);
		div.className = csp + 'loader';
		$(div).fadeIn();

	};

	reviewsObj.hideLoader = function () {
		var loader = $('.' + csp + 'loader')
		loader.fadeOut();
		setTimeout(function () {
			loader.remove();
		}, 1000)
	};

	reviewsObj.clear = function () {
		reviewsObj.rate = 0;
		var reviewEntry = $('.' + csp + 'review-entry');
		reviewEntry[0].setValue('');
	};

	/**
	 * @param {text} review
	 * @param {string=} [avatar] - url
	 * @param {string=} nick
	 * @param {integer=} rate
	 */
	reviewsObj.getReviewTpl = function (review, avatar, nick, rate) {
		review = review.replace(/\n/g, '<br>');
		var tpl = '<div class="' + csp + 'r-user-review ' + csp + 'r-user-review-admin" data-id="16">\n' +
			'<div class="' + csp + 'row">\n' +
			'<div class="' + csp + 'r-user-info">\n' +
			'<div class="' + csp + 'r-userAvatar">' +
			'<img src="' + avatar + '">' +
			'</div>\n' +
			'<div class="' + csp + 'user-info">\n' +
			'<div class="' + csp + 'r-user-nickName">' + nick + '</div>\n' +
			'<div class="' + csp + 'r-rate msweb_ms-reviews-rate-' + rate + '"></div>\n' +
			'</div>\n' +
			'</div>\n' +
			'</div>\n' +
			'<div class="' + csp + 'row">\n' +
			'<div class="' + csp + 'r-userReview">' + review + '</div>\n' +
			'</div>\n' +
			'</div>';
		return tpl;
	};

	//**** звёзды ****/
	$('.' + csp + 'rating div').hover(function (oEvent) {
		var el = oEvent.currentTarget;
		var i = el.getAttribute('i');
		var pos;
		switch (i) {
			case "0":
				pos = 0;
				break;
			case "1":
				pos = 26;
				break;
			case '2':
				pos = 51;
				break;
			case '3':
				pos = 77;
				break;
			case '4':
				pos = 102;
				break;
			case '5':
				pos = 128;
				break;
		}
		reviewsObj.rate = i;
		$(el).parents('.msweb_ms-reviews-rating:first').css('background-position-y', '-' + pos + 'px');
	});


	//**** /звёзды ****/


	// поведение чекбокса авы и никнейма
	$('[name="shownickname"]').change(function (oEvent) {
		if ($(this).is(':checked')) {
			$('.' + csp + 'usernickname').show();
			reviewsObj.showNickname = true;
		}
		else {
			$('.' + csp + 'usernickname').hide();
			reviewsObj.showNickname = false;
		}
	});
	$('[name="showuseravatar"]').change(function (oEvent) {
		if ($(this).is(':checked')) {
			$('.' + csp + 'userAvatar').children('.' + csp + 'defaultava').hide();
			$('.' + csp + 'userAvatar').children('.' + csp + 'userava').show();
			reviewsObj.showAvatar = true;
		}
		else {
			$('.' + csp + 'userAvatar').children('.' + csp + 'defaultava').show();
			$('.' + csp + 'userAvatar').children('.' + csp + 'userava').hide();
			reviewsObj.showAvatar = false;
		}
	});

	// убираем сообщение аякс
	$('.' + csp + 'review-entry').keydown(function () {
		$('.' + csp + 'ajax-message').css('color', 'black').hide();
	});

	// отправка отзыва
	$('.' + csp + 'sendreview').click(function () {
		var reviewEntry = $('.' + csp + 'review-entry');
		var review = reviewEntry[0].getValue();
		var showNickname = reviewsObj.showNickname;
		var nick = showNickname ? $('.' + csp + 'usernickname')[0].getValue() || __('Guest', 'ms-reviews') : __('Guest', 'ms-reviews');
		var showAvatar = reviewsObj.showAvatar;

		reviewsObj.showLoader(true, $('.' + csp + 'reviews'));

		$.post(msweb.plugins.ajaxUrl, {
			action: 'msweb_MSReviews_ajax',
			data: {
				review: review,
				nick: nick,
				rate: reviewsObj.rate,
				showNickname: showNickname,
				showAvatar: showAvatar
			},
			act: 'sendReview'
		}, function (d) {
			try {
				d = JSON.parse(d);
				if (d.status === 200) {
					var imgSrc = d.imgSrc;
					var newReview = $(reviewsObj.getReviewTpl(review, imgSrc, nick, reviewsObj.rate))[0];
					var reviewList = document.getElementById(csp + 'review-list');
					reviewList.appendChild(newReview);
					reviewList.parentElement.scroll(0, reviewList.parentElement.scrollHeight);
					reviewsObj.clear();
				}
				else if (d.status == 201) {
					$('.' + csp + 'ajax-message').html(d.error).css('color', 'red').show();
				}

			} catch (e) {
				console.log(e.message + '<br>' + d);
			}
			reviewsObj.hideLoader();
		})
	});

	$('.' + csp + 'delete-review').click(function (e) {
		var reviewBlock = $(e.currentTarget).parents('.' + csp + 'r-user-review');
		var rid = reviewBlock.attr('data-id');
		reviewBlock.css({'border': '1px', 'border-style': 'dotted'});
		if (confirm(__('Delete this review', 'ms-reviews') + '?')) {
			// reviewsObj.showLoader(true);
			$.post(msweb.plugins.ajaxUrl, {
				action: 'msweb_MSReviews_ajax',
				data: {
					rid: rid
				},
				act: 'deleteReview'
			}, function (d) {
				try {
					d = JSON.parse(d);
					if (d.status == 200) {
						reviewBlock.fadeOut();
					}
					else
						throw new Error(d.message + ' ' + d.status);
				} catch (e) {
					alert(e.message);
				}
				// reviewsObj.hideLoader();
			});
		}

	});

	$('.' + csp + 'new-review-form-show').click(function (e) {
		var form = $('.' + csp + 'new-review-form');
		if (form.hasClass('visible')) {
			form.removeClass('visible');
			e.target.innerText = __('Add a review', 'ms-reviews');
		}
		else {
			form.addClass('visible');
			e.target.innerText = __('Cancel', 'ms-reviews');
		}
	});

})(jQuery);
