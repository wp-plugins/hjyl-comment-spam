<?php
/*
	Plugin Name: Hjyl Comment Spam
	Plugin URI: http://hjyl.org/hjyl-comment-spam
	Description: A simple Anti Spam for Comment by number.非常简单的数字评论验证码。
	Version: 1.0
	Author: hjyl
	Author URI: http://hjyl.org
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
define('HJYL_COMMENT_SPAM_URL', plugin_dir_url( __FILE__ ));
define('HJYL_COMMENT_SPAM_PATH', dirname( plugin_basename( __FILE__ ) ));

function hjyl_l10n(){
	load_plugin_textdomain( 'hjyl-comment-spam', false, HJYL_COMMENT_SPAM_PATH.'/languages/' );
}
add_action( 'plugins_loaded', 'hjyl_l10n' );
function hjyl_comment_spam(){
	wp_enqueue_style('comment', HJYL_COMMENT_SPAM_URL. 'hjyl-comment-spam.css', array(), '20150513', 'all', false);
}
add_action( 'wp_footer', 'hjyl_comment_spam' );
// ADD: Anti-spam Code
 function hjyl_antispam(){
	if(!is_user_logged_in()){
		 //$pcodes = substr(md5(mt_rand(0,99999)),0,4); //English+Number
		$pcodes = substr(mt_rand(0,99999),0,4);	//Number
		$str = '<p class="hjyl_anti">';
		$str .= '<label for="subpcodes">'.__('Anti-spam Code','hjyl-comment-spam').':</label>';
		$str .= '<input type="text"  size="4" id="subpcodes" name="subpcodes" />';
		$str .= '<span class="pcodes">'.$pcodes.'</span>';
		$str .= '<input type="hidden" value="'.$pcodes.'" name="pcodes" />';
		$str .= '</p>';
		echo $str;
	}
 }
add_action('comment_form', 'hjyl_antispam', 1, 1);
 function yanzhengma(){
	if ( !is_user_logged_in() ) {
		$pcodes = trim($_POST['pcodes']);
		$subpcodes = trim($_POST['subpcodes']);
		if((($pcodes)!=$subpcodes) || empty($subpcodes)){
			hjyl_ajax_comment_err( __('Error: Incorrect Anti-spam Code!','hjyl-comment-spam') );
		}
	}
}
add_filter('pre_comment_on_post', 'yanzhengma');


?>