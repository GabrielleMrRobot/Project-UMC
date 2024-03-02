<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel">
                    <div class="embed-responsive embed-responsive-4by3" style="margin-top: 30px;">
                    <iframe class="embed-responsive-item" src="<?php echo base_url() . "/ventas/generaTicket/" . $id_venta ?>"></iframe>
                </div>
            </div>
        </div>
    </div>
</main>

<?php


/* ve los minutos: 1:49:34 del video numero 8

ve el inicio del video 9 ddonde tienes que cambiar algunas cosas del archivo header.php 

Ve el minuto 15:43 del video 9 donde tienes que cambiar en public funtion index 



tienes qque colocar el $this->productos = new  ProductosModel(); en el construct

apartir del  minuto 50 del video 9 debes hacer unas modificaciones para agregar imagenes al producto

*/ ?>