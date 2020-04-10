<?php

use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = \App\Model\Language::all();

        foreach ($languages as $language) {
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
    }

    protected function commonGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'view',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'create',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'edit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'update',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'delete',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'save',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'title',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'status',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'last_edited',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'yes',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'no',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirmation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirm_delete_confirmation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'config',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'description',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'remove',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'replace',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'select',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enter',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'name',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'count',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'created_at',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'url',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'version',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enabled',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disabled',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enable',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disable',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'or',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'or',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'collapse_all',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'expand_all',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'click_to_edit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'logout',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login_admin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'my_account',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submitted_on',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'email',
            'language_id' => $language->id
        ]);
    }

    protected function validationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => 'required',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => 'url',
            'language_id' => $language->id
        ]);
    }

    protected function dashboardGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_users',
            'language_id' => $language->id
        ]);
    }

    protected function pageGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'all_pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'author',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'create_page',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'edit_page',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'save_draft',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'schedule',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_from',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_to',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'slug',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'featured_image',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'content',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_title',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_slug',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_title',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'select_page',
            'language_id' => $language->id
        ]);
    }

    protected function postGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'all_posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'edit_post',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'create_post',
            'language_id' => $language->id
        ]);
    }

    protected function tagGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'search_add_tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'add_as_new_tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'all_tags',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'create_tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'edit_tag',
            'language_id' => $language->id
        ]);
    }

    protected function formGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'all_forms',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'responses',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'create_form',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'edit_form',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_responses',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_component',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_preview',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_properties',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'drag_component_placeholder',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'properties_component_placeholder',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'duplicate',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'is_required',
            'language_id' => $language->id
        ]);
    }

    protected function menuGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'dashboard',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'blogging',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'tags',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'forms',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'file_manager',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'appearance',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'plugins',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'all_menus',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'create_menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'edit_menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu_structure',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'add_to_menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'custom_link',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'auth',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'guest_label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'logged_in_label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'no_label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'sub_menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'contact',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'home',
            'language_id' => $language->id
        ]);
    }

    protected function pluginGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install_plugin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'update_plugin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'installing',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'uploading',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'browse',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_anyway_upload',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_to_upload',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'select_file',
            'language_id' => $language->id
        ]);
    }

    protected function settingGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management_description_text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'view_setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'change_setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'users',
            'language_id' => $language->id
        ]);
    }

    protected function roleGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'all_roles',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'create_role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'edit_role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'permissions',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'allow',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'disallow',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'only_own',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'module',
            'language_id' => $language->id
        ]);
    }

    protected function translationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'languages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'code',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'translated',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'edit_translation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'key',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'text',
            'language_id' => $language->id
        ]);
    }

    public function userGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'all_users',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'create_user',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'edit_user',
            'language_id' => $language->id
        ]);
    }
}
