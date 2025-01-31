<!doctype html>
<html lang="en">
  <head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="js/datatables/datatables.net-dt/css/jquery.dataTables.css">
    <script src="js/Scripts.js"></script>
    <script src="js/bootstrap/js/orginalCol.js"></script>
    <script src="js/ajax.js"></script>
     <script src="js/jquery.js"></script>
    <script src="js/Scripts.js"></script>

    <title>Visium Os</title>
  </head>
 <body>
    <header>
 <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="icons/ordem.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Visium OS
      </a>
    </nav>
    </header>
    <main>
        @yield('content')
<!--aqui vem o meu conteudo somente aproveito o que vem do meu cabecalho -->
    </main>
</body>


   <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <!-- <script src="js/teste.js"></script> -->
      <script src="js/jsQuery.js"></script>
      <script src="js/jquery/jquery/dist/jquery.min.js"></script>
      <script src="js/popper/@popperjs/core/dist/umd/popper-base.min.js"> </script>
      <script src="js/datatables/datatables.net/js/jquery.dataTables.min.js"> </script>
      <script src="js/datatables/buttons/dataTables.buttons.min.js"> </script>
      <script src="js/datatables/buttons/jszip.min.js"> </script>
      <script src="js/datatables/buttons/pdfmake.min.js"> </script>
      <script src="js/datatables/buttons/vfs_fonts.js"> </script>
      <script src="js/datatables/buttons/buttons.html5.min.js"> </script>
      <script src="js/bootstrap/js/bootstrap.min.js"> </script>
      <script src="js/bootstrap/js/bootstrap.bundle.js"> </script>
      <script src="js/datatables/datatables.net-dt/js/dataTables.select.js"> </script>
       <script src="js/datatables/datatables.net-dt/js/dataTables.buttons.js"> </script>
       <script src="js/datatables/datatables.net-dt/js/buttons.dataTables.js"> </script>

   @stack('scripts')  <!-- Aqui você inclui os scripts específicos de cada página -->

 </body>
</html>
