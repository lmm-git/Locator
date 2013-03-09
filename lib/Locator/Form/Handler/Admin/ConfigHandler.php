<?php
/**
 * Configuration handler class.
 */
class Locator_Form_Handler_Admin_ConfigHandler extends Zikula_Form_AbstractHandler
{
    /**
     * Initialize form handler.
     *
     * This method takes care of all necessary initialisation of our data and form states.
     *
     * @param Zikula_Form_View $view The form view instance.
     *
     * @return boolean False in case of initialization errors, otherwise true.
     */
    public function initialize(Zikula_Form_View $view)
    {
        // permission check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            return $view->registerError(LogUtil::registerPermissionError());
        }

        // retrieve module vars
        $modVars = $this->getVars();

        // assign all module vars
        $this->view->assign('config', $modVars);

        return true;
    }

    /**
     * Command event handler.
     *
     * This event handler is called when a command is issued by the user. Commands are typically something
     * that originates from a {@link Zikula_Form_Plugin_Button} plugin. The passed args contains different properties
     * depending on the command source, but you should at least find a <var>$args['commandName']</var>
     * value indicating the name of the command. The command name is normally specified by the plugin
     * that initiated the command.
     *
     * @param Zikula_Form_View $view The form view instance.
     * @param array            $args Additional arguments.
     *
     * @see Zikula_Form_Plugin_Button
     * @see Zikula_Form_Plugin_ImageButton
     *
     * @return mixed Redirect or false on errors.
     */
    public function handleCommand(Zikula_Form_View $view, &$args)
    {
        if ($args['commandName'] == 'save') {
            // check if all fields are valid
            if (!$this->view->isValid()) {
                return false;
            }

            // retrieve form data
            $data = $this->view->getValues();

            // update all module vars
            if (!$this->setVars($data['config'])) {
                return LogUtil::registerError($this->__('Error! Failed to set configuration variables.'));
            }

            LogUtil::registerStatus($this->__('Done! Module configuration updated.'));
        } else if ($args['commandName'] == 'cancel') {
            // nothing to do there
        }

        // redirect back to the config page
        $url = ModUtil::url($this->name, 'admin', 'config');

        return $this->view->redirect($url);
    }
}
