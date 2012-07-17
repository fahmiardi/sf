<div id="input_komponen_form">
        <div align="left" class="form_component">
                <form method="post" onsubmit="<?=$_SERVER['PHP_SELF']?>">
                        <input type="hidden" name="jenis" value="<?=$jenis?>">
                        <input type="hidden" name="data_source" value="">
                        <?php
                        
                        if($jenis == "text"){
                                echo'<b>Text Field</b>
                                <br>Label Name: <input type="text" name="nama"> 
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "textarea"){
                                echo'<b>Textarea</b>
                                <br>Label Name: <input type="text" name="nama">
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "date"){
                                echo'<b>Date</b>
                                <br>Label Name: <input type="text" name="nama">
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "dropdown"){
                                echo'<b>Drop Down List</b>
                                <br>Label Name: <input type="text" name="nama">
                                <br>
                                <br>Data Source:
                                <select name="data_source">';
                                
                                $table = $this->mservices->getTable();
                                foreach($table as $r){
                                        echo'<option value="'. $r->table_name .'">'. $r->alias .'</option>';
                                }
                                
                                echo'</select>
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "radio"){
                                echo'<b>Radio Button</b>
                                <br>Label Name: <input type="text" name="nama">
                                <br>
                                <br>Data Source: 
                                <select name="data_source">';
                                
                                $table = $this->mservices->getTable();
                                foreach($table as $r){
                                        echo'<option value="'. $r->table_name .'">'. $r->alias .'</option>';
                                }
                                
                                echo'</select>
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "checkbox"){
                                echo'<b>Checkbox</b>
                                <br>Label Name: <input type="text" name="nama">
                                <br>
                                <br>Data Source: 
                                <select name="data_source">';
                                
                                $table = $this->mservices->getTable();
                                foreach($table as $r){
                                        echo'<option value="'. $r->table_name .'">'. $r->alias .'</option>';
                                }
                                
                                echo'</select>
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "photo"){
                                echo'<b>Camera Photo</b>
                                <br>Label Name: <input type="text" name="nama"> 
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "gps"){
                                echo'<b>GPS Location</b>
                                <br>Label Name: <input type="text" name="nama" disabled="disabled"> 
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }elseif($jenis == "barcode"){
                                echo'<b>Barcode</b>
                                <br>Label Name: <input type="text" name="nama" disabled="disabled"> 
                                <br>
                                <button type="submit">Save Component</button>
                                <br>';
                        }
                        ?>
                </form>
        </div>
</div>