<?php
/*
Template Name: Schedule Page Template
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

                                        $schedule_item_type_field = get_sub_field( 'schedule_item_type' );
							     $schedule_item_time = get_sub_field( 'schedule_item_time' );
							     $schedule_item_name = get_sub_field( 'schedule_item_name' );
							     $schedule_item_content = get_sub_field( 'schedule_item_content' );
                                        $schedule_item_speakers = get_sub_field( 'schedule_item_speaker' ); ?>

                                        <div class="schedule-item-inner">
                                             <div class="event-time"><?php echo $schedule_item_time; ?></div>
                                             <div class="schedule-event-item-con">
                                                  <div class="schedule-event-item-inner-con <?php the_sub_field('schedule_item_type'); ?>">
                                                       <span class="schedule-item-name"><?php echo $schedule_item_name; ?></span>
                                                       <?php if( !empty( $schedule_item_content ) ) : ?>
                                                            <i class="fa fa-plus-square"></i>
                                                            <div class="schedule-item-additional"><?php echo $schedule_item_content; ?></div>
                                                       <?php endif; ?>
                                                       <?php if( $schedule_item_speakers ): ?>
                                                            <ul class="schedule-speakers-ul">
                                                                 <?php $speaker_count = 0; ?>
                                                                 <?php foreach( $schedule_item_speakers as $post) : $speaker_count++; ?>
                                                                      <?php
                                                                      setup_postdata($post);
                                                                      $speakers_thumbnail = get_the_post_thumbnail();
                                                                      $speakers_name = get_the_title();
                                                                      $speakers_company = get_field( 'speaker_company' );
                                                                      $speakers_title = get_field( 'speaker_title' );
                                                                      ?>
                                                                      <li class="speaker-count-<?php echo $speaker_count; ?> <?php if( $speaker_count < 5 ) : ?>top-speaker-row<?php endif; ?> <?php if( ( $speaker_count - 1 ) % 4 == 0 ) : ?>first<?php endif; ?>">
                                                                           <?php if( $speakers_thumbnail ) : ?>
                                                                                <div class="schedule-speakers-thumb-con-wrapper">
                                                                                     <div class="schedule-speakers-thumb-con">
                                                                                          <?php echo $speakers_thumbnail; ?>
                                                                                     </div>
                                                                                     <?php if( $speaker_count == 1 ) : ?><span class="moderator-tag">Moderator</span><?php endif; ?>
                                                                                </div>
                                                                           <?php endif; ?>
                                                                           <?php if( $speakers_name ) : ?>
                                                                                <span class="schedule-speakers-name"><?php echo $speakers_name; ?></span>
                                                                           <?php endif; ?>
                                                                           <?php if( $speakers_title ) : ?>
                                                                                <span class="schedule-speakers-title"><?php echo $speakers_title; ?></span>
                                                                           <?php endif; ?>
                                                                           <?php if( $speakers_company ) : ?>
                                                                                <span class="schedule-speakers-company"><?php echo $speakers_company; ?></span>
                                                                           <?php endif; ?>
                                                                      </li>
                                                                 <?php endforeach; ?>
                                                            </ul>
                                                            <?php wp_reset_postdata(); ?>
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

                    <?php $show_key = get_field( 'schedule_key_visibility' ); ?>

                    <div class="full-width color-key">
                         <span class="full-width text-center">* agenda is subject to change</span>
                         <?php if( $show_key == 'show-key' ) : ?>
                              <div class="one-fifth first text-center dark-red">MGF Talk</div>
                              <div class="one-fifth second text-center red">KEYNOTE</div>
                              <div class="one-fifth third text-center dark-blue">Presentation</div>
                              <div class="one-sixth fourth text-center blue" style="display:none;">Sponsor</div> <?php // hidden per Louis on 11/18/2016 ?>
                              <div class="one-fifth fifth text-center green">Panel</div>
                              <div class="one-fifth sixth text-center orange">MGF Event</div>
                         <?php endif; ?>
                    </div>

               </div>

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
                   jQuery(this).siblings('ul.schedule-speakers-ul').slideToggle();
                 });
               });
               </script>

          </article><!-- /main-content -->

     </div><!-- /interior-wrap -->

</section><!-- /page-interior -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
