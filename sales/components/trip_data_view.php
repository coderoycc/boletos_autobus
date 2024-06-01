<div class="card mb-3">
    <div class="card-header">
        <div class="card-title fw-semibold text-secondary m-0"><i class="fas fa-bus me-2"></i>Datos del Viaje</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table text-secondary table-bordered">
                <tr class="bg-info text-light fw-bold">
                    <td colspan="4"><i class="fas fa-calendar ms-2 me-2"></i>Viaje</td>
                </tr>
                <tr>
                    <td class="fw-bold">Partida:</td>
                    <td class="text-center"><?=$_POST['departure_date']?></td>
                    <td class="fw-bold">Hora:</td>
                    <td class="text-center"><?=$_POST['departure_time']?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Precio Base:</td>
                    <td class="text-center"><?=number_format($_POST['base_price'], 2)." Bs"?></td>
                    <td class="fw-bold"></td>
                    <td></td>
                </tr>
                <tr class="bg-info text-light fw-bold">
                    <td colspan="4"><i class="fas fa-bus ms-2 me-2"></i>Bus</td>
                </tr>
                <tr>
                    <td class="fw-bold">Placa:</td>
                    <td class="text-center"><?=$_POST['placa']?></td>
                    <td class="fw-bold">Descripción</td>
                    <td class="text-center"><?=$_POST['description']?></td>
                </tr>
                <tr class="bg-info text-light fw-bold">
                    <td colspan="4"><i class="fas fa-map-marker-alt ms-2 me-2"></i>Lugar</td>
                </tr>
                <tr>
                    <td class="fw-bold">Partida:</td>
                    <td class="text-center"><?=strtoupper($_POST['departure'])?></td>
                    <td class="fw-bold">Destino</td>
                    <td class="text-center"><?=strtoupper($_POST['destination'])?></td>
                </tr>
            </table>
        </div>
    </div>
</div>