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
                <form id="frmMenus" class="form-horizontal" action="<?= site_url() ?>menus/add" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <input type="hidden" id="frm-mode" value="<?= $mode ?>">

                        <div class='form-group'>
                            <label for="fin_id" class="col-sm-2 control-label"><?= lang("Menu ID") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fin_id" placeholder="<?= lang("(Autonumber)") ?>" name="fin_id" value="<?= $fin_id ?>" readonly>
                                <div id="fin_group_id_err" class="text-danger"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fin_order" class="col-sm-2 control-label"><?= lang("Number") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fin_order" placeholder="<?= lang("Menu Name") ?>" name="fin_order">
                                <div id="fin_order_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_caption" class="col-sm-2 control-label"><?= lang("Menu Name") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_caption" placeholder="<?= lang("Menu Name") ?>" name="fst_caption">
                                <div id="fst_caption_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_menu_name" class="col-sm-2 control-label"><?= lang("Menu Name") ?> * </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fst_menu_name" placeholder="<?= lang("Menu Name") ?>" name="fst_menu_name">
                                <div id="fst_menu_name_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fin_type" class="col-sm-2 control-label"><?= lang("Type") ?></label>
                            <div class="col-sm-3">
                                <select class="form-control" id="fin_level" name="fst_type">
                                    <option value='HEADER'><?= lang("HEADER") ?></option>
                                    <option value='TREEVIEW'><?= lang("TREEVIEW") ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- end box body -->

                    <div class="box-footer text-right">
                        <a id="btnSubmitAjax" href="#" class="btn btn-primary">Save Ajax</a>
                    </div>
                    <!-- end box-footer -->
                </form>
            </div>
        </div>
</section>

<script type="text/javascript">
    $(function() {

        <?php if ($mode == "EDIT") { ?>
            init_form($("#fin_id").val());
        <?php } ?>

        $("#btnSubmitAjax").click(function(event) {
            event.preventDefault();
            data = new FormData($("#frmMenus")[0]);

            mode = $("#frm-mode").val();
            if (mode == "ADD") {
                url = "<?= site_url() ?>menus/ajx_add_save";
            } else {
                url = "<?= site_url() ?>menus/ajx_edit_save";
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
                            onDestroy: function() {
                                //alert('the user clicked yes');
                                window.location.href = "<?= site_url() ?>master_groups/lizt";
                                return;
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
                        $("#fin_group_id").val(data.insert_id);

                        //Clear all previous error
                        $(".text-danger").html("");

                        // Change to Edit mode
                        $("#frm-mode").val("EDIT"); //ADD|EDIT

                        $('#fst_group_name').prop('readonly', true);
                        //$("#tabs-master_group-detail").show();
                        //console.log(data.data_image);
                    }
                },
                error: function(e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        });

        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });

        $(".select2").select2();
    });

    function init_form(fin_group_id) {
        //alert("Init Form");
        var url = "<?= site_url() ?>master_groups/fetch_data/" + fin_group_id;
        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                console.log(resp.master_groups);

                $.each(resp.master_groups, function(name, val) {
                    var $el = $('[name="' + name + '"]'),
                        type = $el.attr('type');
                    switch (type) {
                        case 'checkbox':
                            $el.attr('checked', 'checked');
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

<script type="text/javascript">
    $(function() {
        $(".select2-container").addClass("form-control");
        $(".select2-selection--single , .select2-selection--multiple").css({
            "border": "0px solid #000",
            "padding": "0px 0px 0px 0px"
        });
        $(".select2-selection--multiple").css({
            "margin-top": "-5px",
            "background-color": "unset"
        });
    });
</script>