<table class="table  table-bordered table-condensed content_big_td module-cheep content_big_td">

    <thead>
    <tr>
        <th colspan="6">{lang('Page Category','mod_seo')} [{$locale}]</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td colspan="6">
            <div class="inside_padd discount-out">
                <div class="form-horizontal">

                    <label class="control-group">
                                            <span class="span4">
                                                <span data-title="{lang('Variables, can use to', 'mod_seo')}:" class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">
                                                    <b>%name%</b> - {lang('Category name','mod_seo')}<br/>
                                                    <b>%pagenumber%</b> - {lang("Current page number",'mod_seo')}<br/>
                                                    <br/>
                                                    {lang('Additional params for using with category name','mod_seo')}:<br/>
                                                    <b>[t]</b> - {lang('Translit','mod_seo')}<br/>
                                                    <b>[1..6]</b> - {lang('Number case of word','mod_seo')}<br/>
                                                    {lang('Example','mod_seo')}:<br/>
                                                    <b>%name[1]%</b> - {lang('Именительный', 'mod_seo')}<br/>
                                                    <b>%name[2]%</b> - {lang('Родительный', 'mod_seo')}<br/>
                                                    <b>%name[3]%</b> - {lang('Дательный', 'mod_seo')}<br/>
                                                    <b>%name[4]%</b> - {lang('Винительный', 'mod_seo')}<br/>
                                                    <b>%name[5]%</b> - {lang('Творительный', 'mod_seo')}<br/>
                                                    <b>%name[6]%</b> - {lang('Предложный', 'mod_seo')}<br/>
                                                    <b>%name[1..6][t]%</b> - {lang('Совместное использование', 'mod_seo')} <br/>
                                                </div>
                                                Meta-title:
                                            </span>
                                            <span class="span8 discount-name">
                                                <textarea name='pageCategoryTemplateTitle'>{$settings.pageCategoryTemplateTitle}</textarea>
                                            </span>
                    </label>

                    <label class="control-group">
                                            <span class="span4">
                                                <span data-title="{lang('Variables, can use to', 'mod_seo')}:" class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">
                                                    <b>%name%</b> - {lang('Category name','mod_seo')}<br/>
                                                    <b>%desc%</b> - {lang('Category description','mod_seo')}<br/>
                                                    <b>%pagenumber%</b> - {lang("Current page number",'mod_seo')}<br/>
                                                    <br/>
                                                    {lang('Additional params for using with category name','mod_seo')}:<br/>
                                                    <b>[t]</b> - {lang('Translit','mod_seo')}<br/>
                                                    <b>[1..6]</b> - {lang('Number case of word','mod_seo')}<br/>
                                                    {lang('Example','mod_seo')}:<br/>
                                                    <b>%name[1]%</b> - {lang('Именительный', 'mod_seo')}<br/>
                                                    <b>%name[2]%</b> - {lang('Родительный', 'mod_seo')}<br/>
                                                    <b>%name[3]%</b> - {lang('Дательный', 'mod_seo')}<br/>
                                                    <b>%name[4]%</b> - {lang('Винительный', 'mod_seo')}<br/>
                                                    <b>%name[5]%</b> - {lang('Творительный', 'mod_seo')}<br/>
                                                    <b>%name[6]%</b> - {lang('Предложный', 'mod_seo')}<br/>
                                                    <b>%name[1..6][t]%</b> - {lang('Совместное использование', 'mod_seo')} <br/>
                                                </div>
                                                Meta-description:
                                            </span>
                                            <span class="span8 discount-name">
                                                <textarea name='pageCategoryTemplateDesc'>{$settings.pageCategoryTemplateDesc}</textarea>
                                            </span>
                    </label>

                    <label class="control-group">
                                            <span class="span4">
                                                {lang('Description length','mod_seo')}:
                                            </span>
                                            <span class="span8 discount-name">
                                                <input class="input-mini" maxlength="3" type="text" autocomplete="off" name='pageCategoryTemplateDescCount' value="{$settings.pageCategoryTemplateDescCount}" />
                                            </span>
                    </label>

                    <label class="control-group">
                                            <span class="span4">
                                                <span data-title="{lang('Variables, can use to', 'mod_seo')}:" class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">
                                                    <b>%name%</b> - {lang('Category name','mod_seo')}<br/>
                                                    <b>%pagenumber%</b> - {lang("Current page number",'mod_seo')}<br/>
                                                    <br/>
                                                    {lang('Additional params for using with category name','mod_seo')}:<br/>
                                                    <b>[t]</b> - {lang('Translit','mod_seo')}<br/>
                                                    <b>[1..6]</b> - {lang('Number case of word','mod_seo')}<br/>
                                                    {lang('Example','mod_seo')}:<br/>
                                                    <b>%name[1]%</b> - {lang('Именительный', 'mod_seo')}<br/>
                                                    <b>%name[2]%</b> - {lang('Родительный', 'mod_seo')}<br/>
                                                    <b>%name[3]%</b> - {lang('Дательный', 'mod_seo')}<br/>
                                                    <b>%name[4]%</b> - {lang('Винительный', 'mod_seo')}<br/>
                                                    <b>%name[5]%</b> - {lang('Творительный', 'mod_seo')}<br/>
                                                    <b>%name[6]%</b> - {lang('Предложный', 'mod_seo')}<br/>
                                                    <b>%name[1..6][t]%</b> - {lang('Совместное использование', 'mod_seo')} <br/>
                                                </div>
                                                Meta-keywords:
                                            </span>
                                            <span class="span8 discount-name">
                                                <textarea name='pageCategoryTemplateKey'>{$settings.pageCategoryTemplateKey}</textarea>
                                            </span>
                    </label>
                    <label class="control-group">
                                            <span class="span4">
                                                <span class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">
                                                    <b>%number%</b> - {lang('Page number','mod_seo')}<br/>
                                                </div>
                                                {lang('Unique pagination pages','mod_seo')}:
                                            </span>
                                            <span class="span8 discount-name">
                                                <textarea name='pageCategoryTemplatePaginationTemplate'>{$settings.pageCategoryTemplatePaginationTemplate}</textarea>
                                            </span>
                    </label>
                    <div class="control-group">
                        <div class="frame_label no_connection">
                            <span class="span4">{lang('Active','mod_seo')}:</span>
                                                <span class="span1">
                                                    <span class="niceCheck b_n v-a_t">
                                                        <input class="span4" name="usePageCategoryPattern" {if $settings.usePageCategoryPattern == 1} checked="checked" {/if}value="1" type="checkbox"/>
                                                    </span>
                                                </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="frame_label no_connection">
                            <span class="span4">{lang('Use only for empty metadata','mod_seo')}:</span>
                                                <span class="span1">
                                                    <span class="niceCheck b_n v-a_t">
                                                        <input class="span4" name="usePageCategoryPatternForEmptyMeta"  {if $settings.usePageCategoryPatternForEmptyMeta == 1} checked="checked" {/if}value="1" type="checkbox"/>
                                                    </span>
                                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>