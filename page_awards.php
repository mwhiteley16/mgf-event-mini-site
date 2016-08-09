<?php
/*
Template Name: Awards Page Template
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();?>

<?php if( has_post_thumbnail() ) : ?>
     <div class="int-page-thumb-con">
          <?php the_post_thumbnail(); ?>
     </div>
<?php endif; ?>

<section class="page-interior">

     <div class="interior-wrap">

          <article class="main-content <?php echo the_title(); ?>">
          
               <div class="page-title-wrap">
                    <h1 class="page-header">
                         <span><?php the_title(); ?></span>
                    </h1>
               </div>

               <div class="page-content">
                    
                    <?php if( have_rows('schedule_date') ):
				     $dateCount = 1; 
                         $numDates = count( get_field('schedule_date')); 
                         if( $numDates == 1 ) {
                              $columnCount = 'full-width';  
                         } elseif( $numDates == 2 ) {
                              $columnCount = 'one-half';
                         } elseif( $numDates == 3 ) {
                              $columnCount = 'one-third';
                         } elseif( $numDates == 4 ) {
                              $columnCount = 'one-fourth';
                         }
                         ?>
				     <div class="schedule-date-con">
                              <?php while( have_rows('schedule_date') ): the_row(); ?>
                                   <div class="schedule-date text-center <?php echo $columnCount; ?> <?php if( $dateCount == 1 ) : ?>first active<?php endif; ?>" data-target="date-<?php echo $dateCount; ?>"><i class="fa fa-caret-down"></i><?php the_sub_field('schedule_event_date'); ?></div>
                              <?php $dateCount++;
                              endwhile; ?>
                         </div>
		   	     <?php endif; ?>

				<?php if( have_rows('schedule_date') ):
					$subDateCount = 1;
                         while( have_rows('schedule_date') ): the_row(); ?>
                              <div id="date-<?php echo $subDateCount; ?>" class="schedule-items-container <?php if( $subDateCount == 1 ) : ?>active<?php endif; ?>">
                                   <?php if( have_rows('event_date_schedule') ):
							     while( have_rows('event_date_schedule') ): the_row();
						    	     
                                        $schedule_item_type_field = get_sub_field('schedule_item_type');
							     $schedule_item_time = get_sub_field('schedule_item_time');
							     $schedule_item_name = get_sub_field('schedule_item_name');
							     $schedule_item_content = get_sub_field('schedule_item_content'); ?>

                                        <div class="schedule-item-inner">
                                             <div class="event-time"><?php echo $schedule_item_time; ?></div>
                                             <div class="schedule-event-item-con">
                                                  <div class="schedule-event-item-inner-con <?php the_sub_field('schedule_item_type'); ?>">
                                                       <span class="schedule-item-name"><?php echo $schedule_item_name; ?></span>
                                                       <?php if( !empty( $schedule_item_content ) ) : ?>
                                                            <i class="fa fa-plus-square"></i>
                                                            <div class="schedule-item-additional"><?php echo $schedule_item_content; ?></div>
                                                       <?php endif; ?>
                                                  </div>
                                             </div>
                                        </div>

								<?php endwhile;
						    endif; ?>
						</div>
                         <?php $subDateCount++;
                         endwhile;
				endif; ?>

               </div>
               
               <?php // Grab variable for nomination link
               $nomination_url = get_field('nomination_url');
               $nomination_link = get_field('nomination_url_link_text');
               if( !empty( $nomination_url ) ) : ?>
               <div class="nomination-button-con">
                    <a class="nomination-url" href="<?php echo $nomination_url; ?>" target="_blank"><?php echo $nomination_link; ?></a>
               </div>
               <?php endif; ?>
               
               <script>
               jQuery(document).ready(function() {
                 // toggle the active class on the date containers to show the proper date based on the day clicked
                 jQuery('.schedule-date').click(function() {
                   var targetDiv = jQuery(this).attr('data-target');
                   jQuery('.schedule-items-container').removeClass('active');
                   jQuery('.schedule-date').removeClass('active');
                   jQuery(this).addClass('active');
                   jQuery('#' + targetDiv + '.schedule-items-container').addClass('active');
                 });
                 jQuery('.schedule-event-item-inner-con i.fa').click(function() {
                   jQuery(this).toggleClass('fa-plus-square fa-minus-square');
                   jQuery(this).siblings('.schedule-item-additional').slideToggle();
                 });
               });
               </script>

          </article><!-- /main-content -->

     </div><!-- /interior-wrap -->

</section><!-- /page-interior -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
