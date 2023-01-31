<?php
    session_start();
    include_once('database.php');
    require_once("./template.php");
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >
    <link rel="stylesheet" type="text/css" href="styles/doacoesStyle.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Doações'],

          <?php
            $sql = "SELECT concat(date_format(data_doacao, '%b'), '. ', YEAR(data_doacao)) as mes, COUNT(*) as total FROM doacao WHERE data_doacao BETWEEN date_add(last_day(date_sub(curdate(), interval 1 year)), interval 1 day) and curdate() GROUP BY month(data_doacao), year(data_doacao)";
            $res = $conexao->prepare($sql);
            $res->execute();

            while($data = $res->fetch(PDO::FETCH_ASSOC)){
            
          ?>

            ['<?php echo $data['mes'] ?>', '<?php echo $data['total'] ?>'],

          <?php
            }
          ?>
        ]);

        var options = {
          chart: {
            title: 'Doações por mês',
            subtitle: 'Total de doações enviadas em cada mês do último ano',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('donationsChart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <title>Food Waste - Doações</title>
</head>
<body>
<?php
    require_once("./navbar.php");
?>

  <div class="row row-cols-1 row-cols-md-4 g-4 w-100 m-auto mb-4">
    <div class="col d-flex justify-content-center">
      <div class="card text-bg-primary border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Total Doações / Ano</div>
        <div class="card-body">
          <h5 class="card-title">teste</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>
    
    <div class="col d-flex justify-content-center">
      <div class="card text-bg-success border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Tipo de Alimento +Doado</div>
        <div class="card-body">
          <h5 class="card-title">teste</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>

    <div class="col d-flex justify-content-center">
      <div class="card text-bg-danger w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Doador do Ano</div>
        <div class="card-body">
          <h5 class="card-title">teste</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>

    <div class="col d-flex justify-content-center">
      <div class="card text-bg-dark border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Receptor do Ano</div>
        <div class="card-body">
          <h5 class="card-title">teste</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>
  </div>

  <div id="donationsChart" style="width: 40rem; height: 20rem;"></div>

<?php
    require_once("./footer.php");
?>

<!-- Cards -->

<!-- Instituição que mais doou no ano -->
<!-- Instituição que mais recebeu no ano -->
<!-- Tipo alimento mais doado no ano -->
<!-- Total doacoes no ano -->

<!-- Charts -->

<!-- 3 Instituições que mais doaram p/ mes -->
<!-- 3 Instituições que mais receberam p/ mes -->
<!-- Tipo alimento mais doado p/ mes -->
<!-- Total doacoes p/ mes -->

<!-- Maximizar regiao -->