'<?php

use Illuminate\Database\Seeder;

class ZHCNTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = \App\Model\Language::whereCode('zh-CN')->first();

        $this->commonGroup($language);
        $this->validationGroup($language);
        $this->dashboardGroup($language);
        $this->pageGroup($language);
        $this->postGroup($language);
        $this->tagGroup($language);
        $this->formGroup($language);
        $this->menuGroup($language);
        $this->pluginGroup($language);
        $this->settingGroup($language);
        $this->roleGroup($language);
        $this->translationGroup($language);
        $this->userGroup($language);
    }

    protected function commonGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'view',
            'text' => '预览',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'create',
            'text' => '新建',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'edit',
            'text' => '编辑',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'update',
            'text' => '编辑',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'delete',
            'text' => '删除',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'save',
            'text' => '保存',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'title',
            'text' => '标题',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'status',
            'text' => '状态',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'last_edited',
            'text' => '最后编辑',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'yes',
            'text' => '是',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'no',
            'text' => '否',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirmation',
            'text' => '确认',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirm_delete_confirmation',
            'text' => '确认删除{entity} [{item}] ?',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'config',
            'text' => '设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'description',
            'text' => '描述',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'remove',
            'text' => '移除',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'replace',
            'text' => '替换',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'select',
            'text' => '选择',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enter',
            'text' => '输入',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'name',
            'text' => '名字',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'count',
            'text' => '数量',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'created_at',
            'text' => '创建于',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'label',
            'text' => '标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'url',
            'text' => '网址',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'version',
            'text' => '版本',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enabled',
            'text' => '已启用',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disabled',
            'text' => '已禁用',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enable',
            'text' => '启用',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disable',
            'text' => '禁用',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'or',
            'text' => '或',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'collapse_all',
            'text' => '全部收缩',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'expand_all',
            'text' => '全部展开',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'click_to_edit',
            'text' => '点击编辑',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login',
            'text' => '登入',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'logout',
            'text' => '注销',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login_admin',
            'text' => '登入管理页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'my_account',
            'text' => '我的账号',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submitted_on',
            'text' => '提交于',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submit',
            'text' => '提交',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'email',
            'text' => '电邮',
            'language_id' => $language->id
        ]);
    }

    protected function validationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => 'required',
            'text' => '这是必填的',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => '请填写有效的网址',
            'language_id' => $language->id
        ]);
    }

    protected function dashboardGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_pages',
            'text' => '总页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_posts',
            'text' => '总文章',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_users',
            'text' => '总用户',
            'language_id' => $language->id
        ]);
    }

    protected function pageGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'all_pages',
            'text' => '所有页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'author',
            'text' => '作者',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'create_page',
            'text' => '新建页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'edit_page',
            'text' => '编辑页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'save_draft',
            'text' => '保存草稿',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish',
            'text' => '发布',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'schedule',
            'text' => '发布时间',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_from',
            'text' => '从',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_to',
            'text' => '到',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'slug',
            'text' => '链接',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'featured_image',
            'text' => '特色图像',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'content',
            'text' => '内容',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_title',
            'text' => '输入标题',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_slug',
            'text' => '输入链接',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_description',
            'text' => '输入描述',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'select_page',
            'text' => '选择页面',
            'language_id' => $language->id
        ]);
    }

    protected function postGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'all_posts',
            'text' => '所有文章',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'edit_post',
            'text' => '编辑文章',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'create_post',
            'text' => '新建文章',
            'language_id' => $language->id
        ]);
    }

    protected function tagGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'search_add_tag',
            'text' => '搜寻或新建标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'add_as_new_tag',
            'text' => '新建标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'all_tags',
            'text' => '所有标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'create_tag',
            'text' => '新建标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'edit_tag',
            'text' => '编辑标签',
            'language_id' => $language->id
        ]);
    }

    protected function formGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'all_forms',
            'text' => '所有表格',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'responses',
            'text' => '回应',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'create_form',
            'text' => '新建表格',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'edit_form',
            'text' => '编辑表格',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_responses',
            'text' => '表格回应',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_component',
            'text' => '表格构件',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_preview',
            'text' => '表格预览',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_properties',
            'text' => '表格设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'drag_component_placeholder',
            'text' => '拖放表格构件至此',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'properties_component_placeholder',
            'text' => '点击表格预览里的构建以更改其设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'duplicate',
            'text' => '复制',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'is_required',
            'text' => '必填的？',
            'language_id' => $language->id
        ]);
    }

    protected function menuGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'dashboard',
            'text' => '主控面板',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'pages',
            'text' => '页面',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'blogging',
            'text' => '博客',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'posts',
            'text' => '文章',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'tags',
            'text' => '标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'forms',
            'text' => '表格',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'file_manager',
            'text' => '文件管理',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'appearance',
            'text' => '外观',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu',
            'text' => '菜单',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'plugins',
            'text' => '插件',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'settings',
            'text' => '设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'all_menus',
            'text' => '所有菜单',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'create_menu',
            'text' => '新建菜单',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'edit_menu',
            'text' => '编辑菜单',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu_structure',
            'text' => '菜单结构',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'add_to_menu',
            'text' => '添加到菜单架构',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'custom_link',
            'text' => '自定义网址',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'auth',
            'text' => '认证',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'guest_label',
            'text' => '客人标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'logged_in_label',
            'text' => '已登入用户标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'no_label',
            'text' => '没有标签',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'sub_menu',
            'text' => '子项目',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'contact',
            'text' => '联络',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'home',
            'text' => '主页',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'language',
            'text' => '语言',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'available_languages',
            'text' => '语言选择',
            'language_id' => $language->id
        ]);
    }

    protected function pluginGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install',
            'text' => '安装',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install_plugin',
            'text' => '安装插件',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'upload_plugin',
            'text' => '上传插件',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'installing',
            'text' => '正在安装',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'uploading',
            'text' => '正在上传',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'browse',
            'text' => '选择文件',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_anyway_upload',
            'text' => '将文件拖放到此处进行上传',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_to_upload',
            'text' => '松开进行上传',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'select_file',
            'text' => '选择文件',
            'language_id' => $language->id
        ]);
    }

    protected function settingGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general',
            'text' => '常规',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_description_text',
            'text' => '常规设置例如网站标题，网站描述等等',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration',
            'text' => '第三方应用',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_description_text',
            'text' => '第三方应用设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission',
            'text' => '角色和权限',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission_description_text',
            'text' => '角色和权限设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation',
            'text' => '翻译',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation_description_text',
            'text' => '翻译管理',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management',
            'text' => '用户',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management_description_text',
            'text' => '用户管理',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'view_setting',
            'text' => '浏览设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'change_setting',
            'text' => '更改设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_settings',
            'text' => '常规设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_settings',
            'text' => '第三方应用设置',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'users',
            'text' => '用户',
            'language_id' => $language->id
        ]);
    }

    protected function roleGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'all_roles',
            'text' => '所有角色',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'role',
            'text' => '角色',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'create_role',
            'text' => '新建角色',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'edit_role',
            'text' => '编辑角色',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'permissions',
            'text' => '权限',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'allow',
            'text' => '允许',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'disallow',
            'text' => '不允许',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'only_own',
            'text' => '只允许自己',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'module',
            'text' => '模组',
            'language_id' => $language->id
        ]);
    }

    protected function translationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'languages',
            'text' => '语言',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'code',
            'text' => '编号',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'translated',
            'text' => '已翻译',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'edit_translation',
            'text' => '编辑翻译',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'key',
            'text' => '关键词',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'text',
            'text' => '内容',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'all_languages',
            'text' => '所有语言',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'select_language',
            'text' => '选择语言',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'create_translation',
            'text' => '新建翻译',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'group',
            'text' => '分组',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'create_translation_description',
            'text' => '新建翻译将创建于所有语言',
            'language_id' => $language->id
        ]);
    }

    public function userGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'all_users',
            'text' => '所有用户',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'create_user',
            'text' => '新建用户',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'edit_user',
            'text' => '编辑用户',
            'language_id' => $language->id
        ]);
    }
}
