<?php
namespace JhaAdmin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Category extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function __invoke($catid)
    {
        $postMapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('table:category');
        $category = $postMapper->getCategory($catid);
        return $category['catname'];
    }
}