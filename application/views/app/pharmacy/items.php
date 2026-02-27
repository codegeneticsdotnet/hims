<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Item List
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url();?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url();?>app/pharmacy">Pharmacy</a></li>
                <li class="active">Item List</li>
            </ol>
        <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Items</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItemModal" onclick="clearForm()"><i class="fa fa-plus"></i> Add New Item</button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Generic Name</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($items as $item): ?>
                                <tr>
                                    <td><?php echo str_pad($item->itemcode, 6, '0', STR_PAD_LEFT);?></td>
                                    <td><?php echo $item->itemname;?></td>
                                    <td><?php echo $item->genericname;?></td>
                                    <td><?php echo $item->category;?></td>
                                    <td><?php echo $item->unit;?></td>
                                    <td><?php echo number_format($item->price, 2);?></td>
                                    <td>
                                        <?php if($item->stock_on_hand <= 0): ?>
                                            <span class="label label-danger">Out of Stock</span>
                                        <?php elseif($item->stock_on_hand <= 10): // Assuming 10 is low ?>
                                            <span class="label label-warning"><?php echo $item->stock_on_hand;?></span>
                                        <?php else: ?>
                                            <span class="label label-success"><?php echo $item->stock_on_hand;?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-xs" onclick="editItem(<?php echo htmlspecialchars(json_encode($item)); ?>)"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo base_url()?>app/pharmacy/delete_item/<?php echo $item->itemcode;?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Add/Edit Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url()?>app/pharmacy/save_item" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addItemModalLabel">Add New Item</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="form-group">
                        <label>Item Name <span class="text-danger">*</span></label>
                        <input type="text" name="item_name" id="item_name" class="form-control" required placeholder="e.g. Paracetamol 500mg" list="item_list" autocomplete="off">
                        <datalist id="item_list">
                            <?php foreach($items as $item): ?>
                                <option value="<?php echo $item->itemname; ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Generic Name</label>
                        <input type="text" name="generic_name" id="generic_name" class="form-control" placeholder="e.g. Acetaminophen" list="generic_list" autocomplete="off">
                        <datalist id="generic_list">
                            <?php 
                                $generics = array();
                                foreach($items as $item) {
                                    if(!empty($item->genericname)) $generics[] = $item->genericname;
                                }
                                $generics = array_unique($generics);
                                foreach($generics as $gen): 
                            ?>
                                <option value="<?php echo $gen; ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->med_category_name;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit of Measure</label>
                                <select name="unit" id="unit" class="form-control">
                                    <option value="">Select Unit</option>
                                    <?php foreach($units as $unit): ?>
                                    <option value="<?php echo $unit->param_id;?>"><?php echo $unit->cValue;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selling Price</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Re-order Level</label>
                                <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="10">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
    });

    // Auto-complete logic for Item Name and Generic Name (Simple DataList approach)
    // Note: For full autocomplete with AJAX, we'd need a backend endpoint. 
    // Here we can use HTML5 datalist if we have a list of common items, or just standard text inputs.
    // The user asked for "combobox autocomplete". 
    // Since we don't have a separate "standard drug list" table yet, I will enable browser autocomplete 
    // and maybe add a datalist if we had a master list.
    // For now, I'll ensure the inputs have autocomplete="on".
    
    function editItem(item){
        $('#addItemModalLabel').text('Edit Item');
        $('#item_id').val(item.itemcode);
        $('#item_name').val(item.itemname);
        $('#generic_name').val(item.genericname);
        $('#category').val(item.med_cat_id);
        $('#unit').val(item.unit_id);
        $('#price').val(item.price);
        $('#reorder_level').val(item.re_order_level);
        
        // Open Modal
        $('#addItemModal').modal('show');
    }
    
    function clearForm(){
        $('#addItemModalLabel').text('Add New Item');
        $('#item_id').val('');
        $('#item_name').val('');
        $('#generic_name').val('');
        $('#category').val('');
        $('#unit').val('');
        $('#price').val('0.00');
        $('#reorder_level').val('10');
    }
</script>

</body>
</html>
