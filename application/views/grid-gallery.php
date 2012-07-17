


<script type="text/template" id="readTemplate">
        
        <tr id="${gallery_id}">
                <td width="30px">${gallery_id}</td>
                <td>${gallery_name}</td>
                <td>${gallery_address}</td>
                <td><img height="12px" id="${image_path}" onclick="popUp(this.id)" src="<?php echo base_url()?>file/uploads/${image_path}" /></td>                
                <td width="110px"><a class="updateBtn" href="<?php echo base_url()?>${updateLink}">Update</a> | <a class="deleteBtn" href="${deleteLink}">Delete</a></td>
        </tr>
</script>

<script type="text/javascript">



var readUrl   = 'index.php/act_gallery/read',
    updateUrl = 'index.php/act_gallery/update',
    delUrl    = 'index.php/act_gallery/delete',
    delHref,
    updateHref,
    updateId;

jQuery.fn.center = function () {
        this.css("position","absolute");
        this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
        this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
        return this;
    }

function closeBack()
{
    $("#darkBack").fadeOut("slow");
    $("#popUpItem").fadeOut("slow");
}

function closeItem()
{
    $("#darkBack").fadeOut("slow");
    $("#popUpItem").fadeOut("slow");
}


$(document).keypress(function(e){
    if(e.keyCode==27){
        $("#darkBack").fadeOut("slow"); 
        $("#popUpItem").fadeOut("slow");   
    }
});

function popUp(urlImg)
{
    
    var wrapperHeight = $('#content').height();
    $('#darkBack').css({'height': ($(document).height())+'px'});
    var urlBase = '<?php echo base_url()?>';
    $("#darkBack").css({"opacity" : "0.7"})
        .fadeIn("slow");
    
    $("#popUpItem").css({"opacity" : "1"})
        .fadeIn("slow");    
        
    $("#popUpItem").html("<img src='"+urlBase+"file/uploads/"+urlImg+"' width='400px'/>")
                   .center()
                   .fadeIn("slow");
    //alert(x);
}

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
            url: 'index.php/act_gallery/getById/' + updateId,
            dataType: 'json',
            
            success: function( response ) {
                $( '#gallery_id' ).val( response.gallery_id );
                $( '#gallery_name' ).val( response.gallery_name );
                $( '#gallery_address' ).val( response.gallery_address);
                $( '#image_path' ).val( response.image_path);
                $( '#ajaxLoadAni' ).fadeOut( 'slow' );
                
                //--- assign id to hidden field ---
                $( '#gallery_id' ).val( updateId );
                
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
                response[ i ].updateLink = updateUrl + '/' + response[ i ].gallery_id;
                response[ i ].deleteLink = delUrl + '/' + response[ i ].gallery_id;
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