<?php if( !isset($_SERVER['HTTP_REFERER'])) { echo ""; } else{ ?>
<form name="frmitemtagging" id="frmDoctorFeefrmitemtagging">
    <table class="table table-striped">
        <tr>
            <td>Barcode <font color="#FF0000">*</font></td>
            <td>
                <input type="text" class="form-control input-sm" style="width: 70%;" required placeholder="Barcode" name="tboxbarcode" id="tboxbarcode">
            </td>
        </tr>
        <tr>
            <td>Itemname <font color="#FF0000">*</font></td>
            <td>
                <input type="text" class="form-control input-sm" required placeholder="Itemname" name="tboxitemname" id="tboxitemname">
            </td>
        </tr>
        <tr>
            <td>Generic Name <font color="#FF0000">*</font></td>
            <td>
                <input type="text" class="form-control input-sm" required placeholder="Generic Name" name="tboxgenericname" id="tboxgenericname">
            </td>
        </tr>
        
        <tr>
            <td>Cartegory <font color="#FF0000">*</font></td>
            <td>
                <select class="boxcategory" style="width:150px;"></select>
                <script>
                    $('.boxcategory').select2({
                        dropdownParent: $('#itemTaggingmodal'),
                        ajax: {
                            url: "<?php echo base_url();?>app/pharmacy/filllcategory",
                            method:'POST',
                            dataType: 'JSON',
                            theme: "bootstrap",
                            data: function (params) {
                                search: params.term
                            },
                                processResults: function (data) {
                                // Transforms the top-level key of the response object from 'items' to 'results'
                                return {
                                    results: data.results
                                };
                            }
                        }
                    });
                </script>
                &nbsp;<button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick ="viewCategory()" id="buttAddCategory" aria-hidden="true">View Categories</button>
            </td>
        </tr>        
        <tr>
            <td>Category <font color="#FF0000">*</font></td>
            <td>
                <div class="form-group cbo">
                    <select data-live-search="true" name="cboxcategory" id="cboxcategory" data-width="150px" title="- Select Category - " class="selectpicker selcategory form-inline form-control input-sm"><option></option></select>
                </div>
                &nbsp;<button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick ="viewCategory()" id="buttAddCategory" aria-hidden="true">View Categories</button>
            </td>
        </tr>        
        <tr>
            <td>Unit <font color="#FF0000">*</font></td>
            <td>
                <div class="form-group cbo">
                    <select data-live-search="true" name="cboxunit" id="cboxunit" data-width="100px" title="- Select Unit - " class="selectpicker selunit form-inline form-control input-sm"><option></option></select>
                </div>
                &nbsp;<button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick ="viewUnitofMeasure()" id="buttAddUnit" aria-hidden="true">View Units</button>
            </td>
        </tr>        
        <tr>
            <td>Markup <font color="#FF0000">*</font></td>
            <td>
                <input type="text" class="form-control input-sm" style="width: 50%;" required placeholder="Default % or Amount" name="valueFee" id="valueFee">
            </td>
        </tr>
        <tr>
            <td>Min Markup <font color="#FF0000">*</font></td>
            <td>
            <input type="text" class="form-control input-sm" style="width: 50%;" required placeholder="Min % or Amount" name="valueFee" id="valueFee">
            </td>
        </tr>
    </table>    
</form>
<style>
    .form-control {
        width:auto;
        display:inline-block;
    }
    .cbo{
        margin-bottom:0px;display:inline;
    }
    .form-group select {
        display: inline-block;
        width: auto;
        vertical-align: middle;
        margin:0px;
    }
    input[type="search"].form-control{
        padding:0px  2px;
        height:20px;
    }
    .dropdown-menu .open{
        padding:0px;
    }
    .bootstrap-select, .filter-option-inner-inner, .filter-option, .inner, .bs-searchbox{
        font-size:0.9em;
    }
    .bs-placeholder{
        margin:0px;
    }
</style>

<?php } ?>
