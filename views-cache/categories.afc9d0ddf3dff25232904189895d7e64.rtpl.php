<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Categorias
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $url_base; ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?php echo $url_base; ?>admin/categories">Categorias</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="<?php echo $url_base; ?>admin/categories/create" class="btn btn-success">Cadastrar Categoria</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome da Categoria</th>
                    <th style="width: 240px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>

                  <tr>
                    <td><?php echo $value1["idcategory"]; ?></td>
                    <td><?php echo $value1["descategory"]; ?></td>
                    <td>
                      <a href="<?php echo $url_base; ?>admin/categories/<?php echo $value1["idcategory"]; ?>/products" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Produtos</a>
                      <a href="<?php echo $url_base; ?>admin/categories/<?php echo $value1["idcategory"]; ?>" class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i> Editar</a>
                      <a href="<?php echo $url_base; ?>admin/categories/<?php echo $value1["idcategory"]; ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->