<?php 
/* 
Plugin Name: Wy Recent Post Thumbnail  Widget
Plugin URI: https://github.com/mastrayasa/Wy-Recent-Post-Thumbnail-Widget
Description: Widget Recent Post with Thumbnail
Version: 1.0
Author: Mastrayasa
Author URI: http://www.facebook.com/mastrayasa
*/


class wy_recent_post_thumbnail extends WP_Widget { 
	
	
	
	/** constructor */
    function wy_recent_post_thumbnail() {
		$widget_ops = array('description' => __('Show Recent Post Thumbnail') );
        parent::WP_Widget(false, ' Recent Post Thumbnail ',$widget_ops);
    }

	
	
	
    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
		
        $title 	= apply_filters('widget_title', $instance['title']);
		$limit 	= $instance['limit'];

        echo $before_widget; 
        if ( $title )
			echo $before_title . $title . $after_title;  	
		
        if($limit==''){$limit=4;}
		 
		query_posts( array( 'posts_per_page'=> $limit ) ); 
		
		echo '<ul class="recent-post-thumb">';
		while ( have_posts() ) : the_post(); 
			?><li><div><?php 
				 if ( has_post_thumbnail()) {
				   $medium = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium	');
					?><a href="<?php the_permalink() ?>"  title="<?php the_title(); ?>"><img src="<?php echo $medium[0];?>" alt="<?php the_title() ?>"></a><?php 
				} 
			?></div></li><?php
		endwhile;
		
        echo '</ul>'.$after_widget; 
		
		wp_reset_query();
    }

	
	
	
	
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }

	
	
	
	
    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $limit = esc_attr($instance['limit']);
		if($limit==''){$limit=4;}
        ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title : '); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit :'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" />
        </p>
        <?php 
    }
	
	
} 


# ADD STYLE
wp_register_style('rcstyle', plugins_url('css/wy_recent_post_thumbnail_style.css',__FILE__));
wp_enqueue_style( 'rcstyle');


# RUN WIDGET
add_action('widgets_init', create_function('', 'return register_widget("wy_recent_post_thumbnail");'));
?>
