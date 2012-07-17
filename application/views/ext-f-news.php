<script>
   function reload(){
			$('#cc').combotree('reload');
		}
		function setValue(){
			$('#cc').combotree('setValue', 2);
		}
		function getValue(){
			var val = $('#cc').combotree('getValue');
			alert(val);
		}
		function disable(){
			$('#cc').combotree('disable');
		}
		function enable(){
			$('#cc').combotree('enable');
		}
</script>
<div class="box">
    <!-- box / title -->
    <div class="title">
        <h5>News Submittance</h5>
        
    </div>
    <!-- end box / title -->


    <?php if ($proses == "add" || $proses == "update") { ?>
        <?php
        #### tampilkan alert jika terdapat kesalahan dalam memasukkan data
        $salah = validation_errors();
        if ($salah <> "") {
            echo'<div id="box-messages">
                                <div class="messages">
                                        <div id="message-error" class="message message-error">
                                                <div class="image">
                                                        <img src="' . base_url() . 'file/shell/smooth/resources/images/icons/error.png" alt="Error" height="32" />
                                                </div>
                                                <div class="text">
                                                        <h6>Terdapat kesalahan dalam memasukkan data:</h6>
                                                        <span>' . validation_errors() . '</span>
                                                </div>
                                                <div class="dismiss">
                                                        <a href="#message-error"></a>
                                                </div>
                                        </div>
                                </div>
                        </div>';
        }
        $t= $this->session->flashdata('territory');
        echo $t;
        ?>

        <form id="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form">
                <div class="fields">
                    <div class="field">
                        <div class="label">
                            <label for="parent_id">Title</label>
                        </div>
                        <div class="input">
                            <input type="text" id="name" name="news_header" value="<?=$data['news_header']?>" class="medium" />
                        </div>

                    </div>
                    <div class="field">
                        <div class="label">
                            <label for="name">Message</label>
                        </div>
                        <div class="input">
                            <textarea id="name" name="news_content" value="" class="medium" cols="90" rows="5"><?=$data['news_content']?></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <div class="label" style="padding-top:0;">
                            <label>Choose Territory:</label>
                        </div>
                        <div class="input">
                            <select id="cc" class="easyui-combotree" name="territory_id[]" url="<?= base_url() ?>index.php/territory/territory_news_json" multiple="true" cascadeCheck="false" style="width:200px;"></select>
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
    if ($msg <> "") {
        echo'<div id="box-messages">
                        <div class="messages">
                                <div id="message-success" class="message message-success">
                                        <div class="image">
                                                <img src="' . base_url() . 'file/shell/smooth/resources/images/icons/success.png" alt="Success" height="32" />
                                        </div>
                                        <div class="text">
                                                <h6>' . $msg . '</h6>
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

        <?php
        $this->load->view('ext-f-news-tree');
        ?>


    </div>
</div>