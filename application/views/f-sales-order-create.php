<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">

<script type="text/javascript" src="<?= base_url() ?>file/js/add-item.js"></script>


<form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<div class="panel-wrap" style="height: auto">
	<div class="panel-header-div">Cluster Information</div>
    <div class="panel-body-div">
    
        <div class="left-panel-body">
        <input type="hidden" id="checkson" value="test"/>
        <!--<div id="textis" style="float: left; width: 100px; height: 100px; background-color: aqua;">
        
        </div>-->
        <?php foreach($cluster as $item):?>
            <h2><?php echo $item->distributor_name?></h2>
            <p><?php echo $item->distributor_address?></p>
            <input type="hidden" value="<?php echo $item->territory_id?>" name="territory_id"/>
        <?php endforeach?>
        </div>
        <div class="right-panel-body">
            <table class="table-right-panel" width="100%" border="solid black 1px">
                <tr align="center" class="tr-colour">
                    <th width="50%" align="center">Date</th>
                    <th align="center">Sales Order No</th>
                </tr>
                
                <script type="text/javascript">
				        $(function() {
                            $("#date").datepicker({ dateFormat: 'yy-mm-dd' });
				        });
				</script>
                <tr align="center" class="gray">
                    <td width="50%" align="center"><input type="text" id="date" name="so_date" onclick="this.value='';" value="<? print(Date("Y-m-d")); ?>"/><img height="15px" src="<?= base_url() ?>file/js/easyui/themes/pepper-grinder/images/datebox_arrow.png" /></td>
                    <td align="center">auto generated</td>
                    
                    
                </tr>
            </table>
        </div>
        
    </div>
</div>

<script type="text/javascript">

        var counterTR = 0;
        var total_subtotal = 0;
        var total_discount = parseInt(0);
        var total_total = parseInt(0);
        var total_cash_paid = parseInt(0);
        var get_sales_id = "";
        
        $(this).ready( function() {
            $("#sales-name").autocomplete({
                minLength: 1,
                source:
                function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/sales_order/lookup",
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success:
                        function(data){
                            if(data.response =="true"){
                                add(data.message);
                            }
                        },
                    });
                },
            select:
                function(event, ui) {
                    $("#sales-id").val(ui.item.id);
                    populateSalesOrder($("#sales-id").val());
                },
            });
            
            

            
        });
        
        function delete_checked()
        {
            //total_cash_paid = parseInt(0);
            
            var find_defPrice = "";
            var find_reseller_disc = "";
            var find_amount = "";
            
            var value_defPrice = parseInt(0);
            var value_reseller_disc = parseInt(0);
            var value_amount = parseInt(0);
            
            $('input:checkbox:checked').parent().parent().not('#tr_select_all').each(function(i) {
                find_defPrice = $(this).find('.default_price').attr('id');
                value_defPrice = $('#'+find_defPrice).val();
                total_subtotal -= value_defPrice;
                
                find_reseller_disc = $(this).find('.reseller').attr('id');
                value_reseller_disc = $('#'+find_reseller_disc).val();
                total_discount -= value_reseller_disc;  
                
                find_amount = $(this).find('.amount').attr('id');
                value_amount = $('#'+find_amount).val();
                total_total -= value_amount;
                
                
                      
            });
            
            $('input:checkbox:checked').parent().parent().not('#tr_select_all').remove();    
            //alert(cek);
            //$('#cash_paid').val(total_cash_paid);
            $("#subtotal").val(total_subtotal);
            $("#discount").val(total_discount);
            $("#total").val(total_total);
            $("#cash_paid").val(total_total);
            
            
        }

        
        function texy(x, counter)
        {
            $("#iccid"+counter).val(x);
            $('#td_iccid'+counter).empty();
            voila(x,counter);
        }
        
        function autocompletex(x,counter)
        {
            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/sales_order/lookup_iccid/"+x,
                    dataType:"json",
                    success:function(data){
                             $('#td_iccid'+counter).empty();
                             for(var i=0; i<data.length; i++)  
                             {
                                var tex = data[i]['iccid'];
                                $('#td_iccid'+counter).append("<li id='li_tccid' onclick='texy($(this).text(),"+counter+")'>"+tex+"</li>");   
                             }
                    },
                    error: function(data){
                        window.href.location('<?php echo base_url()?>')
                    }
                });
        }
        
        
        function voila(x, counter)
        {
            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/sales_order/get_iccid_data/"+x,
                    dataType:"json",
                    success:function(data){
                             var text = $('select#iccid'+counter+' option:selected').attr('value');
                             var itemgroup = data['item_group_name'];
                             var itemname = data['item_name'];
                             var default_price = data['default_price'];
                             var reseller_price = data['reseller_price'];

                             $("#itemgroup"+counter).val(itemgroup); 
                             $("#itemname"+counter).val(itemname);
                             $("#default_price"+counter).val(default_price);
                                
                             $("#cash_paid").val(total_cash_paid);  
                   
                    },
                    error: function(data){
                        window.href.location('<?php echo base_url()?>')
                    }
                });
        }
        
        
        
        function sumPrice(counterTR)
        {
            var each_amount = parseInt(0);
            var each_discount = parseInt(0);
            var each_price = parseInt(0);
            
            $("#subtotal").val(0);
            $("#discount").val(0);
            $("#total").val(0);
            $("#cash_paid").val(0);
            
            
            each_price = parseInt($("#default_price"+counterTR).val());
            each_discount = parseInt($("#reseller_disc"+counterTR).val());
            each_amount = each_price - Math.round(each_price*each_discount/100);
            
            $("#amount"+counterTR).val(each_amount);
            
            total_subtotal += each_price;
            total_discount += each_discount;
            total_total += each_amount;
            total_cash_paid += each_amount;
            
            $("#subtotal").val(total_subtotal);
            $("#discount").val(total_discount);
            $("#total").val(total_total);
            $("#cash_paid").val(total_total);
            
            $("#reseller_disc"+counterTR).attr('readonly', 'true');
            
        }
        
        function populateSalesOrder(sales_id)
        {
            $(".wide").empty();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/sales_order/load_sales_order/"+sales_id,
                    dataType:"json",
                    success:function(data){
                    total_cash_paid = 0;
                    total_default_price = 0;
                    $.each(data, function(i,n){
                            //document.write(n['iccid']);
                            add_tuple = "<tr align='center' id='new_tuple"+test+"' class='wide'>"+
                                            "<td><input type='checkbox' id='checkbox"+counterTR+"'/></td>"+
                                            "<td><input type='text' id='iccid"+counterTR+"' value='"+ n["iccid"] +"' name='iccid[]' class='width-270-2' onkeyup='autocompletex(this.value,"+counterTR+")' autocomplete='off'/><ul id='td_iccid"+counterTR+"' class='td_iccid'></ul></td>"+
                                            "<td><input type='text' id='itemgroup"+counterTR+"' readonly='true' class='input-readonly' name='item_group_name[]' value='"+ n["item_group_name"] +"' /> </td>"+
                                            "<td><input type='text'  id='itemname"+counterTR+"' readonly='true' class='input-readonly' name='item_name[]' value='"+ n["item_name"] +"'/></td>"+
                                            "<td><input type='text' class='default_price' id='default_price"+counterTR+"' style='border:none' readonly='true' class='input-readonly' name='default_price[]' value='"+ n["default_price"] +"'/></td>"+
                                            "<td><input type='text' class='reseller' id='reseller_disc"+counterTR+"' name='reseller_disc[]' onchange='sumPrice("+counterTR+")'/></td>"+
                                            "<td><input type='text' class='amount' readonly='true' style='border:none' id='amount"+counterTR+"' name='amount[]'/></td>"+
                                        "</tr>";
                            $('#table-updateable').append(add_tuple);
                            test++;
                        });
                    },
                    error: function(data){
                        
                    }
                });               
        }
        
        $(function(){
            $("#sales-id").change(function(){
                var sf = $('select#sales-id option:selected').attr('class');
                $("#sales-name").val(sf);
                var sales_id = $("#sales-id").val();
                $(".wide").empty();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/sales_order/load_sales_order/"+sales_id,
                    dataType:"json",
                    success:function(data){
                    total_cash_paid = 0;
                    total_default_price = 0;
                    $.each(data, function(i,n){
                            //document.write(n['iccid']);
                            add_tuple = "<tr align='center' id='new_tuple"+test+"' class='wide'>"+
                                            "<td><input type='checkbox' id='checkbox"+counterTR+"'/></td>"+
                                            "<td><input type='text' id='iccid"+counterTR+"' value='"+ n["iccid"] +"' name='iccid[]' class='width-270-2' onkeyup='autocompletex(this.value,"+counterTR+")' autocomplete='off'/><ul id='td_iccid"+counterTR+"' class='td_iccid'></ul></td>"+
                                            "<td><input type='text' id='itemgroup"+counterTR+"' readonly='true' class='input-readonly' name='item_group_name[]' value='"+ n["item_group_name"] +"' /> </td>"+
                                            "<td><input type='text'  id='itemname"+counterTR+"' readonly='true' class='input-readonly' name='item_name[]' value='"+ n["item_name"] +"'/></td>"+
                                            "<td><input type='text' class='default_price' id='default_price"+counterTR+"' style='border:none' readonly='true' class='input-readonly' name='default_price[]' value='"+ n["default_price"] +"'/></td>"+
                                            "<td><input type='text' class='reseller' id='reseller_disc"+counterTR+"' name='reseller_disc[]' onchange='sumPrice("+counterTR+")'/></td>"+
                                            "<td><input type='text' class='amount' readonly='true' style='border:none' id='amount"+counterTR+"' name='amount[]'/></td>"+
                                        "</tr>";
                            $('#table-updateable').append(add_tuple);
                            test++;
                        });
                    },
                    error: function(data){
                        
                    }
                });
            });
});


$(function(){
            $("#itemAdd").click(function(){
                counterTR++;
                $.add_tuple = "<tr align='center' id='new_tuple"+counterTR+"' class='wide'>"+
                    "<td><input type='checkbox' id='checkbox"+counterTR+"'/></td>"+
                    "<td><input type='text'  id='iccid"+counterTR+"' name='iccid[]' class='width-270-2' onkeyup='autocompletex(this.value,"+counterTR+")' autocomplete='off'/><ul id='td_iccid"+counterTR+"' class='td_iccid'></ul></td>"+
                    "<td><input type='text'  id='itemgroup"+counterTR+"' readonly='true' class='input-readonly' name='item_group_name[]'/></td>"+
                    "<td><input type='text'  id='itemname"+counterTR+"' readonly='true' class='input-readonly' name='item_name[]'/></td>"+
                    "<td><input type='text' class='default_price' id='default_price"+counterTR+"' style='border:none' readonly='true' class='input-readonly' name='default_price[]'/></td>"+
                    "<td><input type='text' class='reseller' id='reseller_disc"+counterTR+"' name='reseller_disc[]' onchange='sumPrice("+counterTR+")'/></td>"+
                    "<td><input type='text' class='amount' readonly='true' style='border:none' id='amount"+counterTR+"' name='amount[]'/></td>"+
                "</tr>";
            
                $('#table-updateable').append($.add_tuple);
            
                var copyval = $('#reseller_price'+counterTR).attr('value');
                $("#default_price"+counterTR).val(copyval); 
            
            });
});

</script>


<div class="panel-wrap" style="height: auto">
	<div class="panel-header-div">Order Information</div>
    
    <div class="panel-body-div">
        <div class="child-panel-body">
        <div class="left-panel-body">
        
            <table class="table-right-panel" width="60%" border="solid black 1px">
                <tr align="center" class="tr-colour2">
                    <th width="20%" align="center">Sales ID</th>
                    <th align="center">Sales Name</th>
                </tr>
                
                
                <tr align="center" class="gray">
                    <td>
                        
                        <select name="sales_id" id="sales-id">
                        <?php foreach($sales as $item):?>
                            <option id="option1" class="<?php echo $item->user_name?>" value="<?php echo $item->user_id?>"><?php echo $item->user_id?></option>
                        <?php endforeach?>
                        </select>
                        
                    </td>
                    <td class="readonly" align="center">
                        <input  type="text" name="sales_name" id="sales-name" class="width-270"/>
                        
                    </td>
                    
                    
                </tr>
            </table>
        </div>
        <div class="right-panel-body">
            <table class="table-right-panel" width="50%" border="solid black 1px" style="float: right;">
                <tr align="center" class="tr-colour2">
                    <th width="50%" align="center">Payment Method</th>
                    
                </tr>
                
                
                <tr align="center" class="gray">
                    <td width="90%" align="center">
                        <select style="width: 90%;" name="dListPaymentMethod">
                            <?php foreach($payment_method as $method):?>
                                <option value="<?php echo $method->member_display?>">cash</option>
                            <?php endforeach?>
                        </select>
                    </td>
                    
                    
                </tr>
            </table>
        </div>
    </div>
    <div class="child-panel-body-2">
        <div class="buttons">
                <input type="button" id="itemAdd"  value="Add"/> 
                <input type="button" onclick="delete_checked()" value="Delete" />
        </div>
        
        
    </div>
    
    
                    
    <div class="child-panel-body">
        
            <table class="table-right-panel" id="table-updateable" width="92%" style="margin-left: 19px;">
                <tr align="center" class="tr-colour3" id="tr_select_all">
                    <th><input type="checkbox" id="select_all" onclick="check_all()"/></th>
                    <th width="20%">ICCID</th>
                    
                    <th>Item Group</th>
                    <th>Description</th>
                    <th>Price (Rp.)</th>
                    <th>Discount</th>
                    <th>Amount (Rp.)</th>
                    
                </tr>
                
                
            </table>
                       
        
            <div class="summary">
                <table width="100%">
                    <tr>
                        <td>Subtotal</td>
                        <td><input type="text" name="subtotal" id="subtotal" readonly="true"/></td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td><input type="text" name="discount_total" id="discount" class="discount"  readonly="true"/></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><input type="text" name="total" id="total" readonly="true"/></td>
                    </tr>
                    
                    <tr>
                        <td>Cash/Bank</td>
                        <td><input type="text" name="cash_paid" id="cash_paid" readonly="true"/></td>
                    </tr>
                </table>
            </div>
            
            
    </div>
    
    <div class="child-panel-body-2">
        <table class="table-right-panel" width="92%" style="margin-left: 19px; border: none; ">
            <tr style="height: 15px;">
                <td style="text-align: left; font-weight: bold; font-size: 1.3em;">Remark:</td>
                <td width="94%" style="border-bottom: solid #000 1px;"><input type="text" style="width: 100%; border: none"/></td>
            </tr>
        </table>
    </div>
    
        <div class="child-panel-body-2">
        
            <div class="buttons-2" style="margin: 0 auto">
                <input type="submit" value="Submit"/>
                <input type="button" value="Revert" onclick="window.location.reload(true);"/>
            </div>
            
            
    </div>
    </div>
    
</div>
</form>

<script type="text/javascript">
    $(document).ready(function() 
        {
            $("#select_all").click(function() 
            { 
                var checked_status = this.checked; 
                $("input[@name=checkbox]").each(function() 
                { 
                    this.checked = checked_status; 
                }); 
            });
        });            
</script>