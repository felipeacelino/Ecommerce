<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Pedido N°<?php echo $order["idorder"]; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $url_base; ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $url_base; ?>admin/orders">Pedidos</a></li>
        <li class="active"><a href="<?php echo $url_base; ?>admin/orders/<?php echo $order["idorder"]; ?>">Pedido N°<?php echo $order["idorder"]; ?></a></li>
    </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Status do Pedido</h3>
            </div>
            <!-- /.box-header -->
            <?php if( $msgError != '' ){ ?>
            <div class="alert alert-danger alert-dismissible" style="margin:10px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $msgError; ?></p>
            </div>
            <?php } ?>
            <?php if( $msgSuccess != '' ){ ?>
            <div class="alert alert-success alert-dismissible" style="margin:10px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $msgSuccess; ?></p>
            </div>
            <?php } ?>
            <!-- form start -->
            <form role="form" action="<?php echo $url_base; ?>admin/orders/<?php echo $order["idorder"]; ?>/status" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="desproduct">Status do Pedido</label>
                        <select class="form-control" name="idstatus">
                            <?php $counter1=-1;  if( isset($status) && ( is_array($status) || $status instanceof Traversable ) && sizeof($status) ) foreach( $status as $key1 => $value1 ){ $counter1++; ?>
                            <option <?php if( $value1["idstatus"] === $order["idstatus"] ){ ?>selected="selected"<?php } ?> value="<?php echo $value1["idstatus"]; ?>"><?php echo $value1["desstatus"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    
    </section>
    <!-- /.content -->

    <div class="clearfix"></div>

</div>
<!-- /.content-wrapper -->