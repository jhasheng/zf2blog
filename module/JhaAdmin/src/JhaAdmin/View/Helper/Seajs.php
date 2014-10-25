<?php
namespace JhaAdmin\View\Helper;

use Zend\View\Helper\HeadScript;

class Seajs extends HeadScript
{

    protected $str = "seajs.use('%s')";

    /**
     * Return InlineScript object
     *
     * Returns InlineScript helper object; optionally, allows specifying a
     * script or script file to include.
     *
     * @param  string $mode      Script or file
     * @param  string $spec      Script/url
     * @param  string $placement Append, prepend, or set
     * @param  array  $attrs     Array of script attributes
     * @param  string $type      Script type and/or array of script attributes
     * @return InlineScript
     */
    public function __invoke($mode = self::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript')
    {
        return parent::__invoke($mode, $spec, $placement, $attrs, $type);
    }
    
    public function toSeaJs()
    {
        $containers = $this->getContainer();
        $length = $containers->count();
        foreach ($containers as $key => $value){
            if(($length - 1) == $key) $value->source = sprintf($this->str, $value->source);
        }
    }
    
}