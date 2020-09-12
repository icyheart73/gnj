<?php
$tag = is_home() || is_front_page() ? 'h1' : 'p';
?>
<div class="logo_wrapper col-2" itemtype="http://schema.org/Store">
    <a href="<?php echo esc_url(home_url('/')); ?>" itemprop="url">
        <?php
        if(isset($GanjeSetting['gnj_logo'])) { ?>
           <img itemprop="logo" src="<?=$GanjeSetting['gnj_logo'] ?>" alt="<?php bloginfo('name') ?>"/>
       <?php
        }
        ?>
        <<?=$tag ?>><span itemprop="name"><?php bloginfo('name'); ?></span></<?=$tag ?>>
        <span itemprop="description"><?php bloginfo('description') ?></span>
    </a>
</div>
<div class="col">
    1 of 3
</div>
<div class="col">
    3 of 3
</div>

