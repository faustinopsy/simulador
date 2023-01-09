<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/w3.css" rel="stylesheet" />
    <script src="js/jquery-2.2.3.min.js"></script>
<script src="js/chartli.js"></script>
<script src="js/Chart.min.js"></script>
</head>
<style>
@media only screen and (max-width: 600px)
{
    
  .anuncios {
        opacity: 0; /* desaparece no mobile. */
         overflow: hidden;
          display: none;
    }
    
    
}
</style>
<body>
<div class="w3-cell-row">
<div class="w3-container w3-green w3-cell anuncios">
    <p>Anuncio.</p>
    
  </div>
  <div class="w3-container  w3-cell w3-card w3-margin-bottom w3-round-large">


  <form method="POST">
  <label for="criptomoeda">Nome da criptomoeda:</label>
  <input type="text" id="criptomoeda" name="criptomoeda" required>
  <button type="submit" class="w3-button w3-white w3-border">Buscar cotação</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Busca a cotação da criptomoeda do CoinGeko
  $cripto = urlencode($_POST['criptomoeda']);
  $criptomoeda = str_replace("+","",ltrim(rtrim(strtolower( $cripto))));
  $url = "https://api.coingecko.com/api/v3/coins/${criptomoeda}";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $dados = json_decode(curl_exec($ch), true);
  curl_close($ch);

  if(isset($dados["error"])){
    echo "Verifique se o nome esta correto";
    exit;
  }
  // Exibe o preço atual, a abertura do preço no dia, a máxima do preço no dia e a mínima do preço no dia
  echo  '<h4 style=color:blue>'.$criptomoeda.'</h4><br>';
  echo "Preço atual: ".$dados['market_data']['current_price']['usd']." USD<br>";
  echo "Variação da ultima hora: ".$dados['market_data']['price_change_percentage_1h_in_currency']['usd']." USD<br>";
  echo "<br><b style=color:green>Máxima do dia: <br> ▲ "
  .$dados['market_data']['high_24h']['usd']."  USD</b><br>";
  echo "<br><b style=color:red>Mínima do dia: <br> ▼ "
  .$dados['market_data']['low_24h']['usd']."  USD</b><br>";

  // Exibe um gráfico mostrando a variação do preço no dia por intervalos de 15 minutos
 

?>
  <form method="POST">
  <label for="criptomoeda">Nome da criptomoeda:</label>
  <input type="text" id="criptomoeda" name="criptomoeda" required>
  <button type="submit" class="w3-button w3-white w3-border">Buscar cotação</button>
</form>

  


 <script>
var criptomoeda = "<?php  echo $criptomoeda; ?>";
  // Busca o preço da criptomoeda desde o início do dia

fetch(`https://api.coingecko.com/api/v3/coins/${criptomoeda}/market_chart?vs_currency=usd&days=1&interval=hour`)
  .then(response => response.json())
  .then(dados => {
		 // Exibe o gráfico temporal
    var ctx = document.getElementById('grafico').getContext('2d');
    
    var grafico = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dados.prices.map(p => {
		  var date = new Date(p[0]);
		  return date.getHours() + ':' + date.getMinutes();}), // Timestamps em milissegundos
        datasets: [
         
          {
          label: 'Volume',
          data: dados.total_volumes.map(p => p[1]), // Preços
          backgroundColor: 'rgba(255, 99, 71, 0.2)',
          borderColor: '#DDDbff',
            
          },
           {
          label: 'Preço',
          data: dados.prices.map(p => p[1]), // Preços
          backgroundColor: 'rgba(0, 230, 0, 0.2)',
          borderColor: '#DDDbff',
          
          },
		    ]
      }
                
			
    });
  });
        
  fetch(`https://api.coingecko.com/api/v3/coins/${criptomoeda}/market_chart?vs_currency=usd&days=7&interval=day`)
  .then(response => response.json())
  .then(dados => {
		 // Exibe o gráfico temporal
     var semana=['Domingo','segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
    var ctx = document.getElementById('grafico7').getContext('2d');
    var grafico = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dados.prices.map(p => {
		  var date = new Date(p[0]);
		  return semana[date.getDay()]+' - '+date.getHours() + ':' + date.getMinutes();}), // Timestamps em milissegundos
        datasets: [{
          label: 'Preço',
          data: dados.prices.map(p => p[1]), // Preços
          backgroundColor: 'rgba(0, 230, 0, 0.2)',
          borderColor: '#DDDbff',
          
        },
		    {
          label: 'Volume',
          data: dados.total_volumes.map(p => p[1]), // Preços
          backgroundColor: 'rgba(255, 99, 71, 0.2)',
          borderColor: '#DDDbff',
		 
        }
		    ]
      }
    });
  });

    fetch(`https://api.coingecko.com/api/v3/coins/${criptomoeda}/market_chart?vs_currency=usd&days=30&interval=weekday`)
  .then(response => response.json())
  .then(dados => {
		
     var semana=['Domingo','segunda','Terça','Quarta','Quinta','Sexta','Sábado'];

   
    var ctx = document.getElementById('grafico30').getContext('2d');
    var grafico = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dados.prices.map(p => {
		  var date = new Date(p[0]);
		  return semana[date.getDay()]+' - '+date.getHours() + ':' + date.getMinutes();}), // Timestamps em milissegundos
        datasets: [{
          label: 'Preço',
          data: dados.prices.map(p => p[1]), // Preços
          backgroundColor: 'rgba(0, 230, 0, 0.2)',
          borderColor: '#DDDbff',
         
        },
		    {
          label: 'Volume',
          data: dados.total_volumes.map(p => p[1]), // Preços
          backgroundColor: 'rgba(255, 99, 71, 0.2)',
          borderColor: '#DDDbff',
		  
        }
		    ]
      }
    });
  });
let modelo=[];
  fetch(`https://api.coingecko.com/api/v3/coins/${criptomoeda}/market_chart?vs_currency=usd&days=365&interval=month`)
  .then(response => response.json())
  .then(dados => {

// modelo.push(dados.prices.map(p => {
// 		  var date = new Date(p[0]);
// 		  return date.getDate();}),
//       dados.prices.map(p => {
// 		  var date = new Date(p[0]);
// 		  return date.getMonth() }),
//       dados.prices.map(p => {
// 		  var date = new Date(p[0]);
// 		  return date.getFullYear();}),
//       dados.prices.map(p => p[1])
//       );
//       console.log(modelo[0][0],modelo[1][0],modelo[2][0],modelo[3][0]);
// var _gerarCsv = function(){ 
//     var csv = 'dia, mes, ano,preco\n';
//     for(var i=0;i<modelo[0].length;i++){
//       csv +=      modelo[0][i]+',';
//       csv +=      modelo[1][i]+',';
//       csv +=      modelo[2][i]+',';
//       csv +=      modelo[3][i];
//       csv += '\n';
//     }
      

//     var hiddenElement = document.createElement('a');
//     hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
//     hiddenElement.target = '_blank';
//     hiddenElement.download = 'modelo.csv';
//     hiddenElement.click();
// };
// _gerarCsv();

     var meses=['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
     var semana=['Domingo','segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
    var ctx = document.getElementById('grafico365').getContext('2d');
    var grafico = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dados.prices.map(p => {
		  var date = new Date(p[0]);
		  return meses[date.getMonth()]+' - '+semana[date.getDay()] ;}), // Timestamps em milissegundos
        datasets: [{
          label: 'Preço',
          data: dados.prices.map(p => p[1]), // Preços
          backgroundColor: 'rgba(0, 230, 0, 0.2)',
          borderColor: '#DDDbff',
          
        },
		    {
          label: 'Volume',
          data: dados.total_volumes.map(p => p[1]), // Preços
          backgroundColor: 'rgba(255, 99, 71, 0.2)',
          borderColor: '#DDDbff',
		  
        }
		    ]
      }
    });
  });
  
   
  function openAba(evt, abaName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("aba");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-teal", "");
  }
  document.getElementById(abaName).style.display = "block";
  evt.currentTarget.className += " w3-teal";
}
    </script>

<?php
}
?>

<div class="w3-bar w3-grey">
  <button class="w3-bar-item w3-button tablink w3-teal" onclick="openAba(event,'dia')">Dia</button>
  <button class="w3-bar-item w3-button tablink" onclick="openAba(event,'semana')">Semana</button>
  <button class="w3-bar-item w3-button tablink" onclick="openAba(event,'mes')">Mês</button>
  <button class="w3-bar-item w3-button tablink" onclick="openAba(event,'ano')">Ano</button>
</div>

<div id="dia" class="w3-container aba">
<h4>Gráfico do dia</h4>
<canvas id="grafico"></canvas>
</div>

<div id="semana" class="w3-container aba" style="display:none">
<h4>Gráfico últimos 3 dias</h4>
<canvas id="grafico7"></canvas>
</div>
<div id="mes" class="w3-container aba" style="display:none">
<h4>Gráfico últimos 7 dias</h4>
<canvas id="grafico30"></canvas>
</div>
<div id="ano" class="w3-container aba" style="display:none">
<h4>Gráfico último ano</h4>
<canvas id="grafico365"></canvas>
</div>

</div>
   <div class="w3-container w3-green w3-cell anuncios">
    <p>Anuncio.</p>
  
</div> 
</div>
    