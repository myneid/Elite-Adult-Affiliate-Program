<?php
require_once    '../phpinclude/classAffiliateProgramDB.inc.php';
require_once    '../phpinclude/classSmartyEC.inc.php';
require_once    '../phpinclude/classAPConfig.inc.php';

        $config = new APConfig();
        $conf_vars = $config->get_all_vars();

        $smarty = new SmartyEC('../templates');
        $smarty->clear_all_cache();
        $smarty->assign('base_url', $conf_vars['base_url'] );
        $smarty->display('admin/index.html');
