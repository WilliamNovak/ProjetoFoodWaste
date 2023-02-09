<?php
    session_start();
    include_once('database.php');
    require_once("./template.php");

    $sql_total_year = "SELECT COUNT(*) as total_year FROM doacao WHERE year(data_doacao) = year(curdate())";
    $yearRes = $conexao->prepare($sql_total_year);
    $yearRes->execute();
    $yearArray = $yearRes->fetch(PDO::FETCH_ASSOC);
    $totalYear = $yearArray['total_year'];
    
    $sql_total_type = "SELECT t.descricao_alimento, COUNT(*) as total_type FROM doacao d, alimentos a, tipo_alimento t WHERE year(d.data_doacao) = year(curdate()) AND d.idalimento = a.idalimento AND a.idtipo = t.idtipo_alimento GROUP BY t.descricao_alimento ORDER BY COUNT(*) DESC LIMIT 1";
    $typeRes = $conexao->prepare($sql_total_type);
    $typeRes->execute();
    $typeArray = $typeRes->fetch(PDO::FETCH_ASSOC);
    $totalType = $typeArray['total_type'];
    $type = $typeArray['descricao_alimento'];

    $sql_donor = "SELECT u.nome_usuario, COUNT(*) as total_donor FROM doacao d, usuario u WHERE year(d.data_doacao) = year(curdate()) AND d.iddoador = u.idusuario GROUP BY u.idusuario ORDER BY COUNT(*) DESC LIMIT 1";
    $donorRes = $conexao->prepare($sql_donor);
    $donorRes->execute();
    $donorArray = $donorRes->fetch(PDO::FETCH_ASSOC);
    $totalDonor = $donorArray['total_donor'];
    $donor = $donorArray['nome_usuario'];

    $sql_receptor = "SELECT u.nome_usuario, COUNT(*) as total_receiver FROM doacao d, usuario u WHERE year(d.data_doacao) = year(curdate()) AND d.idreceptor = u.idusuario GROUP BY u.idusuario ORDER BY COUNT(*) DESC LIMIT 1";
    $receiverRes = $conexao->prepare($sql_receptor);
    $receiverRes->execute();
    $receiverArray = $receiverRes->fetch(PDO::FETCH_ASSOC);
    $totalReceiver = $receiverArray['total_receiver'];
    $receiver = $receiverArray['nome_usuario'];

    $sql_food_types = "SELECT idtipo_alimento, descricao_alimento FROM tipo_alimento ORDER BY idtipo_alimento";
    $typesRes = $conexao->prepare($sql_food_types);
    $typesRes->execute();

    $sql_months = "WITH calendar AS (
      SELECT NOW() - INTERVAL x.month_number MONTH AS date
      FROM (
        SELECT 0 AS month_number
        UNION SELECT 1
        UNION SELECT 2
        UNION SELECT 3
        UNION SELECT 4
        UNION SELECT 5
        UNION SELECT 6
        UNION SELECT 7
        UNION SELECT 8
        UNION SELECT 9
        UNION SELECT 10
        UNION SELECT 11
        UNION SELECT 12
      ) x
      WHERE x.month_number < 12
    )
    SELECT DISTINCT DATE_FORMAT(date, '%b') AS mes, YEAR(date) AS ano
      FROM calendar
    ORDER BY date";
    $res_months = $conexao->prepare($sql_months);
    $res_months->execute();
?>
    <link rel="stylesheet" type="text/css" href="styles/style.css" >

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawDonationsChart);
      google.charts.setOnLoadCallback(drawTypeChart);

      function drawDonationsChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Doações']

          <?php
            while($data = $res_months->fetch(PDO::FETCH_ASSOC)){

              $sql_total = "SELECT COUNT(*) as total FROM doacao WHERE DATE_FORMAT(data_doacao, '%b') = ? AND YEAR(data_doacao) = ?";
              $res_total = $conexao->prepare($sql_total);
              $res_total->execute([$data['mes'],$data['ano']]);
              $totalArray = $res_total->fetch(PDO::FETCH_ASSOC);
              $total = $totalArray['total'];

          ?>
            ,['<?php echo $data['mes'].'. '.$data['ano'] ?>', <?php echo $total ?>]
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

      function drawTypeChart() {
        var data = google.visualization.arrayToDataTable([

          ['Mês'
            <?php 
              while($data = $typesRes->fetch(PDO::FETCH_ASSOC)){
            ?>
            ,'<?php
                echo $data['descricao_alimento'];
            ?>'
            <?php
              }
            ?>
          ]

          <?php
            $res_months2 = $conexao->prepare($sql_months);
            $res_months2->execute();

            while($data = $res_months2->fetch(PDO::FETCH_ASSOC)){
          ?>
            ,['<?php echo $data['mes'].'. '.$data['ano'] ?>'
            
            <?php
              $typesRes2 = $conexao->prepare($sql_food_types);
              $typesRes2->execute();

              while($typeData = $typesRes2->fetch(PDO::FETCH_ASSOC)){

                $sql_totals = "SELECT COUNT(*) as total FROM doacao d, tipo_alimento t, alimentos a WHERE d.idalimento = a.idalimento AND a.idtipo = t.idtipo_alimento AND DATE_FORMAT(d.data_doacao, '%b') = ? AND YEAR(d.data_doacao) = ? AND t.idtipo_alimento = ?";
                $res_totals = $conexao->prepare($sql_totals);
                $res_totals->execute([$data['mes'],$data['ano'],$typeData['idtipo_alimento']]);

                while($totals = $res_totals->fetch(PDO::FETCH_ASSOC)){
            ?>
            ,<?php
                  echo $totals['total'];
                }
              }
            ?>]

          <?php
            }
          ?>
        ]);

        var options = {
          title: 'Tipos de alimento por mês',
          subtitle: 'Total de doações por tipo de alimento em cada mês do último ano',
          legend: { position: 'top', maxLines: 3 },
          bar: { groupWidth: '75%' },
          isStacked: true,
        };

        var chart = new google.charts.Bar(document.getElementById('typeChart'));

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
      <div class="card text-bg-green border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Total Doações / Ano</div>
        <div class="card-body d-flex justify-content-center">
          <h5 class="card-title fs-2 my-auto me-1"><?php echo $totalYear ?></h5>
          <p class="card-text fs-6 my-auto">/qtd</p>
        </div>
      </div>
    </div>
    
    <div class="col d-flex justify-content-center">
      <div class="card text-bg-light-green border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Tipo de Alimento / Ano</div>
        <div class="card-body d-flex justify-content-center">
          <h5 class="card-title fs-2 my-auto me-1"><?php echo $type ?></h5>
          <p class="card-text fs-4 my-auto">(<?php echo $totalType ?>)</p>
        </div>
      </div>
    </div>

    <div class="col d-flex justify-content-center">
      <div class="card text-bg-green w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Doador do Ano</div>
        <div class="card-body d-flex justify-content-center">
          <h5 class="card-title fs-2 my-auto me-1"><?php echo $donor ?></h5>
          <p class="card-text fs-4 my-auto">(<?php echo $totalDonor ?>)</p>
        </div>
      </div>
    </div>

    <div class="col d-flex justify-content-center">
      <div class="card text-bg-light-green border-1 w-100" style="max-width: 18rem;">
        <div class="card-header text-start">Receptor do Ano</div>
        <div class="card-body d-flex justify-content-center">
          <h5 class="card-title fs-2 my-auto me-1"><?php echo $receiver ?></h5>
          <p class="card-text fs-4 my-auto">(<?php echo $totalReceiver ?>)</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cols-1 row-cols-md-2 g-4 w-100 m-auto">
    <div id="donationsChart" style="height: 20rem;"></div>
    <div id="typeChart" style="height: 20rem;"></div>
    <div id="chart3" style="height: 20rem;"></div>
    <div id="chart4" style="height: 20rem;"></div>
  </div>

<?php
    require_once("./footer.php");
?>

<!-- Charts -->

<!-- 3 Instituições que mais doaram p/ mes -->
<!-- 3 Instituições que mais receberam p/ mes -->
<!-- Tipo alimento mais doado p/ mes -->
<!-- Total doacoes p/ mes -->

<!-- Maximizar regiao -->