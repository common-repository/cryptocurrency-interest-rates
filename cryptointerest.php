<?php
/*
   Plugin Name: Cryptocurrency Interest Rates
   Description: Cryptocurrency Interest Rates Widget From EarnCryptoInterest
   Author: earncryptointerest
   Author URI: https://earncryptointerest.com
   Version: 1.1.2
   License: GPL2
   License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class CryptoInterestWidget extends WP_Widget
{
   function CryptoInterestWidget()
   {
      $widget_ops = array('classname' => 'CryptoInterestWidget', 'description' => 'Displays cryptocurrency interest rates.' );
      parent::__construct('CryptoInterestWidget', 'Cryptocurrency Interest Rates', $widget_ops);
   }

   function form($instance)
   {
      $defaults = array('count' => 5, 'dark' => 0, 'width' => 0, 'height' => 0, 'credits' => '');
	  $instance = wp_parse_args((array)$instance, $defaults);

      echo '
      <style>
      table#cryptocurrency-rates td
      {
         padding:5px;
      }
      </style>
      <table id="cryptocurrency-rates" style="margin-top:10px; margin-bottom:10px;">
	  <tr>
	     <td style="white-space:nowrap;">Coin Count</td>
	     <td colspan="2">
	        <select id="' . $this->get_field_id('count') . '" name="' . $this->get_field_name('count') . '">';
            foreach ([3,4,5,6,7,8,9,10] as $c)
            {
               echo '<option value="'. $c .'"' . ($c == $instance['count'] ? ' selected' : '') . '>'. $c .'</option>';
            }
	        echo '
	        </select>
	     </td>
	  </tr>
	  <tr>
	     <td>Theme</td>
	     <td colspan="2">
	        <select id="' . $this->get_field_id('dark') . '" name="' . $this->get_field_name('dark') . '">
               <option value="0"' . ($instance['dark'] ? '' : ' selected') . '>Light</option>
               <option value="1"' . ($instance['dark'] ? ' selected' : '') . '>Dark</option>
	        </select>
	     </td>
	  </tr>
	  <tr>
	     <td>Width</td>
	     <td colspan="2">
	        <select id="' . $this->get_field_id('width') . '" name="' . $this->get_field_name('width') . '">
		    <option value="0"' . ($instance['width'] == 0 ? ' selected' : '') . '>Auto</option>';
            for ($width = 230; $width <= 330; $width += 10)
            {
               echo '<option value="' . $width . '"' . ($width == $instance['width'] ? ' selected' : '') . '>' . $width . '</option>';
            }
	        echo '
	        </select>
	     </td>
	  </tr>
	  <tr>
	     <td>Height</td>
	     <td colspan="2">
	        <select id="' . $this->get_field_id('height') . '" name="' . $this->get_field_name('height') . '">
		    <option value="0"' . ($instance['height'] == 0 ? ' selected' : '') . '>Auto</option>';
            for ($height = 200; $height <= 600; $height += 10)
            {
               echo '<option value="' . $height . '"' . ($instance['height'] == $height ? ' selected' : '') . '>' . $height . '</option>';
            }
	        echo '
	        </select>
	     </td>
	  </tr>
	  <tr>
	  	<td>Credits</td>
	  	<td><input type="checkbox" id="' . $this->get_field_id('credits') . '" name="' . $this->get_field_name('credits') . '"' . ($instance['credits'] == 'on' ? ' checked' : '') . '></td>
	  	<td>"Powered by EarnCryptoInterest.com" with a link to our site will be shown.</td>
      </tr>
	  </table>';
   }

   function update($new_instance, $old_instance)
   {
      $instance = $old_instance;

      $instance['count'] = $new_instance['count'];
      $instance['dark'] = $new_instance['dark'];
      $instance['width'] = $new_instance['width'];
      $instance['height'] = $new_instance['height'];
      $instance['credits'] = $new_instance['credits'];
      return $instance;
   }

   function widget($args, $instance)
   {
      extract($args, EXTR_SKIP);

      echo $before_widget;
      $this->render($instance['count'], $instance['dark'], $instance['width'], $instance['height'], $instance['credits']);
      echo $after_widget;
   }

   function render($count, $dark, $width, $height, $credits)
   {
      $theme = $dark ? 'dark' : 'light';
      $bkgcolor = $dark ? 'black' : 'white';
      $width = $width ? "width:" . $width . "px; " : "";
      $rowHeight = $dark ? 57 : 51;
      $headerHeight = 38;
      $height = $height ? $height : $headerHeight + $count * $rowHeight;

      if($credits == "on")
      {
         $creditsOut = '<div style="padding:2px 10px 2px 10px; line-height:20px; font-size:12px; font-family:\'Trebuchet MS\', Helvetica, sans-serif; text-align:left; background-color:black; color:white;">Powered by <a href="https://earncryptointerest.com" target="_blank" style="color:white; text-decoration:none;">EarnCryptoInterest.com</a></div>';
      }
      else
      {
         $creditsOut = '';
      }

      echo '<div style="' . $width . 'border:1px solid grey; background-color:' . $bkgcolor . ';"><div style="height:' . $height . 'px; width:100%;"><iframe src="https://widget.earncryptointerest.com/widget?count=' . $count . '&theme=' . $theme . '" width="100%" height="100%" frameborder="0" border="0" marginwidth="0" marginheight="0" style="margin:0px; padding:0px;"></iframe></div>' . $creditsOut . '</div>';
   }
}

add_action('widgets_init', create_function('', 'return register_widget("CryptoInterestWidget");'));
?>