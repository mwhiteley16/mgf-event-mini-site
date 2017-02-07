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
                    <?php the_content(); ?>
               </div>

          </article><!-- /main-content -->

     </div><!-- /interior-wrap -->

</section><!-- /page-interior -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
