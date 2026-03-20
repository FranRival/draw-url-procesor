<?php
/*
Plugin Name: Draw URL Processor
Description: Envía URLs a draw.io sin mostrarlas al usuario
Version: 1.0
*/

add_action('admin_menu', function() {
    add_menu_page(
        'Draw URL Processor',
        'Draw URL Processor',
        'manage_options',
        'draw-url-processor',
        'dup_render_page'
    );
});

function dup_render_page() {
?>
<div class="wrap">
    <h1>Draw URL Processor</h1>

    <textarea id="dup_urls" rows="12" style="width:100%;" placeholder="1 URL por línea"></textarea>

    <br><br>

    <button id="dup_process" class="button button-primary">
        Procesar
    </button>
</div>

<script>
document.getElementById('dup_process').addEventListener('click', function(){

    const urls = document.getElementById('dup_urls').value
        .split('\n')
        .map(u => u.trim())
        .filter(u => u.length > 0);

    if(urls.length === 0){
        alert('No hay URLs');
        return;
    }

    fetch(ajaxurl, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=dup_generate&urls=' + encodeURIComponent(JSON.stringify(urls))
    })
    .then(res => res.json())
    .then(data => {
        if(data.url){
            window.open(data.url, '_blank');
        }
    });

});
</script>
<?php
}

add_action('wp_ajax_dup_generate', function(){

    $urls = json_decode(stripslashes($_POST['urls']), true);

    $y = 20;
    $nodes = '';

    foreach($urls as $i => $url){
        $id = $i + 2;

        $safe_url = htmlspecialchars($url, ENT_QUOTES);

        $nodes .= '
        <mxCell id="'.$id.'" value="'.$safe_url.'" style="rounded=1;whiteSpace=wrap;html=1;" vertex="1" parent="1">
            <mxGeometry x="20" y="'.$y.'" width="300" height="60" as="geometry"/>
        </mxCell>';

        $y += 80;
    }

    $xml = '
    <mxfile host="app.diagrams.net">
        <diagram name="URLs">
            <mxGraphModel>
                <root>
                    <mxCell id="0"/>
                    <mxCell id="1" parent="0"/>
                    '.$nodes.'
                </root>
            </mxGraphModel>
        </diagram>
    </mxfile>';

    $encoded = base64_encode($xml);

    $draw_url = 'https://app.diagrams.net/?create=' . urlencode($encoded);

    wp_send_json([
        'url' => $draw_url
    ]);
});