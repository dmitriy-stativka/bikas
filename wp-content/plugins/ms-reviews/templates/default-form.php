<?php
if (!defined('ABSPATH'))
	die();
$params = isset($params) ? $params : exit('Bad params');
?>
<div class="<?= $params['cssPrefix'] ?>reviews">
	<div class="<?= $params['cssPrefix'] ?>title">
		<h4><?php _e('Reviews', 'ms-reviews'); ?></h4>
	</div>
	<div class="<?= $params['cssPrefix'] ?>wrapper">
		<div id="<?= $params['cssPrefix'] ?>review-list">
			<?php
			foreach ($params['reviews'] as $review) {
				$showNickName = $review['show_nickname'];
				$usernickname = $showNickName == "true" ? $review['usernickname'] :  __('Guest', 'ms-reviews');
				$ava = $review['show_avatar'] == "true" ? get_avatar_url($review['user_id']) : $params['defaultAvatar'];
				?>
				<div class="<?= $params['cssPrefix'] ?>r-user-review <?= $params['cssPrefix'] ?>r-user-review-admin" data-id="<?= $review['id'] ?>">
					<div class="<?= $params['cssPrefix'] ?>row">
						<div class="<?= $params['cssPrefix'] ?>r-user-info">
							<div class="<?= $params['cssPrefix'] ?>r-userAvatar"><img src="<?= $ava ?>"></div>
							<div class="<?= $params['cssPrefix'] ?>-user-info">
								<div class="<?= $params['cssPrefix'] ?>r-user-nickName"><?= $usernickname ?></div>
								<div class="<?= $params['cssPrefix'] ?>r-rate <?= $params['cssPrefix'] ?>rate-<?= $review['rate'] ?>"></div>
							</div>
						</div>
					</div>
					<div class="<?= $params['cssPrefix'] ?>row">
						<div class="<?= $params['cssPrefix'] ?>r-userReview"><?= \MS_WEB\MS_REVIEWS\Main::decodeHtml($review['text']) ?></div>
					</div>
					<?php
					if ($params['isAdmin']) { ?>
						<span class="<?= $params['cssPrefix'] ?>delete-review"><?php _e('Remove', 'ms-reviews'); ?></span>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
	if ($params['userIsLogged']) { ?>
		<div class="<?= $params['cssPrefix'] ?>new-review-form-show"><?php _e('Add review', 'ms-reviews'); ?></div>
		<div class="<?= $params['cssPrefix'] ?>new-review-form">
			<div class="<?= $params['cssPrefix'] ?>user-info-row">
				<div class="<?= $params['cssPrefix'] ?>userAvatar">
					<img src="<?= $params['ava'] ?>" class="<?= $params['cssPrefix'] ?>userava" alt=""/>
				</div>
				<div class="<?= $params['cssPrefix'] ?>usernickname msweb-input" value="<?= $params['nick'] ?>" data-placeholder="<?php _e('Enter a nickname', 'ms-reviews'); ?>"></div>
			</div>
			<div class="<?= $params['cssPrefix'] ?>options-row">
				<div>
					<label style="font-weight: 400;"><input type="checkbox" name="shownickname" checked><?php _e('Show nickname', 'ms-reviews'); ?></label>
				</div>
				<!--			<div>-->
				<!--				<label style="font-weight: 400;"><input type="checkbox" name="showavatar" checked> Отображать аватар</label>-->
				<!--			</div>-->
			</div>

			<div><?php _e('Rate', 'ms-reviews'); ?>:</div>
			<div class="<?= $params['cssPrefix'] ?>rating">
				<div id="rate1" i="1"></div>
				<div id="rate2" i="2"></div>
				<div id="rate3" i="3"></div>
				<div id="rate4" i="4"></div>
				<div id="rate5" i="5"></div>
			</div>
			<div class="<?= $params['cssPrefix'] ?>review-entry msweb-input msweb-input-textarea" data-placeholder="<?php _e('Enter your review', 'ms-reviews'); ?>"></div>
			<div class="<?= $params['cssPrefix'] ?>ajax-message"></div>
			<div class="<?= $params['cssPrefix'] ?>chunky">
				<div class="<?= $params['cssPrefix'] ?>chunky14">
					<span class="<?= $params['cssPrefix'] ?>sendreview"><?php _e('Submit', 'ms-reviews'); ?></span>
				</div>
			</div>
		</div>
	<?php }
	else { ?>
		<div class="<?= $params['cssPrefix'] ?>warning"><?php _e('Log in to leave a review', 'ms-reviews'); ?></div>
		<?php
		echo wp_login_form(array(
			'form_id' => $params['cssPrefix'] . 'login'
		));
		do_action('login_form');
		?>
	<?php } ?>
</div>