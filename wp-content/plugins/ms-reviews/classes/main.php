<?php

namespace MS_WEB\MS_REVIEWS;

class Main {

	const DEBUG = true;
	static $SCRIPTS_VERSION = 4;
	const DEFAULT_AVATAR = 'default-avatar.png';

	static function onActivate() {
		global $wpdb;

		$db = $wpdb->dbh;
		$dbPrefix = $wpdb->prefix;
		$tableExist = $wpdb->get_var("SELECT COUNT(*)>>0 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$wpdb->dbname}' AND TABLE_NAME = '{$dbPrefix}msweb_reviews'");

		if (!$tableExist) {
			$db->query("CREATE TABLE IF NOT EXISTS `" . $dbPrefix . "msweb_reviews` (`id` int(11) NOT NULL, `user_id` int(11) NOT NULL, `show_avatar` text NOT NULL,  `show_nickname` text NOT NULL,  `usernickname` text NOT NULL,  `rate` int(11) NOT NULL,  `text` text NOT NULL,  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
			$db->query("ALTER TABLE `" . $dbPrefix . "msweb_reviews` ADD PRIMARY KEY (`id`);");
			$db->query("ALTER TABLE `" . $dbPrefix . "msweb_reviews` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
		}
	}

	static public function getUrl() {
		return str_replace('/classes', '', plugins_url('', __FILE__));
	}

	static function enqueAdminStyles() {
		if (is_admin()) {
			if (self::DEBUG) {
				self::$SCRIPTS_VERSION = time();
			}
			wp_enqueue_style('ms-pluginsadmin_shared', self::getUrl() . '/shared.css', null, self::$SCRIPTS_VERSION);
		}
	}

	static function initJSCSS() {
		if (self::DEBUG) {
			self::$SCRIPTS_VERSION = time();
		}
		wp_enqueue_style('msweb_MSReviewsCSS', self::getUrl() . '/css/style.css', null, self::$SCRIPTS_VERSION);
		wp_enqueue_script('jquery');
		wp_enqueue_script('msweb-inputs', self::getUrl() . '/js/msweb-um/msweb-inputs.js', null, self::$SCRIPTS_VERSION, true);
		wp_enqueue_script('msweb_MSReviewsJS', self::getUrl() . '/js/main.js', 'jquery', self::$SCRIPTS_VERSION, true);
		wp_set_script_translations('msweb_MSReviewsJS', 'ms-reviews');

		$js = "if (!window.msweb) { 
			 	msweb = { 
			 		plugins: { 
				        ajaxUrl: \"" . admin_url('admin-ajax.php') . "\", 
				        msreviews: {
				            _cssPrefix: 'msweb_ms-reviews-', 
				            _url: \"" . self::getUrl() . "\" 
				        }
			 		}
			 	}
			 } else {
			 	msweb.plugins.msreviews = {
				            _cssPrefix: 'msweb_ms-reviews-', 
				            _url: \"" . self::getUrl() . "\" 
				        }
			 }";
		wp_add_inline_script('msweb_MSReviewsJS', $js, 'before');
	}

	/**
	 * Forms a readable string from the encoded
	 */
	static function decodeHtml($text) {
		if (!$text || $text == '')
			return;

		$text = html_entity_decode($text, ENT_QUOTES, "UTF-8");
		$text = htmlspecialchars_decode($text);
		$text = str_replace("\n", '<br>', $text);
		return $text;
	}

	/**
	 * prepare string to mysql insert
	 * @param $text
	 * @return string|void
	 */
	static function prepareDataQuery($text) {
		if (!$text || $text == '')
			return;

		global $wpdb;
		$db = $wpdb->dbh;

		$text = (string)$text;
		$text = htmlspecialchars($text);
		$text = htmlentities($text, ENT_QUOTES, "UTF-8");
		if (function_exists('mysqli_real_escape_string '))
			$text = $db->real_escape_string($text);
		return $text;
	}

	/**
	 * Creates a review form
	 * @return string
	 */
	static function getMSReviewsArea() {
		global $wpdb;
		$db = $wpdb->dbh;
		$dbPrefix = $wpdb->prefix;

		$userdata = $GLOBALS['userdata'];
		$user_id = get_current_user_id();
		if ($userdata)
			$nick = $userdata->nickname;
		else
			$nick = 'Пользователь';

		$reviews = $wpdb->get_results('SELECT * FROM ' . $dbPrefix . 'msweb_reviews r LEFT JOIN ' . $dbPrefix . 'users u ON (r.user_id = u.ID)', ARRAY_A);

		$userIsLogged = is_user_logged_in();

		$params = array(
			'cssPrefix' => 'msweb_ms-reviews-',
			'nick' => $nick,
			'ava' => get_avatar_url($user_id),
			'reviews' => $reviews,
			'isAdmin' => current_user_can('administrator'),
			'defaultAvatar' => self::getUrl() . '/img/' . self::DEFAULT_AVATAR,
			'userIsLogged' => $userIsLogged
		);

		ob_start();
		include __DIR__ . '/../templates/default-form.php';
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	/**
	 * processes Ajax requests. Adds the text of the response
	 * to the database, if there is an avatar, then sends a link to it
	 */
	static function ajaxCallback() {
		if (!is_user_logged_in())
			wp_die();

		global $wpdb;
		$db = $wpdb->dbh;
		$dbPrefix = $wpdb->prefix;
		$action = isset($_POST['act']) ? $_POST['act'] : '';
		$answer = array('status' => 200, 'error' => '', 'message' => '');
		try {

			switch ($action) {
				case 'sendReview':
				{
					$data = $_POST['data'];
					$userId = get_current_user_id();
					$rate = self::prepareDataQuery($data['rate']);
					$showAvatar = self::prepareDataQuery($data['showAvatar']);
					$showNickname = self::prepareDataQuery($data['showNickname']);
					$nick = self::prepareDataQuery($data['nick']);
					$text = self::prepareDataQuery($data['review']);
					if (!$text) {
						throw new \Exception(__('Enter the comment text', 'ms-reviews'), 201);
					}

					$testText = preg_replace('/[^а-яА-ЯёЁa-zA-Z\s]/', '', $text);
					$strlen = mb_strlen($testText, 'UTF-8');

					if ($strlen > 1200) {
						throw new \Exception(__("The length of the comment should not exceed 1200 characters", 'ms-reviews'), 201);
					}
					if ($strlen == 0) {
						throw new \Exception(__('The message should not consist only of numbers', 'ms-reviews'), 201);
					}
					if ($strlen < 5) {
						throw new \Exception(__('The message is too short', 'ms-reviews'), 201);
					}


					$res = $db->query("INSERT INTO `" . $dbPrefix . "msweb_reviews`(`user_id`, `show_avatar`, `show_nickname`, `usernickname`, `rate`, `text`) VALUES ($userId, '$showAvatar', '$showNickname', '$nick', '$rate', '$text')");
					if (!$res)
						throw new Exception(__('Couldn\'t add a review', 'ms-reviews'), 500);
					$answer['message'] = __('Review added', 'ms-reviews') . "!";
					if ($showAvatar === "true") {
						$avatar = get_avatar_url($userId);
						if ($avatar) {
							$imgSrc = $avatar;
						}
						else {
							$imgSrc = self::getUrl() . '/img/' . self::DEFAULT_AVATAR;
						}
					}
					else {
						$imgSrc = self::getUrl() . '/img/' . self::DEFAULT_AVATAR;
					}

					$answer['imgSrc'] = $imgSrc;
					break;
				}
				case 'deleteReview':
				{
					if (!current_user_can('administrator'))
						throw new \Exception('Access denied!', 403);
					$rid = self::prepareDataQuery($_POST['data']['rid']);
					$res = $db->query("DELETE FROM " . $dbPrefix . "msweb_reviews WHERE id = '$rid'");
					if (!$res)
						throw new \Exception(__('Failed', 'ms-reviews').'.', 500);
					$answer['message'] = __('The review has been deleted', 'ms-reviews');
					break;
				}
			}
		} catch (\Exception $e) {
			$answer['error'] = $e->getMessage();
			$answer['line'] = 'line ' . $e->getLine();
			$answer['status'] = $e->getCode();
		}
		echo json_encode($answer);

		wp_die();
	}

	static function adminMenuItem() {
		add_submenu_page('ms-plugins', __('MS-Reviews - отзывы на сайте', 'msweb-plugins-reviews'), 'MS-Reviews', 'manage_options', 'msweb-plugins-reviews', array('MS_WEB\MS_REVIEWS\Main', 'adminPage'));
	}

	static function adminPage() {
		wp_enqueue_style('bootstrap', self::getUrl() . '/bootstrap/css/bootstrap.css');
		include __DIR__ . '/../templates/admin-page.php';
	}
}