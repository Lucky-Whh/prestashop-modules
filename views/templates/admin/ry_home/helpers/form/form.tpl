{extends file="helpers/form/form.tpl"}

{block name="defaultForm"}
    <form id="{if isset($fields.form.form.id_form)}{$fields.form.form.id_form|escape:'html':'UTF-8'}{else}{if $table == null}configuration_form{else}{$table}_form{/if}{if isset($smarty.capture.table_count) && $smarty.capture.table_count}_{$smarty.capture.table_count|intval}{/if}{/if}" method="post" action="{$admin_link}" enctype="multipart/form-data" class="form-horizontal{if isset($name_controller) && $name_controller} {$name_controller}{/if}">
        <fieldset class="general tab-manager plblogtabs" style="display: block;">
            {if isset($menu) && $menu}
                <div class="panel form-horizontal" id="customer_part">
                    <div class="panel-heading">
                        <i class="icon-cogs"></i>
                        添加顶部导航
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">名称：</label>
                        <div class="col-lg-7">
                            <div id="urldiv">
                                <input type="text" name="title" value="{if isset($menu->title) && $menu->title !== ''}{$menu->title}{/if}" size="55">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">URL：</label>
                        <div class="col-lg-7">
                            <div id="urldiv">
                                <input type="text" name="url_1" value="{if isset($menu->url) && $menu->url !== ''}{$menu->url}{else}#{/if}" size="55">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group"><label class="control-label col-lg-3">目标</label>
                        <div class="col-lg-7">
                            <select name="animation[target]">
                                <option value="_self" {if isset($menu->animation->target) && $menu->animation->target == '_self'}selected{/if}>_self</option>
                                <option value="_blank" {if isset($menu->animation->target) && $menu->animation->target == '_blank'}selected{/if}>_blank</option>
                            </select>
                            <p class="help-block">链接的目标(如_self或 _blank)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">显示：</label>
                        <div class="col-lg-9">
                            <div id="activediv" style="float: left;">
                                <input type="radio" name="display" value="1" {if isset( $menu->display)}{if $menu->display}checked="checked"{/if}{else}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/enabled.gif" alt="Enabled" title="Enabled"></label>
                                <input type="radio" name="display" value="0" {if isset( $menu->display) && !$menu->display}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/disabled.gif" alt="Disabled" title="Disabled"></label>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <center><button class="btn btn-default" type="submit" name="submitAddHomeMenu" value=""><i class="process-icon-save"></i>保存</button>
                        <button class="btn btn-default" type="submit" name="cancelAddHomeMenu" value="1"><i class="process-icon-cancel"></i>取消</button></center>
                </div>
            {/if}
            {if isset($slider) && $slider|count}
                <div class="panel form-horizontal" id="customer_part">
                    <div class="panel-heading">
                        <i class="icon-cogs"></i>
                        添加幻灯片
                    </div>
                    <div id="slider-form-group" class="form-group">
                        <label class="control-label col-lg-3">
                    <span title="" data-toggle="tooltip" class="label-tooltip">
                        背景
                    </span>
                        </label>
                        <div class="col-lg-9">
                            <input type="radio" checked="checked" onclick="return showBackground('image')" name="image[type]" value="image"><label class="radioCheck">图片</label>
                        </div>
                    </div>
                    <div class="animation form-group" id="animation_image"><label class="control-label col-lg-3">选择文件：</label>
                        <div class="col-lg-6">
                            <input id="image" type="file" name="image[value]" class="hide">
                            <input type="hidden" name="imagehidden" value="{if isset($slider->image)}{$slider->image->value}{/if}">
                            <input type="hidden" name="id_home_slider" value="{if isset($slider->id_home_slider)}{$slider->id_home_slider}{/if}">
                            <div class="dummyfile input-group">
                                <span class="input-group-addon"><i class="icon-file"></i></span>
                                <input id="image-name" type="text" class="disabled" name="image[value]" value="{if isset($slider->image)}{$slider->image->value}{/if}" readonly="">
                                    <span class="input-group-btn">
                                        <button id="image-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
                                            <i class="icon-folder-open"></i> 上传文件
                                        </button>
                                    </span>
                            </div>
                        </div><script>
                            $(document).ready(function(){
                                $("#image-selectbutton").click(function(e){
                                    $("#image").trigger("click");
                                });
                                $("#image").change(function(e){
                                    var val = $(this).val();
                                    var file = val.split(/[\/]/);
                                    $("#image-name").val(file[file.length-1]);
                                });
                            });
                        </script>

                        <div class="clear"></div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">URL：</label>
                        <div class="col-lg-7">
                            <div id="urldiv">
                                <input type="text" name="url_1" value="{if isset($slider->url) && $slider->url !== ''}{$slider->url}{else}#{/if}" size="55">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group"><label class="control-label col-lg-3">目标</label>
                        <div class="col-lg-7">
                            <select name="animation[target]">
                                <option value="_self" {if isset($slider->animation->target) && $slider->animation->target == '_self'}selected{/if}>_self</option>
                                <option value="_blank" {if isset($slider->animation->target) && $slider->animation->target == '_blank'}selected{/if}>_blank</option>
                            </select>
                            <p class="help-block">链接的目标(如_self或 _blank)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">显示：</label>
                        <div class="col-lg-9">
                            <div id="activediv" style="float: left;">
                                <input type="radio" name="display" value="1" {if isset( $slider->display)}{if $slider->display}checked="checked"{/if}{else}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/enabled.gif" alt="Enabled" title="Enabled"></label>
                                <input type="radio" name="display" value="0" {if isset( $slider->display) && !$slider->display}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/disabled.gif" alt="Disabled" title="Disabled"></label>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <center><button class="btn btn-default" type="submit" name="submitAddHomeSlider" value=""><i class="process-icon-save"></i>保存</button>
                        <button class="btn btn-default" type="submit" name="cancelAddHomeSlider" value="1"><i class="process-icon-cancel"></i>取消</button></center>
                </div>
            {/if}
            {if isset($floor) && $floor|count}
                <div class="panel form-horizontal" id="customer_part">
                    <div class="panel-heading">
                        <i class="icon-cogs"></i>
                        添加楼层
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">楼层名称：</label>
                        <div class="col-lg-7">
                            <div id="urldiv">
                                <input type="text" name="title" value="{if isset($menu->title) && $menu->title !== ''}{$menu->title}{/if}" size="55">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group"><label class="control-label col-lg-3">楼层类型</label>
                        <div class="col-lg-7">
                            <select name="floor_type" id="floor_type">
                                <option value="Default" {if isset($floor->type) && $floor->type == 'Default'}selected{/if}>Default</option>
                                <option value="Category" {if isset($floor->type) && $floor->type == 'Category'}selected{/if}>Category</option>
                                <option value="New" {if isset($floor->type) && $floor->type == 'New'}selected{/if}>New</option>
                                <option value="Special" {if isset($floor->type) && $floor->type == 'Special'}selected{/if}>Special</option>
                                <option value="Topic" {if isset($floor->type) && $floor->type == 'Topic'}selected{/if}>Topic</option>
                            </select>
                            <p class="help-block">楼层展示类型(如Default或Category)</p>
                            <div id="Default_floor_div" style="display: block;">
                                <label class="control-label col-lg-3">搜索商品</label>
                                <div class="input-group col-lg-5">
                                    <input type="text" id="searchProduct" value="">
                                    <span class="input-group-addon"><i class="icon-search"></i></span>
                                </div>
                                <br>
                                <table class="table">
                                    <tbody><tr>
                                        <td>
                                            <p>未选商品</p>
                                            <select id="Default_select_1" class="input-large" multiple="">
                                            </select>
                                            <a id="Default_select_add" class="btn btn-default btn-block clearfix">添加 <i class="icon-arrow-right"></i></a>
                                        </td>
                                        <td>
                                            <p>已选商品</p>
                                            <select name="product_select[]" id="Default_select_2" class="input-large" multiple="">
                                                <option value="4">&nbsp;体验店自提</option>
                                                <option value="21">&nbsp;宏光小区店自提</option>
                                                <option value="2">&nbsp;惠民路店自提</option>
                                                <option value="3">&nbsp;经济巷店自提</option>
                                                <option value="1">&nbsp;麟州镖局</option>
                                            </select>
                                            <a id="Default_select_remove" class="btn btn-default btn-block clearfix"><i class="icon-arrow-left"></i> 删除 </a>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </div>
                            <div id="Category_floor_div" style="display: none;">
                                <label class="control-label col-lg-3">搜索分类</label>
                                <div class="input-group col-lg-5">
                                    <input type="text" id="searchProduct" value="">
                                    <span class="input-group-addon"><i class="icon-search"></i></span>
                                </div>
                                <br>
                                <table class="table">
                                    <tbody><tr>
                                        <td>
                                            <p>未选分类</p>
                                            <select id="Category_select_1" class="input-large" multiple="">
                                            </select>
                                            <a id="Category_select_add" class="btn btn-default btn-block clearfix">添加 <i class="icon-arrow-right"></i></a>
                                        </td>
                                        <td>
                                            <p>已选分类</p>
                                            <select name="category_select[]" id="Category_select_2" class="input-large" multiple="">
                                                <option value="4">&nbsp;奶粉</option>
                                                <option value="21">&nbsp;饮料饮品</option>
                                            </select>
                                            <a id="Category_select_remove" class="btn btn-default btn-block clearfix"><i class="icon-arrow-left"></i> 删除 </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Topic_floor_div" style="display: none;">
                                <br>
                                <table id="topic_group_table" class="table">
                                    <tbody>

                                    </tbody>
                                </table>
                                <input type="hidden" name="topic_group" value="0">
                                <a href="javascript:addTopicGroup();" class="btn btn-default ">
                                    <i class="icon-plus-sign"></i> 添加
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">URL：</label>
                        <div class="col-lg-7">
                            <div id="urldiv">
                                <input type="text" name="url_1" value="{if isset($floor->url) && $floor->url !== ''}{$floor->url}{else}#{/if}" size="55">
                            </div>
                            <p class="help-block">楼层整体跳转链接</p>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group"><label class="control-label col-lg-3">目标</label>
                        <div class="col-lg-7">
                            <select name="animation[target]">
                                <option value="_self" {if isset($floor->animation->target) && $floor->animation->target == '_self'}selected{/if}>_self</option>
                                <option value="_blank" {if isset($floor->animation->target) && $floor->animation->target == '_blank'}selected{/if}>_blank</option>
                            </select>
                            <p class="help-block">链接的目标(如_self或 _blank)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">显示：</label>
                        <div class="col-lg-9">
                            <div id="activediv" style="float: left;">
                                <input type="radio" name="display" value="1" {if isset( $floor->display)}{if $floor->display}checked="checked"{/if}{else}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/enabled.gif" alt="Enabled" title="Enabled"></label>
                                <input type="radio" name="display" value="0" {if isset( $floor->display) && !$floor->display}checked="checked"{/if}>
                                <label class="t"><img src="/img/admin/disabled.gif" alt="Disabled" title="Disabled"></label>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <center><button class="btn btn-default" type="submit" name="submitAddHomeFloor" value=""><i class="process-icon-save"></i>保存</button>
                        <button class="btn btn-default" type="submit" name="cancelAddHomeFloor" value="1"><i class="process-icon-cancel"></i>取消</button></center>
                </div>
            {/if}
        </fieldset>
    </form>
    <script type="text/javascript" src="/modules/ryhome/views/js/form.js"></script>
{/block}