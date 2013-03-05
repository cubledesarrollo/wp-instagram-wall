<div class="wrap">
    <h2>Instagram Wall</h2>
    <form method="post" action="options.php"> 
        
        <?php @settings_fields('wp_instagram_wall-group'); ?>
        <?php @do_settings_fields('wp_instagram_wall-group'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="title">Title</label></th>
                <td><input type="text" name="title" id="title" value="<?php echo get_option('title'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="slug">Slug</label></th>
                <td><input type="text" name="slug" id="slug" value="<?php echo get_option('slug'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="access_token">Access Token</label></th>
                <td><input type="text" name="access_token" id="access_token" value="<?php echo get_option('access_token'); ?>" /></td>
            </tr>
        </table>
        <?php @submit_button(); ?>
    </form>
</div>