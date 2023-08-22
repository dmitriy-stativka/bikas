<?php $build_folder = get_template_directory_uri() . '/assets/build/' ?>
<div class="overlay" data-overlay>
    

    <div id="cart-dialog" data-popup="cart" class="modal-dialog modal">
        <div class="modal__inner">
            <button class="close">
                <svg width='35' height='35'>
                    <use href='<?php echo $build_folder?>img/sprite/sprite.svg#close'></use>
                </svg>
            </button>
            <?php the_widget('WC_Widget_Cart'); ?>
        </div>
    </div>
    <div id="callback-dialog" data-popup="dialog" class="modal-dialog modal">
        <div class="modal__inner">
            <button class="close">
                <svg width='35' height='35'>
                    <use href='<?php echo $build_folder?>img/sprite/sprite.svg#close'></use>
                </svg>
            </button>

            <?php echo do_shortcode('[contact-form-7 id="4486" title="CF1"]'); ?>
        </div>
    </div>
</div>

