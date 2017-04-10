<?php
/*
Template Name: Home Page Template
*/
?>

<?php get_header(); ?>

<section class="home-video">

     <div class="home-bg">

          <img class="mobile-poster" src="<?php the_field('mobile_video_poster'); ?>" alt="Mobile Growth Fellowship">
          <img class="tablet-poster" src="<?php the_field('home_video_image'); ?>" alt="Mobile Growth Fellowship">

          <video id="bgvid" autoplay loop muted playsinline poster="<?php the_field('home_video_image'); ?>">
               <source src="<?php the_field('home_video_url_mp4'); ?>" type='video/mp4'>
               <source src="<?php the_field('home_video_url_webm'); ?>" type='video/webm'>
          </video>

     </div>
     
     <div class="video-event-overlay">
          <div class="home-event-title"><?php the_field('home_event_name'); ?></div>
          <div class="home-event-date-location"><span class="mobile-full"><?php the_field('home_event_date'); ?></span> <span class="desktop-only">&bull;</span> <span class="mobile-full"><?php the_field('home_event_location'); ?></span></div>
          <a class="home-registration-link register-now" href="<?php the_field('register_now_header_link', 'option'); ?>">Register</a>
          
          <?php
               $now = time();
               $eventdate = strtotime(get_field('home_event_date_data'));
               $datediff = $eventdate - $now;
               $days_left = (floor($datediff/(60*60*24)))+1;
          ?>
          
          <div class="home-event-sub-text">
               <?php if( $days_left > 1 ) : ?>
                   Only <span class="strong"><?php echo $days_left; ?></span> days left<span class="desktop-only">, so register now!</span><span class="mobile-only">Register Now!</span>
               <?php elseif( $days_left == 1 ) : ?>
                   Only <span class="strong"><?php echo $days_left; ?></span> day left<span class="desktop-only">, so register now!</span><span class="mobile-only">Register Now!</span>
               <?php elseif( $days_left == 0 ) : ?>
                   <span class="strong">SOLD OUT!</span>!
               <?php elseif( $days_left == -1 ) : ?>
                   <span class="strong">SOLD OUT!</span> 
               <?php else : ?>
                    This event has passed.
               <?php endif; ?>
          </div>
     </div>
     
</section>

<section class="home-section-2 home-section">
     <div class="page-interior">
          <div class="interior-wrap">
               <div class="section-2-content text-center">
                    <h1 class="desktop-only"><?php the_field('section2_header'); ?></h1>
                    <h2 class="desktop-only"><?php the_field('section2_event_location'); ?> &bull; <?php the_field('section2_event_date'); ?></h2>
                    <div class="home-section2-desc"><?php the_field('section2_event_description'); ?></div>
               </div>
          </div>
     </div>
</section>

<?php if( have_rows('keynotes_by', 'option') ) : ?>
<section class="keynote-companies home-section">
     <div class="page-interior">
          <div class="interior-wrap border-top">
               <h2 class="home-section-header">Keynotes by:</h2>
               <div class="keynote-logo-wrapper">
               <?php
               $itemCount = '1';
               $itemSpot = 'first';
		       while( have_rows('keynotes_by', 'option') ) : the_row(); ?>
                    <?php
                    $keynote_name = get_sub_field('keynote_name');
                    $keynote_logo = get_sub_field('keynote_logo');
                    $keynote_link = get_sub_field('keynote_link');
                    ?>
                    <div class="keynote-item one-third <?php echo $itemSpot; ?> item-<?php echo $itemCount; ?>">
                         <?php if( !empty( $keynote_link ) ) : ?>
                              <a href="<?php echo $keynote_link; ?>" target="_blank">
                         <?php endif; ?>
                              <img class="keynote-logo" src="<?php echo $keynote_logo; ?>" alt="<?php echo $keynote_name; ?> Logo">
                         <?php if( !empty( $keynote_link ) ) : ?>
                              </a>
                         <?php endif; ?>
                    </div>
               <?php if( $itemCount == '3' ) {
                    $itemCount = 1;
                    $itemSpot = 'first';
               } elseif( $itemCount == '2' ) {
                    $itemCount++;
                    $itemSpot = 'third';  
               } elseif( $itemCount == '1' ) {
                    $itemCount++;
                    $itemSpot = 'second';
               }
               endwhile; ?>
               </div>
          </div>
     </div>
</section>
<?php endif; ?>

<section class="featured-speakers home-section">
     <div class="page-interior">
          <div class="interior-wrap">
               <h2 class="home-section-header">Featured Speakers:</h2>
               <?php echo do_shortcode('[mgf-speakers featured="yes"]'); ?>
               <a class="all-speakers" href="<?php echo get_home_url(); ?>/speakers">Check out the full list of Speakers...</a>
          </div>
     </div>
</section>

<section id="venue-section" class="venue-section home-section">
     <div class="page-interior">
          <div class="interior-wrap">
               <div class="venue-img-wrap">
                    <img src="<?php the_field('home_venue_image'); ?>" alt="<?php the_field('home_venue_image_alt'); ?>">
                    <div class="venue-content-box">
                         <span class="venue-header">Venue</span>
                         <div class="venue-content">
                              <?php the_field('home_venue_content'); ?>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</section>

<section id="sponsors-section" class="sponsors-section home-section">
     <div class="page-interior">
          <div class="interior-wrap">
               <h2 class="home-section-header">Sponsors:</h2>
               <?php echo do_shortcode('[mgf-sponsors level="diamond"]'); ?>
               <?php echo do_shortcode('[mgf-sponsors level="platinum"]'); ?>
               <?php echo do_shortcode('[mgf-sponsors level="gold"]'); ?>
               <?php echo do_shortcode('[mgf-sponsors level="silver"]'); ?>
               <?php echo do_shortcode('[mgf-sponsors level="bronze"]'); ?>
               <?php echo do_shortcode('[mgf-sponsors level="media-partner"]'); ?> 
          </div>
     </div>
</section>

<?php get_footer(); ?>
