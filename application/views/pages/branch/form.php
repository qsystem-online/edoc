<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url() ?>bower_components/select2/dist/css/select2.min.css">

<section class="content-header">
    <h1><?= lang("Menus") ?><small><?= lang("form") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Menus") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= $title ?></h3>
                </div>
                <!-- end box header -->

                <!-- form start -->
                <form id="frmBranch" class="form-horizontal" action="<?= site_url() ?>branch/add" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <input type="hidden" id="frm-mode" value="<?= $mode ?>">

                        <div class='form-group'>
                            <label for="fin_branch_id" class="col-sm-2 control-label"><?= lang("Branch ID") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fin_branch_id" placeholder="<?= lang("(Autonumber)") ?>" name="fin_branch_id" value="<?= $fin_branch_id ?>" readonly>
                                <div id="fin_branch_id_err" class="text-danger"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_branch_name" class="col-sm-2 control-label"><?= lang("Branch Name") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_branch_name" placeholder="<?= lang("Branch Name") ?>" name="fst_branch_name">
                                <div id="fst_branch_name_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_branch_address" class="col-sm-2 control-label"><?= lang("Address") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_branch_address" placeholder="<?= lang("Address") ?>" name="fst_branch_address">
                                <div id="fst_branch_address_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_branch_phone" class="col-sm-2 control-label"><?= lang("Phone") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_branch_phone" placeholder="<?= lang("Phone") ?>" name="fst_branch_phone">
                                <div id="fst_branch_phone_err" class="text-danger"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="fst_notes" class="col-sm-2 control-label"><?= lang("Notes") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_notes" placeholder="<?= lang("Notes") ?>" name="fst_notes">
                                <div id="fst_notes_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fbl_central" class="col-sm-2 control-label"><?= lang("Central") ?> :</label>
                            <div class="checkbox">
                                <label><input id="fbl_central" type="checkbox" name="fbl_central" value="1"><?= lang("Central") ?></label><br>
                            </div>
                        </div>
                    </div>
                    <!-- end box body -->

                    <div class="box-footer text-right">
                        <a id="btnSubmitAjax" href="#" class="btn btn-primary">Save Record</a>
                    </div>
                    <!-- end box-footer -->
                </form>
            </div>
        </div>
</section>

<script type="text/javascript">
    $(function() {

        <?php if ($mode == "EDIT") { ?>
            init_form($("#fin_branch_id").val());
        <?php } ?>

        $("#btnSubmitAjax").click(function(event) {
            event.preventDefault();
            data = new FormData($("#frmBranch")[0]);

            mode = $("#frm-mode").val();
            if (mode == "ADD") {
                url = "<?= site_url() ?>branch/ajx_add_save";
            } else {
                url = "<?= site_url() ?>branch/ajx_edit_save";
            }

            //var formData = new FormData($('form')[0])
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(resp) {
                    if (resp.message != "") {
                        $.alert({
                            title: 'Message',
                            content: resp.message,
                            buttons: {
                                OK: function() {
                                    if (resp.status == "SUCCESS") {
                                        //location.reload();
                                        window.location.href = "<?= site_url() ?>branch/lizt";
                                        return;
                                    }
                                },
                            }
                        });
                    }

                    if (resp.status == "VALIDATION_FORM_FAILED") {
                        //Show Error
                        errors = resp.data;
                        for (key in errors) {
                            $("#" + key + "_err").html(errors[key]);
                        }
                    } else if (resp.status == "SUCCESS") {
                        data = resp.data;
                        $("#fin_branch_id").val(data.insert_id);

                        //Clear all previous error
                        $(".text-danger").html("");

                        // Change to Edit mode
                        $("#frm-mode").val("EDIT"); //ADD|EDIT

                    }
                },
                error: function(e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        });

    });

    function init_form(fin_branch_id) {
        //alert("Init Form");
        var url = "<?= site_url() ?>branch/fetch_data/" + fin_branch_id;
        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                console.log(resp.branch);

                $.each(resp.branch, function(name, val) {
                    var $el = $('[name="' + name + '"]'),
                        type = $el.attr('type');
                    switch (type) {
                        case 'checkbox':
                            $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                            break;
                        case 'radio':
                            $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                            break;
                        default:
                            $el.val(val);
                            console.log(val);
                    }
                });
            },

            error: function(e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
            }
        });
    }
</script>

<!-- Select2 -->
<script src="<?= base_url() ?>bower_components/select2/dist/js/select2.full.js"></script>