<?php
/*
template: jwptemplate
version: 3
platform: php(wordpress)
*/

if(is_admin()):
    add_action('admin_menu', 'JWPCustomMetaBoxes');
    function JWPCustomMetaBoxes() { 
        global $wpdb;
        $getwidgets = $wpdb->get_results("SELECT c_post_name, mb_value FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'mb'");

        foreach($getwidgets as $meta_box_data):
            $data = json_decode($meta_box_data->mb_value);

            $metabox_id = trim(str_replace(" ", "-", $data->jwp_meta_box_group));
            $fields = array(
                'c_metabox_field_name' => $data->c_metabox_field_name,
                'meta_field_type' => $data->meta_field_type,
                'c_metabox_field_desc' => $data->c_metabox_field_desc,
                'meta_field_options' => $data->meta_field_options
            );
            add_meta_box($metabox_id, $data->jwp_meta_box_group_label, 'JWPCallBackFunction', $data->jwp_meta_box_custom_posts, strtolower($data->meta_type), strtolower($data->meta_priority),$fields);
        endforeach;

    }

    function JWPCallBackFunction($attr, $field) {
        global $post;
        echo '<input type="hidden" name="page_noncename" id="sectionspost_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

        foreach ($field['args']['c_metabox_field_name'] as $key => $value) {
            $metafieldname = strtolower(trim(str_replace(" ", "-", $field['args']['c_metabox_field_name'][$key])));
            $textmetaval = get_post_meta($post->ID,$metafieldname, true);

            switch ($field['args']['meta_field_type'][$key]) {
                case 'text':
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                    <input type="text" class="widefat" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>" value="<?php echo $textmetaval; ?>">
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php
                     break;
                case 'email':
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                    <input type="email" class="widefat" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>" value="<?php echo $textmetaval; ?>">
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php
                    break;
                case 'number':
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                    <input type="number" class="widefat" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>" value="<?php echo $textmetaval; ?>">
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php
                    break;
                case 'date':
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                    <input type="date" class="widefat" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>" value="<?php echo $textmetaval; ?>">
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php
                    break;
                case 'textarea':
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                    <textarea class="widefat" name="<?php echo $metafieldname; ?>" rows="5" id="<?php echo $metafieldname; ?>"><?php echo $textmetaval; ?></textarea>
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php
                    break;

                case 'select':
                    $options = explode("\r\n", $field['args']['meta_field_options'][$key]);
?>
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label>
                       <select class="widefat" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>">
                        <option></option>
                        <?php foreach($options as $index => $values): ?>
                           <option value="<?php echo $values ?>" <?php echo ($textmetaval == $values)? "selected" : NULL;  ?>><?php echo $values; ?></option>
                        <?php endforeach; ?>
                       </select> 
                       <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
<?php

                break;

                case 'checkbox':
                    $options = explode("\r\n", $field['args']['meta_field_options'][$key]);
                    $options_saved = explode("[jwp]", $textmetaval);
?>

                    <div class="jwp_option_checkbox jwp_field_div_section">
                    <div><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label><br/>
                        <?php 
                        $cnter = 0;
                        foreach($options as $index => $values): $cnter++; ?>
                            <div>
                            <input type="checkbox" class="<?php echo $metafieldname.'_option_class'; ?>" jwp_target_field="<?php echo $metafieldname; ?>" id="<?php echo trim(str_replace(" ", "-", $metafieldname).$cnter); ?>" value="<?php echo $values; ?>" <?php echo (@in_array($values, $options_saved))? "checked" : NULL; ?>><label for="<?php echo trim(str_replace(" ", "-", $metafieldname).$cnter); ?>">&nbsp;<?php echo $values; ?></label>&nbsp;&nbsp;&nbsp;
                            </div>
                        <?php endforeach; ?>
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                        <input type="hidden" name="<?php echo $metafieldname; ?>" id="<?php echo $metafieldname; ?>" value="<?php echo $textmetaval; ?>">
                    </div>
                    <!-- implement jquery to fix the single or none checkbox select -->
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery('.<?php echo $metafieldname.'_option_class'; ?>').click(function(){
                                var get_target = jQuery(this).attr('jwp_target_field');
                                jQuery('#'+get_target).val('');
                                var newcon = "";
                                for(var cc = 1; cc <= jQuery('.<?php echo $metafieldname.'_option_class'; ?>').length; cc++){

                                    if(jQuery('#<?php echo $metafieldname; ?>'+cc).is(":checked")){
                                        if(cc < jQuery('.<?php echo $metafieldname.'_option_class'; ?>').length){
                                            newcon = newcon + jQuery('#<?php echo $metafieldname; ?>'+cc).val()+"[jwp]";
                                        }else{
                                            newcon = newcon + jQuery('#<?php echo $metafieldname; ?>'+cc).val();
                                        }
                                        
                                    }
                                }
                                jQuery('#'+get_target).val(newcon);
                            });
                        });
                    </script>
                    </div>


<?php

                break;


                case 'radio':
                    $options = explode("\r\n", $field['args']['meta_field_options'][$key]);
                    $options_saved = explode("[jwp]", $textmetaval);
?>
                    <div class="jwp_option_radio jwp_field_div_section">
                    <div><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label><br/>
                        <?php 
                        $cnter = 0;
                        foreach($options as $index => $values): $cnter++; ?>
                            <div>
                            <input type="radio" name="<?php echo $metafieldname; ?>" id="<?php echo trim(str_replace(" ", "-", $metafieldname).$cnter); ?>" value="<?php echo $values; ?>" <?php echo (in_array($values, $options_saved))? "checked" : NULL; ?>><label for="<?php echo trim(str_replace(" ", "-", $metafieldname).$cnter); ?>">&nbsp;<?php echo $values; ?></label>&nbsp;&nbsp;&nbsp;
                            </div>
                        <?php endforeach; ?>
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </div>
                    </div>
<?php


                break;

                case 'media_upload':

?>
                  
                    <p><label><?php echo $field['args']['c_metabox_field_name'][$key]; ?></label></p>
                    <p id="expo_logo_holder"><?php if($textmetaval): ?><img src="<?php echo $textmetaval; ?>"><?php endif; ?></p>
                    <p>
                    <input type="text" id="<?php echo $metafieldname; ?>" name="<?php echo $metafieldname; ?>" class="widefat" value="<?php echo $textmetaval; ?>" /> 
                        <i><?php echo $field['args']['c_metabox_field_desc'][$key]; ?></i>
                    </p>
                    <p>
                    <button id="expo_logo_select" class="button button-primary button-large">Select Featured Image</button>
                    </p>
             

                   
                    <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('#expo_logo_select').click(function(e) {
                                    e.preventDefault();
                                    var image = wp.media({ 
                                        title: 'Select Logo',
                                        // mutiple: true if you want to upload multiple files at once
                                        multiple: false
                                    }).open()
                                    .on('select', function(e){
                                        // This will return the selected image from the Media Uploader, the result is an object
                                        var uploaded_image = image.state().get('selection').first();
                                        // We convert uploaded_image to a JSON object to make accessing it easier
                                        // Output to the console uploaded_image
                                        console.log(uploaded_image);
                                        var image_url = uploaded_image.toJSON().url;
                                        var image_title = uploaded_image.toJSON().title;
                                        // Let's assign the url value to the input field
                                        $('#<?php echo $metafieldname; ?>').val(image_url);
                                        $('#expo_logo_holder').html('<img src="'+image_url+'" >');
                                    });
                                });
                            });
                    </script>

                <style type="text/css">
                    #expo_logo_holder img{ max-width: 100%; }
                </style>
<?php
                break;
                default:
                    //do nothing
                break;
             }

        }


    }
    
    add_action('save_post', 'SaveCustomMetaBox', 1, 2);
    function SaveCustomMetaBox($post_id, $post) {
        if ( !wp_verify_nonce( $_POST['page_noncename'], plugin_basename(__FILE__) )) {
            return $post->ID;
        }
        if ( !current_user_can( 'edit_post', $post->ID ))
            return $post->ID; 

        foreach ($_POST as $key => $value) { 

            $value = implode('[jwp]', (array)$value);

            if(get_post_meta($post->ID, $key, FALSE)) { 
                update_post_meta($post->ID, $key, $value);
            } else { 
                add_post_meta($post->ID, $key, $value);
            }
            if(!$value) delete_post_meta($post->ID, $key); 
        }

    }


endif;

?>