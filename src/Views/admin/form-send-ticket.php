<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<div class="wrap">
    <div class="columns">
        <form method="POST" action="<?=admin_url('admin-post.php')?>" class="column is-half is-offset-one-quarter">
            <input type="hidden" name="action" value="send_ticket_manually">
            <div class="field">
                <label class="label">Elegir un pedido</label>
                <div class="control">
                    <div class="select is-fullwidth">
                    <select name="order_id">
                    <?php for ($i=0; $i < count($orders); $i++): ?>
                        <option value="<?=$orders[$i]->ID?>">Pedido #<?=$orders[$i]->ID?></option>
                    <?php endfor; ?>
                    </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Número de Teléfono</label>
                <div class="control">
                    <input class="input" type="tel" name="phone" placeholder="Ex: 11522...4">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" style="font-size:16px">
                        Enviar Prueba
                    </button>
                </div>
            </div>
        </form>
    </div><!--/.columns-->
</div>