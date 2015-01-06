<!DOCTYPE html>
<html lang="en">
    <head>
        <?php @include_once('view/head.view.php'); ?>
    </head>

    <body>

        <div class="site-wrapper">

            <div class="site-wrapper-inner">

                <div class="cover-container">

                    <?php @include_once('view/header.view.php'); ?>

                    <div class="inner cover">
                        <h3 class="cover-heading">Aspect Ratios</h3>
                        <div class="btn-group" role="group" id="ratios"></div>
                        
                        <div class="row mt20">
                            <div style="width: 300px; margin: 0px auto; background-color: #fff; border-top-left-radius: 5px; border-bottom-right-radius: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon border-b-l-0 border-b-none text-shadow-none" style="padding-right: 8px;" data-toggle="tooltip" data-placement="bottom" title="Maintain width and height ratio">Constrain</span>
                                    <input type="checkbox" id="ratio_constrain" name="ratio_constrain" checked="checked" class="form-control border-b-r-0 border-b-none" />
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon border-b-l-0 border-b-none text-shadow-none" style="padding-right: 32px;">Width</span>
                                    <input type="text" id="ratio_width" class="form-control border-b-r-0 border-b-none" />
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon border-t-l-0 border-b-l-0 border-b-none text-shadow-none" style="padding-right: 68px;"></span>
                                    <input type="range" id="ratio_width_range" class="form-control border-t-r-0 border-b-r-0 border-b-none" min="1" max="5000" data-toggle="tooltip" data-placement="bottom" title="Adjust width"/>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon border-t-l-0 border-b-l-0 text-shadow-none border-b-none" style="padding-right: 28px;">Height</span>
                                    <input type="text" id="ratio_height" class="form-control border-t-r-0 border-b-r-0 border-b-none"/>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon border-t-l-0 border-b-l-0 text-shadow-none border-b-none" style="padding-right: 68px;"></span>
                                    <input type="range" id="ratio_height_range" class="form-control border-t-r-0 border-b-r-0 border-b-none" min="1" max="5000" data-toggle="tooltip" data-placement="bottom" title="Adjust height"/>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon border-t-l-0 text-shadow-none" style="padding-right: 35px;" data-toggle="tooltip" data-placement="bottom" title="Calculated ratio for above width and height">Ratio</span>
                                    <input type="text" id="ratio_ratio" class="form-control border-t-r-0 border-b-r-0 border-b-none" readonly="readonly"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt20">
                            <div id="preview" style="margin: 0px auto;">
                                <p class="text-shadow-none pt10">Preview</p>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Add Aspect Ratio Modal -->
                    <div id="modal-add-aspect-ratio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_alert" aria-hidden="true">
                        <div class="modal-dialog" style="width: 350px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h3 class="modal-title">Custom Aspect Ratio</h3>
                                </div>
                                <form class="form-horizontal" id="custom_ratio_form" name="custom_ratio_form">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="custom_ratio_width" class="col-sm-5 control-label">Width Ratio</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" id="custom_ratio_width" placeholder="Eg: 4">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_ratio_height" class="col-sm-5 control-label">Height Ratio</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" id="custom_ratio_height" placeholder="Eg: 3">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_ratio_name" class="col-sm-5 control-label">Name (optional)</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="custom_ratio_name" placeholder="Eg: Standard">
                                            </div>
                                        </div>
                                        <p><em><span class="glyphicon glyphicon-info-sign" style="color: #aaa;"></span> This will be saved in your browser's local storage and will be available when you come back to this website.</em></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" id="custom_ratio_save">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php @include_once('view/footer.view.php'); ?>

                </div>

            </div>

        </div>
    </body>
</html>