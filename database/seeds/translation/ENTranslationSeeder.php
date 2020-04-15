<?php

use Illuminate\Database\Seeder;

class ENTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = \App\Model\Language::whereCode('en')->first();

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
            'text' => 'View',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'create',
            'text' => 'Create',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'edit',
            'text' => 'Edit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'update',
            'text' => 'Update',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'delete',
            'text' => 'Delete',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'save',
            'text' => 'Save',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'title',
            'text' => 'Title',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'status',
            'text' => 'Status',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'last_edited',
            'text' => 'Last Edited',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'yes',
            'text' => 'Yes',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'no',
            'text' => 'No',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirmation',
            'text' => 'Confirmation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'confirm_delete_confirmation',
            'text' => 'Confirm Delete {entity} [{item}] ?',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'config',
            'text' => 'Config',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'description',
            'text' => 'Description',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'remove',
            'text' => 'Remove',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'replace',
            'text' => 'Replace',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'select',
            'text' => 'Select',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enter',
            'text' => 'Enter',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'name',
            'text' => 'Name',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'count',
            'text' => 'Count',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'created_at',
            'text' => 'Created At',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'label',
            'text' => 'Label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'url',
            'text' => 'Url',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'version',
            'text' => 'Version',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enabled',
            'text' => 'Enabled',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disabled',
            'text' => 'Disabled',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'enable',
            'text' => 'Enable',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'disable',
            'text' => 'Disable',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'or',
            'text' => 'Or',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'collapse_all',
            'text' => 'Collapse All',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'expand_all',
            'text' => 'Expand All',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'click_to_edit',
            'text' => 'Click to edit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login',
            'text' => 'Login',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'logout',
            'text' => 'Logout',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'login_admin',
            'text' => 'Login Admin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'my_account',
            'text' => 'My Account',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submitted_on',
            'text' => 'Submitted On',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'submit',
            'text' => 'Submit',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'common',
            'key' => 'email',
            'text' => 'Email',
            'language_id' => $language->id
        ]);
    }

    protected function validationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => 'required',
            'text' => 'This is a required field',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'validation',
            'key' => 'This is not a valid url',
            'language_id' => $language->id
        ]);
    }

    protected function dashboardGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_pages',
            'text' => 'Total Pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_posts',
            'text' => 'Total Posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'dashboard',
            'key' => 'total_users',
            'text' => 'Total Users',
            'language_id' => $language->id
        ]);
    }

    protected function pageGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'all_pages',
            'text' => 'All Pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'author',
            'text' => 'Author',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'create_page',
            'text' => 'Create Page',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'edit_page',
            'text' => 'Edit Page',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'save_draft',
            'text' => 'Save Draft',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish',
            'text' => 'Publish',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'schedule',
            'text' => 'Schedule',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_from',
            'text' => 'Publish From',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'publish_to',
            'text' => 'Publish To',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'slug',
            'text' => 'Slug',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'featured_image',
            'text' => 'Featured Image',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'content',
            'text' => 'Content',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_title',
            'text' => 'Enter Title',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_slug',
            'text' => 'Enter Slug',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'enter_description',
            'text' => 'Enter Description',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'page',
            'key' => 'select_page',
            'text' => 'Select Page',
            'language_id' => $language->id
        ]);
    }

    protected function postGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'all_posts',
            'text' => 'All Posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'edit_post',
            'text' => 'Edit Post',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'post',
            'key' => 'create_post',
            'text' => 'Create Post',
            'language_id' => $language->id
        ]);
    }

    protected function tagGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'search_add_tag',
            'text' => 'Search or add a tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'add_as_new_tag',
            'text' => 'Add as a new tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'all_tags',
            'text' => 'All Tags',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'create_tag',
            'text' => 'Create Tag',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'tag',
            'key' => 'edit_tag',
            'text' => 'Edit Tag',
            'language_id' => $language->id
        ]);
    }

    protected function formGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'all_forms',
            'text' => 'All Forms',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'responses',
            'text' => 'Responses',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'create_form',
            'text' => 'Create Form',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'edit_form',
            'text' => 'Edit Form',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_responses',
            'text' => 'Form Responses',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_component',
            'text' => 'Form Component',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_preview',
            'text' => 'Form Preview',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'form_properties',
            'text' => 'Form Properties',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'drag_component_placeholder',
            'text' => 'Drag component here from the left',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'properties_component_placeholder',
            'text' => 'Please click a component in form preview to change its properties',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'duplicate',
            'text' => 'Duplicate',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'form',
            'key' => 'is_required',
            'text' => 'Is Required?',
            'language_id' => $language->id
        ]);
    }

    protected function menuGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'dashboard',
            'text' => 'Dashboard',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'pages',
            'text' => 'Pages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'blogging',
            'text' => 'Blogging',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'posts',
            'text' => 'Posts',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'tags',
            'text' => 'Tags',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'forms',
            'text' => 'Forms',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'file_manager',
            'text' => 'File Manager',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'appearance',
            'text' => 'Appearance',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu',
            'text' => 'Menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'plugins',
            'text' => 'Plugins',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'settings',
            'text' => 'Settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'all_menus',
            'text' => 'All Menus',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'create_menu',
            'text' => 'Create Menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'edit_menu',
            'text' => 'Edit Menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'menu_structure',
            'text' => 'Menu Structure',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'add_to_menu',
            'text' => 'Add to menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'custom_link',
            'text' => 'Custom Link',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'auth',
            'text' => 'Auth',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'guest_label',
            'text' => 'Guest Label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'logged_in_label',
            'text' => 'Logged In Label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'no_label',
            'text' => 'No Label',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'sub_menu',
            'text' => 'sub menu',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'contact',
            'text' => 'Contact',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'home',
            'text' => 'Home',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'language',
            'text' => 'Language',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'menu',
            'key' => 'available_languages',
            'text' => 'Available Languages',
            'language_id' => $language->id
        ]);
    }

    protected function pluginGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install',
            'text' => 'Install',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'install_plugin',
            'text' => 'Install Plugin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'upload_plugin',
            'text' => 'Upload Plugin',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'installing',
            'text' => 'Installing',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'uploading',
            'text' => 'Uploading',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'browse',
            'text' => 'Browse',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_anyway_upload',
            'text' => 'Drop file anyway to upload',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'drop_file_to_upload',
            'text' => 'Drop file to upload',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'plugin',
            'key' => 'select_file',
            'text' => 'Select File',
            'language_id' => $language->id
        ]);
    }

    protected function settingGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general',
            'text' => 'General',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_description_text',
            'text' => 'General settings such as site title, description',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration',
            'text' => 'Integration',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_description_text',
            'text' => 'Integration settings with other services',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission',
            'text' => 'Roles And Permission',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'roles_and_permission_description_text',
            'text' => 'Roles and permission setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation',
            'text' => 'Translation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'translation_description_text',
            'text' => 'Manage Translations',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management',
            'text' => 'User Management',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'user_management_description_text',
            'text' => 'Manage user setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'view_setting',
            'text' => 'View Setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'change_setting',
            'text' => 'Change Setting',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'general_settings',
            'text' => 'General Settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'integration_settings',
            'text' => 'Integration Settings',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'setting',
            'key' => 'users',
            'text' => 'Users',
            'language_id' => $language->id
        ]);
    }

    protected function roleGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'all_roles',
            'text' => 'All Roles',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'role',
            'text' => 'Role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'create_role',
            'text' => 'Create Role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'edit_role',
            'text' => 'Edit Role',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'permissions',
            'text' => 'Permissions',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'allow',
            'text' => 'Allow',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'disallow',
            'text' => 'Disallow',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'only_own',
            'text' => 'Only Own',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'role',
            'key' => 'module',
            'text' => 'Module',
            'language_id' => $language->id
        ]);
    }

    protected function translationGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'languages',
            'text' => 'Languages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'code',
            'text' => 'Code',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'translated',
            'text' => 'Translated',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'edit_translation',
            'text' => 'Edit Translation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'key',
            'text' => 'Key',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'text',
            'text' => 'Text',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'all_languages',
            'text' => 'All Languages',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'select_language',
            'text' => 'Select Language',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'create_translation',
            'text' => 'Create Translation',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'group',
            'text' => 'group',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'translation',
            'key' => 'create_translation_description',
            'text' => 'Create translation will create empty translation for all language',
            'language_id' => $language->id
        ]);
    }

    public function userGroup($language)
    {
        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'all_users',
            'text' => 'All Users',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'create_user',
            'text' => 'Create User',
            'language_id' => $language->id
        ]);

        \App\Model\Translation::forceCreate([
            'group' => 'user',
            'key' => 'edit_user',
            'text' => 'Edit User',
            'language_id' => $language->id
        ]);
    }
}
