<?php

/**

 * @package Online_Counter

 * @version 1.0

 */

/*

  Plugin Name: Online Counter

  Plugin URI: http://www.online-counter.org

  Description: This module shows you the visitors of your site.

  Author: OnlineCounter

  Version: 1.0

  Author URI: http://www.online-counter.org

  License: GNU/GPL

 */

 

global $wpdb;

define('ONL_HITS_TABLE', $wpdb->prefix . 'onl_hits');

define('ONL_INFO_TABLE', $wpdb->prefix . 'onl_info');

define('BMW_PATH', ABSPATH . 'wp-content/plugins/online_counter');

require_once(ABSPATH . 'wp-includes/pluggable.php');



function online_counter_install() {

    global $wpdb;

    if ($wpdb->get_var('SHOW TABLES LIKE "' . ONL_HITS_TABLE . '"') != ONL_HITS_TABLE) {

        $sql = "CREATE TABLE IF NOT EXISTS `" . ONL_HITS_TABLE . "` (";

        $sql .= "`id` int(11) unsigned NOT NULL AUTO_INCREMENT,";

        $sql .= "`count` int(11) NOT NULL DEFAULT '0',";

        $sql .= "`created` int(11) NOT NULL DEFAULT '0',";

        $sql .= "PRIMARY KEY (`id`)";

        $sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $wpdb->query($sql);

    }

    if ($wpdb->get_var('SHOW TABLES LIKE "' . ONL_INFO_TABLE . '"') != ONL_INFO_TABLE) {

        $sql = "CREATE TABLE IF NOT EXISTS `" . ONL_INFO_TABLE . "` (";

        $sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,";

        $sql .= "`ip_address` varchar(30) NOT NULL,";

        $sql .= "`user_agent` varchar(255) NOT NULL,";

        $sql .= "`created` int(11) DEFAULT '0',";

        $sql .= "PRIMARY KEY (`id`)";

        $sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $wpdb->query($sql);

    }

}



function online_counter_uninstall() {

    global $wpdb;

    $sql = "DROP TABLE `" . ONL_HITS_TABLE . "`;";

    $wpdb->query($sql);

    $sql = "DROP TABLE `" . ONL_INFO_TABLE . "`;";

    $wpdb->query($sql);

}



register_activation_hook(__FILE__, 'online_counter_install');

register_deactivation_hook(__FILE__, 'online_counter_uninstall');



class Online_Counter extends WP_Widget {



    function __construct() {

        $params = array(

            'description' => 'This module shows you the visitors of your site.', //plugin description

            'name' => 'Online Counter'  //title of plugin

        );



        parent::__construct('Online_Counter', '', $params);

    }



    public function form($instance) {

//        $instance = wp_parse_args((array) $instance, array('title' => ''));

//        $title = $instance['title'];



        if ($instance) {

            $title = esc_attr($instance['title']);

            $number_digits = esc_attr($instance['number_digits']);

            $width = esc_attr($instance['width']);

            $today = esc_attr($instance['today']);

            $xweek = esc_attr($instance['xweek']);

            $xmonth = esc_attr($instance['xmonth']);

            $all = esc_attr($instance['all']);

            $online = esc_attr($instance['online']);

        } else {

            $title = __('Online Counter');

            $number_digits = 6;

            $width = '';

            $today = __('Today');

            $xweek = __('Week');

            $xmonth = __('Month');

            $all = __('Total');

            $online = __('Users Online:');

        }

        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('number_digits'); ?>">Min Number Digits: <input class="widefat" id="<?php echo $this->get_field_id('number_digits'); ?>" name="<?php echo $this->get_field_name('number_digits'); ?>" type="text" value="<?php echo attribute_escape($number_digits); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('width'); ?>">Module Width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></label></p>

        <p><font size='2'><b>Translate to your language</b></font></p>

        <p><label for="<?php echo $this->get_field_id('today'); ?>">Today: <input class="widefat" id="<?php echo $this->get_field_id('today'); ?>" name="<?php echo $this->get_field_name('today'); ?>" type="text" value="<?php echo attribute_escape($today); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('xweek'); ?>">This Week: <input class="widefat" id="<?php echo $this->get_field_id('xweek'); ?>" name="<?php echo $this->get_field_name('xweek'); ?>" type="text" value="<?php echo attribute_escape($xweek); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('xmonth'); ?>">This Month: <input class="widefat" id="<?php echo $this->get_field_id('xmonth'); ?>" name="<?php echo $this->get_field_name('xmonth'); ?>" type="text" value="<?php echo attribute_escape($xmonth); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('all'); ?>">All: <input class="widefat" id="<?php echo $this->get_field_id('all'); ?>" name="<?php echo $this->get_field_name('all'); ?>" type="text" value="<?php echo attribute_escape($all); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('online'); ?>">Users Online: <input class="widefat" id="<?php echo $this->get_field_id('online'); ?>" name="<?php echo $this->get_field_name('online'); ?>" type="text" value="<?php echo attribute_escape($online); ?>" /></label></p>

        <?php

    }



    public function widget($args, $instance) {

        extract($args, EXTR_SKIP);



        $number_digits = empty($instance['number_digits']) ? 6 : $instance['number_digits'];

        $number_digits = (int) $number_digits;

        $today = empty($instance['today']) ? 'Today' : $instance['today'];

        $x_week = empty($instance['xweek']) ? 'Week' : $instance['xweek'];

        $x_month = empty($instance['xmonth']) ? 'Month' : $instance['xmonth'];

        $all = empty($instance['all']) ? 'Total' : $instance['all'];

        $online = empty($instance['online']) ? 'Users Online:' : $instance['online'];



        $width = $instance['width'];

        $width = preg_replace("/\s/", "", $width);

        $width = preg_replace("/([0-9]+)$/", "$1px", $width);



        Online_Counter::onAfterInitialise();



        echo $before_widget;

        

        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);



        if (!empty($title))

            $title = $before_title . $title . $after_title;



        echo "<link rel='stylesheet' type='text/css' href='" . WP_PLUGIN_URL . "/online_counter/online_counter.css' />";



        $arr_counter = array();



        $query = "SELECT SUM(count) FROM " . ONL_HITS_TABLE;

        $arr_counter['total'] = @mysql_result(mysql_query($query), 0);



        $query = "SELECT count FROM " . ONL_HITS_TABLE . " ORDER BY created DESC LIMIT 0,1";

        $arr_counter['today'] = @mysql_result(mysql_query($query), 0);



        date_default_timezone_set('UTC');

        $offset = 7;

        $now = mktime();

        $now = $now + ($offset * 60 * 60);

        //    $now = $now + ($offset * 60 * 60) - (7 * 24 * 60 * 60);

        //    $now = $now + ($offset * 60 * 60) - (31 * 24 * 60 * 60);

        //    var_dump(date('d/m/Y H:i:s', $now));



        $minute = (int) gmstrftime("%M", $now);

        $hour = (int) gmstrftime("%H", $now);

        $day = (int) gmstrftime("%d", $now);

        $month = (int) gmstrftime("%m", $now);

        $year = (int) gmstrftime("%Y", $now);



        $created = $now;



        $todaystart = gmmktime(0, 0, 0, $month, $day, $year);

        // If Sunday is starting day of week then Sunday = 0 ... Saturday = 6

        // If Monday is starting day of week then Monday = 0 ... Sunday = 6

        $sunday = 0;

        $weekday = (int) gmstrftime("%w", $now);

        $wk = $weekday - $sunday;

        $weekday = ($wk > 0) ? $wk : 7 + $wk;



        $xweekstart = $todaystart - $weekday * 86400;

        //    var_dump(date('d/m/Y H:i:s', $xweekstart));

        $query = "SELECT SUM(count) FROM " . ONL_HITS_TABLE . " WHERE created>=" . $xweekstart;

        $arr_counter['ThisWeek'] = @mysql_result(mysql_query($query), 0);



        $xmonthstart = gmmktime(0, 0, 0, $month, 1, $year);

        //    var_dump(date('d/m/Y H:i:s', $xmonthstart));

        $query = "SELECT SUM(count) FROM " . ONL_HITS_TABLE . " WHERE created>=" . $xmonthstart;

        $arr_counter['ThisMonth'] = @mysql_result(mysql_query($query), 0);



        $min = 15;

        $timeout = $created - ($min * 60);

        //    var_dump(date('d/m/Y H:i:s', $timeout));

        $query = "SELECT COUNT(id) FROM " . ONL_INFO_TABLE . " WHERE created>=" . $timeout;

        $arr_counter['UserOnline'] = @mysql_result(mysql_query($query), 0);



        //Write output

        $str = '<!-- Online Counter for WordPress! -->';

        if ($width != '')

            $str .= '<div class="online-counter" style="width:' . $width . '">';

        else

            $str .= '<div class="online-counter">';

        $str .= '<div class="mod-count-inner1">';

        $str .= '<div class="mod-count-inner2">';

        if (trim($title) != '')

            $str .= '<div class="title">' . trim($title) . '</div>';

        $str .= '<div class="mod-count-content">';

        $str .= '<div class="count-num">';



        $total_number = str_pad($arr_counter['total'], $number_digits, '0', STR_PAD_LEFT);

        $arr = str_split($total_number);

        foreach ($arr as $value) {

            $str .= '<span class="digit-' . $value . '">' . $value . '</span>';

        }

        $str .= '</div>';

        // $str .= '<ul class="list-count">';

        // $str .= '<li class="clearfix">';

        // $str .= '<span class="left icon-day icon-dayt">' . $today . '</span>';

        // $str .= '<span class="right">' . $arr_counter['today'] . '</span>';

        // $str .= '</li>';

        // $str .= '<li class="clearfix">';

        // $str .= '<span class="left icon-day icon-daytw">' . $x_week . '</span>';

        // $str .= '<span class="right">' . $arr_counter['ThisWeek'] . '</span>';

        // $str .= '</li>';

        // $str .= '<li class="clearfix">';

        // $str .= '<span class="left icon-day icon-daytm">' . $x_month . '</span>';

        // $str .= '<span class="right">' . $arr_counter['ThisMonth'] . '</span>';

        // $str .= '</li>';

        // $str .= '<li class="clearfix">';

        // $str .= '<span class="left icon-day icon-daya">' . $all . '</span>';

        // $str .= '<span class="right">' . $arr_counter['total'] . '</span>';

        // $str .= '</li>';

        // $str .= '</ul>';

        // $str .= '<div class="ip-now">';

        // $str .= $online . ' ' . $arr_counter['UserOnline'];

        // $str .= '</div>';

        // $str .= '<div class="rate-count"><a href="http://nqe.com.vn">Online Counter</a></div>';

        $str .= '</div>';

        $str .= '</div>';

        $str .= '</div>';

        $str .= '</div>';



        echo $str;



        echo $after_widget;

    }



    function onAfterInitialise() {

        date_default_timezone_set('UTC');

        $offset = 7;

        $now = mktime();

        $now = $now + ($offset * 60 * 60);

        //    $now = $now + ($offset * 60 * 60) - (7 * 24 * 60 * 60);

        //    $now = $now + ($offset * 60 * 60) - (31 * 24 * 60 * 60);

        //    var_dump(date('d/m/Y H:i:s', $now));



        $minute = (int) gmstrftime("%M", $now);

        $hour = (int) gmstrftime("%H", $now);

        $day = (int) gmstrftime("%d", $now);

        $month = (int) gmstrftime("%m", $now);

        $year = (int) gmstrftime("%Y", $now);



        $created = $now;



        $hitid = 0;

        $todaystart = gmmktime(0, 0, 0, $month, $day, $year);

        //    var_dump(date('d/m/Y H:i:s', $todaystart));

        $todayend = $todaystart + 86400;

        $query = "SELECT id FROM " . ONL_HITS_TABLE . " WHERE created>=" . $todaystart . " AND created<=" . $todayend;

        $hitid = @mysql_result(mysql_query($query), 0);

        if ($hitid > 0) {

            //A counter for this page  already exsists. Now we have to update it.

            $query = "UPDATE " . ONL_HITS_TABLE . " SET count=count+1 WHERE id=" . $hitid;

            mysql_query($query);

        } else {

            // This page did not exsist in the counter database. A new counter must be created for this page.

            $query = "INSERT INTO " . ONL_HITS_TABLE . " (count,created)VALUES (1," . $created . ")";

            mysql_query($query);

        }



        // gather user data

        $ip = $_SERVER["REMOTE_ADDR"];

        $agent = $_SERVER["HTTP_USER_AGENT"];

        $num_rows = 0;

        $query = "SELECT COUNT(id) FROM " . ONL_INFO_TABLE . " WHERE ip_address='" . $ip . "'";

        $num_rows = @mysql_result(mysql_query($query), 0);

        if (!$num_rows) { // check if the IP is in database

            // if not , add it.	

            $query = "INSERT INTO " . ONL_INFO_TABLE . " (ip_address,user_agent,created) VALUES('" . $ip . "','" . $agent . "'," . $created . ")";

            mysql_query($query);

        } else {

            $query = "UPDATE " . ONL_INFO_TABLE . " SET created=" . $created . " WHERE ip_address='" . $ip . "'";

            mysql_query($query);

        }



        return;

    }



}



add_action('widgets_init', 'register_online_counter');



function register_online_counter() {

    register_widget('Online_Counter');

}

?>

