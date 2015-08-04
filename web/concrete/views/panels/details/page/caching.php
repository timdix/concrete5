<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getByID(Loader::helper('security')->sanitizeInt($_REQUEST['cID']));
if (is_object($c) && !$c->isError()) {
    $cp = new Permissions($c);
    if ($cp->canEditPageSpeedSettings()) {
        ?><iframe id="ccm-page-preview-frame" name="ccm-page-preview-frame" src="<?=$controller->action("preview")?>"></iframe><?php 
    }
}
