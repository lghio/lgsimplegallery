<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
jimport( 'joomla.filesystem.folder' );

class JFormFieldFolderTree extends JFormField
{
	protected $type = 'FolderTree';

	protected function getInput()
	{
		$options = array();
		
		$path		= JPATH_ROOT.'/'.$this->element['directory'];
		$filter		= $this->element['filter'];
		$folders	= JFolder::listFolderTree($path, $filter);

		foreach ($folders as $folder)
		{
			$options[] = JHtml::_('select.option', str_replace("\\","/",$folder['relname']), str_replace("\\","/",substr($folder['relname'], 1)));
		}

		return JHtml::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
	}
}