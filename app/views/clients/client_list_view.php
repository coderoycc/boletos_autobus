<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="table-clients" width="100%">
            <thead>
                <tr class="text-center text-secondary">
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>C.I.</th>
                    <th>N.I.T.</th>
                    <th>Menor</th>
                    <th>Fecha de Registro</th>
                    <th>Hora de Registro</th>
                    <th>Usuario Creador</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clients as $client){ ?>
                <tr>
                    <td align="center"><?=$client['id']?></td>
                    <td><?=(ucfirst($client['name'])." ".ucfirst($client['lastname'])." ".ucfirst($client['mothers_lastname']))?></td>
                    <td align="center"><?=($client['ci'] == null || $client['ci'] == '' ? "-" : $client['ci'])?></td>
                    <td align="center"><?=($client['nit'] == null || $client['nit'] == '' ? '-' : $client['nit'])?></td>
                    <td align="center">
                        <span class="badge text-bg-<?=($client['is_minor'] == '1' ? 'success' : 'light')?>">
                            <?=($client['is_minor'] == '1' ? 'SI' : 'NO')?>
                        </span>
                    </td>
                    <td align="center"><?=((new DateTime($client['created_at']))->format('d/m/Y'))?></td>
                    <td align="center"><?=((new DateTime($client['created_at']))->format('H:i'))?></td>
                    <td align="center">
                        <span class="badge text-bg-light">
                            <?=ucfirst($client['username'])?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>