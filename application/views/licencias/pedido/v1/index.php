<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lincenciamiento Blazar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="row">
        <p></p>
        <div class="col-md-04">
          <p>Licenciamiento Blazar Networks</p>
        </div>
      </div>
    </div>
  </nav>

  <?php
  $costoUnitario = $this->utilerias->generarDecimales($pedido->dou_costo_licencia);
  $costototal = $costoUnitario * $pedido->int_cantidad_licencia;
  $costototal = $this->utilerias->generarDecimales($costototal);
  $formstyle = "";
  $alertaentrega = " display: none; ";
  $formcancelado = " display: none; ";

  if ($pedido->int_activo_pedido == 2) {
    $formstyle = " display: none; ";
    $alertaentrega = "";
  }
  if ($pedido->int_activo_pedido == 0) {
    $formcancelado = "";
    $formstyle = " display: none; ";
  }

  ?>


  <div class="container">
    <br><br><br><br>
    <h2>Pedido: #<?= $pedido->var_codigo_pedido ?></h2>
    <h4>Hola <?= $proveedor->nombres . " " . $proveedor->apellidopat ?>, este es un pedido de Blazar.</h4>

    <div class="card" style="width: 100%">
      <div class="card-header">
        <p>Detalles de pedido</p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Tipo de licencia: <strong><?= $licencia->nombrelicencia ?></strong></li>
        <li class="list-group-item">Licencia valida para: <strong><?= $pedido->int_cantidad_licencia ?></strong> dispositivos.</li>
        <li class="list-group-item">Costo Unitario: $<?= $costoUnitario ?></li>
        <li class="list-group-item">Precio total: $<?= $costototal ?></li>
        <li class="list-group-item">Total a pagar: <strong style="color:red">$<?= $costototal ?></strong></li>

      </ul>
      <p>Nota: <?= $pedido->txt_nota ?></p><br>
    </div>
    <div class="alert alert-success" role="alert" style="<?= $alertaentrega ?>">
      <p>Este pedido fue entregado correctamente. <br>Fecha de entrega <strong><?= $pedido->tsp_fecha_entrega ?></strong>.</p>
    </div>
    <div class="alert alert-success" role="alert" style="display:none" id="subenvioalerta">
      <p>Este pedido fue entregado correctamente.</strong>.</p>
    </div>

    <div class="alert alert-danger" role="alert" style="<?= $formcancelado ?>">
      <p>Este pedido fue cancelado.</p>
    </div>





    <form action="#" id="formpedido" style="<?= $formstyle ?>">
      <div class="form-group">
        <label for="licencia">Licencia:</label>
        <input type="text" name="idpedido" id="idpedido" value="<?= $pedido->int_id_pedido ?>" style="display: none;">
        <input type="text" class="form-control" id="licencia" placeholder="Ingrese la licencia" name="licencia" required>
      </div>
      <div class="form-group">
        <label for="cantidadcals">Cantidad de CALS:</label>
        <input type="number" class="form-control" id="cantidadcals" placeholder="Ingrese la cantidad total de CALS" name="cantidadcals" required>
      </div>
      <div class="form-group">
        <label for="codigocal">Codigo CAL:</label>
        <input type="text" class="form-control" id="codigocal" placeholder="Ingrese la cantidad total de CALS" name="codigocal" required>
      </div>
      <div class="checkbox">
        <label><input type="checkbox" name="terminos" id="terminos" required> Acepto los terminos y condiciones.</label>
      </div>
      <button type="submit" class="btn btn-success">Enviar Pedido</button>
    </form>
  </div>
  <br><br><br>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
  $(document).ready(function() {

    $('#licencia').mask("AAAAA-AAAAA-AAAAA-AAAAA-AAAAA", {
      placeholder: "XXXXX-XXXXX-XXXXX-XXXXX-XXXXX"
    });

    $('#licencia').keyup(function() {
      var valor = $(this).val();
      $(this).val(valor.toUpperCase());
    });
    $('#licencia').change(function() {
      var valor = $(this).val();
      $(this).val(valor.toUpperCase());
    });

  });
</script>
<script>
  $("#formpedido").submit(function(event) {
    event.preventDefault();
    let data = $(this).serialize();
    $.ajax({
      url: "<?= base_url("CLicenciamientoext/aceptarPedido") ?>",
      method: "POST", //First change type to method here

      data: data,
      // contentType: false,
      // processData: false,
      success: function(response) {
        var respuesta = JSON.parse(response);
        if (respuesta.status == "success") {
          $("#formpedido").hide();
          $("#subenvioalerta").show();
          alert("PEDIDO ENVIADO.");
        } else {
          alert("Error ya se ha registrado esta licencia anteriormente, por favor ingrese una nueva licencia.");
        }

      },
      error: function() {
        alert("Error al enviar el pedido.");
      }

    });
  });
</script>

</html>