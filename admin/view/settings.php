<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Songlist for <b>Song of the Day</b></h2></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Song</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hidden">
                    <td></td>
                    <td></td>
                    <td>
                        <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                    </td>
                </tr> 
                <?php for ($i=0; $i < count($all_songs); $i++): ?>
                <tr data-sotd-id="<?= $all_songs[$i]->id?>">
                    <td><?= $all_songs[$i]->title;?></td>
                    <td><?= $all_songs[$i]->singer;?></td>
                    <td>
                        <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                    </td>
                </tr>   
                <?php endfor;?>  
            </tbody>
        </table>
    </div>
</div>