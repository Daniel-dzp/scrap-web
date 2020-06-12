<?php
    $datos = null;
    if(isset($_GET['ciudad']) && isset($_GET['colonia']))
    {
        $colonia = $_GET['colonia'];
        $ciudad = $_GET['ciudad'];
        if($colonia != '' && $ciudad != '')
        {
            $datos = file_get_contents("https://micodigopostal.org/guanajuato/$ciudad/$colonia/");

            $datos = explode('<h2>Detalles:</h2>',$datos);
            $datos = explode('</div></article></section></div><div id="social-m">', $datos[1]); // $datos[0] tiene la tabla

            $datos = explode('<tbody><tr><td>', $datos[0]);
            $datos = explode('</td></tr></tbody>',$datos[1]);
            $datos = explode('</td><td>',$datos[0]);
            
            $datosFinales = [];
            $datosFinales[0] = $datos[0]; // Asentamiento
            $datosFinales[1] = $datos[1]; // Tipo de Asentamiento
            $datosFinales[5] = $datos[5]; // Zona
            
            // codigo postal
            $datosTemp = explode('<span itemprop="postalCode">', $datos[2]);
            $datosTemp = explode('</span>', $datosTemp[1]);
            $datosFinales[2] = $datosTemp[0];

            // municipio
            $datosTemp = explode('<span itemprop="addressLocality">', $datos[3]);
            $datosTemp = explode('</span>', $datosTemp[1]);
            $datosFinales[3] = $datosTemp[0];

            // Ciudad
            $datosTemp = explode('<span itemprop="addressLocality">', $datos[4]);
            $datosTemp = explode('</span>', $datosTemp[1]);
            $datosFinales[4] = $datosTemp[0];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigos Postales</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <h3>Buscar código postal</h3>
                <form method="get" action="" class="form-group">
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Colonia</label>
                        <input type="text" name="colonia" class="form-control">
                    </div>
                    
                    <input type="submit" value="Buscar" class="btn btn-default btn-success">
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="row">    
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <?php
                    if($datos != null):
                ?>
                    <h4>El código postal de <?=$colonia?> en <?=$ciudad?> es <?=$datosFinales[2]?></h4>
                    <table class="table table-sm">
                        <tr>
                            <th>Asentamiento</th>
                            <th>Tipo de Asentamiento</th>
                            <th>Código Postal</th>
                            <th>Municipio</th>
                            <th>Ciudad</th>
                            <th>Zona</th>
                        </tr>
                        <tr>
                            <th><?=$datosFinales[0]?></th>
                            <th><?=$datosFinales[1]?></th>
                            <th><?=$datosFinales[2]?></th>
                            <th><?=$datosFinales[3]?></th>
                            <th><?=$datosFinales[4]?></th>
                            <th><?=$datosFinales[5]?></th>
                        </tr>
                    </table>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
        
    
</body>
</html>