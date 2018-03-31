<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14-01-2018
 * Time: 20:40
 */
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liceo</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/public/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select2/dist/css/select2.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select_bootstrap/dist/select2-bootstrap.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select_bootstrap/dist/select2-bootstrap.min.css')?>">
    <!-- Carga Inicial por carga de plantilla-->
    <script src="<?php echo base_url('/public/js/jquery.js')?>"></script>
</head>
<body style="background-color: #1F4661;">
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="color:black;">Liceo Politecnico de Curacautin</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url('/registro/registro_alumnos')?>">Registrar Alumno</a></li>
                <li><a href="<?php echo base_url('/mantenedores/alumnos')?>">Listado Alumno</a></li>
                <li><a href="<?php echo base_url('/manuales/informativo')?>">Mini Manual de Uso</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
    <div class="container">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <?php echo $content_for_layout; ?>
        </div>
    </div>
</body>
<style>
    hr {
        -moz-border-bottom-colors: none;
        -moz-border-image: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #EEEEEE -moz-use-text-color #FFFFFF;
        border-style: solid none;
        border-width: 1px 0;
        margin: 18px 0;
    }
    .select2 {
        width: 100%!important; /* overrides computed width, 100px in your demo */
    }
</style>
<div class="modal fade" id="modal_generico" tabindex="-1"
role="dialog" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
            <h3 id="titulo_modal_generico"></h3>
        </div>
        <div class="modal-body">
            <h4 id="modal_generico_body"></h4>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url('/public/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('/public/js/datatables.js')?>"></script>
<script src="<?php echo base_url('/public/js/integracion_datatables.js')?>"></script>
<script src="<?php echo base_url('/public/select2/dist/js/select2.min.js')?>"></script>
</html>

