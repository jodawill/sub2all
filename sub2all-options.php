<?php
function s2a_show_enable_option($user) { ?>
 <table class="form-table">
  <tr>
   <th><label for="s2a_disabled"><?php _e("Require manual subscription to receive forum notifications"); ?></label></th>
   <td>
    <input type="checkbox" name="s2a_disabled" <?php if (esc_attr(get_the_author_meta('s2a_disabled', $user->ID)) == 'on') echo ' checked' ?>/><br/>
   </td>
  </tr>
 </table>
<?php }
add_action('view_user_profile', 's2a_show_enable_option');
add_action('edit_user_profile', 's2a_show_enable_option');
add_action('profile_personal_options', 's2a_show_enable_option');

function s2a_save_user_option($user_id) {
 if (!current_user_can('edit_user', $user_id)) {
  return false;
 }
 update_user_meta( $user_id, 's2a_disabled', $_POST['s2a_disabled'] );
}
add_action( 'personal_options_update', 's2a_save_user_option' );
add_action( 'edit_user_profile_update', 's2a_save_user_option' );
?>
