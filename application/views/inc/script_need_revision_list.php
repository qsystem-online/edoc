<script type="text/javascript"> 
    $(function(){
        $('#tblList').on('click','.btn-edit', function (e) {
            e.preventDefault();
            t = $('#tblList').DataTable();
            var trRow = $(this).parents('tr');
			data = t.row(trRow).data();
            window.location = "<?= base_url() ?>document/edit/" + data.fin_document_id;            

        });
    })
</script>