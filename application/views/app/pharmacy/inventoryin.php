<?php if( !isset($_SERVER['HTTP_REFERER'])) { echo ""; } else{ ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container">
    <h4 class="title">Inventory In</h4>
    <div class="col-md-11">
        <br />
        <table>
            <tr>
                <td><label>Batch No &nbsp;</label></td>
                <td>
                    <input type="text" class="form-control input-sm" required placeholder="Generic Name" name="valueFee" id="valueFee">
                </td>
                <td><label>Batch Date&nbsp;</label></td>
                <td>
                    <input type="text" class="form-control input-sm" required placeholder="Generic Name" name="valueFee" id="valueFee">
                </td>
            </tr>
        </table>
        <br />
        <table>
            <tr>
                <td><label>Itemname</label></td>
                <td><label>Qty</label></td>
                <td><label>Amount</label></td>
                <td><label>Total Amount</label></td>
                <td><label>Bin No</label></td>
                <td><label>Best Before</label></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text" class="form-control input-sm col-lg-3" required ondblclick="itemTagging()" placeholder="Itemname" name="cartitemname" id="cartitemname"></td>
                <td><input type="text" class="form-control input-sm col-lg-1" required placeholder="Qty" name="cartitemqty" id="cartitemqty"></td>
                <td><input type="text" class="form-control input-sm col-lg-1" required placeholder="Amount" name="cartitemamount" id="cartitemamount"></td>
                <td><input type="text" class="form-control input-sm col-lg-2" required placeholder="Amount" name="carttotalamount" id="carttotalamount"></td>
                <td><input type="text" class="form-control input-sm col-lg-2" required placeholder="Amount" name="cartbinno" id="cartbinno"></td>
                <td><input type="text" class="form-control input-sm col-lg-2" required placeholder="Amount" name="cartbestbefore" id="cartbestbefore"></td>
                <td>
                    <button type="button" class="btn btn-primary" name="buttAddToItemCart" id="buttAddToItemCart">Add</button>
                </td>
            </tr>
        </table>
        <hr />
        <table class="table table-hover table-striped" style="font-size:0.9em;">
            <tr>
                <th class="col-lg-1">No.         </th>
                <th class="col-lg-3">Itemname    </th>
                <th class="col-lg-1">Qty         </th>
                <th class="col-lg-2">Amount      </th>
                <th class="col-lg-2">Total Amount</th>
                <th class="col-lg-1">Bin No      </th>
                <th class="col-lg-1">Best Before </th>
                <th class="col-lg-1">Action      </th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br /><br /><br />
    </div>
</div>
<!-- / itemTagging modal -->   
<div class="modal fade modal-lg" id="itemTaggingmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Item Tagging</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div id="msgNotif"></div>
                    <div class="col-md-5">
                        <h4>Add New Item</h4>
                        <div id="itemTaggingmodalContainer"></div>
                        <form name="frmitemtagging" id="frmDoctorFeefrmitemtagging">
                        </form>   
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onClick="alert('ok')" name="btnSaveDoctorFee" id="btnSaveDoctorFee">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4>Item List</h4>
                        <div id="itemTable"></div>
                    </div>
                    <br style="clear:both" />
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- / itemCategoryModal modal -->   
<div class="modal fade" id="itemCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Categories</h4>
            </div>
            <div class="modal-body">
                <div id="msgNotif"></div>
                <form name="frmcategory" id="frmcategory">
                    <table>
                        <tr>
                            <td width="40%">Category</td>
                            <td width="50%">Description</td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input onKeyUp="tableCategory(this.value)" class="form-control input-sm" name="cCategory" id="cCategory" type="text" placeholder="New Category"></td>
                            <td><input class="form-control input-sm" name="cDescription" id="cDescription" type="text" placeholder="Description"></td>
                            <td><button type="button" class="btn btn-primary btn-sm" name="btnSaveNewCategory" id="btnSaveNewCategory">Add</button></td>
                        </tr>
                    </table>
                    <div id="categoryTable"></div>
                </form>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- / itemUnitModal modal -->   
<div class="modal fade" id="itemUnitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Unit of Measurement</h4>
            </div>
            <div class="modal-body">
                <div id="msgNotif"></div>
                <form name="frmitemtagging" id="frmitemtagging">
                <table>
                    <tr>
                        <td width="40%">Unit</td>
                        <td width="50%">Description</td>
                        <td width="10%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><input onKeyUp="tableUnitofMeasure(this.value)" class="form-control input-sm" name="cUnit" id="cUnit" type="text" placeholder="Search here"></td>
                        <td><input class="form-control input-sm" name="cUnitDescription" id="cUnitDescription" type="text" placeholder="Description"></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" name="buttSaveNewUnit" id="buttSaveNewUnit">Add New</button>
                        </td>
                    </tr>
                </table>
                <div id="unitTable">
                </div>
                </form>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function itemTagging(){
        $('#itemTaggingmodal').modal('show');
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/itemtagging",
            method:'POST',
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                $("#itemTaggingmodalContainer").html(resp);
                fillList('category');
                fillList('unit');
                //fillSearchInput('unit');
            }
        })
    }
    $('.cboxunit').click(function () {
        fillList("unit");
    });
    
    function fillSearchInput(cbox){
        //var selector = $('.sel' + cbox).selectpicker();
        //var searchBoxElement = $('.sel' + cbox).parent().find('.bs-searchbox > input');
        
        //var searchBoxElement = $('.selcategory').parent().find('.bs-searchbox > input');
        var searchBoxElement = $('.selcategory').find('.bs-searchbox input');
        if (searchBoxElement.length > 0) {
            alert("The element exists");
        } else {
            alert("The element does not exist");
        }
        searchBoxElement.on('input', function() {
            var searchValue = $(this).val();
            alert(searchValue);
        });
    }
    function fillList(link){
        var searchtext = $('.sel' + link).text();
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/fill" + link,
            method:'POST',
            data: {search: searchtext},
            dataType: 'JSON',
            error:err=>{
                console.log(err)
            },
            success:function(data){
                var options = "";
                for (var i = 0; i < data['length']; i++) {
                    options += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                }
                console.log(options);
                $('.sel' + link).prepend(options);
                $('.sel' + link).selectpicker('refresh');
            }
        })
    }

    viewItems();

    /* for items */
    function viewItems(){
        tableItems('');
    }
    function tableItems(items){
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/tableitems",
            method:'POST',
            data: {catitems: items},
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                $("#itemTable").html(resp);
            }
        })
    }
    /* for category */
    function viewCategory(){
        tableCategory('');        
        $("#cCategory").val('');
        $("#cDescription").val('');
        $('#itemCategoryModal').modal('show');
    }
    function tableCategory(category){
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/tablecategory",
            method:'POST',
            data: {catsearch: category},
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                $("#categoryTable").html(resp);
            }
        })
    }
    /* for unit */
    function viewUnitofMeasure(){
        tableUnitofMeasure('');
        $("#cUnit").val('');
        $("#cUnitDescription").val('');
        $('#itemUnitModal').modal('show');
    }
    function tableUnitofMeasure(unit){
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/tableunit",
            method:'POST',
            data: {unitsearch: unit},
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                $("#unitTable").html(resp);
            }
        })
    }
    
// save new category
    $("#btnSaveNewCategory").click(function(){
        var cCategory = $("#cCategory").val();
        var cDescription = $("#cDescription").val();
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/savecategory",
            method:'POST',
            data: {cCategory: cCategory, cDescription: cDescription},
            dataType: 'JSON',
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                stat = resp.status;
                switch(stat){
                    case "SUCCESS":
                        alertmodal(cCategory + ' Added Successfully', 'New Category Added Successfully'); 
                        tableCategory(cCategory);        
                        break; 
                    case "ERROR":
                        alertmodal('Unable to Add: ' + cCategory, 'Error');
                        tableCategory('');        
                        break; 
                    case "NOTVALID":
                        alertmodal(resp.message, 'Required Fields');
                        break;
                }
            }
        })
    });
// save new unit
    $("#buttSaveNewUnit").click(function(){
        var cUnit = $("#cUnit").val();
        var cUnitDescription = $("#cUnitDescription").val();
        $.ajax({
            url: "<?php echo base_url();?>" + "app/pharmacy/saveunit",
            method:'POST',
            data: {cUnit: cUnit, cUnitDescription: cUnitDescription},
            dataType: 'JSON',
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                stat = resp.status;
                switch(stat){
                    case "SUCCESS":
                        alertmodal(cUnit + ' Added Successfully', 'New Unit Added Successfully'); 
                        tableUnitofMeasure(cUnit);        
                        break; 
                    case "ERROR":
                        alertmodal('Unable to Add: ' + cUnit, 'Error');
                        tableUnitofMeasure('');        
                        break; 
                    case "NOTVALID":
                        alertmodal(resp.message, 'Required Fields');
                        break;
                }
            }
        })
    });
    
</script>

<!-- alertModal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog"  aria-labelledby="alertModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="alertModalLabel" style="float:left;">&nbsp;</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                <br />
            </div>
            <div class="modal-body" id="alertModalMessage">&nbsp;</div>
            <div class="modal-footer">
                <button type="button" id="closeid" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveid" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteTrans(){
        alertmodal('Are you sure that you want to Delete', 'Delete Transaction',false);
    }
    var modalConfirm = function(callback) {
        $('#alertModal').modal('show');
        $("#saveid").on("click", function() {
            callback(true);
            $("#alertModal").modal('hide');
        });
        $("#closeid").on("click", function() {
            callback(false);
            $("#alertModal").modal('hide');
        });
    };
    function alertmodal(message, title, hidesave=true){
        $("#saveid").html("Save");
        $("#closeid").html("Close");
        if(hidesave){
            $("#saveid").hide();
        }else{
            $("#saveid").show();
        }
        $("#alertModalMessage").html(message);
        $("#alertModalLabel").html(title);
        modalConfirm(function(confirm) {
            if (confirm) {
                $("#result").html("Changes Saved");
            } else {
                $("#result").html("Not Saved");
            }
        });
    }
</script>
<?php }?>