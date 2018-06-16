<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Produtos da Categoria <?php echo $category["descategory"]; ?>

  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $url_base; ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $url_base; ?>admin/categories">Categorias</a></li>
    <li><a href="<?php echo $url_base; ?>admin/categories/<?php echo $category["idcategory"]; ?>"><?php echo $category["descategory"]; ?></a></li>
    <li class="active"><a href="<?php echo $url_base; ?>admin/categories/<?php echo $category["idcategory"]; ?>/products">Produtos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Todos os Produtos</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome do Produto</th>
                            <th style="width: 240px">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter1=-1;  if( isset($productsNotRelated) && ( is_array($productsNotRelated) || $productsNotRelated instanceof Traversable ) && sizeof($productsNotRelated) ) foreach( $productsNotRelated as $key1 => $value1 ){ $counter1++; ?>

                            <tr>
                            <td><?php echo $value1["idproduct"]; ?></td>
                            <td><?php echo $value1["desproduct"]; ?></td>
                            <td>
                                <a href="<?php echo $url_base; ?>admin/categories/<?php echo $category["idcategory"]; ?>/products/<?php echo $value1["idproduct"]; ?>/add" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>
                            </td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                <h3 class="box-title">Produtos na Categoria <?php echo $category["descategory"]; ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome do Produto</th>
                            <th style="width: 240px">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter1=-1;  if( isset($productsRelated) && ( is_array($productsRelated) || $productsRelated instanceof Traversable ) && sizeof($productsRelated) ) foreach( $productsRelated as $key1 => $value1 ){ $counter1++; ?>

                            <tr>
                            <td><?php echo $value1["idproduct"]; ?></td>
                            <td><?php echo $value1["desproduct"]; ?></td>
                            <td>
                                <a href="<?php echo $url_base; ?>admin/categories/<?php echo $category["idcategory"]; ?>/products/<?php echo $value1["idproduct"]; ?>/remove" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-left"></i> Remover</a>
                            </td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->