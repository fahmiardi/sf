<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Holiday</h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>/index/add">New</a></li>
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>">List Data</a></li>
                </ul>
        </div>
        <!-- end box / title -->
        
        <?php if($this->uri->segment(3)=="add" || $this->uri->segment(3)=="update"){?>
        <?php
        #### tampilkan alert jika terdapat kesalahan dalam memasukkan data
                $salah = validation_errors();
                if($salah <> ""){
                        echo'<div id="box-messages">
                                <div class="messages">
                                        <div id="message-error" class="message message-error">
                                                <div class="image">
                                                        <img src="'. base_url() .'file/shell/smooth/resources/images/icons/error.png" alt="Error" height="32" />
                                                </div>
                                                <div class="text">
                                                        <h6>Terdapat kesalahan dalam memasukkan data:</h6>
                                                        <span>'. validation_errors() .'</span>
                                                </div>
                                                <div class="dismiss">
                                                        <a href="#message-error"></a>
                                                </div>
                                        </div>
                                </div>
                        </div>';
                }
        ?>
        
                <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="tanggal">Date:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="tanggal" name="tanggal" value="<?=$data['tanggal']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="keterangan">Information:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="keterangan" name="keterangan" value="<?=$data['keterangan']?>" class="medium" />
                                        </div>
                                </div>
                                
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        <?php } ?>
        
        <?php
        $msg = $this->session->flashdata('message');
        if($msg <> ""){
              echo'<div id="box-messages">
                        <div class="messages">
                                <div id="message-success" class="message message-success">
                                        <div class="image">
                                                <img src="'. base_url() .'file/shell/smooth/resources/images/icons/success.png" alt="Success" height="32" />
                                        </div>
                                        <div class="text">
                                                <h6>'. $msg .'</h6>
                                        </div>
                                        <div class="dismiss">
                                                <a href="#message-success"></a>
                                        </div>
                                </div>
                        </div>
                </div>';
        }
        ?>
        <div class="table">
                <base href="<?php echo base_url() ?>" />
                <div id="ajaxLoadAni">
                        <img src="file/smooth/images/ajax-loader.gif" alt="Ajax Loading Animation" />
                        <span>Loading...</span>
                </div>
                <table id="records">
                        <thead>
                                <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Information</th>
                                        <th>Actions</th>    
                                </tr>
                        </thead>
                        <tbody></tbody>
                </table>
                
<?php   ################################################################################ ?>
<!-- delete confirmation dialog box -->
<div id="delConfDialog" title="Confirm">
    <p>Are you sure?</p>
</div>
<!-- message dialog box -->
<div id="msgDialog"><p></p></div>

<script type="text/template" id="readTemplate">
        <tr id="${id}">
                <td width="30px">${nomor}</td>
                <td>${tanggal}</td>
                <td>${keterangan}</td>
                <td width="110px"><a class="updateBtn" href="${updateLink}">Update</a> | <a class="deleteBtn" href="${deleteLink}">Delete</a></td>
        </tr>
</script>

<script type="text/javascript">
var readUrl   = 'index.php/holiday/read',
    updateUrl = 'index.php/holiday/index/update',
    delUrl    = 'index.php/holiday/delete',
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
<?php   ################################################################################ ?>

        </div>
</div>