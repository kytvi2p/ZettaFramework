<?php

/**
 * Вывод редактируемого блока
 *
 */
class Zetta_View_Helper_Block extends Zend_View_Helper_Abstract {

	protected $_blockModel;
	
	public function setView(Zend_View_Interface $view) {

		parent::setView($view);
		
		$this->view
    		->addBasePath(HEAP_PATH . DS . 'Blocks/App/views')
    		->addBasePath(MODULES_PATH . DS . 'Blocks/App/views');
    	
    	$this->_blockModel = new Modules_Blocks_Model_Blocks();
    			
		if ($this->isAdmin()) {
	    	
			$this->view->current_route_id = Zend_Registry::get('RouteCurrentId');
			
			$this->view->headScript()
				->appendFile($this->view->libUrl('/Blocks/public/js/admin.js'))
				->prependScript('
					var _urlBlockSave = "' . $this->view->url(array('module' => 'blocks', 'controller' => 'admin', 'action' => 'save'), 'mvc', true) . '",
						_urlBlockInfo = "' . $this->view->url(array('module' => 'blocks', 'controller' => 'admin', 'action' => 'blockinfo'), 'mvc', true) . '",
						_urlBlockDelete = "' . $this->view->url(array('module' => 'blocks', 'controller' => 'admin', 'action' => 'blockdelete'), 'mvc', true) . '",
						_currentRouteId = ' . $this->view->current_route_id . ';
				');
				
			
		}
	
	}
	
    public function block($blockName, $blockType = 'html', $defaultValue = false, $inherit = true) {

    	$block = $this->_blockModel->getBlock($blockName);
    	$this->view->block = $block;
    	$this->view->block_name = $blockName;
    	$this->view->block_type = $blockType;
    	$this->view->content = $block ? $block->content : $defaultValue;
    	$this->view->inherit = $inherit;

    	try {
    		$return = $this->view->render('block_' . $blockName . '/index.phtml');
    	}
    	catch (Exception $e) {
    		$return = $this->view->render('block/index.phtml');
    	}
    	
    	if ($this->isAdmin()) {
    		$this->view->content = $return;
			$return = $this->view->render('block/adminWrapper.phtml');
    	}
    	
    	return $return;

    }
    
    
    protected function isAdmin() {

    	$_user = Zend_auth::getInstance()->getIdentity();
		
    	if ($_user && strstr($_user->role_name, 'admin')) {
			return true;
			
		}

    }

}