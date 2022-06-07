<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewStats
{

    public function viewStatsPage($tab)
    {
?>
        <h1 class="display-3">Statistics</h1>

        <hr class="my-5">

        <h1 class="display-4">Tickets per months in <?php echo date('Y'); ?></h1>
        <canvas id="graph1"></canvas>

        <!-- Script -->
        <script>
            var ctx = document.getElementById('graph1').getContext('2d')

            var data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Tickets',
                    backgroundColor: '292b2c',
                    borderColor: 'rgb(255, 99, 132)',
                    data: <?php echo json_encode($tab); ?>
                }]
            }

            var options = {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of ticket'
                        },
                        ticks: {
                            stepSize: 10
                        }
                    }
                }
            }

            var config = {
                type: 'line',
                data: data,
                options: options
            }
            var graph1 = new Chart(ctx, config)
        </script>



    <?php
    }

    public function viewAlertWarning($msg)
    {
    ?>
        <div class="alert alert-warning text-center mx-auto mt-3" role="alert"><?php echo $msg; ?></div>
<?php
    }
}
