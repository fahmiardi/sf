<!-- delete confirmation dialog box -->
<div id="delConfDialog" title="Confirm">
    <p>Are you sure?</p>
</div>


<!-- message dialog box -->
<div id="msgDialog"><p></p></div>

<script type="text/template" id="readTemplate">
        <tr id="${receipt_id}">
                <td align="center" width="30px">${nomor}</td>
                <td align="center">${receipt_date}</td>
				<td align="center">${custom_receipt_id}</td>
                <td align="center">${sales_id}</td>
				
                <td width="110px">
					<a class="" href="<?=base_url().'index.php/sales/topdf/' . '${receipt_id}' . '/' . '${territory_id}'?>">PDF</a> | 
					<a class="" href="<?=base_url().'index.php/sales/getDetail/' . '${receipt_id}' . '/' . '${territory_id}'?>">Detail</a>		
				</td>
				
        </tr>

</script>

<script type="text/javascript">
var readUrl   = 'index.php/sales/read',
    updateUrl = 'index.php/sales/show_data',
    delUrl    = 'index.php/sales/delete',
    delHref,
    updateHref,
    updateId;


$( function() {
    
    $( '#tabs' ).tabs({
        fx: { height: 'toggle', opacity: 'toggle' }
    });
    
    readUsers();
    
    $( '#msgDialog' ).dialog({
        autoOpen: false,
        
        buttons: {
            'Ok': function() {
                $( this ).dialog( 'close' );
            }
        }
    });    
    
    $( '#delConfDialog' ).dialog({
        autoOpen: false,
        
        buttons: {
            'No': function() {
                $( this ).dialog( 'close' );
            },
            
            'Yes': function() {
                //display ajax loader animation here...
                $( '#ajaxLoadAni' ).fadeIn( 'slow' );
                
                $( this ).dialog( 'close' );
                
				  deleteId = $( this ).parents( 'tr' ).attr( 'id' );
							
				
                $.ajax({
                    url: 'index.php/sales/delete/' + deleteId,
                    
                    success: function( response ) {
                        //hide ajax loader animation here...
                        $( '#ajaxLoadAni' ).fadeOut( 'slow' );
                        
                        $( '#msgDialog > p' ).html( response );
                        $( '#msgDialog' ).dialog( 'option', 'title', 'Success' ).dialog( 'open' );
                        
                        $( 'a[href=' + delHref + ']' ).parents( 'tr' )
                        .fadeOut( 'slow', function() {
                            $( this ).remove();
                        });
                        
                    } //end success
                });
                
            } //end Yes
            
        } //end buttons
        
    }); //end dialog
    
    $( '#records' ).delegate( 'a.deleteBtn', 'click', function() {
		
        delHref = $( this ).attr( 'href' );
        
        $( '#delConfDialog' ).dialog( 'open' );
        
        return false;
    
    }); //end delete delegate
   
    
}); //end document ready


function readUsers() {
    //display ajax loader animation
    $( '#ajaxLoadAni' ).fadeIn( 'slow' );
    
	var tempId = "", row = "";
    $.ajax({
        url: readUrl,
        dataType: 'json',
        success: function( response ) {
            var j=1;
            for( var i in response ) {
                response[ i ].updateLink = updateUrl + '/' + response[ i ].id;
                response[ i ].deleteLink = delUrl + '/' + response[i].receipt_id;
                response[ i ].nomor = j;
				
				//generate custom receipt_id
				tempId = response[ i ].receipt_id;			
				if (tempId.length < 4)
				{
					var ii = tempId.length;
					for(ii; ii<4; ii++)
					{
						tempId = '0' + tempId;
					}
				}
				response[ i ].custom_receipt_id = tempId;
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