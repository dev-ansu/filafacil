<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <?php echo $title ?>
    </div>
<div class="card-body">
    <table id="<?php echo $tableId ?>" class="table table-dark w-100 table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <?php foreach($headers as $header): ?>
                    <th style="text-align: left;"><?php echo $header ?></th>
                <?php endforeach; ?>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</div>

<input type="hidden" id="_csrf" value="<?php echo $_csrf; ?>">

