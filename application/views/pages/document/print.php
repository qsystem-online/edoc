<style>
@media print{
    @page {
        size: A5 landscape;
        height: 215mm;
        width: 139mm;
        margin: 0;
    }
}
.ct1 td{
    padding:5px;
}
</style>

<div>
    <?php
        //var_dump($document);
    ?>
    <table>
        <tr>
            <td><label>Document No</label></td>
            <td><label>:</label></td>
            <td><?=$document["fst_document_no"]?></td>
        </tr>
        <tr>
            <td><label>Group</label></td>
            <td><label>:</label></td>
            <td><?=$document["fst_group_name"]?></td>
        </tr>
        <tr>
            <td><label>Name</label></td>
            <td><label>:<label></td>
            <td><?=$document["fst_name"]?></td>
        </tr>
        <tr>
            <td colspan="3"><i><?=$document["fst_memo"]?></i></td>
        </tr>            
    </table>

    <table class="ct1" border="1" style="width:100%">
        <tr>
            <td style="width:100px"><label>Create Date :</label></td>
            <td style="width:300px"><?=$document["fdt_insert_datetime"]?></td>
            <td style="width:100px"><label>Create By :</label></td>
            <td><?=$document["fst_username"]?></td>
        </tr>
    </table>
    
</div>
<script type="text/javascript">
$(function(){
    window.print();
});

</script>
 