var test = 2;
var add_tuple = "";



(function($){
  tile = function() {
    add_tuple = "<tr align='center' id='new_tuple"+test+"' class='wide'>"+
                    "<td><input type='checkbox'/></td>"+
                    "<td><input type='text' name='iccid[]'/></td>"+
                    "<td><input type='text' name='item_code[]' /></td>"+
                    "<td><input type='text' name='item_group_name[]' /></td>"+
                    "<td><input type='text' name='item_name[]'/></td>"+
                    "<td><input type='text' name='price[]'/></td>"+
                    "<td><input type='text' name='priceEditable[]'/></td>"+
                "</tr>";
    $('#table-updateable').append(add_tuple);
    test++;
  };
})(jQuery);

(function($){
  teli = function() {
    test--;
    $('#new_tuple'+test).remove();
    
  };
})(jQuery);

(function($){
  check_all = function() {
    $("INPUT[type='checkbox']").attr('checked', $('#select_all').is(':checked'));
  };
})(jQuery);

(function($){
  delete_checked = function() {
        $('input:checkbox:checked').parent().parent().not('#tr_select_all').remove();
        var deleted_value = $('input:checkbox:checked').parent().attr('id').val();
        alert(deleted_value);    
  };
})(jQuery);






 