<?php $custom_css = get_field( 'custom_css', 'option' );
if( $custom_css ) : ?>
     <style><?php echo $custom_css; ?></style>
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


