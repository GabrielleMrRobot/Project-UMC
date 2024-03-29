<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h4 class="mt-4"><?php echo $titulo;?></h4>
                        
                        <?php if(isset($validation)){ ?>
                        <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                        </div>
                        <?php } ?>

                        <form method="POST" action="<?php echo base_url(); ?>/cajas/actualizar"
                        autocomplete="off">
                        <?php csrf_field(); ?>

                        <input type="hidden" id="id" name="id" value="<?php echo $caja['id']; ?>" />

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Numero Caja</label>
                                    <input class="form-control" id="numero_caja" name="numero_caja" type="text" 
                                    value="<?php echo $caja['numero_caja']; ?>" autofocus required/>


                                </div>

                                <div class="col-12 col-sm-6">
                                    <label>Nombre</label>
                                    <input class="form-control" id="nombre" name="nombre" type="text"
                                    value="<?php echo $caja['nombre']; ?>"/>


                                </div>
                            
                            </div>
                        
                         </div>

                   

                         <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Folio</label>
                                    <input class="form-control" id="folio" name="folio" type="text" 
                                    value="<?php echo $caja['folio']; ?>"/>


                                </div>
                            
                            </div>
                        
                         </div>


                            <a href = "<?php echo base_url(); ?>/cajas" class="btn btn-primary">Regresar</a>
                            <button type="submit" class= "btn btn-success"> Guardar</button>
                       
                         </form>
                    </div>
                </main>