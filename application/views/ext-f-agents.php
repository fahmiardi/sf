<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">
<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
</script>

<table id="test" width=100% title="New Agents" class="easyui-treegrid" style="height:600px"
       url="<?php echo base_url("index.php/ext_act_agents/getStatusAgentsByIdJson/" . $this->session->userdata("username") . "/" . $this->session->userdata('agent_status')); ?>"
       rownumbers="true"
       idField="agent_id">
    <thead>
        <tr>
            <th field="agent_name" width="200">Name</th>
            <th field="agent_address" width="250">Address</th>
            <th field="agent_city" width="140">City</th>
            <th field="actions" width="200">Actions</th>
        </tr>
    </thead>
</table>