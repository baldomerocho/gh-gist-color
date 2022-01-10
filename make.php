<!DOCTYPE html>
<html>

<head>

    <!--    IMPORT SCRIPTS JS [VUEJS, SWEET ALERT 2] -->
    <script src="https://unpkg.com/vue@2.5.2"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<?php
// VALIDATE IF CURRENT GIST THEME WP IS CHANGED ON POST
$option_name = "current_gist_theme_wp";
$new_value = $_POST["newGistThemeWPSelected"];
$get_option = get_option($option_name);
if ($_POST["theme"] != "" && $_POST["theme"] != $get_option) {
    if ($get_option != $new_value) {
        update_option($option_name, $new_value);
        echo '<script type="text/javascript">
            Swal.fire(
              `' . strtoupper($_POST["theme"]) . ' selected`,
              `Gist Theme Updated`,
              `success`
            );
            </script>';
    } else {
        $deprecated = ' ';
        $autoload = 'no';
        add_option($option_name, $new_value, $deprecated, $autoload);
    }
    $get_option = get_option($option_name);


}


// CREATE FORM FOR UPDATE OR CHANGE GIST THEME WP


?>
<div id="app">
    <h2>Current theme: {{selection.toUpperCase()}}</h2>
    <img v-bind:src="ruta+selection+'.png'" alt="" style="margin:20px 0">
    <form id="updateGistThemeWP" name="updateGistThemeWP" method="POST">
        <select id="newGistThemeWPSelected" size="1" v-model="selection" name="newGistThemeWPSelected">
            <option v-for="item in items" :value="item">{{item.toUpperCase()}}</option>
        </select>
        <input type="submit" value="Save" style=""/>

    </form>
</div>


<script>
    (async () => {
        const productsResponse = await fetch(<?php echo '"' . plugins_url('gist-theme-wp/options.json', dirname(__FILE__)) . '"'?>);
        const products = await productsResponse.json();

        new Vue({
            el: '#app',
            data() {
                return {
                    items: products,
                    selection: <?php echo '"' . $get_option . '"'?>,
                    ruta: <?php echo '"' . plugins_url('gist-theme-wp/themes-gist/', dirname(__FILE__)) . '"'?>
                }
            }
        })
    })();
</script>
</body>

</html>