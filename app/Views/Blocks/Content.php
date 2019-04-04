<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 10:11 AM.
 */

namespace App\Views\Blocks;

use App\Views\AbstractClass\AbstractBlock;

class Content extends AbstractBlock
{
    public function display()
    {
        if ($this->isHomepage()) {
            //homepage, return post
            return \PageContent::block('PostItemList');
        }

        $formTemplates = $this->extractFormTemplateFromContent();
        if ($formTemplates !== null) {
            $this->renderFormTemplates($formTemplates);
        }

        return $this->currentPage->content;
    }

    protected function extractFormTemplateFromContent()
    {
        $result = preg_match_all("/\[\[form:[a-zA-Z0-9 ]+\]\]/", $this->currentPage->content, $matches);
        if (!$result || $result === 0) {
            return null;
        }
        return current($matches);
    }

    protected function renderFormTemplates($formTemplates)
    {
        foreach ($formTemplates as $formTemplate) {
            //get form template name
            $formName = substr($formTemplate, 7, -2);
            $formView = \PageContent::block('form', ['name' => $formName]);
            $this->currentPage->content = str_replace('[[form:' . $formName . ']]', $formView, $this->currentPage->content);
        }

    }
}
