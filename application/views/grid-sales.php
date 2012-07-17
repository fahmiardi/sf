


<script type="text/template" id="readTemplate">
        <tr id="${so_id}">
                <td width="30px">${so_id}</td>
                <td>${territory_id}</td>
                <td>${so_date}</td>
                <td>${sales_id}</td>
                <td>${payment_method}</td>
                <td>${discount}</td>
                <td width=25>${cash_paid}</td>
        </tr>
</script>

<script type="text/javascript">
var readUrl   = 'index.php/act_sales/read',
    updateUrl = 'index.php/act_sales/update',
    delUrl    = 'index.php/act_sales/delete',
    delHref,
    updateHref,
    updateId;


$( function() {
    
    $( '#tabs' ).tabs({
        fx: { height: 'toggle', opacity: 'toggle' }
    });
    
    readUsers();
    
    
    $( '#records' ).delegate( 'a.updateBtn', 'click', function() {
        updateHref = $( this ).attr( 'href' );
        updateId = $( this ).parents( 'tr' ).attr( "id" );
        
        $( '#ajaxLoadAni' ).fadeIn( 'slow' );
        
        $.ajax({
            url: 'index.php/act_sales/getById/' + updateId,
            dataType: 'json',
            
            success: function( response ) {
                $( '#so_id' ).val( response.so_id );
                $( '#territory_id' ).val( response.territory_id );
                $( '#so_date' ).val( response.so_date );
                $( '#sales_id' ).val( response.sales_id );
                $( '#payment_method' ).val( response.payment_method );
                $( '#discount' ).val( response.discount );
                $( '#cash_paid' ).val( response.cash_paid );
                
                $( '#ajaxLoadAni' ).fadeOut( 'slow' );
                
                //--- assign id to hidden field ---
                $( '#so_id' ).val( updateId );
                
                $( '#updateDialog' ).dialog( 'open' );
            }
        });
        
       /**
 *  <td width="30px">${so_id}</td>
 *                 <td>${territory_id}</td>
 *                 <td>${so_date}</td>
 *                 <td>${sales_id}</td>
 *                 <td>${payment_method}</td>
 *                 <td>${discount}</td>
 *                 <td width=25>${cash_paid}</td>
 */
        
        return false;
    }); //end update delegate
    
    $( '#records' ).delegate( 'a.deleteBtn', 'click', function() {
        delHref = $( this ).attr( 'href' );
        
        $( '#delConfDialog' ).dialog( 'open' );
        
        return false;
    
    }); //end delete delegate
    
    
    // --- Create Record with Validation ---
    $( '#create form' ).validate({
        rules: {
            cName: { required: true },
            cEmail: { required: true, email: true }
        },
        
        /*
        //uncomment this block of code if you want to display custom messages
        messages: {
            cName: { required: "Name is required." },
            cEmail: {
                required: "Email is required.",
                email: "Please enter valid email address."
            }
        },
        */
        
    });
    
}); //end document ready


function readUsers() {
    //display ajax loader animation
    $( '#ajaxLoadAni' ).fadeIn( 'slow' );
    
    $.ajax({
        url: readUrl,
        dataType: 'json',
        success: function( response ) {
            var j=1;
            for( var i in response ) {
                response[ i ].updateLink = updateUrl + '/' + response[ i ].so_id;
                response[ i ].deleteLink = delUrl + '/' + response[ i ].so_id;
                response[ i ].nomor = j;
                j++;
            }
            
            //clear old rows
            $( '#records > tbody' ).html( '' );
            
            //append new rows
            $( '#readTemplate' ).render( response ).appendTo( "#records > tbody" );
            
            //apply dataTable to #records table and save its object in dataTable variable
            if( typeof dataTable == 'undefined' )
                dataTable = $( '#records' ).dataTable({"bJQueryUI": true});
            
            //hide ajax loader animation here...
            $( '#ajaxLoadAni' ).fadeOut( 'slow' );
        }
    });
} // end readUsers
</script>