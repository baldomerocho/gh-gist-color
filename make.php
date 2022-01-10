<html>

<?php
// VALIDATE IF CURRENT GIST THEME WP IS CHANGED ON POST
$option_name = "current_theme_gist_embed";
$new_value = $_POST["newGistThemeWPSelected"];
$get_option = get_option($option_name);
$showAlert=0;
if ($_POST["newGistThemeWPSelected"] != "" && $_POST["newGistThemeWPSelected"] != $get_option) {
    if ($get_option != $new_value) {
        update_option($option_name, $new_value);
        $showAlert=1;
    } else {
        $deprecated = ' ';
        $autoload = 'no';
        add_option($option_name, $new_value, $deprecated, $autoload);
        $showAlert=0;
    }
    $get_option = get_option($option_name);


}
?>

<body style="vh">

<!-- CREATE FORM FOR UPDATE OR CHANGE GIST THEME WP -->
<div id="app">
    <h2>Current theme: {{selection.toUpperCase()}}</h2>
    <img :src="ruta+selection+'.png'" alt="" style="margin:20px 0">
    <form id="updateGistThemeWP" name="updateGistThemeWP" method="POST">
        <select id="newGistThemeWPSelected" size="1" v-model="selection" name="newGistThemeWPSelected">
            <option v-for="item in items" :value="item">{{item.toUpperCase()}}</option>
        </select>
        <input type="submit" value="Save" style=""/>

    </form>
</div>


<script>
    (async () => {
        const productsResponse = await fetch(<?php echo '"' . plugins_url('theme-gist/options.json', dirname(__FILE__)) . '"'?>);
        const products = await productsResponse.json();

        new Vue({
            el: '#app',
            data() {
                return {
                    items: products,
                    selection: <?php echo '"' . $get_option . '"'?>,
                    ruta: <?php echo '"' . plugins_url('theme-gist/themes-gist/', dirname(__FILE__)) . '"'?>,
                    showalertsw2: <?php echo $showAlert?>
                }
            },
            mounted(){

                if (this.showalertsw2) {
                    Swal.fire(this.selection.toUpperCase()+' selected', `Gist Theme Updated`, `success`);
                }
            }
        })
    })();
</script>
</body>
</html>