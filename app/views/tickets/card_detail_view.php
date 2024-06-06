<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h4 class="card-title m-0 p-2 text-center text-secondary fw-semibold">
            DETALLES DE LA VENTA
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr class="table-secondary">
                        <td colspan="2"><b class="fw-semibold"><i class="fas fa-user-circle ms-2 me-2"></i>Cliente</b></td>
                    </tr>
                    <tr align="center">
                        <td colspan="2"><?=strtoupper($client->name." ".$client->lastname." ".$client->mothers_lastname)?></td>
                    </tr>
                    <tr>
                        <td class="me-2">
                            <b class="text-secondary me-2">CI:</b><?=$client->ci?>
                        </td>
                        <td class="me-2">
                            <b class="text-secondary me-2">NIT:</b><?=$client->nit?>
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><b class="fw-semibold"><i class="fas fa-bus ms-2 me-2"></i>Bus</b></td>
                    </tr>
                    <tr>
                        <td class="me-2"><b class="fw-semibold me-2">Descripción:</b><?=$bus->description?></td>
                        <td class="me-2"><b class="fw-semibold me-2">Placa:</b><?=$bus->placa?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><b class="fw-semibold"><i class="fas fa-map-marker-alt ms-2 me-2"></i>Viaje</b></td>
                    </tr>
                    <tr>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Salida:</b><?=(new DateTime($trip->departure_date))->format('d/m/Y')?>
                        </td>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Hora:</b><?=(new DateTime($trip->departure_time))->format('H:i')?>
                        </td>
                    </tr>
                    <tr>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Origen:</b><?=strtoupper($origin->location)?>
                        </td>
                        <td class="me-4">
                            <b class="fw-semibold me-2">Destino:</b><?=strtoupper($destination->location)?>
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><b class="fw-semibold"><i class="fas fa-tag ms-2 me-2"></i>Compra</b></td>
                    </tr>
                    <tr>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Fecha:</b><?=(new DateTime($ticket->created_at))->format('d/m/Y')?>
                        </td>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Hora:</b><?=(new DateTime($ticket->created_at))->format('H:i')?>
                        </td>
                    </tr>
                    <tr>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Número de Asiento:</b><?=$ticket->seat_number?>
                        </td>
                        <td class="me-2">
                            <b class="fw-semibold me-2">Precio:</b><span class="text-dark fw-bold"><?=number_format($ticket->price, 2) . " Bs"?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>