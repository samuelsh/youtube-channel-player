<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Youtube_Channel_Player
 * @subpackage Youtube_Channel_Player/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Youtube_Channel_Player
 * @subpackage Youtube_Channel_Player/public
 * @author     Your Name <email@example.com>
 */
class Youtube_Channel_Player_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Youtube_Channel_Player    The ID of this plugin.
	 */
	private $Youtube_Channel_Player;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Youtube_Channel_Player       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Youtube_Channel_Player, $version ) {

		$this->Youtube_Channel_Player = $Youtube_Channel_Player;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Youtube_Channel_Player_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Youtube_Channel_Player_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Youtube_Channel_Player, plugin_dir_url( __FILE__ ) . 'css/youtube-channel-player-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'countdown_timer_css', plugin_dir_url( __FILE__ ) . 'js/countdown_timer_js/CSS/jquery.countdownTimer.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'colorbox_css', plugin_dir_url( __FILE__ ) . 'js/jquery-colorbox/colorbox.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Youtube_Channel_Player_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Youtube_Channel_Player_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Youtube_Channel_Player, plugin_dir_url( __FILE__ ) . 'js/youtube-channel-player-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'countown_timer_js', plugin_dir_url( __FILE__ ) . 'js/countdown_timer_js/jquery.countdownTimer.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'colorbox_js', plugin_dir_url( __FILE__ ) . 'js/jquery-colorbox/jquery.colorbox.js', array( 'jquery' ), $this->version, false );

	}

	
	
	/**
	 * Register the shortcode for embedding yotube channel to post/page
	 *
	 */
	public function embed_ytb_channel($atts, $content = null) {
		$out = "";	
		shortcode_atts(array(
				"channel_id" => ''
		), $atts);
		$channel_list = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=".$atts['channel_id']."&key=AIzaSyAi1i-MN1M-jiSzV1y2qTydlHmM4ZFwjJY&maxResults=50";
		$curl = curl_init($channel_list);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		$ytb_channel_decoded = json_decode($return, true);
		$playlists_array = $ytb_channel_decoded['items'];
		
		$out .= '<div id="outer_tube">';
		$out .= '<div id="inner_tube">';		
		$out .= '</div>';
		$out .= '<div id="tube_sidebar">';
		foreach ($playlists_array as $playlist){
			$out .= '<img class="tube_thumbs" src="'.$playlist['snippet']['thumbnails']['default']['url'].'" id="'.$playlist['id'].'">';
		}
		$out .= '</div>';
		$out .= '<div><button type="button" id="ytb_button" style="background: rgba(27,127,204,.8); margin-top: 50px; margin-left: 140px; width: 180px">'. __('Jump to Random clip') .'</button></div>';
		$out .= '<div id="countdowntimer" style="margin-top:50px; margin-left:150px;"><span id="future_date"><span></div>';
		$out .= '<p>';
		$out .= 		'<a class="inline cboxElement" href="#inline_content">Report Video</a>';
		$out .=	'</p>';
		$out .= '<p>';
		$out .= 		'<a id="UCgFXkHaLRgKkBjxQ9PA3xqQ" class="channel_url" href="#" onclick="return false;">הערוץ הבטוח גילאי 2-4</a>';
		$out .=	'</p>';
		$out .= '<p>';
		$out .= 		'<a id="UCUXLXXDOZ1GngW2ofFy0GmQ" class="channel_url"  href="#" onclick="return false;">הערוץ הבטוח גילאי 5-8</a>';
		$out .=	'</p>';
		$out .= '<p>';
		$out .= 		'<a id="UC5KBlL7whXg9nDQU_dsh8Iw" class="channel_url"  href="#" onclick="return false;">הערוץ הבטוח גילאי 9-11</a>';
		$out .=	'</p>';
		$out .=			'<div style="display:none" >';
		$out .=					'<div id="inline_content" style="padding:10px; background:#fff;float:right;">';
		$out .= 					'<form id="report_form" name="report_form" action="post">';
		$out .= 					'<p><label for="what_problematic" style="float:right"><small>מה בעייתי בסרטון?:</small></label></br>';
		$out .=						'<textarea tabindex="4" cols="35" rows="5" value="" id="what_problematic" name="what_problematic"></textarea></p>';
		$out .= 					'</br>';
		$out .= 					'<p><label for="what_time" style="float:right"><small>באיזה דקה בסרטון נצפתה הבעיה?</small></label>';
		$out .= 					'<input type="text" tabindex="3" size="22" id="what_time" name="what_time"></p>';
		$out .=						'</br><button id="report_send" style="margin-right:20px;float:right">שלח</button>';
		$out .=						'</form>';	
		$out .=					'</div>';	
		$out .= 		'</div>';
		$out .= '</div>';

		return $out;	
	}
}
