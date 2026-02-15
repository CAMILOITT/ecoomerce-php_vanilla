<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin - dashboard</title>
  <link rel="stylesheet" href="/global.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php include_once __DIR__ . '/../components/aside.php'; ?>
  <main style="width: 100%; display: flex; flex-direction: column; gap: 16px;">
    <h1>Dashboard</h1>
    <div>
      <div class="container-dash">
        <div class="dash">1</div>
        <div class="dash">2</div>
        <div class="dash">3</div>
      </div>
      <style>
        .container-dash {
          display: flex;
          gap: 20px;
        }

        .dash {
          border-radius: 8px;
          width: 100px;
          height: 100px;
          background-color: #eee;
          color: black;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24px;
        }
      </style>
      <div style="display: flex
        ;">
        <div>
          <canvas id='myChart'></canvas>
          <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ['laptop', 'monitor', 'celular', 'ram 8gb', 'teclado', 'audífonos'],
                datasets: [{
                  label: '# of Votes',
                  data: [12, 19, 3, 5, 2, 3],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          </script>
        </div>
        <div style="display: flex; flex-direction: column;">

          <?php foreach (['laptop', 'monitor', 'celular', 'ram 8gb', 'teclado', 'audífonos'] as $item): ?>
            <div><?= $item ?></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    </div>
  </main>
</body>

</html>

<style>
  body {
    display: flex;
  }
</style>