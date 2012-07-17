<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">
<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery.easyui.min.js"></script>

<table id="test" width=100% title="Territory Tree" class="easyui-treegrid" style="height:600px"
       url="<?php echo base_url("index.php/ext_act_news/getByCreatedById_json/" . $this->session->userdata("username")); ?>"
       rownumbers="true"
       idField="news_id" treeField="name">
    <thead>
        <tr>
            <th field="territory_id" width="550">Territory ID</th>
            <th field="news_header" width="250">News Header</th>
            <th field="news_content" width="140">News Content</th>
            <th field="created_by" width="140">Created By</th>
            <th field="actions" width="140">Actions</th>

        </tr>
    </thead>
</table>