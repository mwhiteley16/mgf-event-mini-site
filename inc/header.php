<?php
$custom_css = get_field( 'custom_css', 'option' );
$primary_color = get_field( 'primary_color', 'option' );
$link_color = get_field( 'link_color', 'option' );
$secondary_color = get_field( 'secondary_color', 'option' );
function hex2rgba($color, $opacity = false) { // convert hex to rgba for opaque use

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}
$primary_color_rgba = hex2rgba($primary_color, 0.8);
if( $custom_css || $primary_color || $secondary_color ) : ?>
     <style>
          <?php echo $custom_css; ?>
          a.register-now,
          a.home-registration-link,
          a.register-now:visited,
		a.register-now:hover,
          a.home-register-link:visited,
          .schedule-date.active,
		.schedule-item-inner .schedule-event-item-inner-con.green,
		.color-key div.green {
               background-color: <?php echo $link_color; ?>;
               color: #fff;
          }
		.schedule-item-inner .schedule-event-item-inner-con.blue,
		.color-key div.blue {
			background-color: <?php echo $secondary_color; ?>;
			color: #fff;
		}
          a, a:visited,
          .schedule-date i.fa {
               color: <?php echo $link_color; ?>;
			-webkit-transition: all 300ms ease;
			-moz-transition: all 300ms ease;
			-o-transition: all 300ms ease;
			transition: all 300ms ease;
          }
          ul#menu-main-menu > li:hover > a,
          ul#menu-main-menu > li.current-menu-parent a {
               color: #336699;
               border-bottom: 7px solid <?php echo $primary_color; ?>;
          }
          .home-section-2 h1,
          h2,
          .team-member-name,
          h1.page-header span,
		.schedule-date:hover > i.fa,
          ul#menu-main-menu > li > a:hover {
               color: <?php echo $primary_color; ?>;
          }
          .venue-content-box,
          .team-member-img-con:hover {
               background-color: <?php echo $primary_color_rgba; ?>;
          }
          .speaker-popup,
          .schedule-date:hover,
          .schedule-item-inner .schedule-event-item-inner-con.dark-blue,
          .color-key div.dark-blue {
               background-color: <?php echo $primary_color; ?>;
          }
          @media(max-width:1025px) {
          .navigation {
               background-color: <?php echo $primary_color; ?>;
          }
          }
     </style>
<?php endif; ?>

<section class="header-con">
     <a href="<?php echo get_home_url(); ?>"><img src="<?php the_field('site_logo', 'option'); ?>" alt="<?php the_field('site_logo_alt_text', 'option'); ?>"></a>
     <a class="register-now" href="<?php the_field('register_now_header_link', 'option'); ?>" target="_blank">Register Now</a>
     <div class="navigation">
          <?php wp_nav_menu( array('menu' => 'Main Menu', 'container_class' => 'main-menu-con' )); ?>
     </div>
</section>

<?php
// check to make sure we're on the home page since we only want this functionality for that nav
if( is_front_page() ) : ?>
<script>
jQuery(document).ready(function() {
// scroll to the correct section based on the navigation item clicked while preventing the default links
jQuery('ul.menu li.sponsors-nav > a').on('click', function(event) {
    event.preventDefault();
    jQuery('html, body').animate({
         scrollTop: jQuery('.sponsors-section').offset().top
    }, 1000);
});
jQuery('ul.menu li.venue-nav > a').on('click', function(event) {
    event.preventDefault();
    jQuery('html, body').animate({
         scrollTop: jQuery('.venue-section').offset().top
    }, 1000);
});
});
</script>
<?php endif; ?>

<?php
// Check to see if the external link option is checked and if not render the popup for registration and script for functionality
if( !in_array( 'External Link', get_field('link_or_iframe', 'option') ) ) : ?>

<div class="register-now-container" style="display: none;">
<i class="fa fa-times-circle close-registration"></i>
     <?php the_field('register_now_iframe', 'option'); ?>
</div>

<script>
jQuery(document).ready(function() {
  // function to show/hide the registration popup when clicking the register now button
  jQuery('a.register-now').click(function(event) {
    event.preventDefault();
    jQuery('.register-now-container').fadeIn();
  });
  jQuery('li.registration-menu-link a').click(function(event) {
     event.preventDefault();
     jQuery('.register-now-container').fadeIn();
  });
  // close it when you click the 'x'
  jQuery('i.close-registration').click(function() {
    jQuery('.register-now-container').fadeOut();
  });
  // close it when you click outside of the container
  jQuery(document).mouseup(function (e) {
    var container = jQuery('.register-now-container');
    if( !container.is(e.target) && container.has(e.target).length === 0 ) {
      container.fadeOut();
    }
  });
});
</script>

<?php endif; ?>

<?php if( is_page( 'speakers' ) ) : ?>
<script>
jQuery(document).ready(function() {
// popup on speakers page
// use the data-target attribute of the link to find the correct div and show it and scroll to the right part of the page
jQuery('.team-member-img-con').click(function() {
     var targetDiv = jQuery(this).attr('data-target');
     jQuery('#' + targetDiv).fadeIn();
     jQuery('html, body').animate({
          scrollTop: jQuery('.page-content').offset().top - 130
     }, 1000);
});
// hide the lightbox popup
jQuery('i.close-speaker-lightbox').click(function() {
     jQuery('.speaker-popup').fadeOut();
});
});
jQuery(document).mouseup(function (e) {
     var container = jQuery('.speaker-popup');
     if( !container.is(e.target) && container.has(e.target).length === 0 ) {
          container.fadeOut();
     }
});
</script>
<?php endif; ?>
