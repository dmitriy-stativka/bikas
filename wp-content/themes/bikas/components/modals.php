<?php $build_folder = get_template_directory_uri() . '/assets/build/' ?>
<div class="overlay" data-overlay>
    

    <div id="cart-dialog" data-popup="cart" class="modal-dialog modal">
        <div>
            <a href="#close" title="Close" class="modal-dialog-close">&times;</a>
            <?php the_widget('WC_Widget_Cart'); ?>
        </div>
    </div>
    <div id="callback-dialog" data-popup="dialog" class="modal-dialog modal">
        <div>
            <a href="#close" title="Close" class="modal-dialog-close">&times;</a>
            <?php echo do_shortcode('[contact-form-7 id="4486" title="CF1"]'); ?>
        </div>
    </div>
</div>

