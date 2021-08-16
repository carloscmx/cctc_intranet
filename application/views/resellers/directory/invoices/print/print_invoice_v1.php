<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
   <!--  All snippets are MIT license http://bootdey.com/license -->
   <title>Intranet - Blazar</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
   <div class="container">
      <div class="col-md-12">
         <div class="invoice">
            <!-- begin invoice-company -->
            <div class="invoice-company text-inverse f-w-600">
               <span class="pull-right hidden-print">
                  <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
                  <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
               </span>
               <img src="<?= $logo ?>" alt="" srcset="">
               <h4>Factura #<?= $nreferencia ?></h4>
            </div>
            <!-- end invoice-company -->
            <!-- begin invoice-header -->
            <div class="invoice-header">
               <div class="invoice-from">
                  <small>Facturado a</small>
                  <address class="m-t-5 m-b-5">
                     <?= $empresato ?>
                     <?= $facturato ?>
                  </address>

               </div>
               <div class="invoice-to">
                  <small>Pagar a</small>

                  <address class="m-t-5 m-b-5">
                     <?= $pagarto ?>
                     <?= reference_bank() ?>

                  </address>
               </div>
               <div class="invoice-date">
                  <h3>Estatus: <?= $estatus ?></h3>
                  <div class="date text-inverse m-t-5">Fecha de la Factura:
                     <?= $fechafactura ?></div>
                  <div class="invoice-detail">
                     Método de Pago: <?= $facturametodopago ?>
                  </div>
                  <div class="date text-inverse m-t-5">Fecha de vencimiento:
                     <?= $facturavencimiento ?></div>

               </div>
            </div>
            <!-- end invoice-header -->
            <!-- begin invoice-content -->
            <div class="invoice-content">
               <!-- begin table-responsive -->
               <div class="table-responsive">
                  <table class="table table-invoice">
                     <thead>
                        <tr>
                           <th>Productos/Servicios</th>
                           <th class="text-center">Descripción </th>
                           <th class="text-right">Importe</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($items as $key) : ?>
                           <tr>
                              <td colspan="2"><?= $key->description; ?></td>
                              <td><?= $key->amount; ?></td>

                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
               <!-- end table-responsive -->
               <!-- begin invoice-price -->
               <div class="invoice-price">
                  <div class="invoice-price-left">
                     <div class="invoice-price-row">
                        <div class="sub-price">
                           <small>CREDITO</small>
                           <span class="text-inverse">$<?= $credito ?></span>
                        </div>
                        <div class="sub-price">
                           <small>SUBTOTAL</small>
                           <span class="text-inverse">$<?= $subtotal ?></span>
                        </div>
                        <div class="sub-price">
                           <i class="fa fa-plus text-muted"></i>
                        </div>
                        <div class="sub-price">
                           <small>IVA (<?= $taxrate ?>%)</small>
                           <span class="text-inverse">$<?= $tax ?></span>
                        </div>
                     </div>
                  </div>
                  <div class="invoice-price-right">
                     <small>TOTAL</small> <span class="f-w-600">$<?= $total ?></span>
                  </div>
               </div>
               <!-- end invoice-price -->
            </div>
            <!-- end invoice-content -->
            <!-- begin invoice-note -->
            <div class="invoice-note">
               ** Producto/Servicio sujeto a impuesto<br>
            </div>
            <table class="">
               <thead>
                  <tr>
                     <th>Fecha Transacción </th>
                     <th>Método/Gateway </th>
                     <th>ID Transacción </th>
                     <th>Total</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($transacciones as $key) : ?>
                     <tr>
                        <td><?= $key->date; ?></td>
                        <td><?= $key->gateway; ?></td>
                        <td><?= $key->transid; ?></td>

                        <td><?= $key->amountin; ?></td>


                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
            <h5>Balance <?= $balance ?></h5>
            <!-- end invoice-note -->
            <!-- begin invoice-footer -->
            <div class="invoice-footer">
               <p class="text-center m-b-5 f-w-600">

               </p>
               <p class="text-center">
                  Intranet: <?= vesion_stash() ?>
               </p>
            </div>
            <!-- end invoice-footer -->
         </div>
      </div>
   </div>

   <style type="text/css">
      body {
         margin-top: 20px;
         background: #eee;
      }

      .invoice {
         background: #fff;
         padding: 20px
      }

      .invoice-company {
         font-size: 20px
      }

      .invoice-header {
         margin: 0 -20px;
         background: #f0f3f4;
         padding: 20px
      }

      .invoice-date,
      .invoice-from,
      .invoice-to {
         display: table-cell;
         width: 1%
      }

      .invoice-from,
      .invoice-to {
         padding-right: 20px
      }

      .invoice-date .date,
      .invoice-from strong,
      .invoice-to strong {
         font-size: 16px;
         font-weight: 600
      }

      .invoice-date {
         text-align: right;
         padding-left: 20px
      }

      .invoice-price {
         background: #f0f3f4;
         display: table;
         width: 100%
      }

      .invoice-price .invoice-price-left,
      .invoice-price .invoice-price-right {
         display: table-cell;
         padding: 20px;
         font-size: 20px;
         font-weight: 600;
         width: 75%;
         position: relative;
         vertical-align: middle
      }

      .invoice-price .invoice-price-left .sub-price {
         display: table-cell;
         vertical-align: middle;
         padding: 0 20px
      }

      .invoice-price small {
         font-size: 12px;
         font-weight: 400;
         display: block
      }

      .invoice-price .invoice-price-row {
         display: table;
         float: left
      }

      .invoice-price .invoice-price-right {
         width: 25%;
         background: #2d353c;
         color: #fff;
         font-size: 28px;
         text-align: right;
         vertical-align: bottom;
         font-weight: 300
      }

      .invoice-price .invoice-price-right small {
         display: block;
         opacity: .6;
         position: absolute;
         top: 10px;
         left: 10px;
         font-size: 12px
      }

      .invoice-footer {
         border-top: 1px solid #ddd;
         padding-top: 10px;
         font-size: 10px
      }

      .invoice-note {
         color: #999;
         margin-top: 80px;
         font-size: 85%
      }

      .invoice>div:not(.invoice-footer) {
         margin-bottom: 20px
      }

      .btn.btn-white,
      .btn.btn-white.disabled,
      .btn.btn-white.disabled:focus,
      .btn.btn-white.disabled:hover,
      .btn.btn-white[disabled],
      .btn.btn-white[disabled]:focus,
      .btn.btn-white[disabled]:hover {
         color: #2d353c;
         background: #fff;
         border-color: #d9dfe3;
      }
   </style>

   <script type="text/javascript">

   </script>
</body>

</html>