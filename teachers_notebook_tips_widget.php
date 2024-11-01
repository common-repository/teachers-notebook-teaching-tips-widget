<?php
/*
	Plugin Name:	Teachers Notebook FREE K-12 Teaching Tips Widget
	Plugin URI:		http://www.teachersnotebook.com
	Description:	Plugin to add a Teachers Notebook FREE K-12 Teaching Tips widget to the sidebar or footer, or embed into a page or post using shortcodes.
	Version:		1.0
	Author:			Teachers Notebook LLC
	Author URI:		http://www.teachersnotebook.com
	License:		GPLv2 (or later)
	License URI:	http://www.gnu.org/licenses/gpl-2.0.html
*/


	// Define extension to WordPress' WP_Widget class
	class Teachers_Notebook_Tips_Widget extends WP_Widget
	{
		// function to import the Widget
		function Teachers_Notebook_Tips_Widget()
		{
			$widget_ops = array( 'classname' => 'Teachers_Notebook_Tips_Widget', 'description' => 'Teachers Notebook Teaching Tips Widget' );
			$this->WP_Widget( 'Teachers_Notebook_Tips_Widget', 'TN Tips Widget', $widget_ops );
		}
	 

		// function to edit the Widget settings once added to sidebar or footer
		function form( $instance )
		{
			return;
		}
	 
		// update the Widget variables (set all old to new then overwrite changes)
		function update($new_instance, $old_instance)
		{
			return $new_instance;
		}

		// execute the Widget
		function widget($args, $instance)
		{
			$errmsg	= "";
			$html	= "";


			extract( $args, EXTR_SKIP );

			echo $before_widget;

			if( ($handle = curl_init( "http://www.teachersnotebook.com/widget/generic/tips/" )) !== false )
			{
				curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 15 );
				curl_setopt( $handle, CURLOPT_HEADER, 0 );
				curl_setopt( $handle, CURLOPT_RETURNTRANSFER, 1 );

				if( ($html = curl_exec( $handle )) === false )
					$errmsg = "No Response";

				curl_close( $handle );
			}
			else
				$errmsg = "Internal (URL)";

			if( $errmsg != "" )
				$html = "[teachers_notebook_tips_widget]<br />ERROR: " . $errmsg;

			echo $html;

			echo $after_widget;
		}
	}

	function teachers_notebook_tips_widget_shortcode_handler( $argv )
	{
		$errmsg	= "";
		$html	= "";

		if( ($handle = curl_init( "http://www.teachersnotebook.com/widget/generic/tips/" )) !== false )
		{
			curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 15 );
			curl_setopt( $handle, CURLOPT_HEADER, 0 );
			curl_setopt( $handle, CURLOPT_RETURNTRANSFER, 1 );

			if( ($html = curl_exec( $handle )) === false )
				$errmsg = "No Response";

			curl_close( $handle );
		}
		else
			$errmsg = "Internal (URL)";

		if( $errmsg != "" )
			$html = "[teachers_notebook_tips_widget]<br />ERROR: " . $errmsg;

		return $html;
	}


	// register the Widget
	add_action( 'widgets_init', create_function('', 'return register_widget("Teachers_Notebook_Tips_Widget");') );

	// register the shortcode
	add_shortcode( 'teachers_notebook_tips_widget', 'teachers_notebook_tips_widget_shortcode_handler' );
?>
