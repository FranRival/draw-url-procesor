<?php
/*
Plugin Name: Trash Posts Processor
Description: Envía posts a la papelera usando URLs o IDs
Version: 1.0
*/

add_action('admin_menu', function() {
    add_menu_page(
        'Trash Processor',
        'Trash Processor',
        'manage_options',
        'trash-processor',
        'tpp_render_page'
    );
});

function tpp_render_page() {
?>
<div class="wrap">
    <h1>Enviar a Trash</h1>

    <textarea id="tpp_input" rows="15" style="width:100%;" placeholder="URLs o IDs (1 por línea)"></textarea>

    <br><br>

    <button id="tpp_process" class="button button-primary">
        Procesar
    </button>
</div>

<script>
document.getElementById('tpp_process').addEventListener('click', function(){

    const data = document.getElementById('tpp_input').value
        .split('\n')
        .map(v => v.trim())
        .filter(v => v.length > 0);

    if(data.length === 0){
        alert('No hay datos');
        return;
    }

    fetch(ajaxurl, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=tpp_process&data=' + encodeURIComponent(JSON.stringify(data))
    })
    .then(res => res.json())
    .then(res => {
        alert('Procesados: ' + res.total + ' | Enviados a Trash: ' + res.trashed);
    });

});
</script>
<?php
}

add_action('wp_ajax_tpp_process', function(){

    $items = json_decode(stripslashes($_POST['data']), true);

    $trashed = 0;
    $total = count($items);

    foreach($items as $item){

        // Detectar si es ID o URL
        if(is_numeric($item)){
            $post_id = intval($item);
        } else {
            $post_id = url_to_postid($item);
        }

        if($post_id && get_post($post_id)){
            wp_trash_post($post_id);
            $trashed++;
        }
    }

    wp_send_json([
        'total' => $total,
        'trashed' => $trashed
    ]);
});