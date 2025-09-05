<br />
<div class="box-body no-padding">
    <table class="table table-hover table-striped">
    <?php if($tabletoload == "tableitems"){ ?>
        <tr>
            <th>BARCODE</th>
            <th>ITEMNAME</th>
            <th>GENERIC NAME</th>
            <th>CATEGORY</th>
            <th>UNIT</th>
            <th>MARKUP</th>
            <th>MINMARKUP</th>
            <th>ACTION</th>
        </tr>
    <?php foreach ($items as $item){	?>
        <tr>
            <td><?php echo $item->barcode; ?></td>
            <td><?php echo $item->itemname; ?></td>
            <td><?php echo $item->genericname; ?></td>
            <td><?php echo $item->category; ?></td>
            <td><?php echo $item->unit; ?></td>
            <td><?php echo $item->markup; ?></td>
            <td><?php echo $item->minmarkup; ?></td>
            <td><a href="#" data-id="<?php echo $item->itemcode; ?>"> Delete</a></td>
        </tr>
    <?php }
    } elseif ($tabletoload == "tablecategory") {?>
        <tr>
            <th width="40%">Category</th>
            <th width="50%">Description</th>
            <th width="10%">&nbsp;</th>
        </tr>
<?php 
        foreach ($categories as $category){	?>
        <tr>
            <td><?php echo $category->categoryname; ?></td>
            <td><?php echo $category->categorydesc; ?></td>
            <td><a href="#" data-id="<?php echo $category->param_id; ?>"> Delete</a></td>
        </tr>
<?php   }
    } elseif ($tabletoload == "tableunit") {?>
    <tr>
            <th width="40%">Unit</th>
            <th width="50%">Description</th>
            <th width="10%">&nbsp;</th>
        </tr>
<?php 
    foreach ($units as $unit){	?>
        <tr>
            <td><?php echo $unit->unitname; ?></td>
            <td><?php echo $unit->unitdesc; ?></td>
            <td><a href="#" data-id="<?php echo $unit->param_id; ?>"> Delete</a></td>
        </tr>
<?php 
        }
    } ?>
    </table>
</div>
