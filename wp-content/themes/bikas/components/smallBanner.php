<?php  $build_folder = get_template_directory_uri() . '/assets/build/';?>

<section class="small-banner">
    <div class="container">
        <div class="small-banner__inner">
            <span class="small-banner__value">
                <?php the_field('sale', 'options');?>
            </span>

           

            <div class="small-banner__coll">

                <div class="small-banner__image">
                    <img width="233" heght="300" src="<?php echo $build_folder?>img/img.png" alt="image">
                </div>  

                <div class="small-banner__content">
                    <span class="small-banner__descr">
                        <?php the_field('title_sale', 'options');?>
                    </span>
                    <h2 class="small-banner__title">
                        <?php the_field('subtitle_sale', 'options');?>
                    </h2>

                    <div class="counter" data-seconds="<?php the_field('timer', 'options');?>"></div>
                </div>

            </div>

        </div>
    </div>
</section>