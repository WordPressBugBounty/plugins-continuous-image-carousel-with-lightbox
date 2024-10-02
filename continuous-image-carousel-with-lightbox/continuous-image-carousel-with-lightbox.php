<?php
     /* 
    Plugin Name: Continuous Image Carousel With Lightbox
    Plugin URI:https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/
    Author URI:https://www.i13websolution.com
    Description:Continuous Image Carousel With Lightbox is beautiful responsive continuous thumbnail image slider with responsive lightbox.Add any number of images from admin panel.
    Author:I Thirteen Web Solution
    Version:1.0.18
    Text Domain:continuous-image-carousel-with-lightbox
    Domain Path: /languages
    */
    //error_reporting(0);
    add_filter('widget_text', 'do_shortcode');
    add_action('admin_menu', 'continuous_slider_plus_lightbox_add_admin_menu');
    //add_action( 'admin_init', 'continuous_slider_plus_lightbox_plugin_admin_init' );
    register_activation_hook(__FILE__,'install_continuous_slider_plus_lightbox');
    register_deactivation_hook(__FILE__,'cicwl_continuous_slider_plus_lightbox_remove_access_capabilities');
    add_action('wp_enqueue_scripts', 'continuous_slider_plus_lightbox_load_styles_and_js');
    add_shortcode( 'print_continuous_slider_plus_lightbox', 'print_continuous_slider_plus_lightbox_func' );
    add_action('admin_notices', 'continuous_slider_plus_lightbox_admin_notices');
    add_action('plugins_loaded', 'cicwl_lang_for_wp_continuous_slider_with_lightbox');
    add_filter( 'user_has_cap', 'cicwl_continuous_slider_plus_lightbox_admin_cap_list' , 10, 4 );
    add_action( 'wp_ajax_mass_upload_wrthsliderlboxcont', 'wrthslider_slider_mass_upload_wrthsliderlboxcont' );
    
    function cicwl_lang_for_wp_continuous_slider_with_lightbox() {
      
      load_plugin_textdomain( 'continuous-image-carousel-with-lightbox', false, basename( dirname( __FILE__ ) ) . '/languages/' );
      add_filter( 'map_meta_cap',  'map_cicwl_continuous_slider_plus_lightbox_meta_caps', 10, 4 );
    }
    
    function map_cicwl_continuous_slider_plus_lightbox_meta_caps( array $caps, $cap, $user_id, array $args  ) {
        
       
        if ( ! in_array( $cap, array(
                                      'cicwl_continuous_slider_settings',
                                      'cicwl_continuous_slider_view_images',
                                      'cicwl_continuous_slider_add_image',
                                      'cicwl_continuous_slider_edit_image',
                                      'cicwl_continuous_slider_delete_image',
                                      'cicwl_continuous_slider_preview',
                                      
                                    ), true ) ) {
            
			return $caps;
         }

       
         
   
        $caps = array();

        switch ( $cap ) {
            
                 case 'cicwl_continuous_slider_settings':
                        $caps[] = 'cicwl_continuous_slider_settings';
                        break;
              
                 case 'cicwl_continuous_slider_view_images':
                        $caps[] = 'cicwl_continuous_slider_view_images';
                        break;
              
                case 'cicwl_continuous_slider_add_image':
                        $caps[] = 'cicwl_continuous_slider_add_image';
                        break;
              
                case 'cicwl_continuous_slider_edit_image':
                        $caps[] = 'cicwl_continuous_slider_edit_image';
                        break;
              
                case 'cicwl_continuous_slider_delete_image':
                        $caps[] = 'cicwl_continuous_slider_delete_image';
                        break;
              
                case 'cicwl_continuous_slider_preview':
                        $caps[] = 'cicwl_continuous_slider_preview';
                        break;
              
                default:
                        
                        $caps[] = 'do_not_allow';
                        break;
        }

      
     return apply_filters( 'cicwl_continuous_slider_plus_lightbox_meta_caps', $caps, $cap, $user_id, $args );
}


 function cicwl_continuous_slider_plus_lightbox_admin_cap_list($allcaps, $caps, $args, $user){
        
        
        if ( ! in_array( 'administrator', $user->roles ) ) {
            
            return $allcaps;
        }
        else{
            
            if(!isset($allcaps['cicwl_continuous_slider_settings'])){
                
                $allcaps['cicwl_continuous_slider_settings']=true;
            }
            
            if(!isset($allcaps['cicwl_continuous_slider_view_images'])){
                
                $allcaps['cicwl_continuous_slider_view_images']=true;
            }
            
            if(!isset($allcaps['cicwl_continuous_slider_add_image'])){
                
                $allcaps['cicwl_continuous_slider_add_image']=true;
            }
            if(!isset($allcaps['cicwl_continuous_slider_edit_image'])){
                
                $allcaps['cicwl_continuous_slider_edit_image']=true;
            }
            if(!isset($allcaps['cicwl_continuous_slider_delete_image'])){
                
                $allcaps['cicwl_continuous_slider_delete_image']=true;
            }
            if(!isset($allcaps['cicwl_continuous_slider_preview'])){
                
                $allcaps['cicwl_continuous_slider_preview']=true;
            }
         
        }
        
        return $allcaps;
        
    }

function  cicwl_continuous_slider_plus_lightbox_add_access_capabilities() {
     
    // Capabilities for all roles.
    $roles = array( 'administrator' );
    foreach ( $roles as $role ) {
        
            $role = get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }
         
            
            if(!$role->has_cap( 'cicwl_continuous_slider_settings' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_settings' );
            }
            
            if(!$role->has_cap( 'cicwl_continuous_slider_view_images' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_view_images' );
            }
         
            
            if(!$role->has_cap( 'cicwl_continuous_slider_add_image' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_add_image' );
            }
            
            if(!$role->has_cap( 'cicwl_continuous_slider_edit_image' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_edit_image' );
            }
            
            if(!$role->has_cap( 'cicwl_continuous_slider_delete_image' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_delete_image' );
            }
            
            if(!$role->has_cap( 'cicwl_continuous_slider_preview' ) ){
            
                    $role->add_cap( 'cicwl_continuous_slider_preview' );
            }
            
         
    }
    
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}

function cicwl_continuous_slider_plus_lightbox_remove_access_capabilities(){
    
    global $wp_roles;

    if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
    }

    foreach ( $wp_roles->roles as $role => $details ) {
            $role = $wp_roles->get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }

            $role->remove_cap( 'cicwl_continuous_slider_settings' );
            $role->remove_cap( 'cicwl_continuous_slider_view_images' );
            $role->remove_cap( 'cicwl_continuous_slider_add_image' );
            $role->remove_cap( 'cicwl_continuous_slider_edit_image' );
            $role->remove_cap( 'cicwl_continuous_slider_delete_image' );
            $role->remove_cap( 'cicwl_continuous_slider_preview' );
       

    }

    // Refresh current set of capabilities of the user, to be able to directly use the new caps.
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}

    function continuous_slider_plus_lightbox_admin_notices() {
        
        if (is_plugin_active('continuous-image-carousel-with-lightbox/continuous-image-carousel-with-lightbox.php')) {
            
            $uploads = wp_upload_dir();
            $baseDir=$uploads['basedir'];
            $baseDir=str_replace("\\","/",$baseDir);
            $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
            
            if(file_exists($pathToImagesFolder) and is_dir($pathToImagesFolder)){
                
                if( !is_writable($pathToImagesFolder)){
                        echo "<div class='updated'><p>".__( 'Continuous Image Carousel With Lightbox is active but does not have write permission on','continuous-image-carousel-with-lightbox')."</p><p><b>".$pathToImagesFolder."</b> ".__( 'directory.Please allow write permission','continuous-image-carousel-with-lightbox'). ".</p></div> ";
                } 
                
                      
            }
            else{
               
                  wp_mkdir_p($pathToImagesFolder);  
                   if(!file_exists($pathToImagesFolder) and !is_dir($pathToImagesFolder)){
                    echo "<div class='updated'><p>".__( 'Continuous Image Carousel With Lightbox is active but plugin does not have permission to create directory','continuous-image-carousel-with-lightbox')."</p><p><b>".$pathToImagesFolder."</b> .".__( 'Please create circle-image-slider-with-lightbox directory inside upload directory and allow write permission.','continuous-image-carousel-with-lightbox')."</p></div> "; 
                    
                  }
                  
                 
            }
        }
    }


    function continuous_slider_plus_lightbox_load_styles_and_js(){
        
        if (!is_admin()) {                                                       


            wp_register_style( 'images-continuous-thumbnail-slider-plus-lighbox-style', plugins_url('/css/images-continuous-thumbnail-slider-plus-lighbox-style.css', __FILE__),array(),'1.0.10' );
            wp_register_style( 'continuous-l-box-css', plugins_url('/css/continuous-l-box-css.css', __FILE__),array(),'1.0.10' );
            wp_register_script('images-continuous-thumbnail-slider-plus-lightbox-jc',plugins_url('/js/images-continuous-thumbnail-slider-plus-lightbox-jc.js', __FILE__),array('jquery'),'1.0.13');
            wp_register_script('continuous-l-box-js',plugins_url('/js/continuous-l-box-js.js', __FILE__),array('jquery'),'1.0.12');

          

        }  
    }

    function install_continuous_slider_plus_lightbox(){

        global $wpdb;
        $table_name = $wpdb->prefix . "continuous_image_carousel";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE " . $table_name . " (
         `id` int(10)  NOT NULL AUTO_INCREMENT,
         `title` varchar(1000)  NOT NULL,
         `image_name` varchar(500) NOT NULL,
         `image_description` text  DEFAULT NULL,
         `image_order` int(11) NOT NULL DEFAULT '0',
         `open_link_in` tinyint(1) NOT NULL DEFAULT '1',
         `enable_light_box_img_desc` tinyint(1) NOT NULL DEFAULT '1',
         `createdon` datetime NOT NULL,
         `custom_link` varchar(1000)  DEFAULT NULL,
         `post_id` int(10)  DEFAULT NULL,
         `slider_id` int(10)  NOT NULL DEFAULT '1',
         PRIMARY KEY (`id`)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);


        $continuous_thumbnail_slider_plus_lightbox_settings=array('pauseonmouseover' => '1','speed' => '15000','imageheight' => '120','imagewidth' => '120','visible'=> '5','min_visible'=> '1','resizeImages'=>'1','scollerBackground'=>'#FFFFFF','imageMargin'=>'15');

        $existingopt=get_option('continuous_thumbnail_slider_plus_lightbox_settings');
        if(!is_array($existingopt)){

             update_option('continuous_thumbnail_slider_plus_lightbox_settings',$continuous_thumbnail_slider_plus_lightbox_settings);

         }
         else{

             $flag=false;
             if(!isset($existingopt['show_caption'])){

                $flag=true; 
                $existingopt['show_caption']='0'; 

             }
            

             if($flag==true){

                update_option('continuous_thumbnail_slider_plus_lightbox_settings', $existingopt); 

               }
         }

         $uploads = wp_upload_dir();
         $baseDir=$uploads['basedir'];
         $baseDir=str_replace("\\","/",$baseDir);
         $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
         wp_mkdir_p($pathToImagesFolder);  
         cicwl_continuous_slider_plus_lightbox_add_access_capabilities();
          

    } 




    function continuous_slider_plus_lightbox_add_admin_menu(){

        $hook_suffix_r_l=add_menu_page( __( 'Continuous Slider plus Lightbox','continuous-image-carousel-with-lightbox'), __( 'Continuous Slider plus Lightbox','continuous-image-carousel-with-lightbox'), 'cicwl_continuous_slider_settings', 'continuous_thumbnail_slider_with_lightbox', 'continuous_thumbnail_slider_with_lightbox_admin_options_func' );
        $hook_suffix_r_l=add_submenu_page( 'continuous_thumbnail_slider_with_lightbox', __( 'Manage Sliders','continuous-image-carousel-with-lightbox'), __( 'Slider Settings','continuous-image-carousel-with-lightbox' ),'cicwl_continuous_slider_settings', 'continuous_thumbnail_slider_with_lightbox', 'continuous_thumbnail_slider_with_lightbox_admin_options_func' );
        $hook_suffix_r_l_1=add_submenu_page( 'continuous_thumbnail_slider_with_lightbox', __( 'Manage Images','continuous-image-carousel-with-lightbox'), __( 'Manage Images','continuous-image-carousel-with-lightbox'),'cicwl_continuous_slider_view_images', 'continuous_thumbnail_slider_with_lightbox_image_management', 'continuous_thumbnail_slider_with_lightbox_image_management_func' );
        $hook_suffix_r_l_2=add_submenu_page( 'continuous_thumbnail_slider_with_lightbox', __( 'Preview Slider','continuous-image-carousel-with-lightbox'), __( 'Preview Slider','continuous-image-carousel-with-lightbox'),'cicwl_continuous_slider_preview', 'continuous_thumbnail_slider_with_lightbox_preview', 'continuous_thumbnail_slider_with_lightbox_admin_preview_func' );

        add_action( 'load-' . $hook_suffix_r_l , 'continuous_slider_plus_lightbox_plugin_admin_init' );
        add_action( 'load-' . $hook_suffix_r_l_1 , 'continuous_slider_plus_lightbox_plugin_admin_init' );
        add_action( 'load-' . $hook_suffix_r_l_2 , 'continuous_slider_plus_lightbox_plugin_admin_init' );

    }

    function continuous_slider_plus_lightbox_plugin_admin_init(){


            $url = plugin_dir_url(__FILE__);  
            wp_enqueue_script( 'jquery.validate', $url.'js/jquery.validate.js' );  
            wp_enqueue_style( 'images-continuous-thumbnail-slider-plus-lighbox-style', plugins_url('/css/images-continuous-thumbnail-slider-plus-lighbox-style.css', __FILE__) );
            wp_enqueue_style( 'continuous-l-box-css', plugins_url('/css/continuous-l-box-css.css', __FILE__) );
            wp_enqueue_style( 'admin-css-cont-carousel-gallery', plugins_url('/css/admin-css.css', __FILE__) );
            wp_enqueue_script('jquery'); 
            wp_enqueue_script('images-continuous-thumbnail-slider-plus-lightbox-jc',plugins_url('/js/images-continuous-thumbnail-slider-plus-lightbox-jc.js', __FILE__));
            wp_enqueue_script('continuous-l-box-js',plugins_url('/js/continuous-l-box-js.js', __FILE__));
            continuous_slider_plus_lightbox_admin_scripts_init();



    }

    function continuous_thumbnail_slider_with_lightbox_admin_options_func(){

         if ( ! current_user_can( 'cicwl_continuous_slider_settings' ) ) {

           wp_die( __( "Access Denied", "continuous-image-carousel-with-lightbox" ) );

         } 
        
        if(isset($_POST['btnsave'])){

             if ( !check_admin_referer( 'action_image_add_edit','add_edit_image_nonce')){

                wp_die('Security check fail'); 
             }

            $speed=(int) trim(htmlentities(sanitize_text_field($_POST['speed']),ENT_QUOTES));
            

            //$scrollerwidth=$_POST['scrollerwidth'];

            $visible=intval(htmlentities(sanitize_text_field($_POST['visible']),ENT_QUOTES));

            $min_visible=intval(htmlentities(sanitize_text_field($_POST['min_visible']),ENT_QUOTES));


            if(isset($_POST['pauseonmouseover']))
                $pauseonmouseover=true;  
            else 
                $pauseonmouseover=false;

            if(isset($_POST['lightbox']))
                $lightbox=true;  
            else 
                $lightbox=false;


            $imageMargin=(int)trim(htmlentities(sanitize_text_field($_POST['imageMargin']),ENT_QUOTES));
            $imageheight=(int)trim(htmlentities(sanitize_text_field($_POST['imageheight']),ENT_QUOTES));
            $imagewidth=(int)trim(htmlentities(sanitize_text_field($_POST['imagewidth']),ENT_QUOTES));

            $scollerBackground=trim(htmlentities(sanitize_text_field($_POST['scollerBackground']),ENT_QUOTES));

            $show_caption=intval(htmlentities(sanitize_text_field($_POST['show_caption'],ENT_QUOTES)));  
    
            $options=array();
            $options['pauseonmouseover']=$pauseonmouseover;  
            $options['lightbox']=$lightbox;  
            $options['speed']=$speed;  
            //$options['scrollerwidth']=$scrollerwidth;  
            $options['imageMargin']=$imageMargin;  
            $options['imageheight']=$imageheight;  
            $options['imagewidth']=$imagewidth;  
            $options['visible']=$visible;  
            $options['min_visible']=$min_visible;  
            $options['resizeImages']=1;  
            $options['scollerBackground']=$scollerBackground;  
            $options['show_caption']=$show_caption;  
           

            $settings=update_option('continuous_thumbnail_slider_plus_lightbox_settings',$options); 
            $continuous_thumbnail_slider_plus_lightbox_messages=array();
            $continuous_thumbnail_slider_plus_lightbox_messages['type']='succ';
            $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Settings saved successfully.','continuous-image-carousel-with-lightbox');
            update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);



        }  
        $settings=get_option('continuous_thumbnail_slider_plus_lightbox_settings');

        if(!isset($settings['show_caption'])){
            
            $settings['show_caption']=0;
        }
        
       
        

    ?>      
    <div id="poststuff" > 
        <div id="post-body" class="metabox-holder columns-2" >  
            <div id="post-body-content">
                <div class="wrap">
                    <table><tr>
                            <td>
                                    <div class="fb-like" data-href="https://www.facebook.com/i13websolution" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                                    <div id="fb-root"></div>
                                      <script>(function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return;
                                        js = d.createElement(s); js.id = id;
                                        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=158817690866061&autoLogAppEvents=1';
                                        fjs.parentNode.insertBefore(js, fjs);
                                      }(document, 'script', 'facebook-jssdk'));</script>
                                </td> 
                            <td>
                                <a target="_blank" title="Donate" href="http://www.i13websolution.com/donate-wordpress_image_thumbnail.php">
                                    <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
                                </a>
                            </td>
                        </tr>
                    </table>

                    <?php
                        $messages=get_option('continuous_thumbnail_slider_plus_lightbox_messages'); 
                        $type='';
                        $message='';
                        if(isset($messages['type']) and $messages['type']!=""){

                            $type=$messages['type'];
                            $message=$messages['message'];

                        }  


                        if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                        else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
       

                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', array());     
                    ?>      

                    <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/"><?php echo __('UPGRADE TO PRO VERSION','continuous-image-carousel-with-lightbox');?></a></h3></span>
                    
                    <h2><?php echo __('Slider Settings','continuous-image-carousel-with-lightbox');?></h2>
                    <div id="poststuff">
                        <div id="post-body" class="metabox-holder columns-2">
                            <div id="post-body-content">
                                <form method="post" action="" id="scrollersettiings" name="scrollersettiings" >


                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label ><?php echo __('Speed','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="speed" size="30" name="speed" value="<?php echo $settings['speed']; ?>" style="width:100px;">
                                                        <div style="clear:both"><?php echo __('Example 15000','continuous-image-carousel-with-lightbox');?></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div style="clear:both"></div>

                                        </div>
                                    </div>
                                     <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Display Lightbox On Image Click?','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id="lightboxz" size="30" name="lightbox" value="" <?php if(isset($settings['lightbox']) and $settings['lightbox']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;Display Lightbox ? 
                                                        <div style="clear:both;margin-top:3px"><?php echo __('On click Of Image Show Lightbox','continuous-image-carousel-with-lightbox');?></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Slider Background Color','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="scollerBackground" size="30" name="scollerBackground" value="<?php echo $settings['scollerBackground']; ?>" style="width:100px;">
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Max Visible','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="visible" size="30" name="visible" value="<?php echo $settings['visible']; ?>" style="width:100px;">
                                                        <div style="clear:both"><?php echo __('This will decide your slider width automatically','continuous-image-carousel-with-lightbox');?></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php echo __('Specify the number of items visible at all times within the slider.','continuous-image-carousel-with-lightbox');?>
                                            <div style="clear:both"></div>

                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Min Visible','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="min_visible" size="30" name="min_visible" value="<?php echo $settings['min_visible']; ?>" style="width:100px;">
                                                        <div style="clear:both"><?php echo __('This will decide your slider width in responsive layout','continuous-image-carousel-with-lightbox');?></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php echo __('The responsive layout decide by slider itself using min visible.','continuous-image-carousel-with-lightbox');?>
                                            <div style="clear:both"></div>

                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Pause On Mouse Over?','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id="pauseonmouseover" size="30" name="pauseonmouseover" value="" <?php if($settings['pauseonmouseover']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;Pause On Mouse Over ? 
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Image Height','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="imageheight" size="30" name="imageheight" value="<?php echo $settings['imageheight']; ?>" style="width:100px;">
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Image Width','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="imagewidth" size="30" name="imagewidth" value="<?php echo $settings['imagewidth']; ?>" style="width:100px;">
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __('Image Margin','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="imageMargin" size="30" name="imageMargin" value="<?php echo $settings['imageMargin']; ?>" style="width:100px;">
                                                        <div style="clear:both;padding-top:5px"><?php echo __('Gap between two images','continuous-image-carousel-with-lightbox');?> </div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <div style="clear:both"></div>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label><?php echo __( 'Show Caption?','wp-responsive-slider-with-lightbox');?></label></h3>
                                       <div class="inside">
                                            <table>
                                              <tr>
                                                <td>
                                                  <input style="width:20px;" type='radio' <?php if($settings['show_caption']==true){echo "checked='checked'";}?>  name='show_caption' value='1' ><?php echo __( 'Yes','wp-responsive-slider-with-lightbox');?> &nbsp;<input style="width:20px;" type='radio' name='show_caption' <?php if($settings['show_caption']==false){echo "checked='checked'";} ?> value='0' ><?php echo __( 'No','wp-responsive-slider-with-lightbox');?>
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                                </td>
                                              </tr>
                                            </table>
                                            <div style="clear:both"></div>
                                        </div>
                                     </div>
                                      
                                     <?php wp_nonce_field('action_image_add_edit','add_edit_image_nonce'); ?>           
                                    <input type="submit"  name="btnsave" id="btnsave" value="<?php echo __('Save Changes','continuous-image-carousel-with-lightbox');?>" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="<?php echo __('Cancel','continuous-image-carousel-with-lightbox');?>" class="button-primary" onclick="location.href='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management'">

                                </form> 
                                <script type="text/javascript">

                                    jQuery(document).ready(function() {

                                            jQuery("#scrollersettiings").validate({
                                                    rules: {
                                                      speed: {
                                                            required:true, 
                                                            number:true, 
                                                            maxlength:15
                                                        },
                                                        visible:{
                                                            required:true,  
                                                            number:true,
                                                            maxlength:15

                                                        },
                                                        min_visible:{
                                                            required:true,  
                                                            number:true,
                                                            maxlength:15

                                                        },
                                                       
                                                        scollerBackground:{
                                                            required:true,
                                                            maxlength:7  
                                                        },
                                                       imageheight:{
                                                            required:true,
                                                            number:true,
                                                            maxlength:15    
                                                        },
                                                        imagewidth:{
                                                            required:true,
                                                            number:true,
                                                            maxlength:15    
                                                        },imageMargin:{
                                                            required:true,
                                                            number:true,
                                                            maxlength:15    
                                                        }

                                                    },
                                                    errorClass: "image_error",
                                                    errorPlacement: function(error, element) {
                                                        error.appendTo( element.next().next());
                                                    } 


                                            })
                                            
                                            jQuery('#scollerBackground').wpColorPicker();   
                                    });

                                </script> 

                            </div>
                        </div>
                    </div>  
                </div>      
            </div>
            <div id="postbox-container-1" class="postbox-container"> 
                    <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('New DIVI AI Theme','continuous-image-carousel-with-lightbox'); ?></h3> 
                        <div class="inside">
                            <center><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715&url=80806" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/divi_300x250.jpg', __FILE__ );?>" width="250" height="250"></a></center>

                            <div style="margin:10px 5px">

                            </div>
                        </div></div>

                     <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','continuous-image-carousel-with-lightbox');?></h3> 
                            <div class="inside">
                                <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                        <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                                    </a></center>
                                <div style="margin:10px 5px">
                                </div>
                            </div>

                        </div>
                </div> 
            <div class="clear"></div>
        </div>  
    </div> 
    <?php
    } 
    function continuous_thumbnail_slider_with_lightbox_image_management_func(){

        
         
        $action='gridview';
        global $wpdb;


        if(isset($_GET['action']) and $_GET['action']!=''){


            $action=trim($_GET['action']);
        }

    ?>

    <?php 
        if(strtolower($action)==strtolower('gridview')){ 


            $wpcurrentdir=dirname(__FILE__);
            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);

            $uploads = wp_upload_dir();
            $baseurl=$uploads['baseurl'];
            $baseurl.='/continuous-image-carousel-with-lightbox/';
            
            if ( ! current_user_can( 'cicwl_continuous_slider_view_images' ) ) {

                wp_die( __( "Access Denied", "continuous-image-carousel-with-lightbox" ) );

              } 
            


        ?> 
        
        <div id="poststuff"  class="wrap">
            <div id="post-body" class="metabox-holder columns-2">
                <table><tr>
                       <td>
                            <div class="fb-like" data-href="https://www.facebook.com/i13websolution" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                            <div id="fb-root"></div>
                              <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=158817690866061&autoLogAppEvents=1';
                                fjs.parentNode.insertBefore(js, fjs);
                              }(document, 'script', 'facebook-jssdk'));</script>
                        </td> 
                        <td>
                            <a target="_blank" title="Donate" href="http://www.i13websolution.com/donate-wordpress_image_thumbnail.php">
                                <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
                            </a>
                        </td>
                    </tr>
                </table>

                <?php 

                    $messages=get_option('continuous_thumbnail_slider_plus_lightbox_messages'); 
                    $type='';
                    $message='';
                    if(isset($messages['type']) and $messages['type']!=""){

                        $type=$messages['type'];
                        $message=$messages['message'];

                    }  


                   if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                   else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
       

                    update_option('continuous_thumbnail_slider_plus_lightbox_messages', array());   
                    $url = plugin_dir_url(__FILE__);  
                ?>

                 <div id="modelMainDiv" style="display:none;z-index: 1000; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;filter:alpha(opacity=15)" ></div>
                <div id="LoaderDiv" style="display:none;z-index: 1000; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;filter:alpha(opacity=15)" ></div>
                <div id="ContainDiv" style="display:none;z-index: 1056; position: fixed; padding: 5px; margin: 0px; width: 30%; top: 40%; left: 35%; text-align: center; color: rgb(0, 0, 0); border: 1px solid #999999; background-color: rgb(255, 255, 255); cursor: wait;" >
                  <img src="<?php echo $url.'images/loading.gif'?>" />
                   <h5 id="wait"><?php echo __('Please wait while uploading images...','continuous-image-carousel-with-lightbox');?></h5>
                </div>
                <div id="post-body-content" >  

                
                    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                    <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/"><?php echo __('UPGRADE TO PRO VERSION','continuous-image-carousel-with-lightbox');?></a></h3></span>
                    <h2><?php echo __('Images','continuous-image-carousel-with-lightbox');?> <a class="button add-new-h2" href="admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management&action=addedit"><?php echo __('Add New','continuous-image-carousel-with-lightbox');?></a> 
                    &nbsp;&nbsp;
                       <a class="massAdd button add-new-h2" href="javascript:void(0)"><?php echo __('Mass Add','continuous-image-carousel-with-lightbox');?></a>
                    
                    
                    </h2>
                    <br/>

                    <form method="POST" action="admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management&action=deleteselected"  id="posts-filter" onkeypress="return event.keyCode != 13;">
                        <div class="alignleft actions">
                            <select name="action_upper" id="action_upper">
                                <option selected="selected" value="-1"><?php echo __('Bulk Actions','continuous-image-carousel-with-lightbox');?></option>
                                <option value="delete"><?php echo __('Delete','continuous-image-carousel-with-lightbox');?></option>
                            </select>
                            <input type="submit" value="<?php echo __('Apply','continuous-image-carousel-with-lightbox');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
                        </div>
                        <br class="clear">
                        <br/>
                        <?php
                           
                             $setacrionpage='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';

                             if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                              $setacrionpage.='&order_by='.sanitize_text_field($_GET['order_by']);   
                             }

                             if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                              $setacrionpage.='&order_pos='.sanitize_text_field($_GET['order_pos']);   
                             }

                             $seval="";
                             if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                              $seval=sanitize_text_field($_GET['search_term']);   
                             }
                             
                             $setacrionpage=esc_html($setacrionpage);

                         ?>
                        <?php 

                            $settings=get_option('continuous_thumbnail_slider_plus_lightbox_settings'); 
                            $visibleImages=$settings['visible'];
                            
                            
                            
                            $order_by='id';
                            $order_pos="asc";

                            if(isset($_GET['order_by'])){

                               $order_by=trim($_GET['order_by']); 
                            }

                            if(isset($_GET['order_pos'])){

                               $order_pos=trim($_GET['order_pos']); 
                            }
                            
                            $search_term_='';
                            if(isset($_GET['search_term'])){

                               $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
                            }
                            $search_term_=esc_html($search_term_);
                             $search_term='';
                            if(isset($_GET['search_term'])){

                               $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
                            }

                            $query = "SELECT * FROM " . $wpdb->prefix . "continuous_image_carousel ";
                            $queryCount = "SELECT count(*) FROM " . $wpdb->prefix . "continuous_image_carousel ";
                            if($search_term!=''){
                               $query.=" where id like '%$search_term%' or title like '%$search_term%' "; 
                               $queryCount.=" where id like '%$search_term%' or title like '%$search_term%' "; 
                            }

                            $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                            $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                            $query.=" order by $order_by $order_pos";
                      
                            $rowsCount=$wpdb->get_var($queryCount);
                            
                            $allCount = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."continuous_image_carousel" );

                          

                        ?>
                        
                         <div style="padding-top:5px;padding-bottom:5px">
                               <b><?php echo __( 'Search','continuous-image-carousel-with-lightbox');?> : </b>
                                 <input type="text" value="<?php echo esc_html($seval);?>" id="search_term" name="search_term">&nbsp;
                                 <input type='button'  value='<?php echo __( 'Search','continuous-image-carousel-with-lightbox');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                                 <input type='button'  value='<?php echo __( 'Reset Search','continuous-image-carousel-with-lightbox');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                           </div>  
                           <script type="text/javascript" >
                              
                               jQuery('#search_term').on("keyup", function(e) {
                                      if (e.which == 13) {

                                          SearchredirectTO();
                                      }
                                 });   
                            function SearchredirectTO(){
                              var redirectto='<?php echo $setacrionpage; ?>';
                              var searchval=jQuery('#search_term').val();
                              redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                              window.location.href=redirectto;
                            }
                           function ResetSearch(){

                                var redirectto='<?php echo $setacrionpage; ?>';
                                window.location.href=redirectto;
                                exit;
                           }
                           </script>  
                       
                           
                        <?php if($allCount<$visibleImages){ ?>
                            <h4 style="color: green"><?php echo __( 'Current slider setting - Total visible images','continuous-image-carousel-with-lightbox');?> <?php echo $visibleImages; ?></h4>
                            <h4 style="color: green"><?php echo __( 'Please add atleast','continuous-image-carousel-with-lightbox');?> <?php echo $visibleImages; ?> <?php echo __( 'images','continuous-image-carousel-with-lightbox');?></h4>
                            <?php } else{
                                echo "<br/>";
                        }?>
                        <div id="no-more-tables">
                            <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf" >
                                <thead>
                                    <tr>
                                        <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
                                        
                                       <?php if($order_by=="id" and $order_pos=="asc"):?>
                                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                       <?php else:?>
                                           <?php if($order_by=="id"):?>
                                       <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                           <?php else:?>
                                               <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','continuous-image-carousel-with-lightbox');?></a></th>
                                           <?php endif;?>    
                                       <?php endif;?> 
                                               
                                       <?php if($order_by=="title" and $order_pos=="asc"):?>
                                            <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Title','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                       <?php else:?>
                                           <?php if($order_by=="title"):?>
                                       <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                           <?php else:?>
                                               <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','continuous-image-carousel-with-lightbox');?></a></th>
                                           <?php endif;?>    
                                       <?php endif;?> 
                                               
                                        <th><span></span></th>
                                        
                                        <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Published On','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                        <?php else:?>
                                            <?php if($order_by=="createdon"):?>
                                        <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','continuous-image-carousel-with-lightbox');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                            <?php else:?>
                                                <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','continuous-image-carousel-with-lightbox');?></a></th>
                                            <?php endif;?>    
                                        <?php endif;?>  
                                        
                                        <th><span><?php echo __( 'Edit','continuous-image-carousel-with-lightbox');?></span></th>
                                        <th><span><?php echo __( 'Delete','continuous-image-carousel-with-lightbox');?></span></th>
                                    </tr>
                                </thead>

                                <tbody id="the-list">
                                    <?php

                                        if($rowsCount > 0){

                                            global $wp_rewrite;
                                            $rows_per_page = 10;

                                            $current = (isset($_GET['paged'])) ? ( (int) htmlentities(strip_tags($_GET['paged']),ENT_QUOTES)) : 1;
                                            $pagination_args = array(
                                                'base' => @add_query_arg('paged','%#%'),
                                                'format' => '',
                                                'total' => ceil($rowsCount/$rows_per_page),
                                                'current' => $current,
                                                'show_all' => false,
                                                'type' => 'plain',
                                            );


                                            $offset = ($current - 1) * $rows_per_page;
                                            $query.=" limit $offset, $rows_per_page";
                                            $rows = $wpdb->get_results ( $query ,ARRAY_A);
                                            $delRecNonce=wp_create_nonce('delete_image');

                                            foreach ($rows as $row) {

                                                $id=$row['id'];
                                                $editlink="admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management&action=addedit&id=$id";
                                                $deletelink="admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management&action=delete&id=$id&nonce=$delRecNonce";
                                                $outputimgmain = $baseurl.$row['image_name']; 

                                            ?>
                                            <tr valign="top" >
                                                <td class="alignCenter check-column"   data-title="<?php echo __('Select Record','continuous-image-carousel-with-lightbox');?>" ><input type="checkbox" value="<?php echo $row['id'] ?>" name="thumbnails[]"></td>
                                                <td  class="alignCenter" data-title="<?php echo __('Id','continuous-image-carousel-with-lightbox');?>" ><strong><?php echo $row['id']; ?></strong></td>  
                                                <td   data-title="<?php echo __('Title','continuous-image-carousel-with-lightbox');?>" ><strong><?php echo $row['title']; ?></strong></td>  
                                                <td class="alignCenter">
                                                    <img src="<?php echo $outputimgmain;?>" style="width:50px" height="50px"/>
                                                </td> 
                                                <td class="alignCenter"   data-title="<?php echo __('Published On','continuous-image-carousel-with-lightbox');?>" ><?php echo $row['createdon'] ?></td>
                                                <td class="alignCenter"   data-title="<?php echo __('Edit Record','continuous-image-carousel-with-lightbox');?>" ><strong><a href='<?php echo $editlink; ?>' title="<?php echo __('Edit','continuous-image-carousel-with-lightbox');?>"><?php echo __('Edit','continuous-image-carousel-with-lightbox');?></a></strong></td>  
                                                <td class="alignCenter"   data-title="<?php echo __('Delete Record','continuous-image-carousel-with-lightbox');?>" ><strong><a href='<?php echo $deletelink; ?>' onclick="return confirmDelete();"  title="<?php echo __('Delete','continuous-image-carousel-with-lightbox');?>"><?php echo __('Delete','continuous-image-carousel-with-lightbox');?></a> </strong></td>  
                                            </tr>
                                            <?php 
                                            } 
                                        }
                                        else{
                                        ?>

                                        <tr valign="top" class="" id="">
                                            <td colspan="7" data-title="<?php echo __('No Record','continuous-image-carousel-with-lightbox');?>" align="center"><strong><?php echo __('No Images Found','continuous-image-carousel-with-lightbox');?></strong></td>  
                                        </tr>

                                        <?php 
                                        } 
                                    ?>      
                                </tbody>
                            </table>
                        </div>
                        <?php
                            if($rowsCount>0){
                                echo "<div class='pagination' style='padding-top:10px'>";
                                echo paginate_links($pagination_args);
                                echo "</div>";
                            }
                        ?>
                        <br/>
                        <div class="alignleft actions">
                            <select name="action" id="action_bottom">
                                <option selected="selected" value="-1"><?php echo __('Bulk Actions','continuous-image-carousel-with-lightbox');?></option>
                                <option value="delete"><?php echo __('Delete','continuous-image-carousel-with-lightbox');?></option>
                            </select>
                             <?php wp_nonce_field('action_settings_mass_delete','mass_delete_nonce'); ?>
                            <input type="submit" value="<?php echo __('Apply','continuous-image-carousel-with-lightbox');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
                        </div>

                    </form>
                    <script type="text/JavaScript">

                      function  confirmDelete_bulk(){
                            var topval=document.getElementById("action_bottom").value;
                            var bottomVal=document.getElementById("action_upper").value;
                       
                            if(topval=='delete' || bottomVal=='delete'){
                                
                            
                                var agree=confirm("<?php echo __('Are you sure you want to delete selected images?','continuous-image-carousel-with-lightbox');?>");
                                if (agree)
                                    return true ;
                                else
                                    return false;
                            }
                        }
                        function  confirmDelete(){
                            var agree=confirm("<?php echo __('Are you sure you want to delete this image?','continuous-image-carousel-with-lightbox');?>");
                            if (agree)
                                return true ;
                            else
                                return false;
                        }
                        
                         var nonce_sec='<?php echo wp_create_nonce( "thumbnail-mass-image" );?>';
                            jQuery(document).ready(function() {
                                   //uploading files variable
                                   var custom_file_frame;
                                   jQuery(".massAdd").click(function(event) {
                                      var slider_id=jQuery(this).attr('id'); 
                                      event.preventDefault();
                                      //If the frame already exists, reopen it
                                      if (typeof(custom_file_frame)!=="undefined") {
                                         custom_file_frame.close();
                                      }

                                      //Create WP media frame.
                                      custom_file_frame = wp.media.frames.customHeader = wp.media({
                                         //Title of media manager frame
                                         title: "<?php echo __("WP Media Uploader",'continuous-image-carousel-with-lightbox');?>",
                                         library: {
                                            type: 'image'
                                         },
                                         button: {
                                            //Button text
                                            text: "<?php echo __("Set Image",'continuous-image-carousel-with-lightbox');?>"
                                         },
                                         //Do not allow multiple files, if you want multiple, set true
                                         multiple: true
                                      });

                                      //callback for selected image

                                      custom_file_frame.on('select', function() {


                                            jQuery("#modelMainDiv").show();
                                            jQuery("#LoaderDiv").show();
                                            jQuery("#ContainDiv").show();
                                            var selection = custom_file_frame.state().get('selection');
                                            selection.map(function(attachment) {

                                                attachment = attachment.toJSON();
                                                var validExtensions=new Array();
                                                validExtensions[0]='jpg';
                                                validExtensions[1]='jpeg';
                                                validExtensions[2]='png';
                                                validExtensions[3]='gif';


                                                var inarr=parseInt(jQuery.inArray( attachment.subtype, validExtensions));

                                                if(inarr>0 && attachment.type.toLowerCase()=='image' ){

                                                      var titleTouse="";
                                                      var imageDescriptionTouse="";

                                                      if(jQuery.trim(attachment.title)!=''){

                                                         titleTouse=jQuery.trim(attachment.title); 
                                                      }  
                                                      else if(jQuery.trim(attachment.caption)!=''){

                                                         titleTouse=jQuery.trim(attachment.caption);  
                                                      }

                                                      if(jQuery.trim(attachment.description)!=''){

                                                         imageDescriptionTouse=jQuery.trim(attachment.description); 
                                                      }  
                                                      else if(jQuery.trim(attachment.caption)!=''){

                                                         imageDescriptionTouse=jQuery.trim(attachment.caption);  
                                                      }

                                                      var data = {
                                                                imagetitle:titleTouse,
                                                                image_description: imageDescriptionTouse,
                                                                attachment_id:attachment.id,
                                                                slider_id:slider_id,
                                                                action: 'mass_upload_wrthsliderlboxcont',
                                                                thumbnail_security:nonce_sec
                                                            };

                                                        url='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management&action=mass_upload_wrthsliderlboxcont';
                                                        jQuery.ajax({
                                                              type: 'POST',
                                                              url: ajaxurl,
                                                              data: data,
                                                              success: function(result) {
                                                                  if(result.isOk == false)
                                                                      alert(result.message);
                                                              },
                                                              dataType:'html'
                                                            });


                                                }  

                                            });

                                            jQuery("#modelMainDiv").hide();
                                            jQuery("#LoaderDiv").hide();
                                            jQuery("#ContainDiv").hide();

                                        });

                                         custom_file_frame.on('close', function() {
                                             window.location.reload();
                                          });

                                      //Open modal
                                      custom_file_frame.open();
                                   });
                                })
                    </script>

                    <br class="clear">
                    <h3><?php echo __('To print this slider into WordPress Post/Page use below Short code','continuous-image-carousel-with-lightbox');?></h3>
                    <input type="text" value="[print_continuous_slider_plus_lightbox]" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
                    <div class="clear"></div>
                    <h3><?php echo __('To print this slider into WordPress theme/template PHP files use below php code','continuous-image-carousel-with-lightbox');?></h3>
                    <input type="text" value="echo do_shortcode('[print_continuous_slider_plus_lightbox]');" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
                    <div class="clear"></div>
                </div>
                <div id="postbox-container-1" class="postbox-container"> 
                    <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Access All Themes One price','continuous-image-carousel-with-lightbox'); ?></h3> 
                        <div class="inside">
                            <center><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_5_1_18" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.jpg', __FILE__ );?>" width="250" height="250"></a></center>

                            <div style="margin:10px 5px">

                            </div>
                        </div></div>

                     <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','continuous-image-carousel-with-lightbox');?></h3> 
                            <div class="inside">
                                <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                        <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                                    </a></center>
                                <div style="margin:10px 5px">
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>

        <?php 
        }   
        else if(strtolower($action)==strtolower('addedit')){
            $url = plugin_dir_url(__FILE__);

        ?>
        <?php        
            if(isset($_POST['btnsave'])){

               if ( !check_admin_referer( 'action_image_add_edit','add_edit_image_nonce')){

                   wp_die('Security check fail'); 
               }
               
               $uploads = wp_upload_dir();
               $baseDir=$uploads['basedir'];
               $baseDir=str_replace("\\","/",$baseDir);
               $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
             
                //edit save
                if(isset($_POST['imageid'])){

                    
                    if ( ! current_user_can( 'cicwl_continuous_slider_edit_image' ) ) {

                        $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                        $continuous_thumbnail_slider_plus_lightbox_messages=array();
                        $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                        $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                    }

                    //add new
                    $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                    $title=trim(htmlentities(sanitize_text_field($_POST['imagetitle']),ENT_QUOTES));
                    $imageurl=trim(htmlentities(strip_tags($_POST['imageurl']),ENT_QUOTES));
                    $imageid=intval(htmlentities(sanitize_text_field($_POST['imageid']),ENT_QUOTES));
                    $imagename="";
                    if(trim($_POST['HdnMediaSelection'])!=''){

                        $postThumbnailID=(int) htmlentities(sanitize_text_field($_POST['HdnMediaSelection']),ENT_QUOTES);
                        $photoMeta = wp_get_attachment_metadata( $postThumbnailID );
                        if(is_array($photoMeta) and isset($photoMeta['file'])) {

                            $fileName=$photoMeta['file'];
                            $phyPath=ABSPATH;
                            $phyPath=str_replace("\\","/",$phyPath);

                            $pathArray=pathinfo($fileName);

                            $imagename=$pathArray['basename'];

                            $upload_dir_n = wp_upload_dir(); 
                            $upload_dir_n=$upload_dir_n['basedir'];
                            $fileUrl=$upload_dir_n.'/'.$fileName;
                            $fileUrl=str_replace("\\","/",$fileUrl);

                            $wpcurrentdir=dirname(__FILE__);
                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                            $imageUploadTo=$pathToImagesFolder.'/'.$imagename;

                            @copy($fileUrl, $imageUploadTo);

                        }

                    }     


                    try{
                        if($imagename!=""){
                            $query = "update ".$wpdb->prefix."continuous_image_carousel set title='$title',image_name='$imagename',
                            custom_link='$imageurl' where id=$imageid";
                        }
                        else{
                            $query = "update ".$wpdb->prefix."continuous_image_carousel set title='$title',
                            custom_link='$imageurl' where id=$imageid";
                        } 
                        $wpdb->query($query); 

                        $continuous_thumbnail_slider_plus_lightbox_messages=array();
                        $continuous_thumbnail_slider_plus_lightbox_messages['type']='succ';
                        $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Image updated successfully.','continuous-image-carousel-with-lightbox');
                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);


                    }
                    catch(Exception $e){

                        $continuous_thumbnail_slider_plus_lightbox_messages=array();
                        $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                        $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Error while updating image.','continuous-image-carousel-with-lightbox');
                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                    }  


                    echo "<script type='text/javascript'> location.href='$location';</script>";
                    exit;
                }
                else{

                    //add new

                    if ( ! current_user_can( 'cicwl_continuous_slider_add_image' ) ) {

                        $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                        $continuous_thumbnail_slider_plus_lightbox_messages=array();
                        $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                        $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                    }
                    
                    $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                    $title=trim(htmlentities(sanitize_text_field($_POST['imagetitle']),ENT_QUOTES));
                    $imageurl=trim(htmlentities(strip_tags($_POST['imageurl']),ENT_QUOTES));
                    $createdOn=date('Y-m-d h:i:s');
                    if(function_exists('date_i18n')){

                        $createdOn=date_i18n('Y-m-d'.' '.get_option('time_format') ,false,false);
                        if(get_option('time_format')=='H:i')
                            $createdOn=date('Y-m-d H:i:s',strtotime($createdOn));
                        else   
                            $createdOn=date('Y-m-d h:i:s',strtotime($createdOn));

                    }

                        $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';

                        try{

                             if(trim($_POST['HdnMediaSelection'])!=''){

                                    $postThumbnailID=(int)  htmlentities(sanitize_text_field($_POST['HdnMediaSelection']),ENT_QUOTES);
                                    $photoMeta = wp_get_attachment_metadata( $postThumbnailID );

                                    if(is_array($photoMeta) and isset($photoMeta['file'])) {

                                        $fileName=$photoMeta['file'];
                                        $phyPath=ABSPATH;
                                        $phyPath=str_replace("\\","/",$phyPath);

                                        $pathArray=pathinfo($fileName);

                                        $imagename=$pathArray['basename'];

                                        $upload_dir_n = wp_upload_dir(); 
                                        $upload_dir_n=$upload_dir_n['basedir'];
                                        $fileUrl=$upload_dir_n.'/'.$fileName;
                                        $fileUrl=str_replace("\\","/",$fileUrl);

                                        $wpcurrentdir=dirname(__FILE__);
                                        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                        $imageUploadTo=$pathToImagesFolder.'/'.$imagename;

                                        @copy($fileUrl, $imageUploadTo);

                                    }

                                } 

                              $query = "INSERT INTO ".$wpdb->prefix."continuous_image_carousel (title, image_name,createdon,custom_link) 
                              VALUES ('$title','$imagename','$createdOn','$imageurl')";


                            $wpdb->query($query); 

                            $continuous_thumbnail_slider_plus_lightbox_messages=array();
                            $continuous_thumbnail_slider_plus_lightbox_messages['type']='succ';
                            $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('New image added successfully.','continuous-image-carousel-with-lightbox');
                            update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);


                        }
                        catch(Exception $e){

                            $continuous_thumbnail_slider_plus_lightbox_messages=array();
                            $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                            $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Error while adding image.','continuous-image-carousel-with-lightbox');
                            update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                        }  

                         
                    echo "<script type='text/javascript'> location.href='$location';</script>";         
                    exit;
                } 

            }
            else{ 

                $uploads = wp_upload_dir();
                $baseurl=$uploads['baseurl'];
                $baseurl.='/continuous-image-carousel-with-lightbox/';
            ?>
            <div id="poststuff">  
            <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/"><?php echo __('UPGRADE TO PRO VERSION','continuous-image-carousel-with-lightbox');?></a></h3></span>
            <div id="post-body" class="metabox-holder columns-2" >
                <div id="post-body-content">
                    <?php if(isset($_GET['id']) and intval($_GET['id'])>0)
                        { 


                                if ( ! current_user_can( 'cicwl_continuous_slider_edit_image' ) ) {

                                    $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                                    $continuous_thumbnail_slider_plus_lightbox_messages=array();
                                    $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                                    $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                                    update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                                    exit;   

                                }
                                $id= (int) htmlentities(strip_tags($_GET['id']),ENT_QUOTES);
                                $query="SELECT * FROM ".$wpdb->prefix."continuous_image_carousel WHERE id=$id";
                                $myrow  = $wpdb->get_row($query);

                                if(is_object($myrow)){

                                    $title=$myrow->title;
                                    $image_link=$myrow->custom_link;
                                    $image_name=$myrow->image_name;

                                }   

                        ?>

                        <h2><?php echo __('Update Image','continuous-image-carousel-with-lightbox');?> </h2>

                        <?php }else{ 

                            
                               if ( ! current_user_can( 'cicwl_continuous_slider_add_image' ) ) {

                                    $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                                    $continuous_thumbnail_slider_plus_lightbox_messages=array();
                                    $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                                    $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                                    update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                                    exit;   

                                }
                                
                                $title='';
                                $image_link='';
                                $image_name='';

                        ?>

                        <h2><?php echo __('Add Image','continuous-image-carousel-with-lightbox');?> </h2>
                        <?php } ?>

                    <div id="poststuff">
                        <div id="post-body" class="metabox-holder columns-2">
                            <div id="post-body-content">
                                <form method="post" action="" id="addimage" name="addimage" enctype="multipart/form-data" >

                                     <div class="stuffbox" id="namediv" style="width:100%">
                                        <h3><label for="link_name"><?php echo __('Upload Image','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside" id="fileuploaddiv">
                                            <?php if($image_name!=""){ ?>
                                                <div><b><?php echo __('Current Image','continuous-image-carousel-with-lightbox');?> : </b><a id="currImg" href="<?php echo $baseurl.$image_name; ?>" target="_new"><?php echo $image_name; ?></a></div>
                                                <?php } ?>      
                                             <div class="uploader">
                                                <br/>
                                                  <a href="javascript:;" class="niks_media" id="myMediaUploader"><b><?php echo __('Click here to add image','continuous-image-carousel-with-lightbox');?></b></a>
                                                <input id="HdnMediaSelection" name="HdnMediaSelection" type="hidden" value="" />
                                                <br/>
                                            </div>  
                                            <script>
                                                
                                                jQuery(document).ready(function() {
                                                        //uploading files variable
                                                        var custom_file_frame;
                                                        jQuery("#myMediaUploader").click(function(event) {
                                                                event.preventDefault();
                                                                //If the frame already exists, reopen it
                                                                if (typeof(custom_file_frame)!=="undefined") {
                                                                    custom_file_frame.close();
                                                                }

                                                                //Create WP media frame.
                                                                custom_file_frame = wp.media.frames.customHeader = wp.media({
                                                                        //Title of media manager frame
                                                                        title: "<?php echo __('WP Media Uploader','continuous-image-carousel-with-lightbox');?>",
                                                                        library: {
                                                                            type: 'image'
                                                                        },
                                                                        button: {
                                                                            //Button text
                                                                            text: "<?php echo __('Set Image','continuous-image-carousel-with-lightbox');?>"
                                                                        },
                                                                        //Do not allow multiple files, if you want multiple, set true
                                                                        multiple: false
                                                                });

                                                                //callback for selected image
                                                                custom_file_frame.on('select', function() {

                                                                        var attachment = custom_file_frame.state().get('selection').first().toJSON();


                                                                        var validExtensions=new Array();
                                                                        validExtensions[0]='jpg';
                                                                        validExtensions[1]='jpeg';
                                                                        validExtensions[2]='png';
                                                                        validExtensions[3]='gif';
                                                                      

                                                                        var inarr=parseInt(jQuery.inArray( attachment.subtype, validExtensions));

                                                                        if(inarr>0 && attachment.type.toLowerCase()=='image' ){

                                                                            var titleTouse="";
                                                                            var imageDescriptionTouse="";

                                                                            if(jQuery.trim(attachment.title)!=''){

                                                                                titleTouse=jQuery.trim(attachment.title); 
                                                                            }  
                                                                            else if(jQuery.trim(attachment.caption)!=''){

                                                                                titleTouse=jQuery.trim(attachment.caption);  
                                                                            }

                                                                            if(jQuery.trim(attachment.description)!=''){

                                                                                imageDescriptionTouse=jQuery.trim(attachment.description); 
                                                                            }  
                                                                            else if(jQuery.trim(attachment.caption)!=''){

                                                                                imageDescriptionTouse=jQuery.trim(attachment.caption);  
                                                                            }

                                                                            jQuery("#imagetitle").val(titleTouse);  
                                                                            jQuery("#image_description").val(imageDescriptionTouse);  

                                                                            if(attachment.id!=''){
                                                                                jQuery("#HdnMediaSelection").val(attachment.id);  
                                                                            }   

                                                                        }  
                                                                        else{

                                                                            alert('<?php echo __('Invalid image selection','continuous-image-carousel-with-lightbox');?>.');
                                                                        }  
                                                                        //do something with attachment variable, for example attachment.filename
                                                                        //Object:
                                                                        //attachment.alt - image alt
                                                                        //attachment.author - author id
                                                                        //attachment.caption
                                                                        //attachment.dateFormatted - date of image uploaded
                                                                        //attachment.description
                                                                        //attachment.editLink - edit link of media
                                                                        //attachment.filename
                                                                        //attachment.height
                                                                        //attachment.icon - don't know WTF?))
                                                                        //attachment.id - id of attachment
                                                                        //attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
                                                                        //attachment.menuOrder
                                                                        //attachment.mime - mime type, for example image/jpeg"
                                                                        //attachment.name - name of attachment file, for example "my-image"
                                                                        //attachment.status - usual is "inherit"
                                                                        //attachment.subtype - "jpeg" if is "jpg"
                                                                        //attachment.title
                                                                        //attachment.type - "image"
                                                                        //attachment.uploadedTo
                                                                        //attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
                                                                        //attachment.width
                                                                });

                                                                //Open modal
                                                                custom_file_frame.open();
                                                        });
                                                })
                                            </script>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label for="link_name"><?php echo __('Image Title','continuous-image-carousel-with-lightbox');?></label></h3>
                                        <div class="inside">
                                            <input type="text" id="imagetitle"  size="30" name="imagetitle" value="<?php echo $title;?>">
                                            <div style="clear:both"></div>
                                            <div></div>
                                            <div style="clear:both"></div>
                                            <p><?php echo __('Used in image alt for seo','continuous-image-carousel-with-lightbox'); ?></p>
                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label for="link_name"><?php echo __('Image Url','continuous-image-carousel-with-lightbox');?>(<?php echo __('On click redirect to this url.','continuous-image-carousel-with-lightbox'); ?>)</label></h3>
                                        <div class="inside">
                                            <input type="text" id="imageurl" class=""   size="30" name="imageurl" value="<?php echo $image_link; ?>">
                                            <div style="clear:both"></div>
                                            <div></div>
                                            <div style="clear:both"></div>
                                            <p><?php echo __('On image click users will redirect to this url.','continuous-image-carousel-with-lightbox'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php if(isset($_GET['id']) and intval($_GET['id'])>0){ ?> 
                                        <input type="hidden" name="imageid" id="imageid" value="<?php echo (int) htmlentities(strip_tags($_GET['id']),ENT_QUOTES);?>">
                                        <?php
                                        } 
                                    ?>
                                     <?php wp_nonce_field('action_image_add_edit','add_edit_image_nonce'); ?>         
                                    <input type="submit" onclick="return validateFile();" name="btnsave" id="btnsave" value="<?php echo __('Save Changes','continuous-image-carousel-with-lightbox');?>" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="<?php echo __('Cancel','continuous-image-carousel-with-lightbox');?>" class="button-primary" onclick="location.href='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management'">

                                </form> 
                                <script type="text/javascript">

                                    
                                    jQuery(document).ready(function() {

                                            jQuery("#addimage").validate({
                                                    rules: {
                                                        imagetitle: {
                                                            required:true, 
                                                            maxlength: 200
                                                        },imageurl: {
                                                            url2:true,  
                                                            maxlength: 500
                                                        },
                                                        image_name:{
                                                            isimage:true  
                                                        }
                                                    },
                                                    errorClass: "image_error",
                                                    errorPlacement: function(error, element) {
                                                        error.appendTo( element.next().next().next());
                                                    } 


                                            })
                                    });

                                    function validateFile(){

                                            
                                            if(jQuery('#currImg').length>0 || jQuery.trim(jQuery("#HdnMediaSelection").val())!="" ){
                                                return true;
                                            }
                                            else
                                                {
                                                jQuery("#err_daynamic").remove();
                                                jQuery("#myMediaUploader").after('<br/><label class="image_error" id="err_daynamic"><?php echo __('Please select file','continuous-image-carousel-with-lightbox');?>.</label>');
                                                return false;  
                                            } 

                                        }  
                                </script> 

                            </div>
                        </div>
                    </div>  
                </div>      
                <div id="postbox-container-1" class="postbox-container"> 
                    <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Access All Themes One price','continuous-image-carousel-with-lightbox'); ?></h3> 
                        <div class="inside">
                            <center><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_5_1_18" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.jpg', __FILE__ );?>" width="250" height="250"></a></center>

                            <div style="margin:10px 5px">

                            </div>
                        </div></div>

                     <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','continuous-image-carousel-with-lightbox');?></h3> 
                            <div class="inside">
                                <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                        <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                                    </a></center>
                                <div style="margin:10px 5px">
                                </div>
                            </div>

                        </div>
                </div>

            </div>
            <?php 
            } 
        }  

        else if(strtolower($action)==strtolower('delete')){

             $retrieved_nonce = '';
            
            if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                $retrieved_nonce=$_GET['nonce'];

            }
            if (!wp_verify_nonce($retrieved_nonce, 'delete_image' ) ){


                wp_die('Security check fail'); 
            }
            
            if ( ! current_user_can( 'cicwl_continuous_slider_delete_image' ) ) {

                $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                $continuous_thumbnail_slider_plus_lightbox_messages=array();
                $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                echo "<script type='text/javascript'> location.href='$location';</script>";     
                exit;   

            }
            
            $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
            $deleteId=(int) htmlentities(strip_tags($_GET['id']),ENT_QUOTES);

            $uploads = wp_upload_dir();
            $baseDir=$uploads['basedir'];
            $baseDir=str_replace("\\","/",$baseDir);
            $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
            
            try{


                $query="SELECT * FROM ".$wpdb->prefix."continuous_image_carousel WHERE id=$deleteId";
                $myrow  = $wpdb->get_row($query);

                if(is_object($myrow)){

                    $image_name=$myrow->image_name;
                    $wpcurrentdir=dirname(__FILE__);
                    $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                   
                    $imagetoDel=$pathToImagesFolder.'/'.$image_name;
                    @unlink($imagetoDel);

                    $query = "delete from  ".$wpdb->prefix."continuous_image_carousel where id=$deleteId";
                    $wpdb->query($query); 

                    $continuous_thumbnail_slider_plus_lightbox_messages=array();
                    $continuous_thumbnail_slider_plus_lightbox_messages['type']='succ';
                    $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Image deleted successfully.','continuous-image-carousel-with-lightbox');
                    update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                }    


            }
            catch(Exception $e){

                $continuous_thumbnail_slider_plus_lightbox_messages=array();
                $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Error while deleting image.','continuous-image-carousel-with-lightbox');
                update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
            }  

            echo "<script type='text/javascript'> location.href='$location';</script>";
            exit;

        }  
        else if(strtolower($action)==strtolower('deleteselected')){

            if(!check_admin_referer('action_settings_mass_delete','mass_delete_nonce')){
               
                wp_die('Security check fail'); 
            }
        
             if ( ! current_user_can( 'cicwl_continuous_slider_delete_image' ) ) {

                $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management';
                $continuous_thumbnail_slider_plus_lightbox_messages=array();
                $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Access Denied. Please contact your administrator.','continuous-image-carousel-with-lightbox');
                update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                echo "<script type='text/javascript'> location.href='$location';</script>";     
                exit;   

            }
            
            $uploads = wp_upload_dir();
            $baseDir=$uploads['basedir'];
            $baseDir=str_replace("\\","/",$baseDir);
            $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
            
            $location='admin.php?page=continuous_thumbnail_slider_with_lightbox_image_management'; 
            if(isset($_POST) and isset($_POST['deleteselected']) and  ( $_POST['action']=='delete' or $_POST['action_upper']=='delete')){

                if(sizeof($_POST['thumbnails']) >0){

                    $deleteto=$_POST['thumbnails'];
                    $implode=implode(',',$deleteto);   

                    try{

                        foreach($deleteto as $img){ 

                            $img=intval($img);
                            $query="SELECT * FROM ".$wpdb->prefix."continuous_image_carousel WHERE id=$img";
                            $myrow  = $wpdb->get_row($query);

                            if(is_object($myrow)){

                                $image_name=$myrow->image_name;
                                $wpcurrentdir=dirname(__FILE__);
                                $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                              
                                $imagetoDel=$pathToImagesFolder.'/'.$image_name;
                                @unlink($imagetoDel);
                                $query = "delete from  ".$wpdb->prefix."continuous_image_carousel where id=$img";
                                $wpdb->query($query); 

                                $continuous_thumbnail_slider_plus_lightbox_messages=array();
                                $continuous_thumbnail_slider_plus_lightbox_messages['type']='succ';
                                $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Selected images deleted successfully.','continuous-image-carousel-with-lightbox');
                                update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                            }

                        }

                    }
                    catch(Exception $e){

                        $continuous_thumbnail_slider_plus_lightbox_messages=array();
                        $continuous_thumbnail_slider_plus_lightbox_messages['type']='err';
                        $continuous_thumbnail_slider_plus_lightbox_messages['message']=__('Error while deleting image.','continuous-image-carousel-with-lightbox');
                        update_option('continuous_thumbnail_slider_plus_lightbox_messages', $continuous_thumbnail_slider_plus_lightbox_messages);
                    }  

                    echo "<script type='text/javascript'> location.href='$location';</script>";
					exit;

                }
                else{

                    echo "<script type='text/javascript'> location.href='$location';</script>"; 
                    exit;  
                }

            }
            else{

                echo "<script type='text/javascript'> location.href='$location';</script>"; 
                exit;     
            }

        }       
    } 
    function continuous_thumbnail_slider_with_lightbox_admin_preview_func(){  
        
         if ( ! current_user_can( 'cicwl_continuous_slider_preview' ) ) {

           wp_die( __( "Access Denied", "continuous-image-carousel-with-lightbox" ) );

         }
         
        $settings=get_option('continuous_thumbnail_slider_plus_lightbox_settings');
        if(!isset($settings['show_caption'])){
            
            $settings['show_caption']=0;
        }
        
       

    ?>      
    <style type='text/css' >
        .bx-wrapper .bx-viewport {
            background: none repeat scroll 0 0 <?php echo $settings['scollerBackground']; ?> !important;
            border: 0px none !important;
            box-shadow: 0 0 0 0 !important;
        }
    </style>
    <div style="">  
        <div style="float:left;">
            <div class="wrap">
                <h2><?php echo __('Slider Preview','continuous-image-carousel-with-lightbox');?></h2>
                <br>

                <?php
                     $wpcurrentdir=dirname(__FILE__);
                     $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                     $uploads = wp_upload_dir();
                     $baseurl=$uploads['baseurl'];
                     $rand_lightbox_rel=uniqid('lightbox_rel');
                     $randOmeAlbName=uniqid('slider_');
                     $baseurl.='/continuous-image-carousel-with-lightbox/';
                     $baseDir=$uploads['basedir'];
                     $baseDir=str_replace("\\","/",$baseDir);
                     $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';

                ?>
                <div id="poststuff">
                    <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/"><?php echo __('UPGRADE TO PRO VERSION','continuous-image-carousel-with-lightbox');?></a></h3></span>
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content">
                            <div style="clear: both;"></div>
                            <?php $url = plugin_dir_url(__FILE__);  ?>
                            <div id="divResponsiveSliderPlusLightboxMain_admin">
                                
                             <?php 
                                    
                                        $topMargin='5'.'px'; 
                              ?>
                            <?php if($settings['lightbox']):?>
                            <script>
                             function clickedItem(){ 

                                              var uniqObj=jQuery("a[rel^='<?php echo $randOmeAlbName;?>']"); 
                                              jQuery(".<?php echo $rand_lightbox_rel;?>").fancybox_crl({
                                                'overlayColor':'#000000',
                                                 'padding': 10,
                                                 'autoScale': true,
                                                 'autoDimensions':true,
                                                 'transitionIn': 'none',
                                                 'uniqObj':uniqObj,
                                                 'transitionOut': 'none',
                                                 'titlePosition': 'over',
                                                 'cyclic':true,
                                                 'hideOnContentClick':false,
                                                 'width' : 600,
                                                 'height' : 350,
                                                 'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                                                     var currtElem = jQuery('.responsiveSlider a[href="'+currentOpts.href+'"]');

                                                     var isoverlay = jQuery(currtElem).attr('data-overlay')

                                                    if(isoverlay=="1" && jQuery.trim(title)!=""){
                                                     return '<span id="fancybox_crl-title-over">' + title  + '</span>';
                                                    }
                                                    else{
                                                        return '';
                                                    }

                                                    },

                                               });

                                               return false;
                                          }
                             </script>
                             <?php endif;?>
                                <div class="responsiveSlider" style="margin-top: <?php echo $topMargin;?> !important;display: none">
                                    <?php
                                        global $wpdb;
                                        $imageheight=$settings['imageheight'];
                                        $imagewidth=$settings['imagewidth'];
                                        $query="SELECT * FROM ".$wpdb->prefix."continuous_image_carousel order by createdon desc";
                                        $rows=$wpdb->get_results($query,'ARRAY_A');
                                       
                                        if(count($rows) > 0){
                                            foreach($rows as $row){

                                                $imagename=$row['image_name'];
                                                $imageUploadTo=$baseurl.$imagename;
                                                $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                                $pathinfo=pathinfo($imageUploadTo);
                                                $filenamewithoutextension=$pathinfo['filename'];
                                                $outputimg="";

                                                $outputimgmain = $baseurl.$row['image_name']; 
                                                if($settings['resizeImages']==0){

                                                    $outputimg = $baseurl.$row['image_name']; 

                                                }
                                                else{
                                                    
                                                    $imagetoCheck=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    $imagetoCheckSmall=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                              
                                                    if(file_exists($imagetoCheck)){
                                                        $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    }
                                                    else if(file_exists($imagetoCheckSmall)){
                                                        $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                    }
                                                    else{

                                                        if(function_exists('wp_get_image_editor')){

                                                            
                                                            $image = wp_get_image_editor($pathToImagesFolder.'/'.$row['image_name']); 

                                                            if ( ! is_wp_error( $image ) ) {
                                                                $image->resize( $imagewidth, $imageheight, true );
                                                                $image->save( $imagetoCheck );
                                                               // $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                
                                                                if(file_exists($imagetoCheck)){
                                                                    $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                }
                                                                else if(file_exists($imagetoCheckSmall)){
                                                                    $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                }

                                                            }
                                                            else{
                                                                $outputimg = $baseurl.$row['image_name'];
                                                            }     

                                                        }
                                                        else if(function_exists('image_resize')){

                                                            $return=image_resize($pathToImagesFolder."/".$row['image_name'],$imagewidth,$imageheight) ;
                                                            if ( ! is_wp_error( $return ) ) {

                                                                $isrenamed=rename($return,$imagetoCheck);
                                                                if($isrenamed){
                                                                    //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                                                    
                                                                      if(file_exists($imagetoCheck)){
                                                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                        }
                                                                        else if(file_exists($imagetoCheckSmall)){
                                                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                        }

                                                                }
                                                                else{
                                                                    $outputimg = $baseurl.$row['image_name']; 
                                                                } 
                                                            }
                                                            else{
                                                                $outputimg = $baseurl.$row['image_name'];
                                                            }  
                                                        }
                                                        else{

                                                            $outputimg = $baseurl.$row['image_name'];
                                                        }  

                                                        //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];

                                                    } 
                                                } 

                                                $title="";
                                                $rowTitle=$row['title'];
                                                $rowTitle=str_replace("'","’",$rowTitle); 
                                                $rowTitle=str_replace('"','”',$rowTitle); 
                                                if(trim($row['title'])!='' and trim($row['custom_link'])!=''){

                                                    $title="<a class='Imglink' target='_blank' href='{$row['custom_link']}'>{$rowTitle}</a>";

                                                }
                                                else if(trim($row['title'])!='' and trim($row['custom_link'])==''){

                                                    $title="<a class='Imglink' href='#'>{$rowTitle}</a>"; 

                                                }
                                                else{

                                                    if($row['title']!='')
                                                        $title="<a class='Imglink' target='_blank' href='#'>{$rowTitle}</a>"; 
                                                }

                                                $title= htmlentities($title);
                                            ?>         

                                            <div > 
                                                <a rel="<?php echo $randOmeAlbName;?>" data-overlay="1" data-title="<?php echo $title;?>" class="<?php echo $rand_lightbox_rel;?>"  <?php if($settings['lightbox']):?> href="<?php echo $outputimgmain;?>" <?php elseif($row['custom_link']!=''):?> href="<?php echo $row['custom_link'];?>" <?php else: ?><?php endif;?>>
                                                    <img <?php if($settings['lightbox']):?> onclick="return clickedItem();" <?php endif;?> src="<?php echo $outputimg; ?>" alt="<?php echo $rowTitle; ?>" title="<?php echo $rowTitle;?>"  />
                                                </a> 
                                            </div>

                                            <?php }?>   
                                        <?php }?>   
                                </div>
                            </div>
                            <script>
                                
                                var uniqObj=jQuery("a[rel^='<?php echo $randOmeAlbName;?>']");
                                jQuery(document).ready(function(){
                                    
                                        jQuery(".responsiveSlider").show();
                                        var sliderMainHtmladmin=jQuery('#divResponsiveSliderPlusLightboxMain_admin').html();      
                                        var slider= jQuery('.responsiveSlider').bxSlider({
                                            slideWidth: <?php echo $settings['imagewidth'];?>,
                                           minSlides: <?php echo $settings['min_visible'];?>,
                                           maxSlides: <?php echo $settings['visible'];?>,
                                           slideMargin:<?php echo $settings['imageMargin'];?>,  
                                           speed:<?php echo $settings['speed']; ?>,
                                           useCSS:false,
                                           ticker: true,
                                           <?php if($settings['pauseonmouseover']):?>
                                               tickerHover:true, 
                                            <?php endif;?>           
                                             <?php if($settings['show_caption']):?>
                                             captions:true
                                            <?php else:?>
                                              captions:false
                                            <?php endif;?>
                                          

                                        });
                                      
                                        
                                });
                                
                                     window.addEventListener('load', function() {


                                        setTimeout(function(){ 

                                                if(jQuery(".responsiveSlider").find('.bx-loading').length>0){

                                                        jQuery(".responsiveSlider").find('img').each(function(index, elm) {

                                                                if(!elm.complete || elm.naturalWidth === 0){

                                                                    var toload='';
                                                                    var toloadval='';
                                                                    jQuery.each(this.attributes, function(i, attrib){

                                                                            var value = attrib.value;
                                                                            var aname=attrib.name;

                                                                            var pattern = /^((http|https):\/\/)/;

                                                                            if(pattern.test(value) && aname!='src') {

                                                                                    toload=aname;
                                                                                    toloadval=value;
                                                                             }
                                                                            // do your magic :-)
                                                                     });

                                                                            vsrc=jQuery(elm).attr("src");
                                                                            jQuery(elm).removeAttr("src");
                                                                            dsrc=jQuery(elm).attr("data-src");
                                                                            lsrc=jQuery(elm).attr("data-lazy-src");


                                                                               if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                                                             jQuery(elm).attr("src",dsrc);
                                                                                    }
                                                                                    else if(lsrc!== undefined && lsrc!=vsrc){

                                                                                                     jQuery(elm).attr("src",lsrc);
                                                                                    }
                                                                                    else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                                            jQuery(elm).removeAttr(toload);
                                                                                            jQuery(elm).attr("src",toloadval);


                                                                                        } 
                                                                                    else{

                                                                                                    jQuery(elm).attr("src",vsrc);

                                                                               }   

                                                                            elm=jQuery(elm)[0];      
                                                                             if(!elm.complete && elm.naturalHeight == 0){

                                                                            jQuery(elm).removeAttr('loading');
                                                                            jQuery(elm).removeAttr('data-lazy-type');


                                                                            jQuery(elm).removeClass('lazy');

                                                                            jQuery(elm).removeClass('lazyLoad');
                                                                            jQuery(elm).removeClass('lazy-loaded');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                                            jQuery(elm).removeClass('lazy-hidden');

                                                                        }
                                                                 }

                                                            }).promise().done( function(){ 

                                                                    jQuery(".responsiveSlider").find('.bx-loading').remove();
                                                            } );

                                                    }


                                           }, 6000);

                                });
                            </script>

                        </div>
                    </div>      
                </div>  
            </div>      
        </div>
        <div class="clear"></div>
    </div>
    <h3><?php echo __('To print this slider into WordPress Post/Page use below Short code','continuous-image-carousel-with-lightbox');?></h3>
    <input type="text" value="[print_continuous_slider_plus_lightbox]" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
    <div class="clear"></div>
    <h3><?php echo __('To print this slider into WordPress theme/template PHP files use below php code','continuous-image-carousel-with-lightbox');?></h3>
    <input type="text" value="echo do_shortcode('[print_continuous_slider_plus_lightbox]');" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
    <div class="clear"></div>
    <div class="clear"></div>
    <?php       
    }

    function print_continuous_slider_plus_lightbox_func($atts){

        $wpcurrentdir=dirname(__FILE__);
        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
        $settings=get_option('continuous_thumbnail_slider_plus_lightbox_settings');
        if(!isset($settings['show_caption'])){
            
            $settings['show_caption']=0;
        }
        
     
        
        $wpcurrentdir=dirname(__FILE__);
        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
        
        $uploads = wp_upload_dir();
        $baseurl=$uploads['baseurl'];
        $baseurl.='/continuous-image-carousel-with-lightbox/';
        $baseDir=$uploads['basedir'];
        $baseDir=str_replace("\\","/",$baseDir);
        $pathToImagesFolder=$baseDir.'/continuous-image-carousel-with-lightbox';
        $rand_lightbox_rel=uniqid('lightbox_rel');
        $randOmeAlbName=uniqid('slider_');
        
        wp_enqueue_style( 'images-continuous-thumbnail-slider-plus-lighbox-style');
        wp_enqueue_style( 'continuous-l-box-css');
        wp_enqueue_script('jquery'); 
        wp_enqueue_script('images-continuous-thumbnail-slider-plus-lightbox-jc');
        wp_enqueue_script('continuous-l-box-js');

        ob_start();
    ?><!-- print_continuous_slider_plus_lightbox_func --><style type='text/css' >
        .bx-wrapper .bx-viewport {
            background: none repeat scroll 0 0 <?php echo $settings['scollerBackground']; ?> !important;
            border: 0px none !important;
            box-shadow: 0 0 0 0 !important;
            /*padding:<?php echo $settings['imageMargin'];?>px !important;*/
        }
    </style>              
    <div style="clear: both;"></div>
    <?php $url = plugin_dir_url(__FILE__);  ?>
    <div style="width: auto;postion:relative" id="divSliderMain">
        
         <?php 
                                    
                    $topMargin='5'.'px'; 
          ?>
        <?php if($settings['lightbox']):?>
        <script>
         function clickedItem(){ 
                            
                          
                          var uniqObj=jQuery("a[rel^='<?php echo $randOmeAlbName;?>']"); 
                          jQuery(".<?php echo $rand_lightbox_rel;?>").fancybox_crl({
                            'overlayColor':'#000000',
                             'padding': 10,
                             'autoScale': true,
                             'autoDimensions':true,
                             'transitionIn': 'none',
                             'uniqObj':uniqObj,
                             'transitionOut': 'none',
                             'titlePosition': 'over',
                             'cyclic':true,
                             'hideOnContentClick':false,
                             'width' : 600,
                             'height' : 350,
                             'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                                 var currtElem = jQuery('.responsiveContinuousCarousel a[href="'+currentOpts.href+'"]');

                                 var isoverlay = jQuery(currtElem).attr('data-overlay')
                                 
                                if(isoverlay=="1" && jQuery.trim(title)!=""){
                                 return '<span id="fancybox_crl-title-over">' + title  + '</span>';
                                }
                                else{
                                    return '';
                                }

                                },

                           });

                           return false;
                      }
         </script>
         <?php endif;?>
        <div class="responsiveContinuousCarousel" style="margin-top: <?php echo $topMargin;?> !important;display: none;">
            <?php
                global $wpdb;          
                $imageheight=$settings['imageheight'];
                $imagewidth=$settings['imagewidth'];
                $query="SELECT * FROM ".$wpdb->prefix."continuous_image_carousel order by createdon desc";
                $rows=$wpdb->get_results($query,'ARRAY_A');
              
                if(count($rows) > 0){
                    foreach($rows as $row){

                        $imagename=$row['image_name'];
                        $imageUploadTo=$baseurl.$imagename;
                        $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                        $pathinfo=pathinfo($imageUploadTo);
                        $filenamewithoutextension=$pathinfo['filename'];
                        $outputimg="";

                        $outputimgmain = $baseurl.$row['image_name']; 
                        if($settings['resizeImages']==0){

                            $outputimg = $baseurl.$row['image_name']; 

                        }
                        else{

                                $imagetoCheck=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                $imagetoCheckSmall=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);


                            if(file_exists($imagetoCheck)){
                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                            }
                            else if(file_exists($imagetoCheckSmall)){
                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                            }
                            else{

                                if(function_exists('wp_get_image_editor')){

                                    $image = wp_get_image_editor($pathToImagesFolder."/".$row['image_name']); 

                                    if ( ! is_wp_error( $image ) ) {
                                        $image->resize( $imagewidth, $imageheight, true );
                                        $image->save( $imagetoCheck );
                                        //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                        
                                        if(file_exists($imagetoCheck)){
                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                        }
                                        else if(file_exists($imagetoCheckSmall)){
                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                        }
                                        
                                    }
                                    else{
                                        $outputimg = $baseurl.$row['image_name'];
                                    }     

                                }
                                else if(function_exists('image_resize')){

                                    $return=image_resize($pathToImagesFolder.'/'.$row['image_name'],$imagewidth,$imageheight) ;
                                    if ( ! is_wp_error( $return ) ) {

                                        $isrenamed=rename($return,$imagetoCheck);
                                        if($isrenamed){
                                           // $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                            
                                          if(file_exists($imagetoCheck)){
                                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                            }
                                            else if(file_exists($imagetoCheckSmall)){
                                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                            }


                                        }
                                        else{
                                            $outputimg = $baseurl.$row['image_name']; 
                                        } 
                                    }
                                    else{
                                        $outputimg = $baseurl.$row['image_name'];
                                    }  
                                }
                                else{

                                    $outputimg = $baseurl.$row['image_name'];
                                }  

                                //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];

                            } 
                        } 





                        $title="";
                        $rowTitle=$row['title'];
                        $rowTitle=str_replace("'","’",$rowTitle); 
                        $rowTitle=str_replace('"','”',$rowTitle); 
                        if(trim($row['title'])!='' and trim($row['custom_link'])!=''){

                            $title="<a class='Imglink' target='_blank' href='{$row['custom_link']}'>{$rowTitle}</a>";

                        }
                        else if(trim($row['title'])!='' and trim($row['custom_link'])==''){

                            $title="<a class='Imglink' href='#'>{$rowTitle}</a>"; 

                        }
                        else{

                            if($row['title']!='')
                                $title="<a class='Imglink' target='_blank' href='#'>{$rowTitle}</a>"; 
                        }
                        
                        $title= htmlentities($title);

                    ?>         
            

                    <div class="limargin"> 
                       <a rel="<?php echo $randOmeAlbName;?>" data-overlay="1" data-title="<?php echo $title;?>" class="<?php echo $rand_lightbox_rel;?>"  <?php if($settings['lightbox']):?> href="<?php echo $outputimgmain;?>" <?php elseif($row['custom_link']!=''):?> href="<?php echo $row['custom_link'];?>" <?php else: ?><?php endif;?>>
                            <img <?php if($settings['lightbox']):?> onclick="return clickedItem();" <?php endif;?> src="<?php echo $outputimg; ?>" alt="<?php echo $rowTitle; ?>" title="<?php echo $rowTitle;?>"  />
                        </a> 
                    </div>

                    <?php }?>   
                <?php }?>   
        </div>
    </div>                   
    <script>

      <?php $intval= uniqid('interval_');?>
               
        var <?php echo $intval;?> = setInterval(function() {

        if(document.readyState === 'complete') {

           clearInterval(<?php echo $intval;?>);
                
                     jQuery(".responsiveContinuousCarousel").show();
                    var uniqObj=jQuery("a[rel^='<?php echo $randOmeAlbName;?>']");
                         var slider= jQuery('.responsiveContinuousCarousel').bxSlider({
                             slideWidth: <?php echo $settings['imagewidth'];?>,
                            minSlides: <?php echo $settings['min_visible'];?>,
                            maxSlides: <?php echo $settings['visible'];?>,
                            slideMargin:<?php echo $settings['imageMargin'];?>,  
                            speed:<?php echo $settings['speed']; ?>,
                            useCSS:false,
                            ticker: true,
                            <?php if($settings['pauseonmouseover']):?>
                                tickerHover:true, 
                             <?php endif;?>           
                             <?php if($settings['show_caption']):?>
                             captions:true,
                            <?php else:?>
                              captions:false,
                            <?php endif;?>
                            onSliderLoad: function(){
                                   
                            
                            }    


                     });


              }    
                }, 100);




             window.addEventListener('load', function() {


                setTimeout(function(){ 

                        if(jQuery(".responsiveContinuousCarousel").find('.bx-loading').length>0){

                                jQuery(".responsiveContinuousCarousel").find('img').each(function(index, elm) {

                                        if(!elm.complete || elm.naturalWidth === 0){

                                            var toload='';
                                            var toloadval='';
                                            jQuery.each(this.attributes, function(i, attrib){

                                                    var value = attrib.value;
                                                    var aname=attrib.name;

                                                    var pattern = /^((http|https):\/\/)/;

                                                    if(pattern.test(value) && aname!='src') {

                                                            toload=aname;
                                                            toloadval=value;
                                                     }
                                                    // do your magic :-)
                                             });

                                                    vsrc=jQuery(elm).attr("src");
                                                    jQuery(elm).removeAttr("src");
                                                    dsrc=jQuery(elm).attr("data-src");
                                                    lsrc=jQuery(elm).attr("data-lazy-src");


                                                       if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                                     jQuery(elm).attr("src",dsrc);
                                                            }
                                                            else if(lsrc!== undefined && lsrc!=vsrc){

                                                                             jQuery(elm).attr("src",lsrc);
                                                            }
                                                            else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                    jQuery(elm).removeAttr(toload);
                                                                    jQuery(elm).attr("src",toloadval);


                                                                } 
                                                            else{

                                                                            jQuery(elm).attr("src",vsrc);

                                                       }   

                                                    elm=jQuery(elm)[0];      
                                                     if(!elm.complete && elm.naturalHeight == 0){

                                                    jQuery(elm).removeAttr('loading');
                                                    jQuery(elm).removeAttr('data-lazy-type');


                                                    jQuery(elm).removeClass('lazy');

                                                    jQuery(elm).removeClass('lazyLoad');
                                                    jQuery(elm).removeClass('lazy-loaded');
                                                    jQuery(elm).removeClass('jetpack-lazy-image');
                                                    jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                    jQuery(elm).removeClass('lazy-hidden');

                                                }
                                         }

                                    }).promise().done( function(){ 

                                            jQuery(".responsiveContinuousCarousel").find('.bx-loading').remove();
                                    } );

                            }


                   }, 6000);

        });
                                
            
    </script><!-- end print_continuous_slider_plus_lightbox_func --><?php
        $output = ob_get_clean();
        return $output;
    }
    
     function continuous_slider_plus_responsive_lightbox_get_wp_version() {
        global $wp_version;
        return $wp_version;
    }

    //also we will add an option function that will check for plugin admin page or not
    function continuous_slider_plus_lightbox_is_plugin_page() {
        $server_uri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        foreach (array('continuous_thumbnail_slider_with_lightbox_image_management','continuous_thumbnail_slider_with_lightbox') as $allowURI) {
            if(stristr($server_uri, $allowURI)) return true;
        }
        return false;
    }

    //add media WP scripts
    function continuous_slider_plus_lightbox_admin_scripts_init() {
        if(continuous_slider_plus_lightbox_is_plugin_page()) {
            //double check for WordPress version and function exists
            if(function_exists('wp_enqueue_media') && version_compare(continuous_slider_plus_responsive_lightbox_get_wp_version(), '3.5', '>=')) {
                //call for new media manager
                wp_enqueue_media();
            }
            wp_enqueue_style('media');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }
    }
    
    function cicwlp_remove_extra_p_tags($content){

        if(strpos($content, 'print_continuous_slider_plus_lightbox_func')!==false){
        
            
            $pattern = "/<!-- print_continuous_slider_plus_lightbox_func -->(.*)<!-- end print_continuous_slider_plus_lightbox_func -->/Uis"; 
            $content = preg_replace_callback($pattern, function($matches) {


               $altered = str_replace("<p>","",$matches[1]);
               $altered = str_replace("</p>","",$altered);
              
                $altered=str_replace("&#038;","&",$altered);
                $altered=str_replace("&#8221;",'"',$altered);
              

              return @str_replace($matches[1], $altered, $matches[0]);
            }, $content);

              
            
        }
        
        $content = str_replace("<p><!-- print_continuous_slider_plus_lightbox_func -->","<!-- print_continuous_slider_plus_lightbox_func -->",$content);
        $content = str_replace("<!-- end print_continuous_slider_plus_lightbox_func --></p>","<!-- end print_continuous_slider_plus_lightbox_func -->",$content);
        
        
        return $content;
  }

  function wrthslider_slider_mass_upload_wrthsliderlboxcont(){
        
       global $wpdb; 
      
        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/continuous-image-carousel-with-lightbox/';

      if(isset($_POST) and sizeof($_POST)>0){
      
         if(!check_ajax_referer( 'thumbnail-mass-image','thumbnail_security' )){
          
          wp_die('Security check fail'); 
          
          }  
         if ( ! current_user_can( 'cicwl_continuous_slider_add_image' ) ) {

           wp_die( __( "Access Denied", "continuous-image-carousel-with-lightbox" ) );

         }
         $createdOn=date('Y-m-d h:i:s');
         if(function_exists('date_i18n')){
            
             $createdOn=date_i18n('Y-m-d'.' '.get_option('time_format') ,false,false);
            if(get_option('time_format')=='H:i')
                $createdOn=date('Y-m-d H:i:s',strtotime($createdOn));
             else   
               $createdOn=date('Y-m-d h:i:s',strtotime($createdOn));
         } 
         $attachment_id=(int)$_POST['attachment_id'];
         $photoMeta = wp_get_attachment_metadata( $attachment_id );
        
         $open_link_in=0;
         $enable_light_box_img_desc=0;  
         $imageurl='';
         $title=trim(htmlentities(strip_tags($_POST['imagetitle']),ENT_QUOTES));
         $enable_light_box_img_desc=0;     
        
         if(is_array($photoMeta) and isset($photoMeta['file'])) {
             
                 $fileName=$photoMeta['file'];
                 $phyPath=ABSPATH;
                 $phyPath=str_replace("\\","/",$phyPath);
               
                 $pathArray=pathinfo($fileName);
               
                 $imagename=$pathArray['basename'];
                 $imagename_=$pathArray['filename'];
                 $file_ext=$pathArray['extension'];
                 $imagename=$imagename_.uniqid().".".$file_ext;
                 $upload_dir_n = wp_upload_dir(); 
                 $upload_dir_n=$upload_dir_n['basedir'];
                 $fileUrl=$upload_dir_n.'/'.$fileName;
                 $fileUrl=str_replace("\\","/",$fileUrl);
                 $wpcurrentdir=dirname(__FILE__);
                 $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                 $imageUploadTo=$pathToImagesFolder."/".$imagename;
                 @copy($fileUrl, $imageUploadTo);
                 
                  if(!file_exists($imageUploadTo)){
                    rsths_save_image_remote_lbox($fileUrl,$imageUploadTo);
                   }
                           
          }
      
          
          
         
          $query = "INSERT INTO ".$wpdb->prefix."continuous_image_carousel (title, image_name,createdon) 
                    VALUES ('$title','$imagename','$createdOn')";

          $wpdb->query($query);

          
         
      }  

 }
 
  add_filter('widget_text_content', 'cicwlp_remove_extra_p_tags', 999);
  add_filter('the_content', 'cicwlp_remove_extra_p_tags', 999);




function i13_cic_modify_render_block_defaults($block_content, $block) { 

    $block_content=cicwlp_remove_extra_p_tags($block_content);
    return $block_content; 

}

// add the filter

add_filter( 'render_block', 'i13_cic_modify_render_block_defaults', 10, 2 );
