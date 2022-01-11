<?php if ( ! defined( 'ABSPATH' ) ) exit;  ?>
<html>

<?php
// VALIDATE IF CURRENT GIST THEME WP IS CHANGED ON POST
$option_name = "current_theme_gist_embed";
$new_value = $_POST["newGistThemeWPSelected"];
$get_option = get_option($option_name);
if ($_POST["newGistThemeWPSelected"] != "" && $_POST["newGistThemeWPSelected"] != $get_option) {
    if ($get_option != $new_value) {
        update_option($option_name, $new_value);
        echo '<div class="notice notice-success is-dismissible" style="max-width: 700px">
             <p><strong>'.strtoupper($new_value).'</strong> selected and saved.</p>
         </div>';
    } else {
        add_option($option_name, $new_value, ' ', 'no');
    }
    $get_option = get_option($option_name);


}
?>

<body>

<!-- CREATE FORM FOR UPDATE OR CHANGE GIST THEME WP -->
<div id="appx" class="wrap">
    <h1>Theme Gist Embed Config</h1>
    <h2>Current theme: {{selection.toUpperCase()}}</h2>
    <img :src="ruta+selection+'.png'" alt="" style="margin:20px 0">
    <form id="updateGistThemeWP" name="updateGistThemeWP" method="POST">
        <select id="newGistThemeWPSelected" size="1" v-model="selection" name="newGistThemeWPSelected">
            <option v-for="item in items" :value="item">{{item.toUpperCase()}}</option>
        </select>
        <input type="submit" value="Save" class="button button-primary"/>

    </form>
</div>


<script>
    (async () => {
        const productsResponse = await fetch("<?php echo plugin_dir_url( dirname(__FILE__ ) ) . 'options.json'; ?>");
        const products = await productsResponse.json();

        new Vue({
            el: '#appx',
            data() {
                return {
                    items: products,
                    selection: "<?php echo $get_option?>",
                    ruta: "<?php echo plugin_dir_url( dirname(__FILE__ ) ) . 'themes-gist/'; ?>",
                }
            }
        })
    })();
</script>
</body>
</html>