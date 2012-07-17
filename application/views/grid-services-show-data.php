<!-- delete confirmation dialog box -->
<div id="delConfDialog" title="Confirm">
    <p>Are you sure?</p>
</div>
<!-- message dialog box -->
<div id="msgDialog"><p></p></div>

<script type="text/template" id="readTemplate">
        <tr id="${id}">
                <td width="30px">${nomor}</td>
        <?php
                foreach($getComponent as $r){
                        echo'<td>${'. $r->t_services_column .'}</td>';
                }
        ?>
                <td width="110px"><a class="updateBtn" href="${updateLink}">Update</a> | <a class="deleteBtn" href="${deleteLink}">Delete</a></td>
        </tr>
</script>

<script type="text/javascript">
var readUrl   = 'index.php/act_services_show_data/read/<?=$tabel?>',
    updateUrl = 'index.php/master/agents/update',
    delUrl    = 'index.php/act_services_show_data/delete',
    delHref,
    updateHref,
    updateId;


$( function() {
    
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
                $.ajax({
                    url: delHref,
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
    // --- Create Record with Validation ---
    
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
                response[ i ].updateLink = updateUrl + '/' + response[ i ].id;
                response[ i ].deleteLink = delUrl + '/' + response[ i ].id;
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