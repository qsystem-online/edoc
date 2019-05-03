<script type="text/javascript"> 
    $(function(){
        $('#tblList').on('click','.btn-approval', function (e) {
            e.preventDefault();
            t = $('#tblList').DataTable();
            var trRow = $(this).parents('tr');
			data = t.row(trRow).data();
            window.location = "<?= base_url() ?>document/approval/" + data.fin_document_flow_control_id;            

        });
    })
</script>