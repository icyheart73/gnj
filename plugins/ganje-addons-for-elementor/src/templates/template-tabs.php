<?php
/**
 * View template for Ganje Tabs widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */
 $id_int = substr( $this->get_id_int(), 0, 3 );
 ?>
 <div class="gnje-tabs" role="tablist">
     <div class="gnje-tabs-wrapper">
         <?php
         foreach ( $tabs as $index => $item ) :
             $tab_count = $index + 1;

             $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index );

             $this->add_render_attribute( $tab_title_setting_key, [
                 'id' => 'gnje-tabs-tab-title-' . $id_int . $tab_count,
                 'class' => [ 'gnje-tabs-tab-title', 'gnje-tabs-tab-desktop-title' ],
                 'data-tab' => $tab_count,
                 'role' => 'tab',
                 'aria-controls' => 'gnje-tabs-tab-content-' . $id_int . $tab_count,
             ] );
             ?>
             <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>><a href=""><?php echo $item['tab_title']; ?></a></div>
         <?php endforeach; ?>
     </div>
     <div class="gnje-tabs-content-wrapper">
         <?php
         foreach ( $tabs as $index => $item ) :
             $tab_count = $index + 1;

             $tab_content_setting_key = $this->get_repeater_setting_key('tab_content', 'tabs', $index );

             $tab_title_mobile_setting_key = $this->get_repeater_setting_key('tab_title_mobile', 'tabs', $tab_count );

             $this->add_render_attribute( $tab_content_setting_key, [
                 'id' => 'gnje-tabs-tab-content-' . $id_int . $tab_count,
                 'class' => [ 'gnje-tabs-tab-content', 'gnje-tabs-clearfix' ],
                 'data-tab' => $tab_count,
                 'role' => 'tabpanel',
                 'aria-labelledby' => 'gnje-tabs-tab-title-' . $id_int . $tab_count,
             ] );

             $this->add_render_attribute( $tab_title_mobile_setting_key, [
                 'class' => [ 'gnje-tabs-tab-title', 'gnje-tabs-tab-mobile-title' ],
                 'data-tab' => $tab_count,
                 'role' => 'tab',
             ] );

             $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced');
             ?>
             <div <?php echo $this->get_render_attribute_string( $tab_title_mobile_setting_key ); ?>><?php echo $item['tab_title']; ?></div>
             <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
         <?php endforeach; ?>
     </div>
 </div>
 <?php
